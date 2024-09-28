<?php

namespace app\controllers;

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
                        'title' => $posts->title,
                        'text' => $posts->text,
                        'imagePath' => $posts->imagePath,

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
            // var_dump($roles);
            // die();
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
            $filePath = $model->imageFile->baseName . '.' . $model->imageFile->extension;
            $savePath = Yii::$app->params['uploadImagePath'] . $filePath;
            $post->imagePath = $filePath;

            // echo Yii::getAlias('@app');
            if ($model->imageFile->saveAs($savePath) && $post->save()) {

                Yii::$app->session->setFlash('success', "Successfully saved!");
                return $this->redirect(['task-manager/create-post']);

            }

        }

        return $this->render('create-post', ['model' => $model, 'user' => $user]);
    }
}
