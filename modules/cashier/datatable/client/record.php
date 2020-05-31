<?php
include('../db.php');
include('function.php');

if(isset($_POST['cust_id'])){
    $id = $_POST['cust_id'];
    $date = date("Y-m-d");
    
    $output = array();
    
    $statement = $connection->prepare(
        "SELECT R.rec_id, R.rec_session_remain, C.cls_name, T.cust_id, T.trns_code FROM tbl_record R 
        INNER JOIN tbl_transaction T ON R.trns_id = T.trns_id
        INNER JOIN tbl_transitems I ON T.trns_id = I.trns_id
        INNER JOIN tbl_class C ON C.cls_id = I.cls_id
        WHERE T.cust_id = $id AND (R.rec_session_remain >= 0 AND R.rec_expire > '$date')"
    );
 
    $statement->execute();
    $result = $statement->fetchAll();
    $data = array();
    
    foreach($result as $row){
        $action = '';
        
        if(check_record($row["rec_id"]) == 0 && $row["rec_session_remain"] > 0)
           $action .= '<button type="button" name="timein" id="'.$row["cust_id"].'" rec="'.$row["rec_id"].'"class="btn btn-info btn-xs timein">Time In</button>';
        else if(check_record($row["rec_id"]) > 0 || $row["rec_session_remain"] > 0)
           $action .= '<button type="button" name="timeout" id="'.$row["cust_id"].'" rec="'.$row["rec_id"].'" class="btn btn-danger btn-xs timeout">Log Out</button>';
        
        if($row["rec_session_remain"] == 0)
            $action .= '<span class="btn-gray btn-xs">Expired Sessions</span>';
        
        $sub_array = array();
        $sub_array[] = $row["cls_name"];
        $sub_array[] = $row["rec_session_remain"];
        $sub_array[] = $action;
        $data[] = $sub_array;
    }
    
    $output = array(
        "data"  =>  $data
    );
}

echo json_encode($output);