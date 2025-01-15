<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => 'task-manager/index',
    'language' => 'ru-RU',
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'components' => [
        "authClientCollection" => [
            "class" => "yii\authclient\Collection",
            "clients" => [
                "keycloak" => [
                    "class" => "yii\authclient\OpenIdConnect",
                    "clientId" => 'task-manager-web',
                    "clientSecret" => 'D2Sq7wizqi8X0YYpQg8qIFqHgcuAZ9pb',
                    "returnUrl" => 'http://localhost:80/index.php?r=site/auth-callback',
                    "issuerUrl" => 'http://localhost:8180/realms/task-manager/',
                    "name" => "keycloak",
                    "validateAuthState" => true,
                   
                    "autoRefreshAccessToken" => true,
                    "validateJws" => false,
                    
                    "stateStorage" => [
                        "class" => "yii\authclient\SessionStateStorage",
                        "session" => "session",
                    ],
                    "scope" => "openid profile",
                ],
            ],
        ],




        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '9uv54-uvETwGqEWbK-9qq9hjRiLISSdw',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],

        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['task-manager/login'],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'session' => [
            'class' => 'yii\web\Session',
            'name' => 'my-session',
            'timeout' => 3600, // 1 hour
            'cookieParams' => [
                'httpOnly' => true,
                'secure' => true, // or false, depending on your environment
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1', '172.21.0.1'], 
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
