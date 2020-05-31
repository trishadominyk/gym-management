<?php
include('../db.php');
include('function.php');
if(isset($_POST["operation"]))
{
	if($_POST["operation"] == "Add")
	{

	for($qty = 1; $qty <= $_POST['eqpqty']; $qty++){
		$tokens = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

		$serial = '';

		for ($i = 0; $i < 4; $i++) {
		    for ($j = 0; $j < 5; $j++) {
		        $serial .= $tokens[rand(0, 35)];
		    }

		    if ($i < 3) {
		        $serial .= '-';
		    }
		}
		
		$statement = $connection->prepare("
			INSERT INTO tbl_equipment(eqp_serial, eqp_name, cat_id, eqp_date_added) VALUES ( :serialId, :eqpname, :catid, CURDATE())");
		$result = $statement->execute(
			array(
				':serialId' => $serial,
				':eqpname'	=>	$_POST["eqpname"],
				':catid'	=>	$_POST["catid"]
			)
		);

	}
				

		
	
		if(!empty($result))
		{
			echo 'Data Inserted';
		}
	}
	
}

?>