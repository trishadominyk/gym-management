<?php
include('../library/config.php');
include('../classes/class.staff.php');
include('../classes/class.client.php');

$staff = new Staff();
$client = new Client();

$email = $_GET['email'];
$password = md5($_GET['password']);

$i = array();

if($staff->mobile_staff_login($email, $password)){
    $i['action'] = 'true';
    
    $r = $staff->mobile_staff_login($email, $password);
    
    foreach($r as $value){
		$i['id'] = $value['stf_id'];
		$i['firstName'] = $value['stf_firstname'];
		$i['lastName'] = $value['stf_lastname'];
		$i['lvl'] = $value['lvl_name'];
	}
}
else if($client->mobile_client_login($email, $password)){
    $i['action'] = 'true';
    
    $r = $client->mobile_client_login($email, $password);
    
    foreach($r as $value){
		$i['id'] = $value['cust_id'];
		$i['firstName'] = $value['cust_firstname'];
		$i['lastName'] = $value['cust_lastname'];
		$i['lvl'] = 'CLIENT';
	}
}
else{
    $i['action'] = 'false';
}
    
echo json_encode($i);