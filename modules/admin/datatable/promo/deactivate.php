<?php
include('../db.php');
include("function.php");

if(isset($_POST["prm_id"]))
{
	if($_POST["action"] == 'Close'){
		$statement = $connection->prepare(
		"UPDATE tbl_promo SET prm_status = 'CLOSE' WHERE prm_id = :prm_id"
	);
	$result = $statement->execute(
		array(
			':prm_id'	=>	$_POST["prm_id"]
		)
	);
	
	if(!empty($result))
	{
		echo 'Promo Closed!';
	}

	}else if($_POST["action"] == 'Open'){
		$statement = $connection->prepare(
		"UPDATE tbl_promo SET prm_status = 'OPEN' WHERE prm_id = :prm_id"
		);
		$result = $statement->execute(
			array(
				':prm_id'	=>	$_POST["prm_id"]
			)
		);
		
		if(!empty($result))
		{
			echo 'Promo Opened!';
		}

	}
	
}
?>