<?php
include('../../library/config.php');
include('../../classes/class.staff.php');

$staff = new Staff();

$pro_id = $_GET['pro_id'];

$data = array();

$result = $staff->finish_workout($pro_id);
        
if($result)
    $data['action'] = 'true';
else
    $date['action'] = 'false';
        
echo json_encode($data);