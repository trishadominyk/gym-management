<?php
include('../../../../library/db.php');
include('function.php');

$date = date('Y-m-d');

/*//check if active membership and pending membership
    if(check_membership($cust)){
        if(check_pending($cust)){
            if(new_transaction($cust)){
                $trans = get_transid($cust);

                $result = insert_transitem($trans,$met);

                if(!empty($result)){
                    $total = get_rate($met);

                    update_totalamount($total,$trans);

                    $msg = 'Successfully availed membership. Please pay the cashier at the gym your due amount of Php '.number_format($total,2);

                    echo $msg;
                }
                else
                    echo 'Unsuccessful membership purchase';
            }
        }
        else
            echo 'Error. Client has pending membership';
    }
    else
        echo 'Error. Client has an existing membership.';*/

//check if email exists
if(check_existing($_POST['email'])){
    $emergency = ($_POST['emergency'] != null) ? $_POST['emergency'] : '';
    $contact = ($_POST['contact'] != null) ? $_POST['contact'] : '';
    //create new profile
    $statement = $connection->prepare("INSERT INTO tbl_customer(cust_code, cust_firstname, cust_lastname, cust_email, cust_birthday, cust_password, cust_contact, cust_emergency, cust_date_added) VALUES(:cust_code, :cust_firstname, :cust_lastname, :cust_email, :cust_birthday, :cust_password, :cust_contact, :cust_emergency, :cust_date_added)");

    $result = $statement->execute(
        array(
            ':cust_code'	=>	generateRandomString(),
            ':cust_firstname'	=>	$_POST['firstName'],
            ':cust_lastname'   	=>	$_POST['lastName'],
            ':cust_email'   	=>	$_POST['email'],
            ':cust_birthday'   	=>	$_POST['birthday'],
            ':cust_password'	=>	md5($_POST['password']),
            ':cust_contact'	    =>	$contact,
            ':cust_emergency'	=>	$emergency,
            ':cust_date_added'  =>  $date
        )
    );
    
    if($result)
        echo 'Thank you for registering to Six One Zero Zero! ';
    else
        echo 'Error';
    
    if($_POST['membership'] != null){
        //get_custid
        $cust = get_custid();
        $met = $_POST['membership'];

        //generate pending membership if there is
        if(new_transaction($cust)){
                $trans = get_transid($cust);

                $result = insert_transitem($trans,$met);

                if(!empty($result)){
                    $total = get_rate($met);

                    update_totalamount($total,$trans);

                    $msg = 'Successfully availed membership. Please pay the cashier at the gym your due amount of Php '.number_format($total,2);

                    echo $msg;
                }
                else
                    echo 'Unsuccessful membership purchase';
            }
    }
}
else
    echo 'Error. Email already in use.';