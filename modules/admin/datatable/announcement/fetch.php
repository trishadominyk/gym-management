<?php
include('../db.php');
include('function.php');

$query = '';
$output = array();
$query .= "SELECT * FROM 	tbl_announcement WHERE ann_status <> 'CANCELED' ORDER BY ann_date DESC   ";


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

	$date = 'Date posted: '. date("F d, Y", strtotime($row['ann_date']));
	$sub_array[] .= '<span>'.$date.'</span><h4>'.$row['ann_title'].'</h4><span>'.substr($row['ann_content'], 0, 90).'</span>';
	$sub_array[] = '<button type="button" name="edit" id="'.$row["ann_id"].'" class="btn btn-warning btn-xs edit">Details</button>  <button type="button" name="remove" id="'.$row["ann_id"].'" class="btn btn-danger btn-xs remove">Remove</button>';
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
