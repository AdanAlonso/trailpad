<?php

if(!getenv('PRODUCTION')) {
    putenv('DB_DSN=mysql:host=localhost;dbname=backlog');
    putenv('DB_USER=root');
    putenv('DB_PASS=');
}

return [
    'class' => 'yii\db\Connection',
    'dsn' => getenv('DB_DSN'),
    'username' => getenv('DB_USER'),
    'password' => getenv('DB_PASS'),
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
