<?php
include('../db.php');
include('function.php');

$output = array();

if(isset($_POST['clc_id']) && $_POST['clc_id'] != ''){
    $id = $_POST['clc_id'];
    
    $query = '';
    $query .= "SELECT W.wrk_name, W.wrk_desc, W.wrk_id FROM tbl_workoutplan W
    INNER JOIN tbl_workoutclass WC ON W.wrk_id = WC.wrk_id
    INNER JOIN tbl_classcategory CC ON WC.clc_id = CC.clc_id
    WHERE CC.clc_id = $id ";

    if(isset($_POST["search"]["value"]))
        $query .= 'AND W.wrk_name LIKE "%'.$_POST["search"]["value"].'%" ';

    $query .= 'ORDER BY W.wrk_name ASC ';

    $statement = $connection->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $data = array();
    $filtered_rows = $statement->rowCount();
}
else{
    $query = '';
    $query .= "SELECT W.wrk_name, W.wrk_desc, W.wrk_id FROM tbl_workoutplan W
    INNER JOIN tbl_workoutclass WC ON W.wrk_id = WC.wrk_id
    INNER JOIN tbl_classcategory CC ON WC.clc_id = CC.clc_id ";

    if(isset($_POST["search"]["value"]))
        $query .= 'AND W.wrk_name LIKE "%'.$_POST["search"]["value"].'%" ';

    $query .= 'ORDER BY W.wrk_name ASC ';
    
    if($_POST["length"] != -1)
        $query .= 'LIMIT ' . $_POST['start'].', '.$_POST['length'];

    $statement = $connection->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $data = array();
    $filtered_rows = $statement->rowCount();
}

    foreach($result as $row){
        $sub_array = array();
        
        $sub_array[] = '<h4 style="font-weight:bold;">'.$row['wrk_name'].'</h4><span>'.$row['wrk_desc'].'</span>';
        $sub_array[] = '<button class="btn-xs btn-transparent view" id="'.$row['wrk_id'].'">'.file_get_contents('../../../../svg/ic_selectarrow_light.svg').'</button>';
        
        $data[] = $sub_array;
    }

    $output = array(
        "draw"				=>	intval($_POST["draw"]),
        "recordsTotal"		=> 	$filtered_rows,
        "data"				=>	$data
    );
echo json_encode($output);