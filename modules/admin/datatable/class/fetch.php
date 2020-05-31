<?php
include('../db.php');
include('function.php');
$query = '';
$output = array();
$query .= "SELECT * FROM(tbl_class C INNER JOIN tbl_classcategory CC ON C.clc_id = CC.clc_id) ";
if(!empty($_POST["search"]["value"])){
	$query .= 'WHERE cls_name LIKE "%'.$_POST["search"]["value"].'%" ';
}
else
	$query .= "ORDER BY clc_name ";


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
	$action = ($row['cls_status'] == 'ACTIVE') ? 'Deactivate' : 'Activate';
	$class = ($row['cls_status'] == 'ACTIVE') ? 'btn-danger' : 'btn-success';

	$sub_array = array();
	$sub_array[] = $row["cls_name"];
	$sub_array[] = substr($row["cls_desc"], 0, 20). '...';
	$sub_array[] = 'Php '.number_format($row["cls_rate"],2);
	$sub_array[] = $row["cls_sessions"];
	$sub_array[] = $row["clc_name"];
	$sub_array[] = $row["cls_status"];
	$sub_array[] = '<center>'.'<button type="button" name="update" id="'.$row["cls_id"].'" class="btn btn-warning btn-xs update">Update</button>'.'&nbsp;'.'<button type="button" name="action" action="'.$action.'" id="'.$row["cls_id"].'" class="btn '.$class.' btn-xs delete">'.$action.'</button></center>';
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
