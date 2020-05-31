<?php
function get_classname($id){
    include('../db.php');
    
	$statement = $connection->prepare(
        "SELECT * FROM tbl_class 
        WHERE cls_id = $id"
    );
	$statement->execute();
    $result = $statement->fetch();
    
    return $result['cls_name'];
}

function get_total_all_records($q){
    include('../db.php');
    
	$statement = $connection->prepare("$q");
	$statement->execute();
    
    return $statement->rowCount();
}
 
function check_lastlog($id){
    include('../db.php');
    
	$statement = $connection->prepare(
        "SELECT L.log_date FROM tbl_logbook L
        INNER JOIN tbl_record R ON L.rec_id = L.rec_id
        WHERE R.rec_id = $id
        ORDER BY L.log_date DESC
        LIMIT 1"
    );
	$statement->execute();
    $result = $statement->fetch();
    
    return $result['log_date'];
}