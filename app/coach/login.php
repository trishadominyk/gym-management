<?php
include('../../library/config.php');
include('../../classes/class.staff.php');

$staff = new Staff();

$email = $_GET['email'];
$password = md5($_GET['password']);

$r = $staff->mobile_staff_login($email, $password);
    
$i = array();
if($r){
	$i['action'] = 'true';
	
	foreach($r as $value){
		$i['id'] = $value['stf_id'];
		$i['firstName'] = $value['stf_firstname'];
		$i['lastName'] = $value['stf_lastname'];
		$i['lvl'] = $value['lvl_name'];
	}
}
else{
	$i['action'] = 'false';
}

echo json_encode($i);