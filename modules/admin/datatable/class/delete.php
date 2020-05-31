<?php

include('../db.php');
include("function.php");

if(isset($_POST["cls_id"]) && isset($_POST['action']))
{
	if($_POST["action"] == 'Deactivate'){
		$statement = $connection->prepare(
			"UPDATE tbl_class  SET cls_status = :cls_status WHERE cls_id = :cls_id"
		);
		$result = $statement->execute(
			array(
				':cls_status' => 'INACTIVE',
				':cls_id'	=>	$_POST["cls_id"]
			)
		);
		
		if(!empty($result))
		{
			echo 'Deacivated!';
		}
	}
	else if($_POST["action"] == 'Activate'){
		$statement = $connection->prepare(
			"UPDATE tbl_class  SET cls_status = :cls_status WHERE cls_id = :cls_id"
		);
		$result = $statement->execute(
			array(
				':cls_status' => 'ACTIVE',
				':cls_id'	=>	$_POST["cls_id"]
			)
		);
		
		if(!empty($result))
		{
			echo 'Activated!';
		}
	}
}
?>