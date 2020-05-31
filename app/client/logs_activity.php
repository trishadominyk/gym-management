<?php
include('../../library/config.php');
include('../../classes/class.client.php');

$client = new Client();

$custid = $_GET['custid'];

if(!empty($_GET['custid'])){

}
 $r = $client->get_client_logs($custid);

 $data = array();

if($r){
  foreach ($r as $value){
    array_push($data, array('logid' => $value['log_id'], 'log_date' => $value['log_date'], 'timein' => $value['log_timein'], 'clsname' => $value['cls_name'], 'recid' => $value['rec_id'], 'stf_firstname' => $value['stf_firstname'], 'stf_lastname' => $value['stf_lastname']));
  }
}else{
    $data['data'] = array('action' => 'false');
}
echo json_encode($data);
