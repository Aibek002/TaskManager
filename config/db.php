<?php

return [
'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=datas;dbname=yii2basic', // Измените 'host=db' на 'host=data'
    'username' => 'yii2basic',
    'password' => 'yii2basic',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
