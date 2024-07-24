<?php

$main_token_type = "post";

if (isset($_GET['table']) && !empty($_GET['table'])){
    $table_name = get('table');
    $table_params = get_search();
    $table_structure = $DB->describe($table_name);
    $form_data = get_formData($table_name);
}
//Создание записи
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])){
    unset($_POST['add']);
    if (isset($_POST['token'][$main_token_type])){
        $hash_token = $_POST['token'][$main_token_type];
        unset($_POST['token']);
    }

    if($table_name == 'users' && isset($_POST['password'])){
        $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
    }

    arr_clear($_POST);
    
    if($apptoken->verify($hash_token, $main_token_type)) {
        if($DB->insert($table_name, $_POST)){
            go(ADMIN_URL . "?table=$table_name");
        }
    }

}
//Изменение записи
elseif($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit']) && isset($_GET['id'])){
    unset($_POST['edit']);
    if (isset($_POST['token'][$main_token_type])){
        $hash_token = $_POST['token'][$main_token_type];
        unset($_POST['token']);
    }
    if($table_name == 'users' && isset($_POST['password'])){
        if(!empty($_POST['password'])){
            $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        }else{
            unset($_POST['password']);
        }
    }
    arr_clear($_POST);
    if($apptoken->verify($hash_token, $main_token_type)) {
        if($DB->update($table_name, (int)$_GET['id'], $_POST)){
            go(ADMIN_URL . "?table=$table_name");
        }
    }
}

//Удаление записи
elseif($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete']) && isset($_GET['id'])){
    $hash_token = $_POST['token'][$main_token_type];
    if($apptoken->verify($hash_token, $main_token_type)) {
        if($DB->delete($table_name, ['id' => (int)$_GET['id']])){
            go(ADMIN_URL . "?table=$table_name");
        }
    }
}

xss($form_data);
?>