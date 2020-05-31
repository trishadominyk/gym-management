<?php
include('../db.php');
include('function.php');

if(isset($_POST['log_id']) && isset($_POST['wrk_id'])){
    $statement = $connection->prepare("UPDATE tbl_logbook 
    SET wrk_id = :wrk_id WHERE log_id = :log_id");

    $result = $statement->execute(
        array(
            ':wrk_id'	=>	$_POST["wrk_id"],
            ':log_id'	=>	$_POST["log_id"]
        )
    );
    
    $statement2 = $connection->prepare("INSERT INTO tbl_progress(log_id,pro_start)
    VALUES(:log_id,:pro_start)");

    $result2 = $statement2->execute(
        array(
            ':log_id'	    =>	$_POST["log_id"],
            ':pro_start'	=>	date('H:i:s')
        )
    );

    if(!empty($result) && !empty($result2)){
        //get progress id
        $pro_id = get_progressid($_POST["log_id"]);
        
        //insert activity progress
        $list = get_activities($_POST["wrk_id"]);
        
        if($list){
            foreach($list as $value){
                //update activity progress function
                $update = insert_activityprogress($pro_id, $value["wra_id"]);
            }

            echo 'Begin your workout!';
        }
    }
    else
        echo 'Error. Cannot insert';
}