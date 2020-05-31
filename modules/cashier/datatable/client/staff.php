<?php
include('../db.php');
include('function.php');

if(isset($_POST['rec_id'])){
    $id = $_POST['rec_id'];
    
    $output = array();
    
    $statement = $connection->prepare(
        "SELECT S.stf_id, S.stf_firstname, S.stf_lastname, CC.clc_name
        FROM tbl_record R
        INNER JOIN tbl_transaction T ON R.trns_id = T.trns_id
        INNER JOIN tbl_transitems I ON T.trns_id = I.trns_id
        INNER JOIN tbl_class C ON I.cls_id = C.cls_id
        INNER JOIN tbl_classcategory CC ON C.clc_id = CC.clc_id
        INNER JOIN tbl_staffclass SC ON CC.clc_id = SC.clc_id
        INNER JOIN tbl_staff S ON SC.stf_id = S.stf_id
        WHERE R.rec_id = $id"
    );
 
    $statement->execute();
    $result = $statement->fetchAll();
    
    $output["stf_body"] = '';
    foreach($result as $row){
        //ples add function 2 check if coach is available (logged in and not reached max limit of customers) tenkyu
        if(check_availablecoach($row["stf_id"])){
            $output["stf_body"] .= '<tr><td>'.$row["stf_firstname"].' '.$row["stf_lastname"].'</td><td class="td-button"><button id="'.$row["stf_id"].'" class="btn btn-xs btn-warning selectstaff">Select</button></td></tr>';
        }
        else{
            $output["stf_body"] .= '<tr><td colspan="2">Coach '.$row["stf_firstname"].' '.$row["stf_lastname"].' is not available at the moment.</td></tr>';
        }
    }
}

echo json_encode($output);