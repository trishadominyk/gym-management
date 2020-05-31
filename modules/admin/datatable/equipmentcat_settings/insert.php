<?php
include('../db.php');
include('function.php');
if(isset($_POST["operation"]))
{
	if($_POST["operation"] == "Add")
	{
		$statement = $connection->prepare("INSERT INTO tbl_category(cat_name) VALUES(:catname)");
		$result = $statement->execute(
			array(
				':catname' => $_POST["catname"],
			)
		);
		if(!empty($result))
		{
			echo 'Data Inserted';
		}
	}
	if($_POST["operation"] == "Edit")
	{

		$statement = $connection->prepare("UPDATE tbl_category SET cat_name = :catname WHERE cat_id = :catid");
		$result = $statement->execute(
			array(
				':catname' =>	$_POST["catname"],
				':catid' => $_POST["catid"]
			)
		);
		if(!empty($result))
		{
			echo 'Data Updated';
		}
	}

}

?>
