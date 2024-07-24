<?php
// Обязательные параметры для построения таблицы
//$table_name = 'users';
//$table_params = [];
?>

<?php if(isset($table_name) && isset($table_params) && !empty($table_name) && !empty($table_structure)):?>
<?php
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $DB->cur_page = intval($_GET['page']);
}
if (isset($_GET['sortcol'])){
    $DB->sortCol = $_GET['sortcol'];
}
if (isset($_GET['orderby'])){
    $DB->orderBy = $_GET['orderby'];
} 
$table_rows = $DB->select($table_name, $table_params);
xss($table_rows);

function table_link($id){
    if (empty($_GET)){
        $href = $_SERVER['REQUEST_URI'].'?type=edit&id='.(int)$id;
    }else{
        $href = $_SERVER['REQUEST_URI'].'&type=edit&id='.(int)$id;
    }
    return $href;
}
?>
<!-- Таблицa <?=$table_name?> -->
<div class="table-responsive my-3">
    <table class="table table-hover text-nowrap">
        <thead>
            <tr>
                <?php
                foreach ($table_structure as $col){
                    if($col['Field'] != 'password'){
                        $get_data = $_GET;
                        $get_data['sortcol'] = $col['Field'];

                        if (isset($get_data['orderby'])){
                            $get_data['orderby'] = $get_data['orderby'] == "ASC" ? "DESC" : "ASC" ;
                        }else{
                            $get_data['orderby'] = "DESC";
                        }

                        $href = "?" . http_build_query($get_data);

                        echo '<th scope="col"><a class="text-decoration-none" href="'.$href.'">'. ren_col($col['Field']) .'</a></th>';
                    }
                }
                ?>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            <?php
            foreach ($table_rows as $row){
                $data_href = table_link($row['id']);
                echo '<tr data-href="'.$data_href.'" class="c-pointer">';
                foreach ($table_structure as $col){
                    if($col['Field'] != 'password'){
                        if ($col['Field'] == 'created' || $col['Field'] == 'date' || $col['Field'] == 'date-from') {
                            $val = format_date($row[$col['Field']]);
                        }
                        else{
                            $val = $row[$col['Field']];
                        }
                        echo '<td>'. $val .'</td>';
                    }
                }
                echo '</tr>';
            }  
            ?>
        </tbody>
    </table>
</div>

<?php include 'Pagination.php';?>
<?php endif;?>