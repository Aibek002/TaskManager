<?php

namespace app\controllers;

use app\models\SignUpForm;
use app\models\User;
use Yii;
use app\models\Users;
use yii\web\Controller;

class TaskManagerController extends Controller
{



    public function actionIndex()
    {
        return $this->render("home");
    }

    public function actionSignUp()
    {
        $model = new SignUpForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = new User();
            $user->name = $model->name;
            $user->surname = $model->surname;
            $user->email = $model->email;
            $user->setPassword($model->password_hash);
            $user->generateAuthKey();
            if (User::findByEmail($model->email)) {
                Yii::$app->session->setFlash("error", "Email already exists: $model->email");
            } else {
                if ($user->save()) {
                    Yii::$app->session->setFlash("success", "Form saved");

                    // return $this->redirect(['task-manager/sign-up']);
                } else {
                    Yii::$app->session->setFlash("error", "Form don't saved!");
                }
            }
        } else {
            Yii::$app->session->setFlash("error", "Form not validated");
        }
        return $this->render('sign-up', ['model' => $model]);
    }
    public function actionSignIn()
    {

        return $this->render('sign-in');

    }

}
