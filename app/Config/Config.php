<?php
//Базовые настройки
date_default_timezone_set('Asia/Yekaterinburg'); // Установка времени по ЕКБ

//Старт сессии
ini_set('session.cookie_httponly', 1);
session_start();

//Брендинг
define('SITE_NAME', 'TestTask');
define('SITE_NAME_HTML', '<b>Test<span class="text-warning">Task</span></b>');
define('SITE_LOGO_SVG_NAME', 'app-indicator');
define('SITE_LOGO', '<i class="bi bi-'.SITE_LOGO_SVG_NAME.'"></i>');

//Вызвращает наимеование страницы
function site_subname(){

    switch ($_SERVER['PHP_SELF']){
        //Общие страницы
        case "/index.php":
            return 'Главная';
            break;
        case "/about.php":
            return 'О программе';
            break;
            
        //Страница админ панели
        case "/admin/index.php":
            return 'Админ панель';
            break;
        case "/admin/tables.php":
            return 'Админ панель | Таблицы';
            break;

        default:
            return 'Безымянный';
            break;
    }
}

//Данные для футера сайта
define('CREATED_YEAR', 2024);
define('ORG_NAME', 'ООО "Тестовая организация"');

?>
