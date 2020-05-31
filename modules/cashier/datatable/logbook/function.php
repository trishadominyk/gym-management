<?php
function get_total_logbook_records($q){
	include('../db.php');
	$statement = $connection->prepare("$q");
	$statement->execute();
	$result = $statement->fetchAll();
    
	return $statement->rowCount();
}

function get_staffname($id){
    include('../db.php');
    
	$statement = $connection->prepare("SELECT * FROM tbl_staff WHERE stf_id = $id");
	$statement->execute();
    $f = $statement->fetch();
    $value =  $f["stf_firstname"].' '.$f["stf_lastname"];
    
    return $value;
}

function check_loggedin($id){
    include('../db.php');
    
	$statement = $connection->prepare("SELECT * FROM tbl_stafflogbook WHERE stf_id = $id AND stf_log_out IS NULL");
	$statement->execute();
    $result = $statement->fetchAll();
    
    return $statement->rowCount();
}