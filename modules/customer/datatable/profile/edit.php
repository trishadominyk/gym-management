<?php
include('../../../../library/db.php');

    $emergency = ($_POST['emergency'] != null) ? $_POST['emergency'] : '';
    $contact = ($_POST['contact'] != null) ? $_POST['contact'] : '';

    $id = $_POST['cust_id'];

    //create new profile
    $statement = $connection->prepare("UPDATE tbl_customer SET cust_firstname = :cust_firstname, cust_lastname = :cust_lastname, cust_email = :cust_email, cust_birthday = :cust_birthday, cust_contact = :cust_contact, cust_emergency = :cust_emergency WHERE cust_id = $id");

    $result = $statement->execute(
        array(
            ':cust_firstname'	=>	$_POST['firstName'],
            ':cust_lastname'   	=>	$_POST['lastName'],
            ':cust_email'   	=>	$_POST['email'],
            ':cust_birthday'   	=>	$_POST['birthday'],
            ':cust_contact'	    =>	$contact,
            ':cust_emergency'	=>	$emergency
        )
    );
    
    if($result)
        echo 'Successfully saved. ';
    else
        echo 'Error';