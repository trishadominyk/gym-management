<?php
include('../db.php');
include('function.php');

$date = date('m');

// storing  request (ie, get/post) global array to a variable  
$requestData = $_REQUEST;

$sql = "SELECT S.stf_id, S.stf_firstname, S.stf_lastname, SL.stf_log_date, SL.stf_log_in, SL.stf_log_out
FROM tbl_stafflogbook SL
INNER JOIN tbl_staff S ON SL.stf_id = S.stf_id ";

if(!empty($requestData['columns'][0]['search']['value'])){
	$date_val = date("m", strtotime($requestData['columns'][0]['search']['value']));
    $sql.="WHERE SL.stf_log_date LIKE '%-".$date_val."-%' ";
}
else
    $sql.="WHERE SL.stf_log_date LIKE '%-".$date."-%'";

if(isset($_POST["order"]))
	$sql .= ' ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
else
	$sql .= ' ORDER BY SL.stf_log_date, SL.stf_log_in DESC ';

$statement = $connection->prepare($sql);
$statement->execute();
$result = $statement->fetchAll();
$filtered_rows = $statement->rowCount();

$timeout = '';
$data = array();
foreach($result as $row){
	$name = $row["stf_lastname"].", ".$row["stf_firstname"];
    $timein = date("h:i A", strtotime($row["stf_log_in"]));
    
    if(empty($row["stf_log_out"]) || $row["stf_log_out"] == null)
        $timeout = '<button type="button" name="timeoutstaff" class="btn btn-danger btn-xs timeoutstaff" id="'.$row["stf_id"].'">Time Out</button>';
    else
        $timeout = date("h:i A", strtotime($row["stf_log_out"]));
    
    $sub_array = array();
	$sub_array[] = date("F d, Y", strtotime($row["stf_log_date"]));
    $sub_array[] = $name;
	$sub_array[] = $timein;
	$sub_array[] = $timeout;
	$data[] = $sub_array;
}

$output = array(
	"draw"				=>	intval($_POST["draw"]),
	"recordsTotal"		=> 	$filtered_rows,
	"recordsFiltered"	=>	get_total_logbook_records($sql),
	"data"				=>	$data
);

echo json_encode($output);  // send data as json format