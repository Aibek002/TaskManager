<?php

return [
'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=data;dbname=yii2basic', // Измените 'host=db' на 'host=data'
    'username' => 'root',
    'password' => 'yii2basic',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];