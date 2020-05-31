<?php
include('../../library/config.php');
include('../../classes/class.staff.php');

$staff = new Staff();

$mod = $_GET['mod'];
$id = $_GET['id'];

$data = array();

switch($mod){
    case 'DETAILS':
        $result = $staff->retrieve_details($id);
        
        foreach($result as $row){
            array_push($data, array('stf_firstname'=>$row['stf_firstname'], 'stf_lastname'=>$row['stf_lastname'], 'stf_email'=>$row['stf_email'], 'stf_contact'=>$row['stf_contact']));
        }
        
        echo json_encode($data);
    break;
    
    case 'CLASSES':
        $result = $staff->retrieve_classes($id);
        
        foreach($result as $row){
            array_push($data, array('cls_id'=>$row['cls_id'], 'cls_name'=>$row['cls_name']));
        }
        
        echo json_encode($data);
    break;
}