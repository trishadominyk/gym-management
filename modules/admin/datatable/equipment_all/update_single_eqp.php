<?php
include('../db.php');

$action = $_POST["action"];

if(isset($_POST["eqp_id"]))
{
	if($action == 'Repair'){
		$statement = $connection->prepare(


			"UPDATE tbl_equipment SET eqp_status = 'REPAIR', eqp_date_update = CURDATE() WHERE eqp_id = :eqp_id"
		);
		$result = $statement->execute(
			array(
				':eqp_id'	=>	$_POST["eqp_id"]
			)
		);
	}
	else{
		$statement = $connection->prepare(


			"UPDATE tbl_equipment SET eqp_status = 'AVAILABLE', eqp_date_update = CURDATE() WHERE eqp_id = :eqp_id"
		);
		$result = $statement->execute(
			array(
				':eqp_id'	=>	$_POST["eqp_id"]
			)
		);
	}

	if(!empty($result))
	{
		echo 'Data Updated';
	}
}
?>
