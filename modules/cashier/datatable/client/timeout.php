<?php
include('../db.php');
include("function.php");

if(isset($_POST["cust_id"]) && isset($_POST["rec_id"])){
	$code = get_currentlog($_POST["cust_id"], $_POST["rec_id"]);
    $time = date("H:i:s");
    
    if($code != ''){
        //check if workout plan is assigned
        if(check_workoutplan($code,'CODE')){
            //check if workout progress is finished
            $statement = $connection->prepare(
                "UPDATE tbl_logbook SET log_timeout = '$time' WHERE log_code = '$code' AND rec_id = :rec_id AND log_timeout IS NULL"
            );
            $result = $statement->execute(
                array(
                    ':rec_id'	=>	$_POST["rec_id"]
                )
            );

            if(!empty($result))
            {
                echo 'Client successfully timed out.';
            }
        }
        else
            echo 'Assign a workout plan before timing out.';
    }
}
else if(isset($_POST["log_id"])){
    $id = $_POST["log_id"];
    $time = date("H:i:s");
    
    //check if workout plan is assigned
    if(check_workoutplan($id,'LOG')){
        $statement = $connection->prepare(
            "UPDATE tbl_logbook SET log_timeout = '$time' WHERE log_id = :log_id AND log_timeout IS NULL"
        );
        $result = $statement->execute(
            array(
                ':log_id'	=>	$_POST["log_id"]
            )
        );

        if(!empty($result))
                echo 'Client successfully timed out.';
    }
    else
        echo 'Assign a workout plan before timing out.';
}
else if(isset($_POST["stf_id"])){
    $id = $_POST["stf_id"];
    $time = date("H:i:s");
    
    $statement = $connection->prepare(
        "UPDATE tbl_stafflogbook SET stf_log_out = '$time' WHERE stf_id = :stf_id AND stf_log_out IS NULL"
    );
    $result = $statement->execute(
        array(
            ':stf_id'	=>	$_POST["stf_id"]
        )
    );

    if(!empty($result)){
        echo 'Staff successfully timed out.';}
    else
        echo 'Error. Cannot update staff.';
}