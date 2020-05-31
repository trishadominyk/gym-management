<?php
include('../db.php');

$contact = (!empty($_POST['custcontact'])) ? $_POST['custcontact'] : '' ;
$emergency = (!empty($_POST['custemergency'])) ? $_POST['custemergency'] : '' ;

$statement = $connection->prepare("INSERT INTO tbl_customer (cust_firstname, cust_lastname, cust_email, cust_birthday, cust_contact, cust_emergency, cust_password, cust_date_added) VALUES (:custfname, :custlname, :custemail, :custbirthday, :custcontact, :custemergency, :custpassword, CURDATE())");

$result = $statement->execute(
    array(
        ':custfname'	=>	$_POST["custfname"],
        ':custlname'	=>	$_POST["custlname"],
		':custemail'	=>	$_POST["custemail"],
		':custbirthday'	=>	$_POST["custbirthday"],
		':custcontact'	=>	$contact,
		':custemergency'	=>	$emergency,
        ':custpassword' =>  md5($_POST["custpassword"])
	)
);

if(!empty($result))
    echo 'Client record added.';
else
    echo 'Error. Cannot insert';