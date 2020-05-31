<?php
include('../../library/config.php');
include('../../classes/class.client.php');

$client = new Client();

$id = $_GET['id'];

$data = array();

if(!empty($_GET['id'])){
	$r = $client->get_client_progress($id);

	foreach($r as $row){
        array_push($data, array('log_id'=>$row['log_id'], 'log_date'=>$row['log_date'], 'pro_percentage'=>$row['pro_percentage']));
    }
	
	echo json_encode($data);
}
