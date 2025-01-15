<?php

namespace app\controllers;

use app\models\CreateAvatarForm;
use app\models\CreatePostForm;
use app\models\DialogForm;
use app\models\DialogRead;
use app\models\Post;
use app\models\PostToUsers;
use app\models\SignInForm;
use app\models\SignUpForm;
use app\models\StatusType;
use app\models\StatusUpdate;
use app\models\User;
use PHPUnit\Framework\Constraint\IsEmpty;
use Yii;
use app\models\Users;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\UploadedFile;
use yii\helpers\Url;

class TaskManagerController extends Controller
{
    public function behaviors()
    {
        return [
            "access" => [
                "class" => \yii\filters\AccessControl::class,
                "only" => ["logout", "index"],
                "rules" => [
                    // TODO(annad): Logout is post request!
                    ["allow" => true, "actions" => ["index", "logout"], "roles" => ["@"]],
                ],
            ],
        ];
    }
    public function actions()
    {
        return [
            "error" => [
                "class" => \yii\web\ErrorAction::class,
            ],

            "auth" => [
                "class" => \yii\authclient\AuthAction::class,
                "clientCollection" => "authClientCollection",
            ],
        ];
    }



    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $cli = Yii::$app->authClientCollection->getClient("keycloak");
        $to = Url::to(["auth", "authclient" => $cli->getName()]);
        return $this->redirect($to);
        // print_r($cli);

    }
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(['task-manager/sign-in']);
    }
    public function actionIndex()
    {
    //    echo phpinfo();
        // echo xdebug_info();
        $status_type = StatusType::find()
            ->where(['!=', 'status_type', 'create'])
            ->andWhere(['!=', 'status_type', 'active'])
            ->all();
        $userId = 36; // Замените на нужный user_id
        $sql = 'SELECT p.*, s.* , status_type.status_type FROM post AS p 
                    LEFT JOIN status AS s ON (s.task_id = p.id) 
                    LEFT JOIN status_type ON (status_type.id= s.type) 
                    WHERE s.id = ( SELECT id FROM status WHERE task_id = p.id ORDER BY status_date DESC LIMIT 1 ) 
                    AND p.id IN(SELECT post_id FROM post_to_users where user_id=:id) ORDER BY p.id DESC ;';
        $post = Yii::$app->db->createCommand(
            $sql,
            [':id' => Yii::$app->user->id]
        )->queryAll();
        // print_r($post);





        return $this->render("home", ['task' => $post, 'status_type' => $status_type]);
    }


    public function actionSignUp()
    {
        if (Yii::$app->user->can('createUser')) {
            $auth = Yii::$app->authManager->getRoles();
            $roles = [];
            foreach ($auth as $r) {
                $roles[$r->name] = $r->name;

            }
            $model = new SignUpForm();
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                $user = new User();
                $user->name = $model->name;
                $user->surname = $model->surname;
                $user->email = $model->email;
                $user->password_hash = $model->password_hash;
                $user->generateAuthKey();

                if (User::findByEmail($model->email)) {
                    Yii::$app->session->setFlash("error", "Email already exists: $model->email");
                } else {

                    if ($user->save()) {
                        $path = Yii::getAlias('@webroot/uploadImage/') . $user->getId();
                        if (!is_dir($path)) {
                            if (mkdir($path, 0777, true)) {
                                $path_subdirectory_pub = $path . "/publication";
                                $path_subdirectory_ava = $path . "/avatar";
                                mkdir($path_subdirectory_pub, 0777, true);
                                mkdir($path_subdirectory_ava, 0777, true);

                            }
                        }
                        $getRole = Yii::$app->request->post('roles', []);
                        foreach ($getRole as $grole) {
                            $role = Yii::$app->authManager->getRole($grole);
                            if ($role) {
                                Yii::$app->authManager->assign($role, $user->getId());
                            } else {
                                throw new ForbiddenHttpException("Role which you select not found!");
                            }
                        }

                        Yii::$app->session->setFlash("success", "User created successfully.");
                    } else {
                        Yii::$app->session->setFlash("error", "Form didn't save!");
                    }
                }
            }
        } else {
            throw new ForbiddenHttpException("You cannot create a user because you are not an admin!");
        }

        return $this->render('sign-up', ['model' => $model, 'roles' => $roles]);
    }

    public function actionCreatePost()
    {
        // Проверка прав пользователя на создание поста
        if (Yii::$app->user->can('createPost')) {

            $model = new CreatePostForm();

            // Получаем пользователей, кроме текущего
            $user = User::find()
                ->select(['id', 'name', 'email'])
                ->where(['!=', 'id', Yii::$app->user->id])
                ->all();

            // Если форма успешно загружена и прошла валидацию
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {

                // Получаем загруженный файл
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

                // Проверка, если файл не был загружен
                if (!$model->imageFile) {
                    Yii::$app->session->setFlash('error', 'Изображение не загружено.');
                    return $this->redirect(['task-manager/create-post']);
                }

                // Получаем пользователей, которым предназначен пост
                $post_for_user = Yii::$app->request->post('user', []);
                $post_for_user[] = Yii::$app->user->getId();
                $post = new Post();
                $filePath = uniqid() . '.' . $model->imageFile->extension;  // Генерация уникального имени файла
                $tempPath = Yii::getAlias('@webroot/uploadImage/') . $filePath;  // Временный путь для файла

                // Сохраняем файл во временную директорию
                if (!$model->imageFile->saveAs($tempPath)) {
                    Yii::$app->session->setFlash('error', 'Не удалось сохранить файл.');
                    return $this->redirect(['task-manager/create-post']);
                }

                // Обрабатываем каждого пользователя
                foreach ($post_for_user as $userId) {
                    // Путь к директории пользователя
                    $userPath = Yii::getAlias('@webroot/uploadImage/') . $userId;
                    if (!is_dir($userPath)) {
                        if (!mkdir($userPath, 0777, true)) {
                            throw new \Exception("Не удалось создать директорию: $userPath");
                        }
                        mkdir($userPath . "/publication", 0777, true);
                        mkdir($userPath . "/avatar", 0777, true);
                    }

                    // Создаем и сохраняем пост
                    $post_to_users = new PostToUsers();
                    $status = new StatusUpdate();
                    $status->type = 1;

                    $post->title = $model->title;
                    $post->text = $model->text;
                    $post->imagePath = $filePath;

                    if ($post->save()) {
                        // Сохраняем связь с пользователем и статус
                        $status->task_id = $post->id;
                        $post_to_users->user_id = $userId;
                        $post_to_users->post_id = $post->id;
                        $post_to_users->save();
                        $status->save();
                        $dialog = DialogForm::find()->where(['=', 'post_id', $post->id])->one();
                        if (!$dialog) {
                            $dialog = new DialogForm();
                            $dialog->user_from = Yii::$app->user->getId();
                            $dialog->comments = 'I created new post';
                            $dialog->post_id = $post->id;
                            $dialog->save();
                        }
                        // Путь к файлу пользователя
                        $userImagePath = Yii::$app->params['uploadImagePath'] . $userId . '/publication/' . $filePath;

                        // Перемещаем файл в директорию пользователя
                        if (!copy($tempPath, $userImagePath)) {
                            Yii::$app->session->setFlash('error', 'Ошибка при загрузке файла.');

                            $lastError = error_get_last();
                            if ($lastError) {
                                Yii::error("Ошибка при перемещении файла: " . $lastError['message'], __METHOD__);
                            } else {
                                Yii::error("Ошибка при перемещении файла, причина неизвестна.", __METHOD__);
                            }
                        } else {
                            Yii::$app->session->setFlash('success', 'Файл успешно загружен.');
                        }



                    } else {
                        Yii::$app->session->setFlash('error', 'Ошибка при сохранении поста: ' . implode(', ', $post->getErrorSummary(true)));
                    }
                }
                unlink($tempPath);
                return $this->redirect(['task-manager/index']);
            }

        } else {
            Yii::$app->session->setFlash('error', 'You cannot create post!');
        }

        // Рендерим форму создания поста
        return $this->render('create-post', ['model' => $model, 'user' => $user]);
    }

    public function actionCreateAvatar()
    {
        function clearImageDirectoryUsingGlob($dir)
        {
            // Проверяем, существует ли директория
            if (is_dir($dir)) {
                // Получаем все файлы изображений в директории
                $files = glob($dir . '/*.{jpg,jpeg,png,gif}', GLOB_BRACE); // Указываем расширения

                // Перебираем все найденные файлы
                foreach ($files as $file) {
                    if (is_file($file)) {
                        unlink($file); // Удаляем файл
                    }
                }
            } else {
                echo "Директория не найдена: $dir";
            }
        }

        // Используйте функцию, передав путь к директории

        $model = new CreateAvatarForm();

        if ($model->load(Yii::$app->request->post())) {
            $model->imageAvatar = UploadedFile::getInstance($model, 'imageAvatar');
            if ($model->imageAvatar) {
                $file = uniqid() . "." . $model->imageAvatar->extension;
                $savePath = Yii::$app->params['uploadImagePath'] . Yii::$app->user->id . "/avatar/" . $file;
                $model->fileName = $file;
                $model->id_user = Yii::$app->user->id;
                $avatar = CreateAvatarForm::deleteAll(['id_user' => Yii::$app->user->id]);

                if ($model->save()) {
                    clearImageDirectoryUsingGlob(Yii::$app->params['uploadImagePath'] . Yii::$app->user->id . "/avatar/");
                    if ($model->imageAvatar->saveAs($savePath)) {
                        Yii::$app->session->setFlash('success', 'succefully upload!');
                    } else {
                        Yii::$app->session->setFlash('error', 'Error with saving files!');

                    }
                } else {
                    Yii::$app->session->setFlash('error', 'Error with saving!');

                }

            } else {
                Yii::$app->session->setFlash('error', 'Error unknown file!');
            }
        } else {
            Yii::$app->session->setFlash('error', 'No file uploaded!');
        }
        return $this->render('create-avatar', ['model' => $model]);
    }
    public function actionUpdateStatus($id, $status)
    {
        $status_table = new StatusUpdate();
        $status_type = StatusType::findOne(['status_type' => $status]);
        $status_table->type = $status_type->id;
        $status_table->task_id = $id;
        // print_r($id);
        $status_table->save();
        return $this->redirect('task-manager/index');

    }
    public function actionMoreInformationPosts($id)
    {


        $status_type = StatusType::find()
            ->where(['!=', 'status_type', 'create'])
            ->andWhere(['!=', 'status_type', 'active'])
            ->all();
        $model = new DialogForm();
        $read_status = new DialogRead();




        // print_r($model);
        $sql = 'SELECT p.title, p.text, p.imagePath, s.task_id, MAX(s.status_date) AS status_date, status_type.status_type
                FROM post AS p 
                LEFT JOIN status AS s ON (s.task_id = p.id) 
                LEFT JOIN status_type ON (status_type.id = s.type) 
                WHERE 
                p.id = :id_post
                AND :user_id IN (SELECT user_id FROM post_to_users WHERE post_id = :id_post)
                GROUP BY p.title, p.text, p.imagePath, s.task_id, status_type.status_type;';
        $post = Yii::$app->db->createCommand(
            $sql,
            [

                ':id_post' => $id,
                ':user_id' => Yii::$app->user->getId()
            ]
        )->queryAll();
        // print_r($post);

        $sql_request_for_dialog = 'SELECT dialog.*, user.name, user.surname , user.id FROM dialog
        LEFT JOIN user on ( user.id = dialog.user_from ) WHERE dialog.post_id = :id_post';
        $dialog = Yii::$app->db->createCommand(
            $sql_request_for_dialog,
            [
                ':id_post' => $id,
            ]
        )->queryAll();
        // print_r($id . ' id');

        if ($model->load(Yii::$app->request->post())) {
            $model->user_from = Yii::$app->user->id;
            $model->post_id = $id;
            if ($model->save()) {
                $sql_request_for_get_post_to_users = 'SELECT post_to_users.user_id FROM post_to_users WHERE user_id != :user_id AND post_id=:post_id';
                $users_post = Yii::$app->db->createCommand(
                    $sql_request_for_get_post_to_users,
                    [
                        ':user_id' => Yii::$app->user->id,
                        ':post_id' => $id
                    ]
                )->queryAll();
                // print_r($users_post);
                foreach ($users_post as $i => $users) {
                    $read_status->dialog_id = $model->dialog_id;
                    $read_status->read = 0;
                    $read_status->user_to = $users['user_id'];
                    if (!$read_status->save()) {
                        Yii::$app->session->setFlash('error', 'status not fixed');
                    }
                }


                return $this->refresh();
            }
        }
        $sql = 'SELECT dialog_read.read FROM dialog_read WHERE user_to = :user_id AND dialog_read.read = 0';
        $get_status = Yii::$app->db->createCommand(
            $sql,
            [':user_id' => Yii::$app->user->id]
        )->queryAll();
        // print_r($get_status);
        if (isset($get_status)) {
            $sql = 'UPDATE dialog_read SET dialog_read.read = 1 where user_to = :user_id';
            $update_status_read = Yii::$app->db->createCommand(
                $sql,
                [':user_id' => Yii::$app->user->id]
            )->execute();

        }
        $lastRead = (count($dialog) - 1) >= 1 ? (count($dialog) - 1) : 0;
        // print_r($dialog);


        $sql = 'SELECT dialog_read.read, user.name from dialog_read 
        Left join user on ( user.id =  dialog_read.user_to ) where dialog_read.dialog_id = :dialog_id';
        $get_read_user = Yii::$app->db->createCommand(
            $sql,
            [':dialog_id' => $dialog[$lastRead]['dialog_id']]
        )->queryAll();
        // print_r($get_read_user);
        return $this->render('more-information-posts', ['post' => $post, 'status_type' => $status_type, 'comments' => $dialog, 'model' => $model, 'read' => $get_read_user]);
    }
}
