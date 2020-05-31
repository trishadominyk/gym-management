<?php
include('../db.php');
include("function.php");

if(isset($_POST["eqp_id"]))
{
	$statement = $connection->prepare(
		"UPDATE tbl_staff SET eqp_status = 'DISPOSED', eqp_date_update = CURDATE() WHERE eqp_id = :eqp_id"
	);
	$result = $statement->execute(
		array(
			':eqp_id'	=>	$_POST["eqp_id"]
		)
	);

	if(!empty($result))
	{
		echo 'Item Disposed';
	}
}
?>
