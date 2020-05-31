<?php
include('../db.php');
include('function.php');

$output = array();

if(isset($_POST["log_id"])){
    $id = $_POST["log_id"];
    
    $query = '';
    $query .= "SELECT W.wrk_id, W.wrk_name, W.wrk_desc FROM tbl_logbook L
    INNER JOIN tbl_record R ON L.rec_id = R.rec_id
    INNER JOIN tbl_transaction T ON R.trns_id = T.trns_id
    INNER JOIN tbl_transitems I ON T.trns_id = I.trns_id
    INNER JOIN tbl_class C ON I.cls_id = C.cls_id
    INNER JOIN tbl_classcategory CC ON C.clc_id = CC.clc_id
    INNER JOIN tbl_workoutclass WC ON CC.clc_id = WC.clc_id
    INNER JOIN tbl_workoutplan W ON WC.wrk_id = W.wrk_id
    WHERE L.log_id = $id ";

    if(isset($_POST["order"]))
        $query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
    else
        $query .= 'ORDER BY W.wrk_name ASC ';

    if($_POST["length"] != -1)
        $query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];

    $statement = $connection->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $data = array();
    $filtered_rows = $statement->rowCount();

    foreach($result as $row){
        $sub_array = array();
        $sub_array[] = $row["wrk_name"];
        $sub_array[] = $row["wrk_desc"];
        $sub_array[] = '<button type="button" name="view" id="'.$row["wrk_id"].'" class="btn btn-success btn-xs addworkout">Select</button>';
        $data[] = $sub_array;
    }

    $output = array(
        "draw"				=>	intval($_POST["draw"]),
        "recordsTotal"		=> 	$filtered_rows,
        "data"				=>	$data
    );
}
echo json_encode($output);