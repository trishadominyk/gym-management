<?php
include('../db.php');
include('function.php');

$output = array();

if(isset($_POST['id'])){
    $id = $_POST['id'];
    
    $log_id = get_logid($id);
}
else if(isset($_POST['log_id']))
    $log_id = $_POST['log_id'];
    
    $query = '';
    $query .= "SELECT A.act_name, AP.acp_status, WA.wra_sets
            FROM tbl_logbook L
            INNER JOIN tbl_progress P ON L.log_id = P.log_id
            INNER JOIN tbl_actprogress AP ON P.pro_id = AP.pro_id
            INNER JOIN tbl_workoutact WA ON AP.wra_id = WA.wra_id
            INNER JOIN tbl_activity A ON WA.act_id = A.act_id
            WHERE L.log_id = $log_id 
            ";

    $statement = $connection->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $data = array();
    $filtered_rows = $statement->rowCount();
    $stat = '';

    foreach($result as $row){
        $status = $row["acp_status"];
        
        if($status == "SKIPPED")
            $stat = '<span class="btn-gray btn-xs" style="font-size: x-small;">Skipped</span>';
        else if($status == "COMPLETE")
            $stat = '<span class="btn-green btn-xs" style="font-size: x-small;">Complete</span>';
        else if($status == "INCOMPLETE")
            $stat = '<span class="btn-red btn-xs" style="font-size: x-small;">Incomplete</span>';

        $sub_array = array();
        
        $sub_array[] = $row["act_name"];
        $sub_array[] = $row["wra_sets"];
        $sub_array[] = $stat;
        
        $data[] = $sub_array;
    }

    $output = array(
        "draw"				=>	intval($_POST["draw"]),
        "recordsTotal"		=> 	$filtered_rows,
        "data"				=>	$data
    );
echo json_encode($output);