<?php
function get_categoryname($id){
    include('../../../../library/db.php');
    
	$statement = $connection->prepare(
        "SELECT * FROM tbl_classcategory 
        WHERE clc_id = $id"
    );
	$statement->execute();
    $result = $statement->fetch();
    
    return strtolower($result['clc_name']);
}

function get_total_all_records($q){
    include('../../../../library/db.php');
    
	$statement = $connection->prepare("$q");
	$statement->execute();
    
    return $statement->rowCount();
}
 
function check_lastlog($id){
    include('../../../../library/db.php');
    
	$statement = $connection->prepare(
        "SELECT L.log_date FROM tbl_logbook L
        INNER JOIN tbl_record R ON L.rec_id = L.rec_id
        WHERE R.rec_id = $id
        ORDER BY L.log_date DESC
        LIMIT 1"
    );
	$statement->execute();
    $result = $statement->fetch();
    
    return $result['log_date'];
}

function get_wrkid(){
    include('../../../../library/db.php');
    
	$statement = $connection->prepare(
        "SELECT * FROM tbl_workoutplan 
        ORDER BY wrk_id DESC"
    );
	$statement->execute();
    $result = $statement->fetch();
    
    return strtolower($result['wrk_id']);
}

function get_wrkname($id){
    include('../../../../library/db.php');
    
	$statement = $connection->prepare(
        "SELECT * FROM tbl_workoutplan 
        WHERE wrk_id = $id"
    );
	$statement->execute();
    $result = $statement->fetch();
    
    return $result['wrk_name'];
}

function get_wrkdesc($id){
    include('../../../../library/db.php');
    
	$statement = $connection->prepare(
        "SELECT * FROM tbl_workoutplan 
        WHERE wrk_id = $id"
    );
	$statement->execute();
    $result = $statement->fetch();
    
    return $result['wrk_desc'];
}

function get_activities($id){
    include('../../../../library/db.php');
	$statement = $connection->prepare("SELECT * FROM tbl_activity A");
	$statement->execute();
	$result = $statement->fetchAll();
    
    return $result;
}

function check_workoutactivity($wrk_id,$act_id){
    include('../../../../library/db.php');
	$statement = $connection->prepare("SELECT * FROM tbl_workoutact WHERE wrk_id = $wrk_id AND act_id = $act_id AND wra_status = 'ACTIVE'");
	$statement->execute();
	$result = $statement->fetchAll();
    
	$count = $statement->rowCount();
    
    if($count == 0)
        return true;
    else
        return false;
}