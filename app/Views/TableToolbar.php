<?php if(!empty($table_name)):?>
<div class="d-flex gap-2 my-3">
    <div class="me-auto">
        <?php
            $a_href = '?';
            if(isset($_GET['table']) && !empty($_GET['table'])){
                $a_href .= "table=".$_GET['table']."&";
            }
            $a_href .= 'type=add';
            echo ui_button_a('new', '<i class="bi-plus-lg"></i><span class="ms-2 d-none d-md-inline">Добавить</span>', $a_href, 'btn btn-primary');
        ?>
    </div>
        <div class="vr d-md-none"></div>
    <?php include('Search.php')?>
</div>
<hr>

<?php endif;?>