<?php
include('../../library/config.php');
include('../../classes/class.staff.php');

$staff = new Staff();

$fname = $_GET['fname'];
$lname = $_GET['lname'];
$contact = $_GET['contact'];
$email = $_GET['email'];
$id = $_GET['id'];

$data = array();

$result = $staff->edit_staff($fname,$lname,$contact,$email,$id);
        
if($result)
    $data['action'] = 'true';
else
    $data['action'] = 'false';
        
echo json_encode($data);