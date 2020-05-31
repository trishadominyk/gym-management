<?php
include('../db.php');
include("function.php");

if(isset($_POST["cust_id"]) && isset($_POST["met_id"])){
    $date = date("Y-m-d");
    
    $result = update_membership($_POST["met_id"], $_POST["cust_id"]);
    
        //get_transaction id
        $trans_id = get_transid($_POST["cust_id"], $_POST["met_id"]);
            
        //update tbl_transitems
        $update = update_transitem($trans_id, $_POST["met_id"]);
            
        if($update)
            echo 'Congrats! ';
}