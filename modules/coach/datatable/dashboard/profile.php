<?php
include('../db.php');
include('function.php');

$output = array();

if(isset($_POST['log_id'])){
    $id = $_POST['log_id'];
    
    $statement = $connection->prepare(
        "SELECT *
        FROM tbl_logbook L
        INNER JOIN tbl_progress P ON L.log_id = P.log_id
        INNER JOIN tbl_actprogress AP ON P.pro_id = AP.pro_id
        INNER JOIN tbl_workoutact WA ON AP.wra_id = WA.wra_id
        INNER JOIN tbl_activity A ON WA.act_id = A.act_id
        INNER JOIN tbl_workoutplan W ON L.wrk_id = W.wrk_id
        WHERE L.log_id = $id"
    );
    $statement->execute();
    $result = $statement->fetchAll();
    
    $output['cust_name'] = get_custname($id);
    
    $output['progress'] = '<div class="progress"><div class="progress-bar" role="progressbar" aria-valuenow="'.get_progressrate($id).'" aria-valuemin="0" aria-valuemax="100" style="width:'.get_progressrate($id).'%"><span class="sr-only">70% Complete</span></div></div>';
    
    $output['pro_percentage'] = intval(get_progressrate($id)).'%';
    $output['wrk_name'] = get_wrkname($id);
    $output['wrk_desc'] = get_wrkdesc($id);
    $output['routine_content'] = '';
    
    $output['pro_start'] = 'Time started: ';
    $output['pro_end'] = 'Time ended: ';
    
    foreach($result as $row){
        $output['pro_start'] = 'Time Started: '.date('h:i a', strtotime($row['pro_start']));
        $output['pro_end'] = ($row['pro_end'] != '00:00:00') ? 'Time Ended: '.date('h:i a', strtotime($row['pro_end'])) : 'Time End: Unavailable. Workout in progress.';
        
        if($row['pro_status'] == 'ONGOING' && check_activitycomplete($row['pro_id']) == 0){
            $pro_id = $row['pro_id'];
            $routine_btn = '<button class="btn btn-sm btn-default finish" id="'.$pro_id.'"><b>Finish Workout</b></button>';
            
            switch($row['acp_status']){
                case 'COMPLETE':
                    $status = '<span class="btn-xs btn-success">Complete</span>';
                    $action = '';
                break;
                case 'INCOMPLETE':
                    $status = '<span class="btn-xs btn-danger">Incomplete</span>';
                    $action = '<button id="'.$row['acp_id'].'" action="complete" class="btn btn-dark btn-xs activityprog">'.file_get_contents('../../../../svg/ic_check.svg').'</button>';
                break;
                case 'SKIPPED':
                    $status = '<span class="btn-xs btn-gray">Skipped</span>';
                    $action = '<button id="'.$row['acp_id'].'" action="complete" class="btn btn-dark btn-xs activityprog">'.file_get_contents('../../../../svg/ic_check.svg').'</button>&nbsp;<button id="'.$row['acp_id'].'" action="incomplete" class="btn btn-dark btn-xs activityprog">'.file_get_contents('../../../../svg/ic_incomplete.svg').'</button>';
                break;
                default:
                    $status = '';
                    $action = '<button id="'.$row['acp_id'].'" action="complete" class="btn btn-dark btn-xs activityprog">'.file_get_contents('../../../../svg/ic_check.svg').'</button>&nbsp;<button id="'.$row['acp_id'].'" action="incomplete" class="btn btn-dark btn-xs activityprog">'.file_get_contents('../../../../svg/ic_incomplete.svg').'</button>&nbsp;<button id="'.$row['acp_id'].'" action="skipped" class="btn btn-dark btn-xs activityprog">'.file_get_contents('../../../../svg/ic_skip.svg').'</button>';
                break;
            }
        }
        else{
            $action = '';
            
            switch($row['acp_status']){
                case 'COMPLETE':
                    $status = '<span class="btn-xs btn-success">Complete</span>';
                break;
                case 'INCOMPLETE':
                    $status = '<span class="btn-xs btn-danger">Incomplete</span>';
                break;
                default:
                    $status = '<span class="btn-xs btn-gray">Skipped</span>';
                break;
            }
        }
        
        $output['routine_content'] .= '<tr>';
        $output['routine_content'] .= '<td>'.$row['act_name'].'</td>';
        $output['routine_content'] .= '<td>'.$row['wra_sets'].'</td>';
        $output['routine_content'] .= '<td>'.$status.'</td>';
        $output['routine_content'] .= '<td>'.$action.'</td>';
        $output['routine_content'] .= '</tr>';
    }
    
    if($row['pro_status'] == 'ONGOING')
        $output['routine_btn'] = $routine_btn;
}

echo json_encode($output);