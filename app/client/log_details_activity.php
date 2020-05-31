<?php
include('../../library/config.php');
include('../../classes/class.client.php');

$client = new Client();

if(!empty($_GET['recid'])){

  $recid = $_GET['recid'];
  $data = array();

  $r = $client->get_record_details($recid);

  if($r){
    foreach($r as $value){
      array_push($data, array('actname' => $value['act_name'], 'status' => $value['acp_status'], 'sets' => $value['wra_sets']));
    }
  }
}
echo json_encode($data);
?>
