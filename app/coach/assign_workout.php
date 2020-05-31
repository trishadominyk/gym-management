<?php
include('../../library/config.php');
include('../../classes/class.staff.php');

$staff = new Staff();

$log_id = $_GET['log_id'];

$data = array();

$result = $staff->retrieve_workout($log_id);
        
foreach($result as $row){
    array_push($data, array('wrk_id'=>$row['wrk_id'],'wrk_name'=>$row['wrk_name'], 'wrk_desc'=>$row['wrk_desc']));
}
        
echo json_encode($data);