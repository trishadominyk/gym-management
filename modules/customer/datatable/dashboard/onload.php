<?php
include('../db.php');
include('function.php');

$output = array();

if(isset($_POST['id'])){
    $id = $_POST['id'];

    if(check_login($id) == 0){
        $log_id = get_logid($id);
    }
}
else if(isset($_POST['log_id']))
    $log_id = $_POST['log_id'];

$statement = $connection->prepare(
    "SELECT C.cls_name, S.stf_firstname, S.stf_lastname, W.wrk_name, W.wrk_desc, L.log_date, L.log_timein, P.pro_percentage, R.rec_session_remain FROM (tbl_logbook L
    INNER JOIN tbl_record R ON L.rec_id = R.rec_id
    INNER JOIN tbl_transaction T ON T.trns_id = R.trns_id
    INNER JOIN tbl_transitems I ON T.trns_id = I.trns_id
    INNER JOIN tbl_class C ON I.cls_id = C.cls_id)
    INNER JOIN tbl_progress P ON L.log_id = P.log_id
    INNER JOIN tbl_workoutplan W ON L.wrk_id = W.wrk_id
    INNER JOIN tbl_staff S ON L.stf_id = S.stf_id
    WHERE L.log_id = :id"
);
$statement->bindValue(':id', $log_id, PDO::PARAM_INT);
$statement->execute();
$result = $statement->fetchAll();

foreach($result as $row){
    $cls_name = $row['cls_name'];
    $sessions = $row['rec_session_remain'];
    $stf_name = $row['stf_firstname'].' '.$row['stf_lastname'];
    $log_timein = date('g:i A', strtotime($row['log_timein']));
    $pro_percentage = intval($row['pro_percentage']);

    $wrk_name = $row['wrk_name'];
    $wrk_desc = $row['wrk_desc'];

    $log_date = $row['log_date'];
}

$output['rec_info'] = '<h4>'.$cls_name.'</h4><span>'.$sessions.' session(s) remain</span><hr><p>Coach '.$stf_name.'</p>';

$output['log_timein'] = '<h2>'.$log_timein.'</h2><span>Time Started</span>';

$output['log_progress'] = '<h1>'.$pro_percentage.'% <span style="font-size:small; vertical-align:middle;">Progress</span></h1><div class="progress"><div class="progress-bar" role="progressbar" aria-valuenow="'.$pro_percentage.'" aria-valuemin="0" aria-valuemax="100" style="width:'.$pro_percentage.'%"></div></div>';

$output['wrk_name'] = $wrk_name;
$output['wrk_desc'] = $wrk_desc;

$output['log_date'] = date('F d, Y', strtotime($log_date));

echo json_encode($output);
