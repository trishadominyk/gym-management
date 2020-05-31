<?php
function check_existing($email){
    include('../../../../library/db.php');
    
	$statement = $connection->prepare(
        "SELECT * FROM tbl_customer WHERE cust_email = '$email'"
    );
	$statement->execute();
    
    $count = $statement->rowCount();
    
    if($count == 0)
        return true;
    else
        return false;
}

function check_pending($id){
    include('../../../../library/db.php');
    
	$statement = $connection->prepare(
        "SELECT C.cust_id, C.cust_firstname, C.cust_lastname, C.cust_email, I.met_id, M.met_name, T.trns_id FROM tbl_customer C 
        INNER JOIN tbl_transaction T ON C.cust_id = T.cust_id
        INNER JOIN tbl_transitems I ON T.trns_id = I.trns_id
        INNER JOIN tbl_membershiptype M ON M.met_id = I.met_id
        WHERE C.cust_id = $id AND I.trni_remarks = 'PENDING'"
    );
	$statement->execute();
    
    $count = $statement->rowCount();
    
    if($count == 0)
        return true;
    else
        return false;
}

function generate_code(){
    include('../../../../library/db.php');
    
    $date = date('Y-m-d');

	$statement = $connection->prepare("SELECT * FROM tbl_transaction WHERE trns_date LIKE '$date %'");
	$statement->execute();
    $count = $statement->rowCount();
    $count++;
    
    $datecode = date('mdy');
    $code = $datecode.'-'.$count;
    
    return $code;
}

function new_transaction($cust){
    include('../../../../library/db.php');
    
    $date = date('Y-m-d H:i:s');
    
    $statement = $connection->prepare("INSERT INTO tbl_transaction(cust_id, trns_code, trns_date) VALUES(:cust_id, :trns_code, :trns_date)");

    $result = $statement->execute(
        array(
            ':cust_id'	    =>	$cust,
            ':trns_code'	=>	generate_code(),
            ':trns_date'	=>	$date
        )
    );
    
    return $result;
}

function get_transid($cust){
    include('../../../../library/db.php');
    
    $date = date('Y-m-d');
    
	$statement = $connection->prepare(
        "SELECT trns_id FROM tbl_transaction
        WHERE cust_id = $cust ORDER BY trns_id DESC
        LIMIT 1"
    );
	$statement->execute();
    $result = $statement->fetch();
    
    return $result['trns_id'];
}

function get_rate($met){
    include('../../../../library/db.php');
    
	$statement = $connection->prepare(
        "SELECT met_rate FROM tbl_membershiptype WHERE met_id = $met"
    );
	$statement->execute();
    $result = $statement->fetch();
    
    return $result['met_rate'];
}

function insert_transitem($trans,$met){
    include('../../../../library/db.php');
    
    //with the remarks of pending ples
    $statement = $connection->prepare("INSERT INTO tbl_transitems(trni_amount,trns_id,met_id,trni_remarks) VALUES(:trni_amount,:trns_id,:met_id,:trni_remarks)");

    $result = $statement->execute(
        array(
            ':trni_amount'	=>	get_rate($met),
            ':trns_id'	    =>	$trans,
            ':met_id'   	=>	$met,
            ':trni_remarks'	=>	'PENDING'
        )
    );
    
    return $result;
}

function update_totalamount($total,$trans){
    include('../../../../library/db.php');
    
    $statement = $connection->prepare(
        "UPDATE tbl_transaction SET trns_total = $total WHERE trns_id = $trans"
    );
    $result = $statement->execute();
    
    return $result;
}

function get_custid(){
    include('../../../../library/db.php');
    
	$statement = $connection->prepare(
        "SELECT cust_id FROM tbl_customer ORDER BY cust_id DESC LIMIT 1"
    );
	$statement->execute();
    $result = $statement->fetch();
    
    return $result['cust_id'];
}

function generateRandomString(){
    $length = 15;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}