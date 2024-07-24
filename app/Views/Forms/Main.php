<?php
/*
Функция для получения форм
*/
if (!isset($form_type)){
    $form_type = null;
}
if (isset($_GET["form_type"])) {
    $form_type = $_GET["form_type"];
}
$forms_ready = ["profile"]; 
?>
<?php if(in_array($form_type, $forms_ready)):?>
    <?php
    if ($form_type == "profile"){
        include "ProfileForm.php";        
    } 
    ?>
<?php else:?>
    <?php include "AdminForms.php"?>
<?php endif;?>