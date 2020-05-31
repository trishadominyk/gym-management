<?php
include('../db.php');
include('function.php');

$output = array();

$statement = $connection->prepare(
    "SELECT * FROM tbl_classcategory"
);
$statement->execute();
$result = $statement->fetchAll();
    
$output['list_nav'] = '<ul class="list-nav">';

foreach($result as $row){
    $output['list_nav'] .= '<a href="index.php?mod=workout&sub='.$row['clc_id'].'"><li>'.$row['clc_name'].'</li></a>';
}
$output['list_nav'] .= '</ul>';

if($_POST['clc_id'] == '')
    $output['clc_name'] = 'Workout Plans > Select A Class';
else
    $output['clc_name'] = 'Workout Plans > '.get_categoryname($_POST['clc_id']);

echo json_encode($output);