<?php
include('../db.php');
include('function.php');

$requestData = $_REQUEST;

$query = '';
$output = array();
$query .= "SELECT * FROM tbl_event E LEFT JOIN tbl_eventdetail ED ON E.evn_id = ED.evn_id WHERE ED.evn_det_date >= CURDATE() AND E.evn_status <> 'CANCELED' GROUP BY E.evn_id ";

if($_POST["length"] != -1)
{
	$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}
$statement = $connection->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$data = array();
$filtered_rows = $statement->rowCount();
foreach($result as $row)
{

	$sub_array = array();
	$sub_array[] = $row['evn_name'];
	$sub_array[] = '<center>&nbsp;'.'<button type="button" name="update" id="'.$row["evn_id"].'" class="btn btn-warning btn-xs update">Details</button>'.'&nbsp;'.'<button type="button" name="delete" id="'.$row["evn_id"].'" class="btn btn-danger btn-xs cancel">Cancel</button>';
	$data[] = $sub_array;
}
$output = array(
	"draw"				=>	intval($_POST["draw"]),
	"recordsTotal"		=> 	$filtered_rows,
	"recordsFiltered"	=>	get_total_all_records(),
	"data"				=>	$data
);
echo json_encode($output);
?>
