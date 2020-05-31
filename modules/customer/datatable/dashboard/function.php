<?php
function check_login($id){
    include('../db.php');
    
    $date = date('Y-m-d');
    
	$statement = $connection->prepare(
        "SELECT * FROM tbl_logbook WHERE cust_id = '$id'
        WHERE log_timeout IS NULL AND log_date = '$date'"
    );
	$statement->execute();
    
    return $statement->rowCount();
}
 
function get_logid($id){
    include('../db.php');
    
    $date = date('Y-m-d');
    
	$statement = $connection->prepare(
        "SELECT log_id FROM tbl_logbook
        WHERE cust_id = $id AND log_timeout IS NULL AND log_date = '$date'
        LIMIT 1"
    );
	$statement->execute();
    $result = $statement->fetch();
    
    return $result['log_id'];
}