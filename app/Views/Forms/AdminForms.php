
<?php
function input($item){
    // tt($item);
    global $red_star;
    global $form_data;
    global $DB;

    $label = '';
    $input = '';
    $select = '';
    
    $label .= '<label class="form-label"';
    $input .= '<input class="form-control"';
    $select.= '<select class="form-select"';
    
    if (!empty($item['Field'])) {
        $label .= ' for="'.$item['Field'].'">'.ren_col($item['Field']);
        $input .= ' name="'.$item['Field'].'" id="'.$item['Field'].'" placeholder="'.ren_col($item['Field']).'"';

        if (!empty($item['Type'])) {
            switch ($item['Type']){
                case 'varchar(255)': 
                    $input .= ' type="text" maxlength="255"';
                    break;
                case 'varchar(45)':
                    $input .= ' type="text" maxlength="45"';
                    break;
                case 'varchar(32)':
                    $input .= ' type="text" maxlength="32"';
                    break;
                case 'int':
                    $input .= ' type="number" step="1"';
                    break;
                case 'int':
                    $input .= ' type="number" step="1"';
                    break;
                case 'date':
                    $input .= ' type="date"';
                    break;
                case 'datetime':
                    $input .= ' type="datetime-local"';
                    break;
                default:
                    break;
            }
        }

        

        if (!empty($form_data)){
            if (isset($form_data['password'])){
                unset($form_data['password']);
            }
            if (isset($form_data[$item['Field']])){
                $input .= ' value="'.$form_data[$item['Field']].'"';
            }
        }

        if ($item['Null'] == 'NO' && ($item['Field'] != 'password' || $_GET['type'] == 'add')) {
            $label .= $red_star;
            $input .= ' required';
        }
    
    }

    //Список для полей статус
    if ($item['Field'] == 'id_couriers'){
        $select.= ' name="'.$item['Field'].'" id="'.$item['Field'].'">';
        $couriers = $DB->select('couriers');
        xss($couriers);
        foreach ($couriers as $courier){
            $selected = '';
            if (isset($form_data['id_status']) && $status['id'] == $form_data['id_couriers']) {
                $selected .= 'selected';
            } 
            $select.= '<option value="'.$courier['id'].'" '.$selected.'>'.$courier['name'].'</option>';
        }
    }

    if ($item['Field'] == 'id_regions'){
        $select.= ' name="'.$item['Field'].'" id="'.$item['Field'].'">';
        $regions = $DB->select('regions');
        xss($regions);
        $selected_val = 0;
        if (isset($form_data['id_regions'])) {
            $selected_val = $form_data['id_regions'];
        }
        
        foreach ($regions as $region){
            $selected = '';
            if ($region['id'] == $selected_val) {
                $selected .= 'selected';
            }
            $select.= '<option value="'.$region['id'].'" '.$selected.'>'.$region['name'].'</option>';
        }
    }

    $label .= '</label>';
    $input .= '>';
    $select.= '</select>';

    if($item['Type'] == 'text'){
        $value = '';
        if(isset($form_data[$item['Field']])){
            $value .= $form_data[$item['Field']];
        }
        $input = '<textarea class="form-control" name="'.$item['Field'].'" id="'.$item['Field'].'" rows="3">'.$value.'</textarea>';
    }

    $fiels_select = ['id_couriers', 'id_regions'];
    if (in_array($item['Field'], $fiels_select)){
        return $label.$select;
    }

    return $label.$input;
}

//tt($_SERVER);
function get_cancel_link(){
    $link = str_replace('.php', "", $_SERVER['PHP_SELF']);
    if (isset($_GET['table']) && !empty($_GET['table'])) {
        $link = '?table=' .  $_GET['table'];
    }
    return $link;
}
?>
<!-- Форма AdminForms.php -->
<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" class="my-3">
    <div class="h4 d-flex my-3">
        <?php
            if ($_GET['type'] == 'add') {
                echo 'Создать';
            }elseif ($_GET['type'] == 'edit') {
                echo 'Редактировать ID: ' . $_GET['id'];
            }
        ?>
    </div>
    <hr>
    <?=$apptoken->field($main_token_type)?>
    <?=$apptoken->field("get")?>
    <div class="row g-3">
        <?php foreach($table_structure as $input):?>
            <?php if($input['Field'] != 'id' && $input['Field'] != 'created' && $input['Field'] != 'last_auth'):?>
            <div class="col-12">
                <?=input($input)?>
            </div>
            <?php endif;?>
        <?php endforeach;?>
    </div>
        <!-- Кнопки -->
        <hr>
        <div class="d-flex gap-3 flex-row-reverse">
            
            <button type="submit" class="btn btn-primary" name="<?=$_GET['type']?>">Сохранить</button>
            <a class="btn btn-secondary" href="<?=get_cancel_link()?>">Отмена</a>
            <?php if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                echo '<button type="submit" class="btn btn-danger" name="delete">Удалить</button>';
            }; ?>
        </div>
</form>