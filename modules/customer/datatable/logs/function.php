<?php
function get_total_logs(){
	include('../db.php');
	$statement = $connection->prepare("SELECT * FROM tbl_logbook");
	$statement->execute();
	$result = $statement->fetchAll();
    
	return $statement->rowCount();
}