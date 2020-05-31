<?php
include('../db.php');
include('function.php');
if(isset($_POST["operation"]))
{
	if($_POST["operation"] == "Add")
	{
		$statement = $connection->prepare("
			INSERT INTO tbl_class (cls_name, cls_rate, cls_sessions, clc_id) VALUES (:clsname, :clsrate, :clssessions, :clcid)
		");
		$result = $statement->execute(
			array(
				':clsname'	=>	$_POST["clsname"],
				':clsrate'	=>	$_POST["clsrate"],

				':clssessions'	=>	$_POST["clssessions"],
				':clcid'	=>	$_POST["clcid"]
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
			"UPDATE tbl_class
			SET cls_name = :cls_name, cls_rate = :cls_rate, cls_desc = :cls_desc, cls_sessions = :cls_sessions, clc_id = :clc_id
			WHERE cls_id = :cls_id
			"
		);
		$result = $statement->execute(
			array(
				':cls_name'	=>	$_POST["clsname"],
				':cls_desc'	=>	$_POST["clsdesc"],
				':cls_rate'	=>	$_POST["clsrate"],
				':cls_sessions'	=>	$_POST["clssessions"],
				':cls_id'	=>	$_POST["cls_id"],
				':clc_id'	=>	$_POST["clcid"]

			)
		);
		if(!empty($result))
		{
			echo 'Data Updated';
		}
	}
}

?>
