<?php
require(DIR.'app/Models/Database.php');
require(DIR.'app/Models/AppToken.php');
//Файл с авторизацией к базе данных
$db_auth = require(DIR.'secret/db.php');

$apptoken = new AppToken();

//Обект для работы с базой данных
$DB = new Database(
    $db_auth['driver'],
    $db_auth['db']['main'],
    $db_auth['user'],
    $db_auth['pass'],
    $db_auth['host']
);
$DB->connect(); //Соединение

?>