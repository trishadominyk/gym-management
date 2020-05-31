<?php
function check_email($email){
    include('../db.php');
    $statement = $connection->prepare("SELECT * FROM tbl_customer WHERE cust_email = '$email'");
	return $statement->execute();
}

function get_total_all_records(){
	include('../db.php');
	$statement = $connection->prepare("SELECT * FROM tbl_customer");
	$statement->execute();
	$result = $statement->fetchAll();
    
	return $statement->rowCount();
}

function check_login($id){
    $date = date("Y-m-d");
    
    include('../db.php');
	$statement = $connection->prepare("SELECT * FROM tbl_logbook WHERE cust_id = $id AND log_date = '$date' AND log_timeout IS NUll");
	$statement->execute();
	$result = $statement->fetchAll();
    
	return $statement->rowCount();
}

function check_record($id){
    $date = date("Y-m-d");
    
    include('../db.php');
	$statement = $connection->prepare("SELECT * FROM tbl_logbook WHERE rec_id = $id AND (log_date = '$date' AND log_timeout IS NUll)");
	$statement->execute();
	$result = $statement->fetchAll();
    
	return $statement->rowCount();
}

function generate_logcode(){
    $date = date("Y-m-d");
    
    include('../db.php');
	$statement = $connection->prepare("SELECT * FROM tbl_logbook WHERE log_date = '$date'");
	$statement->execute();
	$result = $statement->fetchAll();
	$count = $statement->rowCount();
    
    $count++;
    
    $date2 = date("md");
    $code = $date2."-".$count;
    
    return $code;
}

function get_currentlog($id, $rec){
    include('../db.php');
	$statement = $connection->prepare("SELECT log_code FROM tbl_logbook WHERE cust_id = $id AND rec_id = $rec AND log_timeout IS NULL");
	$statement->execute();
    $f = $statement->fetch();
    $value =  $f["log_code"];
    
    return $value;
}

function update_record($id){
    include('../db.php');
	$statement = $connection->prepare("UPDATE tbl_record SET rec_session_remain = rec_session_remain - 1 WHERE rec_id = $id");
	return $statement->execute();
}

function check_availablecoach($id){
    include('../db.php');
    
    $date = date('Y-m-d');
    
	$statement = $connection->prepare(
        "SELECT * FROM tbl_stafflogbook WHERE stf_id = $id AND stf_log_out IS NULL"
    );
	$statement->execute();
    $count = $statement->rowCount();
    
    if($count > 0){
        $statement2 = $connection->prepare(
            "SELECT L.log_id
            FROM tbl_logbook L
            LEFT JOIN tbl_progress P ON L.log_id = P.log_id
            WHERE L.stf_id = $id AND (P.pro_status <> 'FINISHED' OR P.pro_status IS NULL) AND L.log_date = '$date'"
        );
        $statement2->execute();
        $count2 = $statement2->rowCount();
        
        if($count2 > 5)
            return false;
        else
            return true;
    }
    else
        return false;    
}

function check_workoutplan($id,$method){
    include('../db.php');
    
    switch($method){
        case 'CODE':
            $statement=$connection->prepare(
                "SELECT * FROM tbl_logbook WHERE log_code = '$id' AND wrk_id = 0"
            );
            $statement->execute();
            $count = $statement->rowCount();
        break;
        case 'LOG':
            $statement=$connection->prepare(
                "SELECT * FROM tbl_logbook WHERE log_id = $id AND wrk_id = 0"
            );
            $statement->execute();
            $count = $statement->rowCount();
        break;
    }
    if($count == 1)
        return false;
    else
        return true;
}