<?php
include('../db.php');
include("function.php");

if(isset($_POST["trns_id"]) && isset($_POST["met_id"])){
    $statement = $connection->prepare(
        "DELETE FROM tbl_transitems WHERE trni_remarks = 'PENDING' AND trns_id = :trns_id AND met_id = :met_id"
    );
    $result = $statement->execute(
        array(
            ':trns_id'	=>	$_POST["trns_id"],
            ':met_id'	=>	$_POST["met_id"]
        )
    );

    if(!empty($result))
        echo 'Cancelled request.';
    else
        echo "Error.";
}