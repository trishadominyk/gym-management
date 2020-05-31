<?php
include('../../library/config.php');
include('../../classes/class.staff.php');

$staff = new Staff();

$id = $_GET['id'];

$data = array();

$result = $staff->retrieve_workoutactivities($id);
        
foreach($result as $row){
    array_push($data, array('act_name'=>$row['act_name'], 'wra_sets'=>$row['wra_sets']));
}
        
echo json_encode($data);