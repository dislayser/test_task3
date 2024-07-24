<?php
//Проверка авторизации
function isAuth($DB){
    if (isset($_COOKIE['auth_token']) && isset($_SESSION["user"]) && !empty($_SESSION["user"])){
        $params = array(
            "id_user" => $_SESSION["user"]["id"],
            "token" => $_COOKIE['auth_token'], 
            "ip" => $_SERVER['REMOTE_ADDR'],
        );
        $auth = $DB->select_one("users_auth", $params);

        if(!empty($auth)){
            return true;
        }
    }
    return false;
}

if(!isAuth($DB)){
    go(LOGOUT_URL);
    exit;
}

//ADMIN
if (isset($_SESSION["user_auth"]['rule']) && $_SESSION["user_auth"]['rule'] != 'admin' && strpos($_SERVER['REQUEST_URI'], '/admin/') !== false){
    //Если пользователь авторизован
    go(BASE_URL);
    exit; // Обязательно завершаем скрипт после перенаправления
}
?>