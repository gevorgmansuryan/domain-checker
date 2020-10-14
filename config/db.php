<?php

return \yii\helpers\ArrayHelper::merge([
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=domain_checker',
    'username' => 'root',
    'password' => '123123',
    'charset' => 'utf8',
], YII_ENV_PROD ? [
    'enableSchemaCache' => true,
    'schemaCacheDuration' => 60,
    'schemaCache' => 'cache',
] : []
);