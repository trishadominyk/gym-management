<?php
include('../db.php');
include('function.php');
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
	$sub_array[] = $row["prm_code"];
	$sub_array[] = $row["prm_date_start"];
	$sub_array[] = $row["prm_date_end"];
	$sub_array[] = $row["prm_discount"];
	$sub_array[] = $row["prm_max"];
	$sub_array[] = $row["prm_avail"];
	$sub_array[] = $row["prm_status"];
	$sub_array[] = '&nbsp;	'.'<button type="button" name="view" id="'.$row["prm_id"].'" class="btn btn-success btn-xs view">Description</button>'.'&nbsp;'.'<button type="button" name="delete" id="'.$row["prm_id"].'" class="btn btn-danger btn-xs delete">Close</button>';
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