<?php
include('../../library/db.php');

if(isset($_POST["operation"]))
{
	if($_POST["operation"] == "Save")
	{
		$statement = $connection->prepare("UPDATE tbl_customer SET cust_email = :custemail, cust_firstname = :custfirst, cust_lastname = :custlast WHERE cust_id = :custid");
		$result = $statement->execute(
			array(
				':custemail' => $_POST["stfemail"],
				':custfirst'	=>	$_POST["stffirst"],
				':custlast'	=>	$_POST["stflast"],
				':custid'	=>	$_POST["custid"]
			)
		);
		if(!empty($result))
		{
			echo 'Profile Updated';
		}
	}
	if($_POST["operation"] == "Edit")
	{

		$statement = $connection->prepare("UPDATE tbl_customer SET cust_email = :custemail, cust_firstname = :custfirst, cust_lastname = :custlast WHERE cust_id = :custid");
		$result = $statement->execute(
			array(
				':custemail' => $_POST["stfemail"],
				':custfirst'	=>	$_POST["stffirst"],
				':custlast'	=>	$_POST["stflast"],
				':custid'	=>	$_POST["custid"]
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
		$statement = $connection->prepare("UPDATE tbl_customer SET cust_password = :stfpass WHERE cust_id = :custid");
		$result = $statement->execute(
			array(
				':custid' => $_POST["stfidpass"],
				':stfpass'	=>	md5($_POST["conpass"])

			)
		);
		if($result){
			echo 'Password successfully updated!';
		}
	}
}


 ?>
