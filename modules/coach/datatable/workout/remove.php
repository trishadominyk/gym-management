<?php
include('../db.php');
include('function.php');

if(!empty($_POST['wra_id'])){
    $statement = $connection->prepare("UPDATE tbl_workoutact SET wra_status = 'REMOVED' WHERE wra_id = :wra_id");

    $result = $statement->execute(
        array(
            ':wra_id'	=>	$_POST["wra_id"]
        )
    );

    if(!empty($result))
        echo 'Activity removed.';
    else{
        echo 'Error. Cannot update.';
    }
}