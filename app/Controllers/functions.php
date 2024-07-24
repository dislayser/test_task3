<?php

//Функция для тестрования массивов и тд
function tt($value = []){
    echo '<pre>';
    print_r($value);
    echo '<pre>';
}

//Преобразует строку/массивы для вставки как текст на HTML страницу, для предотвращения xss аттак
function xss(&$item, $params = ENT_QUOTES, $charset = 'UTF-8') {
    if (is_array($item)) {
        foreach ($item as &$val) {
            xss($val);
        } 
    } else {
        if (is_string($item)) {
            $item = htmlspecialchars($item, $params, $charset);
        }
    }
}

//Приравнивает NULL если значение пустое
function arr_clear(&$arr){
    foreach ($arr as &$item){
        if ($item === ''){
            $item = null;
        }
        $item = trim($item);
    } 
    return $arr;
}

function get_header_title($type){
    $arr_currency = array(
        "AUDCAD_otc" => "AUD/CAD OTC"
    ); 
    if (isset($arr_currency[$type])){
        return htmlspecialchars($arr_currency[$type]);
    }
    return htmlspecialchars($type);
}
//Получение данных для формы
function get_formData($table_name){
    global $DB;
    global $table_name;
    $arr = array();
    if(isset($_GET['id'])){
        $arr = $DB->select_one($table_name, ['id' => (int)$_GET['id']]);
    }
    return $arr;
}

//Сокращенная функция перехода на страницу
function go($url){
    header('Location: '. $url);
    exit;
}
function get($key){
    if (isset($_GET[$key])){
        return $_GET[$key];
    }
    return '';
}
//Для получения парамеров поиска
function get_search(){
    $q = array();
    if (isset($_GET['q']) && isset($_GET['col-search'])) {
        $q[$_GET['col-search']] = "%".$_GET['q']."%";
    }
    return $q;
}

//Переимнование столба
function ren_col($index){
    
    $cols = array(
        'id' => 'ID',
        'name' => 'Имя',
        'surname' => 'Фамилия',

        'created' => 'Создан',
        'date' => 'Дата',
        'date-from' => 'От (дата)',
        'days' => 'Дней',
        
        'id_user' => 'Пользователь',
        'phone' => 'Контакты',
        'login' => 'Логин',
        'password' => 'Пароль',
        'last_auth' => 'Онлайн',
        'api_token' => 'API Токен',

        'id_couriers' => 'Курьер',
        'id_regions' => 'Регион',

        'deleted' => 'Удален',
        'session_id' => 'Сохр. сессия',
        'ip' => 'IP адрес',
        'priority' => 'Приоритет',
        'error' => 'Ошибка',
        'params' => 'Данные',
        'url' => 'URL',
        'rule' => 'Роль',
        'id_rule' => 'Роль',
        'description' => 'Описание',
        'data' => 'Данные',
    );

    if (isset($cols[$index])){
        $index = $cols[$index];
    }

    xss($index);
    return $index;
}


//Преобразовывает дату
function format_date($val){
    if (empty($val)){
        return '';
    }
    $date = new DateTime($val);

    // Форматируем дату в нужный формат
    $formatted = $date->format('d.m.Y');
    
    // Если входная строка содержит время, добавляем его к форматированной дате
    if (strpos($val, ' ') !== false) {
        $formatted .= ' ' . $date->format('H:i');
    }

    return $formatted;
}

// Возвращаем данные в формате JSON
function output($data, $status = 200){
    http_response_code((int)$status);
    echo json_encode($data);
    exit;
}

//Получить DATETIME
function now(){
    $date = new DateTime();
    return $date->format('Y-m-d H:i:s');
}

//Для получения строк из текстового файла
function get_lines($text_file, $rows = 25, $offset = 0){
    // Считываем содержимое файла в массив
    $all_lines = file($text_file);
    
    // Определяем оффсет и выбираем последние строки с учетом оффсета и количества строк
    $offset = count($all_lines) - $offset - $rows;
    $last_lines = array_slice($all_lines, max(0, $offset), $rows);

    // Обратный порядок для правильного вывода
    $lines = array_reverse($last_lines);

    return $lines;
}
function get_lines_count($text_file){
    $all_lines = file($text_file);
    return count($all_lines);
}
function table_structure($arr){
    $result = array();
    foreach ($arr as $val){
        if (!is_array($val)){
            $result[] = ['data' => $val]; 
        }
    }
    return $result;
}

//Проверка авторизации
function is_auth(){
    if (isset($_SESSION["user"]) && !empty($_SESSION["user"])) {
        return true;
    }
    return false;
}
?>
