<?php
include('../db.php');
include('function.php');

$date = date('Y-m-d');

// storing  request (ie, get/post) global array to a variable  
$requestData = $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 => 'log_date', 
	1 => 'cust_name'
);

$sql = "SELECT L.rec_id, L.log_id, L.log_date, L.log_timein, L.log_timeout, L.cust_id, U.cust_id, U.cust_firstname, U.cust_lastname, C.cls_name, CC.clc_name, R.rec_id FROM tbl_logbook L
INNER JOIN tbl_customer U ON L.cust_id = U.cust_id
INNER JOIN tbl_record R ON L.rec_id = R.rec_id
INNER JOIN tbl_transaction T ON R.trns_id = T.trns_id
INNER JOIN tbl_transitems I ON T.trns_id = I.trns_id
INNER JOIN tbl_class C ON I.cls_id = C.cls_id
INNER JOIN tbl_classcategory CC ON C.clc_id = CC.clc_id ";

$datefrom = (!empty($requestData['columns'][0]['search']['value'])) ? $requestData['columns'][0]['search']['value'] : $date;
$dateto = (!empty($requestData['columns'][1]['search']['value'])) ? $requestData['columns'][1]['search']['value'] : $date;
    
$sql.="WHERE L.log_date BETWEEN '".$datefrom."' AND '".$dateto."'";

if(isset($_POST["order"]))
	$sql .= ' ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
else
	$sql .= ' ORDER BY L.log_timein DESC ';

$statement = $connection->prepare($sql);
$statement->execute();
$result = $statement->fetchAll();
$filtered_rows = $statement->rowCount();

$timeout = '';
$data = array();
foreach($result as $row){
	$name = $row["cust_lastname"].", ".$row["cust_firstname"];
    $timein = date("h:i A", strtotime($row["log_timein"]));
    
    if(empty($row["log_timeout"]) || $row["log_timeout"] == null)
        $timeout = '<button type="button" name="timeout" class="btn btn-danger btn-xs timeout" id="'.$row["log_id"].'">Time Out</button>';
    else
        $timeout = date("h:i A", strtotime($row["log_timeout"]));
    
    $sub_array = array();
	$sub_array[] = date("F d, Y", strtotime($row["log_date"]));
    $sub_array[] = $name;
	$sub_array[] = $timein;
	$sub_array[] = $timeout;
    $sub_array[] = $row["clc_name"];
	$sub_array[] = '<button type="button" name="details" id="'.$row["log_id"].'" rec="'.$row["rec_id"].'" class="btn btn-success btn-xs details">Details</button>';
	$data[] = $sub_array;
}

$output = array(
	"draw"				=>	intval($_POST["draw"]),
	"recordsTotal"		=> 	$filtered_rows,
	"recordsFiltered"	=>	get_total_logbook_records($sql),
	"data"				=>	$data
);

echo json_encode($output);  // send data as json format