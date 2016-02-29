<?php
$dsn ='mysql:host=localhost;dbname=...'; //database name
$username ='...';
$password ='...';

return [
    'class' => 'yii\db\Connection',
    'dsn' => $dsn,
    'username' => $username,
    'password' => $password,
    'charset' => 'utf8',
];
