<?php
include('../../library/config.php');
include('../../classes/class.staff.php');

$staff = new Staff();

$i = array();

if(isset($_GET["acp_id"]) && isset($_GET["status"])){
    $acp_id = $_GET['acp_id'];
    $status = strtoupper($_GET['status']);
    
    ///1.UPDATE STATUS OF ACTIVITY PROGRESS
    //update the status of the activity progress
    $result = $staff->update_activityprogress($acp_id,$status);
    
    ///2.GET THE PROGRESS ID
    //get progress id
    $pro_id = $staff->get_proid($acp_id);
    
    ///3.GET NUMBER FOR FORMULA
    //count total no of activities
    $total = $staff->count_activities($pro_id, 'TOTAL');
    //count complete and incomplete
    $complete = $staff->count_activities($pro_id, 'COMPLETE');
    $incomplete = $staff->count_activities($pro_id, 'INCOMPLETE');
    
    ///4.SOLVING
    //solving stuff + formula
    $completed = $complete + (0.5 * $incomplete);
    $percentage = ($completed / $total) * 100;
    
    //5.UPDATE OVERALL PROGRESS
    //update tbl_progress with new percentage
    $result = $staff->update_progress($pro_id,round($percentage,2));
    
    if(!empty($result))
        $i['action'] = "true";
    else
        $i['action'] = "false";
    
    echo json_encode($i);
}