<?php

include('../db.php');
include("function.php");

if(isset($_POST["delete-details"]))
{
	$statement = $connection->prepare(
		"DELETE FROM tbl_eventdetail WHERE evn_det_id = :id");
	$result = $statement->execute(
		array(
			':id'	=>	$_POST["evn_det_id"]
		)
	);
	
	if(!empty($result))
	{
		echo 'Data Deleted';
	}
}


if(isset($_POST['cancel'])){
	$statement = $connection->prepare(
		"UPDATE tbl_event SET evn_status = 'CANCELED' WHERE evn_id = :id");
	$result = $statement->execute(
		array(
			':id'	=>	$_POST["id"]
		)
	);
	
	if(!empty($result))
	{
		echo 'Event Successfully Canceled';
	}
}
?>