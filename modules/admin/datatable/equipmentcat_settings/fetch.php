<?php
include('../db.php');
include('function.php');
$query = '';
$output = array();
$query .= "SELECT * FROM tbl_category ";
if(!empty($_POST["search"]["value"])){
	$query .= 'WHERE cat_name LIKE "%'.$_POST["search"]["value"].'%"';
}else{
	$query .= 'ORDER BY cat_name';
}
$statement = $connection->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$data = array();
$filtered_rows = $statement->rowCount();
foreach($result as $row)
{
	$sub_array = array();
	$sub_array[] = $row["cat_name"];
	$sub_array[] = '<center>&nbsp;	'.'<button type="button" name="update" id="'.$row["cat_id"].'" class="btn btn-warning btn-xs update">Update</button> </center>';
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