<?php
include('../../library/config.php');
include('../../classes/class.client.php');

$client = new Client();

$email = $_GET['email'];
$password = md5($_GET['password']);

$list = $client->mobile_customer_login($email, $password);

$i = array();
if($list){
	$i['action'] = 'true';
	foreach($list as $value){
		$i['id'] = $value['cust_id'];
		$i['id'] = $value['cust_id'];
		$i['firstName'] = $value['cust_firstname'];
		$i['lastName'] = $value['cust_lastname'];
		$i['memid'] = $value['mem_id'];

	}
}
else{
	$i['action'] = 'false';
}

echo json_encode($i);
