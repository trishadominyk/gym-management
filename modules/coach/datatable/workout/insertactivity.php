<?php
include('../db.php');
include('function.php');

if(check_workoutactivity($_POST['wrk_id'],$_POST['act_name'])){
    $statement = $connection->prepare("INSERT INTO tbl_workoutact(wrk_id, act_id, wra_sets) VALUES (:wrk_id, :act_id, :wra_sets)");

    $result = $statement->execute(
        array(
            ':wrk_id'	=>	$_POST["wrk_id"],
            ':act_id'	=>	$_POST["act_name"],
            ':wra_sets' =>  $_POST["wra_sets"]
        )
    );

    if(!empty($result))
        echo 'Activity added.';
    else{
        echo 'Error. Cannot add.';
    }
}
else
    echo 'Error. Activity exists in workout rountine.';