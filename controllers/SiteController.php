<?php

namespace app\controllers;

use app\components\AuthHandler;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\helpers\Url;

class SiteController extends Controller
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

    /**
     * {@inheritdoc}
     */
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

    // state=b32aa7c4319f9b53f75bfcd3b6bb27da244bf414ee51b54f1ec99db67b58c717
    // state=b32aa7c4319f9b53f75bfcd3b6bb27da244bf414ee51b54f1ec99db67b58c717
    public function onAuthSuccess($client)
    {
        (new AuthHandler($client))->handle();
    }


    public function actionAuthCallback()
    {
        $req = Yii::$app->request;
        $authcode = $req->get("code");

        
        $cli = Yii::$app->authClientCollection->getClient("keycloak");
        $cli->fetchAccessToken($authcode); 
        
        $token = $cli->getAccessToken();
        $cli->setAccessToken($token);
        $user = (new AuthHandler($cli))->handle();
        Yii::$app->user->login($user);

        if (Yii::$app->user->isGuest)
        {
            
            $msg = Yii::t("site", "Не удалось авторизовать пользователя");
            throw new ServerErrorHttpException($msg);
        }

        return $this->redirect(Url::to("index"));

        // echo '<pre>' . print_r($user, true) . '</pre>';

        
    }
}
