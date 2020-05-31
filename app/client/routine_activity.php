<?php
include('../../library/config.php');
include('../../classes/class.client.php');

$client = new Client();
$output = array();

$logid = '';
$custid = $_GET['custid'];

if(!empty($custid)){

  $check = $client->check_login($custid);

  if($check){
    $output['action'] = 'false';

  }else
    $logid = $client->get_logid($custid);
    $q1 = $client->get_current_class($logid);

    $q2 = $client->get_workout_plan($logid);

    if($q2){
      foreach($q2 as $value){
        array_push($output, array('actname' => $value['act_name'], 'acpstatus' => $value['acp_status'], 'wrasets' => $value['wra_sets']));
      }
    }else
      echo '';
}

echo json_encode($output);
