<?php
include('../db.php');
include('function.php');
if(isset($_POST["operation"]))
{
	if($_POST["operation"] == "Add")
	{
		$statement = $connection->prepare("
			INSERT INTO tbl_membershiptype (met_name, met_rate, met_duration) VALUES (:metname, :metrate, :metduration)
		");
		$result = $statement->execute(
			array(
				':metname'	=>	$_POST["metname"],
				':metrate'	=>	$_POST["metrate"],
				':metduration'	=>	$_POST["metduration"]
			)
		);
		if(!empty($result))
		{
			echo 'Data Inserted';
		}
	}
	if($_POST["operation"] == "Edit")
	{
		$statement = $connection->prepare(
			"UPDATE tbl_membershiptype 
			SET met_name = :met_name, met_rate = :met_rate, met_duration = :met_duration
			WHERE met_id = :met_id
			"
		);
		$result = $statement->execute(
			array(
				':met_name'	=>	$_POST["metname"],
				':met_rate'	=>	$_POST["metrate"],
				':met_duration'	=>	$_POST["metduration"],
				':met_id'	=>	$_POST["met_id"]

			)
		);
		if(!empty($result))
		{
			echo 'Data Updated';
		}
	}
}

?>