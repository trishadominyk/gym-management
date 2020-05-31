<?php
function get_classlist($id){
    include('../db.php');
    
	$statement = $connection->prepare(
        "SELECT clc_id FROM tbl_staffclass WHERE stf_id = $id"
    );
	$statement->execute();
    $result = $statement->fetchAll();
    
    return $result;
}

function get_custname($id){
    include('../db.php');
    
	$statement = $connection->prepare(
        "SELECT C.cust_firstname, C.cust_lastname
        FROM tbl_logbook L
        INNER JOIN tbl_record R ON L.rec_id = R.rec_id
        INNER JOIN tbl_transaction T ON R.trns_id = T.trns_id
        INNER JOIN tbl_customer C ON T.cust_id = C.cust_id
        WHERE L.log_id = $id LIMIT 1"
    );
	$statement->execute();
    $result = $statement->fetch();
    
    $name = $result['cust_firstname'].' '.$result['cust_lastname'];
    
    return $name;
}

function get_wrkname($id){
    include('../db.php');
    
	$statement = $connection->prepare(
        "SELECT W.wrk_name
        FROM tbl_logbook L
        INNER JOIN tbl_workoutplan W ON L.wrk_id = W.wrk_id
        WHERE L.log_id = $id"
    );
	$statement->execute();
    $result = $statement->fetch();
    
    return $result['wrk_name'];
}

function get_wrkdesc($id){
    include('../db.php');
    
	$statement = $connection->prepare(
        "SELECT W.wrk_desc
        FROM tbl_logbook L
        INNER JOIN tbl_workoutplan W ON L.wrk_id = W.wrk_id
        WHERE L.log_id = $id"
    );
	$statement->execute();
    $result = $statement->fetch();
    
    return $result['wrk_desc'];
}

function get_status($id){
    include('../db.php');
    
	$statement = $connection->prepare(
        "SELECT pro_status
        FROM tbl_progress
        WHERE log_id = $id
        LIMIT 1"
    );
	$statement->execute();
    $result = $statement->fetch();
    
    return $result['pro_status'];
}

function get_total_all_records($id){
    include('../db.php');
    
	$statement = $connection->prepare(
        "SELECT * FROM tbl_logbook WHERE stf_id = $id"
    );
	$statement->execute();
	$result = $statement->fetchAll();
    
	return $statement->rowCount();
}


function get_progressid($id){
    include('../db.php');
    
	$statement = $connection->prepare(
        "SELECT * FROM tbl_progress WHERE log_id = $id LIMIT 1"
    );
	$statement->execute();
    $result = $statement->fetch();
    
    return $result['pro_id'];
}

function get_activities($id){
    include('../db.php');
    
	$statement = $connection->prepare(
        "SELECT * FROM tbl_workoutact
        WHERE wrk_id = $id AND wra_status = 'ACTIVE'"
    );
	$statement->execute();
    
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    
    return $result;
}

function insert_activityprogress($progress, $activity){
    include('../db.php');
    
    $statement = $connection->prepare(
        "INSERT INTO tbl_actprogress(wra_id, pro_id)
        VALUES($activity, $progress)"
    );

    $statement->execute();
    
    return $statement->fetchAll();
}

function get_progressrate($id){
    include('../db.php');
    
	$statement = $connection->prepare(
        "SELECT * FROM tbl_progress 
        WHERE log_id = $id LIMIT 1"
    );
	$statement->execute();
    $result = $statement->fetch();
    
    return $result['pro_percentage'];
}

function check_activitycomplete($id){
    include('../db.php');
    
	$statement = $connection->prepare(
        "SELECT * FROM tbl_actprogress WHERE pro_id = $id AND acp_status IS NULL"
    );
	$statement->execute();
	$result = $statement->fetchAll();
    
	return $statement->rowCount();
}

function get_proid($id){
    include('../db.php');
    
	$statement = $connection->prepare(
        "SELECT pro_id FROM tbl_actprogress 
        WHERE acp_id = $id LIMIT 1"
    );
	$statement->execute();
    $result = $statement->fetch();
    
    return $result['pro_id'];
}

function count_activities($id, $status){
    include('../db.php');
    
    switch($status){
        case 'TOTAL':
            $statement = $connection->prepare(
                "SELECT COUNT(acp_id) AS count FROM tbl_actprogress 
                WHERE pro_id = $id LIMIT 1"
            );
            $statement->execute();
            $result = $statement->fetch();
        break;
        default:
            $statement = $connection->prepare(
                "SELECT COUNT(acp_id) AS count FROM tbl_actprogress 
                WHERE pro_id = $id AND acp_status = '$status' LIMIT 1"
            );
            $statement->execute();
            $result = $statement->fetch();
        break;
    }
    
    return $result['count'];
}

function update_propercent($id, $percentage){
    include('../db.php');
    
    $statement = $connection->prepare(
        "UPDATE tbl_progress SET pro_percentage = $percentage WHERE pro_id = $id"
    );
    $result = $statement->execute();
    
    return $result;
}