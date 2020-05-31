<?php
include('../db.php');

$output = array();

if(isset($_POST['id'])){
    $id = $_POST['id'];
        
    $statement1 = $connection->prepare(
        "SELECT AVG(P.pro_percentage) as avg_progress 
        FROM tbl_progress P
        INNER JOIN tbl_logbook L ON P.log_id = L.log_id
        WHERE L.cust_id = $id"
    );
    
    $statement1->execute();
    $result1 = $statement1->fetchAll();

    foreach($result1 as $row){
        $avg_progress = round($row['avg_progress'], 2);
    }
    
    $output['avg_progress'] = '<h3>'.$avg_progress.'%</h3><p>Average Progress Rate</p><div class="progress"><div class="progress-bar" role="progressbar" aria-valuenow="'.$avg_progress.'" aria-valuemin="0" aria-valuemax="100" style="width:'.$avg_progress.'%"></div></div>';
    
    $month = date('m');
    
    $statement2 = $connection->prepare(
        "SELECT COUNT(log_id) as total_visit FROM tbl_logbook WHERE MONTH(log_date) = $month AND cust_id = $id"
    );
    
    $statement2->execute();
    $result2 = $statement2->fetchAll();

    foreach($result2 as $row){
        $visit_stats = $row['total_visit'];
    }
    
    $output['visit_stats'] = $visit_stats;
    
    $statement3 = $connection->prepare(
        "SELECT L.log_date, L.log_timein, L.log_timeout, C.cls_name
        FROM tbl_logbook L
        INNER JOIN tbl_record R ON L.rec_id = R.rec_id
        INNER JOIN tbl_transaction T ON R.trns_id = T.trns_id
        INNER JOIN tbl_transitems I ON T.trns_id = I.trns_id
        INNER JOIN tbl_class C ON I.cls_id = C.cls_id
        WHERE L.cust_id = $id
        ORDER BY L.log_date DESC
        LIMIT 1"
    );
    
    $statement3->execute();
    $result3 = $statement3->fetchAll();

    foreach($result3 as $row){
        $last_date = date('F d, Y', strtotime($row['log_date']));
        $last_class = $row['cls_name'];
        $last_in = date('g:i a', strtotime($row['log_timein']));
        $last_out = date('g:i a', strtotime($row['log_timeout']));
    }
    
    $output['last_date'] = $last_date;
    $output['last_class'] = $last_class;
    $output['last_in'] = $last_in;
    $output['last_out'] = $last_out;
}

echo json_encode($output);