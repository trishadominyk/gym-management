<?php
include('../db.php');
include('function.php');

if(isset($_POST["acp_id"]) && isset($_POST["action"])){
    $action = $_POST["action"];
    
    switch($action){
        case 'complete':
            $statement = $connection->prepare(
                "UPDATE tbl_actprogress SET acp_status = 'COMPLETE'
                WHERE acp_id = :acp_id"
            );
            $result = $statement->execute(
                array(
                    ':acp_id'	=>	$_POST["acp_id"]
                )
            );
        break;
        case 'incomplete':
            $statement = $connection->prepare(
                "UPDATE tbl_actprogress SET acp_status = 'INCOMPLETE'
                WHERE acp_id = :acp_id"
            );
            $result = $statement->execute(
                array(
                    ':acp_id'	=>	$_POST["acp_id"]
                )
            );
        break;
        case 'skipped':
            $statement = $connection->prepare(
                "UPDATE tbl_actprogress SET acp_status = 'SKIPPED'
                WHERE acp_id = :acp_id"
            );
            $result = $statement->execute(
                array(
                    ':acp_id'	=>	$_POST["acp_id"]
                )
            );
        break;
    }
    
    //update progress percentage ples
    $id = get_proid($_POST['acp_id']);
    
    $total = count_activities($id, 'TOTAL');
    $complete = count_activities($id, 'COMPLETE');
    $incomplete = count_activities($id, 'INCOMPLETE');
    
    $completed = $complete + (0.5 * $incomplete);
    
    $percentage = ($completed / $total) * 100;
    
    $result = update_propercent($id, round($percentage,2));
    
    if(!empty($result))
	{
        echo 'Success.';
	}
}