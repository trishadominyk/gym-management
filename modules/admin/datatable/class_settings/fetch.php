<?php
include('../db.php');
include('function.php');
$query = '';
$output = array();
$query .= "SELECT * FROM tbl_classcategory ";
if(!empty($_POST["search"]["value"])){
	$query .= 'WHERE clc_name LIKE "%'.$_POST["search"]["value"].'%"';
}else{
	$query .= 'ORDER BY clc_name';
}
$statement = $connection->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$data = array();
$filtered_rows = $statement->rowCount();
foreach($result as $row)
{
	$sub_array = array();
	$sub_array[] = $row["clc_name"];
	$sub_array[] = '<center>&nbsp;	'.'<button type="button" name="update" id="'.$row["clc_id"].'" class="btn btn-warning btn-xs update">Update</button> </center>';
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