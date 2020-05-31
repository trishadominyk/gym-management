<?php
include('../../library/config.php');
include('../../classes/class.client.php');

$client = new Client();
$output = array();
$outputb  = array();

$custid = $_GET['custid'];

if(!empty($custid)){

  $check = $client->check_login($custid);

  if($check){
    $output['action'] = 'false';
  }else
    $logid = $client->get_logid($custid);
    $q1 = $client->get_current_class($logid);
    if($q1){
      foreach ($q1 as $value) {
        array_push($output, array('logdate' => $value['log_date'], 'logtimein' => $value['log_timein'],'clsname' => $value['cls_name'], 'stffirstname' => $value['stf_firstname'],'stflastname' => $value['stf_lastname'],'wrkname' => $value['wrk_name'], 'wrkdesc' => $value['wrk_desc'],'logid' => $logid));
      }

    }else
      echo '';
  }
echo json_encode($output);
