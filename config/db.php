<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=gestion_municipal',
    'username' => 'root',
    'password' => '123645',
    'charset' => 'utf8',
    'attributes' => [
            PDO::NULL_TO_STRING => false
        ]
];
