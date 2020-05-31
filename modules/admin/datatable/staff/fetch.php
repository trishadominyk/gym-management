<?php
include('../db.php');
include('function.php');
$query = '';
$output = array();
$query .= "SELECT S.stf_id, S.stf_email, S.stf_firstname, S.stf_lastname, S.stf_contact, S.lvl_id,L.lvl_id, L.lvl_name FROM(tbl_staff S INNER JOIN tbl_level L ON S.lvl_id = L.lvl_id)";
if(!empty($_POST["search"]["value"])){
	$query .= 'WHERE L.lvl_name <> "ADMIN" AND (S.stf_firstname LIKE "%'.$_POST["search"]["value"].'%" OR S.stf_email LIKE "%'.$_POST["search"]["value"].'%" OR S.stf_contact LIKE "%'.$_POST["search"]["value"].'%")';
}else{
	$query .= 'WHERE L.lvl_name <> "ADMIN" ORDER BY S.stf_email';
}
$statement = $connection->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$data = array();
$filtered_rows = $statement->rowCount();
foreach($result as $row)
{
	$sub_array = array();
	$sub_array[] = $row["stf_email"];
	$sub_array[] = $row["stf_lastname"].','.$row["stf_firstname"];
	$sub_array[] = $row["stf_contact"];
	$sub_array[] = $row["lvl_name"];
	$sub_array[] = '<center> 	'.'<button type="button" name="update" id="'.$row["stf_id"].'" class="btn btn-warning btn-xs update">Update</button> </center>';
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
