<?php

use app\priv\Info;

require_once '../priv/Info.php';
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=cottage2',
    'username' => Info::DB_USER,
    'password' => Info::DB_PASSWORD,
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',

];
