<?php
include('../../library/config.php');
include('../../classes/class.staff.php');

$staff = new Staff();

$log_id = $_GET['log_id'];
$wrk_id = $_GET['wrk_id'];

$data = array();

//update tbl_logbook
$result = $staff->assign_workout($log_id,$wrk_id);

//insert into tbl_progress
$result = $staff->new_progress($log_id);
        
//get progress id
$pro_id = $staff->get_progressid($log_id);
    
//insert activity progress
$list = $staff->get_progactivities($wrk_id);
foreach($list as $row){
    $result = $staff->new_progactivities($pro_id,$row['wra_id']);
}

if(!empty($result))
    $data['action'] = 'true';
else
    $data['action'] = 'false';
        
echo json_encode($data);