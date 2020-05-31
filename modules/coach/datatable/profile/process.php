<?php
include('../../library/db.php');

if(isset($_POST["operation"]))
{
	if($_POST["operation"] == "Save")
	{
		$statement = $connection->prepare("UPDATE tbl_staff SET stf_email = :stfemail, stf_firstname = :stffirst, stf_lastname = :stflast, stf_contact = :stfcont WHERE stf_id = :stfid");
		$result = $statement->execute(
			array(
				':stfemail' => $_POST["stfemail"],
				':stffirst'	=>	$_POST["stffirst"],
				':stflast'	=>	$_POST["stflast"],
				':stfcont'	=>	$_POST["stfcont"],
				':stfid'	=>	$_POST["stfid"]
			)
		);
		if(!empty($result))
		{
			echo 'Profile Updated';
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


if(isset($_POST['operation-pass'])){
	if($_POST["operation-pass"] == "Save"){
		$statement = $connection->prepare("UPDATE tbl_staff SET stf_password = :stfpass WHERE stf_id = :stfid");
		$result = $statement->execute(
			array(
				':stfid' => $_POST["stfidpass"],
				':stfpass'	=>	md5($_POST["conpass"])

			)
		);
		if($result){
			echo 'Password successfully updated!';
		}
	}
}


 ?>
