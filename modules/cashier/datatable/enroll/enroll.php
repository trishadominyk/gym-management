<?php
include('../db.php');
include("function.php");

if(isset($_POST["cust_id"])){
    //check if existing record in class
    if($_POST['action'] == 'class'){
        if(check_enrolled($_POST["cls_id"], $_POST["cust_id"]) > 0){
            echo 'Error. Customer is already enrolled in this class category.';
        }
        else{
            $statement = $connection->prepare(
                "INSERT INTO tbl_transtemp(cls_id, cust_id) VALUES(:cls_id, :cust_id)"
            );
            $result = $statement->execute(
                array(
                    ':cls_id'	=>	$_POST["cls_id"],
                    ':cust_id'	=>	$_POST["cust_id"]
                )
            );

            if(!empty($result))
                echo 'Successfully enrolled.';
            else
                echo 'Unsuccessful';   
        }
    }
    else if($_POST['action'] == 'membership'){
        //check if availed current membership or pending membership
        if(check_membership($_POST["cust_id"]) > 0){
            echo 'Error. Customer currently has a membership.';
        }
        else if(check_pendingmembership($_POST["cust_id"]) > 0){
            echo 'Error. Customer currently has a pending membership.';
        }
        else{
            $statement = $connection->prepare(
                "INSERT INTO tbl_transtemp(met_id, cust_id) VALUES(:met_id, :cust_id)"
            );
            $result = $statement->execute(
                array(
                    ':met_id'	=>	$_POST["met_id"],
                    ':cust_id'	=>	$_POST["cust_id"]
                )
            );

            if(!empty($result))
                echo 'Successfully enrolled in a membership.';
            else
                echo 'Unsuccessful';   
        }
    }
}