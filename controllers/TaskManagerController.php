<?php

namespace app\controllers;

use app\models\CreateAvatarForm;
use app\models\CreatePostForm;
use app\models\Post;
use app\models\SignInForm;
use app\models\SignUpForm;
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
        $post = Post::find()->all();
        $postForUser = [];
        foreach ($post as $posts) {
            $userIds = explode(',', $posts->user);// Получаем массив ID пользователей

            // Если нужно, вы можете извлечь информацию о пользователях
            for ($i = 0; $i < count($userIds); $i++) {

                if (Yii::$app->user->id == $userIds[$i]) {
                    $postForUser[] = [
                        'id' => $posts->id,
                        'title' => $posts->title,
                        'text' => $posts->text,
                        'imagePath' => $posts->imagePath,
                        'date' => $posts->date,

                    ];

                }
            }



        }




        return $this->render("home", ['task' => $postForUser]);
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
            $post = new Post();
            $post->title = $model->title;
            $post->text = $model->text;
            $post->user = implode(",", Yii::$app->request->post('user', []));
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            $filePath = uniqid() . '.' . $model->imageFile->extension;
            $savePath = Yii::$app->params['uploadImagePath'] . Yii::$app->user->id . "/publication/" . $filePath;
            $post->imagePath = $filePath;

            // echo Yii::getAlias('@app');
            if ($model->imageFile->saveAs($savePath) && $post->save()) {

                Yii::$app->session->setFlash('success', "Successfully saved!");
                return $this->redirect(['task-manager/create-post']);

            }

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
    public function actionUpdateStatus($id){
        return "hello " . $id ;
    }
}
