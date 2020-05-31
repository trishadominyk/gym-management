<?php
include('../../library/config.php');
include('../../classes/class.staff.php');

$staff = new Staff();

$id = $_GET['cls_id'];

$data = array();

$result = $staff->get_classlist($id);
        
foreach($result as $row){
    $name = $row['cust_firstname'].' '.$row['cust_lastname'];
    $valid = $row['rec_enroll'].' - '.$row['rec_expire'];
    $status = ($row['mem_status'] == NULL) ? 'NONE' : $row['mem_status'];
    
    array_push($data, array('cust_name'=>$name, 'mem_status'=>$status,'valid'=>$valid,'rec_session_remain'=>$row['rec_session_remain']));
}
        
echo json_encode($data);