<?php
include('../../library/config.php');
include('../../classes/class.workoutplan.php');

$workout = new WorkoutPlan();

$id = $_GET['id'];

$data = array();

$result = $workout->get_workoutplans($id);

if($result){
    foreach($result as $row){
        array_push($data, array('wrk_id'=>$row['wrk_id'], 'wrk_name'=>$row['wrk_name']));
    }
}

echo json_encode($data);
