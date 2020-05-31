<?php
include('../db.php');
include('function.php');

$date = date('Y-m-d');

$query = '';
$output = array();
$query .= "SELECT * FROM tbl_promo ";
if(isset($_POST["search"]["value"])){
	$query .= 'WHERE prm_code LIKE "%'.$_POST["search"]["value"].'%"';
}else
{
	$query .= 'ORDER BY prm_status DESC ';
}
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

	$action = ($row['prm_status'] == 'OPEN') ? 'Close' : 'Open';
	$renew = ($row['prm_date_end'] > $date && $row['prm_status'] == 'CLOSE') ? '<button type="button" name="renew" action="'.$action.'" id="'.$row["prm_id"].'" class="btn btn-success btn-xs renew">Open</button>' : '<button type="button" name="close" action="'.$action.'" id="'.$row["prm_id"].'" class="btn btn-warning btn-xs delete">Close</button>';

	$sub_array[] = $row["prm_code"];
	$sub_array[] = $row["prm_date_start"].' to '.$row["prm_date_end"];
	$sub_array[] = $row["prm_discount"];
	$sub_array[] = $row["prm_max"];
	$sub_array[] = $row["prm_avail"];
	$sub_array[] = $row["prm_status"];
	$sub_array[] = '<center>'.'<button type="button" name="view" id="'.$row["prm_id"].'" class="btn btn-primary btn-xs view">Details</button>&nbsp;'.$renew;
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
