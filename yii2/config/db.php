<?php
$dsn      = 'mysql:host=localhost;dbname=twitdb'; //database name
$username = 'root';
$password = 'iddqd';

return [
    'class'    => 'yii\db\Connection',
    'dsn'      => $dsn,
    'username' => $username,
    'password' => $password,
    'charset'  => 'utf8',
];
