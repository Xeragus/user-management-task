<?php

/*
* This is template of database config.
* Fill out database configuration options below and rename this file to 'database.php'
*/

$database = [
    'address'  => getenv('DB_HOST'),
    'username' => getenv('DB_USER'),
    'password' => getenv('DB_PASS'),
    'database' => getenv('DB_NAME'),
    'charset'  => getenv('DB_CHARSET')
];
