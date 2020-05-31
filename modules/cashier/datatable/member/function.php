<?php
function get_total_membership_records(){
	include('../db.php');
	$statement = $connection->prepare("SELECT * FROM tbl_transitems WHERE met_id <> 0 AND trni_remarks = 'PENDING'");
	$statement->execute();
	$result = $statement->fetchAll();
    
	return $statement->rowCount();
}

/*function check_existmembership($id){
    include('../db.php');
	$statement = $connection->prepare("SELECT * FROM tbl_membership WHERE cust_id = $id AND mem_status == 'PENDING'");
	$statement->execute();
	$result = $statement->fetchAll();
    
	return $statement->rowCount();
}

function get_memid($id){
    include('../db.php');
	$statement = $connection->prepare("SELECT mem_id FROM tbl_membership WHERE cust_id = $id AND mem_status = 'ACTIVE'");
	$statement->execute();
    $f = $statement->fetch();
    $value =  $f["mem_id"];
    
    return $value;
}

function update_customerinfo($cust, $mem){
    include('../db.php');
	$statement = $connection->prepare("UPDATE tbl_customer SET mem_id = $mem WHERE cust_id = $cust");
	return $statement->execute();
}

function get_transid($cust, $met){
    include('../db.php');
	$statement = $connection->prepare("SELECT T.trns_id FROM tbl_transaction T INNER JOIN tbl_transitems I ON T.trns_id = I.trns_id WHERE T.cust_id = $cust AND I.met_id = $met AND I.trni_remarks = 'PENDING'");
	$statement->execute();
    $f = $statement->fetch();
    $value =  $f["trns_id"];
    
    return $value;
}

function update_transitem($trans, $met){
    include('../db.php');
	$statement = $connection->prepare("UPDATE tbl_transitems SET trni_remarks = 'PAID' WHERE trns_id = $trans AND met_id = $met AND trni_remarks <> 'PAID'");
	return $statement->execute();
}*/


/**FOR ADDING NEW MEMBERSHIPS**/

function get_custid($id){
    include('../db.php');
	$statement = $connection->prepare("SELECT cust_id FROM tbl_membership WHERE mem_id = $id");
	$statement->execute();
    $f = $statement->fetch();
    $value =  $f["cust_id"];
    
    return $value;
}

function new_transactioncode(){
    include('../db.php');
    
    $date = date("Y-m-d");
    
	$statement = $connection->prepare("SELECT * FROM tbl_transaction WHERE date = '$date'");
	$statement->execute();
	$result = $statement->fetchAll();
    
    $code = date("md")."-".$statement->rowCount();
	return $code;
}

function new_transaction($cust, $stf, $met){
    include('../db.php');
    
    $date = date("Y-m-d");
    $code = new_transactioncode();
    
	//insert into tbl_transaction
    $statement = $connection->prepare("INSERT INTO tbl_transaction(trns_code, trns_date, stf_id, cust_id) VALUES('$code', '$date', $stf, $cust)");
	
    $result = $statement->execute();
    if($result){
        //get trans id
        $transid = get_transaction($cust);
        
        //insert into tbl_transitems
        $statement = $connection->prepare("INSERT INTO tbl_transitems(met_id, met_remarks, stf_id, cust_id) VALUES('$code', '$date', $cust)");
        
        //get transitems details
        
        //update transaction
    }
}

function get_transaction($id){
    include('../db.php');
	$statement = $connection->prepare("SELECT trns_id FROM tbl_transaction WHERE cust_id = $id");
	$statement->execute();
    $result = $statement->fetchAll();
    
    foreach($result as $row){
        $value =  $row["trns_id"];
    }
    
    return $value;
}

function new_transitems($trans, $met){
    include('../db.php');
	$statement = $connection->prepare("INSERT INTO tbl_transitems(trns_code, trns_date, stf_id, cust_id) VALUES('$code', '$date', $stf, $cust)");
	return $statement->execute();
}

function generate_expiredate($id){
    include('../db.php');
    
    $statement = $connection->prepare(
        "SELECT * FROM tbl_membershiptype WHERE met_id = :met_id"
    );
    $statement->execute(
        array(
            ':met_id'  =>  $id
        )
    );
    $row = $statement->fetch();
    
    //solve for expiry date
    $date = date("Y-m-d");
    $expire = date("Y-m-d", strtotime($date."+ ".$row['met_duration']." days"));
    
    return $expire;
}

function update_membership($met, $cust){
    include('../db.php');
    
    $statement = $connection->prepare(
        "INSERT INTO tbl_membership(mem_date_added, mem_date_expire, met_id, mem_status, cust_id)
        VALUES(:mem_date_added, :mem_date_expire, :met_id, :mem_status, :cust_id)"
    );
    $result = $statement->execute(
        array(
            ':mem_date_added'   =>  date('Y-m-d'),
            ':mem_date_expire'  =>  generate_expiredate($met),
            ':met_id'   =>  $met,
            ':mem_status'   =>  'ACTIVE',
            ':cust_id'  =>  $cust
        )
    );
    
    if(!empty($result)){
        //get membership id
        $mem_id = get_membershipid($cust);
        
        if(!empty($mem_id)){
        //update tbl_customer
            $statement = $connection->prepare(
                "UPDATE tbl_customer SET mem_id = $mem_id WHERE cust_id = $cust"
            );
            $result = $statement->execute();
            
            if(!empty($result))
                echo 'Succesfully availed a membership. Customer record has been updated. ';
        }
        else
            echo 'Error.';
    }
    else
        echo 'Error. Cannot update membership.';
}

function get_transid($cust, $met){
    include('../db.php');
	$statement = $connection->prepare(
        "SELECT T.trns_id 
        FROM tbl_transaction T 
        INNER JOIN tbl_transitems I ON T.trns_id = I.trns_id 
        WHERE T.cust_id = $cust AND I.met_id = $met AND I.trni_remarks = 'PENDING'"
    );
	$statement->execute();
    $f = $statement->fetch();
    $value =  $f["trns_id"];
    
    return $value;
}

function get_membershipid($cust){
    include('../db.php');
	$statement = $connection->prepare(
        "SELECT mem_id FROM tbl_membership WHERE cust_id = $cust AND mem_status = 'ACTIVE'"
    );
	$statement->execute();
    $f = $statement->fetch();
    $value =  $f["mem_id"];
    
    return $value;
}

function update_transitem($trans, $met){
    include('../db.php');
	$statement = $connection->prepare(
        "UPDATE tbl_transitems 
        SET trni_remarks = 'PAID' 
        WHERE trns_id = $trans AND met_id = $met AND trni_remarks = 'PENDING'"
    );
	return $statement->execute();
}