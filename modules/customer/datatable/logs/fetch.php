<?php
include('../db.php');
include('function.php');

if(!empty($_POST['cust_id'])){
    $date = date('Y-m-d');
    
    $requestData = $_REQUEST;
    
    $id = $_POST['cust_id'];
    
    $query = '';
    $query = "SELECT L.log_id, L.log_date, L.log_timein, L.log_timeout, C.cls_name, R.rec_id FROM tbl_logbook L
    INNER JOIN tbl_record R ON L.rec_id = R.rec_id
    INNER JOIN tbl_transaction T ON R.trns_id = T.trns_id
    INNER JOIN tbl_transitems I ON T.trns_id = I.trns_id
    INNER JOIN tbl_class C ON I.cls_id = C.cls_id 
    WHERE L.cust_id = $id ";
    
    $datefrom = (!empty($requestData['columns'][0]['search']['value'])) ? $requestData['columns'][0]['search']['value'] : $date;
    
    $dateto = (!empty($requestData['columns'][1]['search']['value'])) ? $requestData['columns'][1]['search']['value'] : $date;

    $query.="AND L.log_date BETWEEN '".$datefrom."' AND '".$dateto."' ";
    
    $query.="ORDER BY L.log_date DESC ";

    if($_POST["length"] != -1)
        $query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];

    $statement = $connection->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();

    $data = array();
    foreach($result as $row){
        $sub_array = array();
        $sub_array[] = date("D, M d, Y", strtotime($row["log_date"]));
        $sub_array[] = date("g:i A", strtotime($row["log_timein"]));
        $sub_array[] = date("g:i A", strtotime($row["log_timeout"]));
        $sub_array[] = $row["cls_name"];
        $sub_array[] = '<button type="button" data-toggle="modal" data-target="#logDetails" name="confirm" id="'.$row["log_id"].'" class="btn btn-success btn-xs details">Details</button>';

        $data[] = $sub_array;
    }

    $output = array(
        "draw"				=>	intval($_POST["draw"]),
        "recordsTotal"		=> 	$filtered_rows,
        "recordsFiltered"	=>	get_total_logs(),
        "data"				=>	$data
    );
    
    echo json_encode($output);
}