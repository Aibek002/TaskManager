<?php

namespace app\controllers;

use app\models\CreateAvatarForm;
use app\models\CreatePostForm;
use app\models\DialogForm;
use app\models\Post;
use app\models\PostToUsers;
use app\models\SignInForm;
use app\models\SignUpForm;
use app\models\StatusType;
use app\models\StatusUpdate;
use app\models\User;
use Yii;
use app\models\Users;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\UploadedFile;

class TaskManagerController extends Controller
{



    public function actionIndex()
    {
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

    public function actionSignIn()
    {
        $model = new SignInForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $identity = User::findOne(['email' => $model->email]);
            if ($identity !== null && $identity->validatePassword($model->password_hash)) {
                Yii::$app->session->setFlash('success', "Successfully sign in");
                if (Yii::$app->user->login($identity)) {
                    return $this->redirect(['task-manager/index']);
                } else {
                    Yii::$app->session->setFlash('error', "Invalid username");
                }
            } else {
                Yii::$app->session->setFlash('error', "Invalid username or password");

            }
        }


        return $this->render('sign-in', ['model' => $model]);

    }
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(['task-manager/sign-in']);
    }

    public function actionCreatePost()
    {
        $model = new CreatePostForm();
        $user = User::find()->select(['id', 'name', 'email'])->all();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            // Сохраняем файл во временную директорию потому что гетИнстанс только один раз сохроняет изображение
            $tempPath = Yii::getAlias('@webroot/') . uniqid() . $model->imageFile->extension;
            $model->imageFile->saveAs($tempPath);

            // Убедитесь, что файл загружен
            if (!$model->imageFile) {
                Yii::$app->session->setFlash('error', 'Изображение не загружено.');
                return $this->redirect(['task-manager/create-post']);
            }
            $post_for_user = Yii::$app->request->post('user', []);
            $post = new Post();
            $filePath = uniqid() . '.' . $model->imageFile->extension;

            // Цикл по каждому пользователю
            foreach ($post_for_user as $userId) {

                $post_to_users = new PostToUsers();
                $status = new StatusUpdate();
                $status->type = 1;

                // Создаем папки для каждого пользователя
                $path = Yii::getAlias('@webroot/uploadImage/') . $userId;
                if (!is_dir($path)) {
                    if (mkdir($path, 0777, true)) {
                        $path_subdirectory_pub = $path . "/publication";
                        $path_subdirectory_ava = $path . "/avatar";
                        mkdir($path_subdirectory_pub, 0777, true);
                        mkdir($path_subdirectory_ava, 0777, true);
                    }
                }

                // Генерация уникального имени файла
                $savePath = Yii::$app->params['uploadImagePath'] . $userId . "/publication/" . $filePath;

                // Присваиваем путь к изображению
                $post->title = $model->title;
                $post->text = $model->text;
                $post->imagePath = $filePath;

                if ($post->save()) {
                    // Сохранение отношений между постом и пользователем
                    $status->task_id = $post->id;
                    $post_to_users->user_id = $userId;
                    $post_to_users->post_id = $post->id;
                    $post_to_users->save();
                    $status->save();
                    copy($tempPath, $savePath);

                    // Сохранение изображения
                } else {
                    Yii::$app->session->setFlash('error', 'Ошибка при сохранении поста');
                }
            }
            // Удаляем временный файл
            unlink($tempPath);
            return $this->redirect(['task-manager/index']);
        }


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

        if ($model->load(Yii::$app->request->post())) {
            $model->user_from = Yii::$app->user->id;
            $model->post_id = $id;
            if ($model->save()) {
                return $this->refresh();
            }
        }


        // print_r($model);
        $sql = 'SELECT p.title, p.text, p.imagePath, s.task_id, s.status_date, status_type.status_type
                    FROM post AS p 
                    LEFT JOIN status AS s ON (s.task_id = p.id) 
                    LEFT JOIN status_type ON (status_type.id = s.type) 
                    
                    WHERE 
                    p.id = :id_post 
                    AND  :user_id IN (SELECT user_id FROM post_to_users WHERE post_id = :id_post)';
        $post = Yii::$app->db->createCommand(
            $sql,
            [

                ':id_post' => $id,
                ':user_id' => Yii::$app->user->getId()
            ]
        )->queryAll();
        // print_r($post);

        $sql_request_for_dialog = 'SELECT dialog.*,user.name,user.surname FROM dialog
        LEFT JOIN user on (user.id=dialog.user_from) WHERE dialog.post_id=:id_post';
        $dialog = Yii::$app->db->createCommand(
            $sql_request_for_dialog,
            [
                ':id_post' => $id,
            ]
        )->queryAll();
        // print_r($dialog);
        return $this->render('more-information-posts', ['post' => $post, 'status_type' => $status_type, 'comments' => $dialog, 'model' => $model]);
    }
}
