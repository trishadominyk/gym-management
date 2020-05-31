<?php
include('../../library/config.php');
include('../../classes/class.staff.php');

$staff = new Staff();

$id = $_GET['id'];

$data = array();

$result = $staff->get_logbook($id);

if($result){
    foreach($result as $row){            
        array_push($data, array('log_id'=>$row['log_id'], 'wrk_id'=>$row['wrk_id'], 'log_timein'=>$row['log_timein'], 'cust_id'=>$row['cust_id'],'cust_firstname'=>$row['cust_firstname'], 'cust_lastname'=>$row['cust_lastname'], 'cls_name'=>$row['cls_name'],'rec_session_remain'=>$row['rec_session_remain']));
    }
}
        
echo json_encode($data);