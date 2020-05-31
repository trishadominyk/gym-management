<?php
include('../db.php');

$id = $_POST['id'];

$statement3 = $connection->prepare(        
    "SELECT L.log_date, P.pro_percentage FROM tbl_progress P 
    INNER JOIN tbl_logbook L ON P.log_id = L.log_id
    WHERE L.cust_id = $id LIMIT 10"
);

$statement3->execute();
$result3 = $statement3->fetchAll();
    
$progress = array();
foreach($result3 as $row){
    array_push($progress, array("log_date"=>date('M d, Y', strtotime($row['log_date'])), "pro_percentage"=>$row['pro_percentage']));
}

echo json_encode($progress);