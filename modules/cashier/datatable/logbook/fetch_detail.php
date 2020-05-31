<?php 
include ('../db.php');
include ('function.php');

if(isset($_POST['rec_id']) && isset($_POST['log_id'])){  
    $output = array();
    $statement = $connection->prepare(
    "SELECT C.cust_firstname, C.cust_lastname, L.cls_name, R.rec_enroll, R.rec_expire, R.rec_session_remain FROM tbl_record R
    INNER JOIN tbl_transaction T ON R.trns_id = T.trns_id
    INNER JOIN tbl_transitems I ON T.trns_id = I.trns_id
    INNER JOIN tbl_class L ON I.cls_id = L.cls_id
    INNER JOIN tbl_customer C ON T.cust_id = C.cust_id
    WHERE R.rec_id = ".$_POST["rec_id"]."
    LIMIT 1"
    );
    $statement->execute();
    $result = $statement->fetchAll();
 
    foreach($result as $row){
        $name = $row["cust_firstname"]." ".$row["cust_lastname"];
        
        $output["cust_name"] = $name;
        $output["cls_name"] = $row["cls_name"];
        $output["rec_valid"] = date("M d, Y", strtotime($row["rec_enroll"])).' - '.date("M d, Y", strtotime($row["rec_expire"]));
        $output["rec_session_remain"] = $row["rec_session_remain"];
    }
    
    $statement2 = $connection->prepare(
        "SELECT W.wrk_name, L.stf_id, A.act_name, WA.wra_sets
        FROM tbl_progress P
        INNER JOIN tbl_logbook L ON P.log_id = L.log_id
        LEFT JOIN tbl_workoutplan W ON L.wrk_id = W.wrk_id
        INNER JOIN tbl_workoutact WA ON W.wrk_id = WA.wrk_id
        INNER JOIN tbl_activity A ON WA.act_id = A.act_id
        WHERE P.log_id = ".$_POST['log_id']." "
    );
    $statement2->execute();
    $result2 = $statement2->fetchAll(); 
    
    $staff = '';
    $workout = 'Workout routine not assigned.';
    
    $output["act_name"] = '<ul>';
    foreach($result2 as $row2){
        $output["act_name"] .= '<li><b>'.$row2["act_name"].'</b> : '.$row2['wra_sets'].' sets</li>';
        $staff = $row2["stf_id"];
        $workout = $row2["wrk_name"];
    }
    $output["act_name"] .= '</ul>';
    
    $output["stf_name"] = 'Coach '.get_staffname($staff);
    $output["wrk_name"] = $workout;
    
    echo json_encode($output);
}
else
    echo "Error retrieving.";
