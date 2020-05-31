<?php

include('../db.php');
include("function.php");

if(isset($_POST["met_id"]) && isset($_POST['action']))
{
	if($_POST["action"] == 'Deactivate'){
		$statement = $connection->prepare(
			"UPDATE tbl_membershiptype  SET met_status = :met_status WHERE met_id = :met_id"
		);
		$result = $statement->execute(
			array(
				':met_status' => 'INACTIVE',
				':met_id'	=>	$_POST["met_id"]
			)
		);
		
		if(!empty($result))
		{
			echo 'Deacivated!';
		}
	}
	else if($_POST["action"] == 'Activate'){
		$statement = $connection->prepare(
			"UPDATE tbl_membershiptype  SET met_status = :met_status WHERE met_id = :met_id"
		);
		$result = $statement->execute(
			array(
				':met_status' => 'ACTIVE',
				':met_id'	=>	$_POST["met_id"]
			)
		);
		
		if(!empty($result))
		{
			echo 'Activated!';
		}
	}
}
?>