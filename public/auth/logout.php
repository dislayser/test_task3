<?php
require(__DIR__.'/../../app/Config/Path.php');
require(DIR.'app/Config/Config.php');
require(DIR.'app/Controllers/db_main.php');
require(DIR.'app/Controllers/functions.php');

$DB->delete("users_auth", ['token' => $_COOKIE['auth_token']]);
// Уничтожаем все данные сессии
session_destroy();

$_SESSION = array();

// Опционально: удаляем куки, связанные с сессией (если они есть)
if (isset($_COOKIE[session_name()])) {
    setcookie('session_id', '', time() - 3600, '/');
}
if (isset($_COOKIE['auth_token'])){
    setcookie('auth_token', '', time() - (60 * 60 * 24 * 30), '/');
}

// Перенаправляем пользователя на страницу авторизации
go(LOGIN_URL); 
exit;
?>