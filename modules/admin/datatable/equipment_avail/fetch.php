<?php
include('../db.php');
include('function.php');
$query = '';
$output = array();
$query .= "SELECT E.eqp_status, E.eqp_serial, E.eqp_id, E.eqp_name,  C.cat_name, C.cat_id, E.cat_id FROM(tbl_equipment E INNER JOIN tbl_category C ON E.cat_id = C.cat_id) ";
if(isset($_POST["search"]["value"]))
{
	$query .= 'WHERE E.eqp_status = "AVAILABLE" AND (E.eqp_serial LIKE "%'.$_POST["search"]["value"].'%" OR  E.eqp_name LIKE "%'.$_POST["search"]["value"].'%") ';
}else{
	$query .= 'WHERE E.eqp_status = "AVAILABLE" ORDER BY E.cat_id';
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
	$action = ($row['eqp_status'] == 'AVAILABLE') ? 'Repair' : 'Fixed';
	$class = ($row['eqp_status'] == 'AVAILABLE') ? 'btn-warning' : 'btn-success';

	$sub_array = array();
	$sub_array[] = $row["eqp_serial"];
	$sub_array[] = $row["eqp_name"];
	
	$sub_array[] = $row["cat_name"];
	$sub_array[] = ($row["eqp_status"] != 'DISPOSED') ? '<center><button type="button" name="update" id="'.$row["eqp_id"].'" action="'.$action.'" class="btn '.$class.' btn-xs update">'.$action.'</button>'.'&nbsp;'.'<button type="button" name="delete" id="'.$row["eqp_id"].'" class="btn btn-danger btn-xs delete">Dispose</button></center>': '<center> Disposed </center>';
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