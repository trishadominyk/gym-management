<?php
include('../db.php');
include('function.php');
$query = '';
$output = array();
$query .= "SELECT * FROM tbl_membershiptype ";
if(isset($_POST["search"]["value"]))
{
	$query .= 'WHERE met_name LIKE "%'.$_POST["search"]["value"].'%" ';

}
if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY met_name DESC ';
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
		$action = ($row['met_status'] == 'ACTIVE') ? 'Deactivate' : 'Activate';
	$memtype = ($row['met_status'] == 'ACTIVE') ? 'btn-danger' : 'btn-success';

	$sub_array = array();
	$sub_array[] = $row["met_name"];
	$sub_array[] = $row["met_rate"];
	$sub_array[] = $row["met_duration"];
	$sub_array[] = $row["met_status"];
	$sub_array[] = '<center>'.'<button type="button" name="update" id="'.$row["met_id"].'" class="btn btn-warning btn-xs update">Update</button>'.'&nbsp;'.'<button type="button" name="action" action="'.$action.'" id="'.$row["met_id"].'" class="btn '.$memtype.' btn-xs delete">'.$action.'</button> </center>';
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