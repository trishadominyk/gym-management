<?php
include('../db.php');
include('function.php');

if(!empty($_POST['cust_id'])){
    $id = $_POST['cust_id'];
    
    $query = '';
    $query = "SELECT L.log_date, P.pro_percentage FROM tbl_progress P 
    INNER JOIN tbl_logbook L ON P.log_id = L.log_id
    WHERE L.cust_id = $id LIMIT 10";

    $statement = $connection->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();

    $data = array();
    foreach($result as $row){
        $sub_array = array();
        $sub_array[] = date("D, M d, Y", strtotime($row["log_date"]));
        $sub_array[] = $row['pro_percentage'].'%';

        $data[] = $sub_array;
    }

    $output = array(
        "draw"				=>	intval($_POST["draw"]),
        "data"				=>	$data
    );
    
    echo json_encode($output);
}

