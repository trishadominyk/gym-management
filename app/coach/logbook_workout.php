<?php
include('../../library/config.php');
include('../../classes/class.client.php');

$client = new Client();

$id = $_GET['id'];

$data = array();

$result = $client->get_logbook_workout($id);
        
foreach($result as $row){
    array_push($data, array('pro_id'=>$row['pro_id'],'acp_id'=>$row['acp_id'],'act_name'=>$row['act_name'], 'wra_sets'=>$row['wra_sets'],'act_status'=>$row['acp_status']));
}

//ples pass acp_id to activityprogress.php and then the action from the buttons
        
echo json_encode($data);