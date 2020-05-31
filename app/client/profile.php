<?php
include('../../library/config.php');
include('../../classes/class.client.php');

$client = new Client();

$custid = $_GET['custid'];

if(!empty($_GET['custid'])){

}
 $r = $client->get_userprofile($custid);

 $data = array();

if($r){
  foreach ($r as $value){
    array_push($data, array('firstname' => $value['cust_firstname'], 'lastname' => $value['cust_lastname'], 'email' => $value['cust_email'], 'membershipname' => $value['met_name'],  'memdatestart' => date('F d, Y', strtotime($value['mem_date_added'])) , 'memdateexpire' =>  date('F d, Y', strtotime($value['mem_date_expire'])), 'memstatus' => $value['mem_status'] ));
  }
}else{
    $data['data'] = array('action' => 'false');
}
echo json_encode($data);
