<?php
include('../db.php');
include('function.php');

$action = $_POST["wrk_action"];

if($action == 'ADD'){
    $statement = $connection->prepare("INSERT INTO tbl_workoutplan(wrk_name, wrk_desc) VALUES (:wrk_name, :wrk_desc)");

    $result = $statement->execute(
        array(
            ':wrk_name'	=>	$_POST["wrk_name"],
            ':wrk_desc'	=>	$_POST["wrk_description"]
        )
    );

    $wrk_id = get_wrkid();

    if(isset($_POST['wrk_class'])){
        foreach($_POST['wrk_class'] as $class)
        {
            $statement = $connection->prepare("INSERT INTO tbl_workoutclass(wrk_id, clc_id) VALUES (:wrk_id, :clc_id)");

            $result = $statement->execute(
                array(
                    ':wrk_id'	=>	$wrk_id,
                    ':clc_id'	=>	$class
                )
            );
        }
    }

    if(!empty($result))
        echo 'Workout routine saved.';
    else
        echo 'Error. Cannot insert';
}
else if($action == 'EDIT'){
    $statement = $connection->prepare("UPDATE tbl_workoutplan SET wrk_name = :wrk_name, wrk_desc = :wrk_desc WHERE wrk_id = :wrk_id");

    $result = $statement->execute(
        array(
            ':wrk_id'	=>	$_POST["wrk_id"],
            ':wrk_name'	=>	$_POST["wrk_name"],
            ':wrk_desc'	=>	$_POST["wrk_description"]
        )
    );
    
    if(!empty($result))
        echo 'Workout routine saved.';
    else
        echo 'Error. Cannot update.';
}