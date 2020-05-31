<?php
include('../db.php');
include('function.php');
if(isset($_POST["operation"]))
{
	if($_POST["operation"] == "Add")
	{

		$encryptpass = md5($_POST['stfconpas']);


		$statement = $connection->prepare("INSERT INTO tbl_staff(stf_email, stf_firstname, stf_lastname, stf_contact, lvl_id, stf_password) VALUES ( :stfemail, :stffirst, :stflast, :stfcont, :lvlid, :stfpassword)");
		$result = $statement->execute(
			array(
				':stfemail' => $_POST["stfemail"],
				':stffirst'	=>	$_POST["stffirst"],
				':stflast'	=>	$_POST["stflast"],
				':stfcont'	=>	$_POST["stfcont"],
				':lvlid'	=>	$_POST["lvlid"],
				':stfpassword'	=>	$encryptpass
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
