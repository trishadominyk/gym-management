<?php
include('../db.php');
include('function.php');
if(isset($_POST["operation"]))
{
	if($_POST["operation"] == "Add")
	{
		$statement = $connection->prepare("INSERT INTO tbl_promo(prm_code,prm_date_start, prm_date_end, prm_discount, prm_max, prm_desc) VALUES ( :prmcode, :prmdatestart, :prmdateend, :prmdiscount, :prmmax, :prmdesc)");
		$result = $statement->execute(
			array(
				':prmcode' => $_POST["prmcode"],
				':prmdatestart'	=>	$_POST["prmdatestart"],
				':prmdateend'	=>	$_POST["prmdateend"],
				':prmdiscount'	=>	$_POST["prmdiscount"],
				':prmmax'	=>	$_POST["prmmax"],
				':prmdesc'	=>	$_POST["prmdesc"]
			)
		);
		if(!empty($result))
		{
			echo 'Data Inserted';
		}
	}
	if($_POST["operation"] == "Edit")
	{

		$statement = $connection->prepare("UPDATE tbl_staff SET stf_email = :stfemail, stf_firstname = :stffirst, stf_lastname = :stflast, stf_contact = :stfcont, lvl_id = :lvlid WHERE stf_id = :stfid");
		$result = $statement->execute(
			array(
				':stfemail' =>	$_POST["stfemail"],
				':stffirst' =>	$_POST["stffirst"],
				':stflast'	=>	$_POST["stflast"],
				':stfcont'	=>	$_POST["stfcont"],
				':lvlid' => $_POST["lvlid"],
				':stfid' => $_POST["stfid"]
			)
		);
		if(!empty($result))
		{
			echo 'Data Updated';
		}
	}
	
}

?>