<?php
include('../db.php');

if(isset($_POST["pro_id"])){
    $pro_id = $_POST["pro_id"];
    
    $time = date('H:i:s');
    
    $statement = $connection->prepare(
        "UPDATE tbl_progress SET pro_status = 'FINISHED', pro_end = '$time'
        WHERE pro_id = :pro_id"
    );
    $result = $statement->execute(
        array(
            ':pro_id'	=>	$_POST["pro_id"]
        )
    );
    
    if(!empty($result))
	{
        echo 'Finished Workout.';
	}
}