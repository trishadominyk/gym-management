<?php
include('../db.php');
include('function.php');

$output = array();

$query = '';
$query .= "SELECT C.cust_id, C.cust_firstname, C.cust_lastname, C.cust_email, I.met_id, M.met_name, T.trns_id FROM tbl_customer C 
INNER JOIN tbl_transaction T ON C.cust_id = T.cust_id
INNER JOIN tbl_transitems I ON T.trns_id = I.trns_id
INNER JOIN tbl_membershiptype M ON M.met_id = I.met_id ";

if($_POST["search"]["value"] != '')
	$query .= 'WHERE (C.cust_firstname LIKE "%'.$_POST["search"]["value"].'%" OR C.cust_lastname LIKE "%'.$_POST["search"]["value"].'%") AND I.met_id <> 0 AND I.trni_remarks = "PENDING"';
else
    $query .= "WHERE I.met_id <> 0 AND I.trni_remarks = 'PENDING'";
    
if(isset($_POST["order"]))
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
else
	$query .= 'ORDER BY T.trns_date ASC ';

if($_POST["length"] != -1)
	$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];

$statement = $connection->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$filtered_rows = $statement->rowCount();

$data = array();
foreach($result as $row){
	$name = $row["cust_lastname"].", ".$row["cust_firstname"];
    
    $sub_array = array();
	$sub_array[] = $name;
	$sub_array[] = $row["cust_email"];
	$sub_array[] = $row["met_name"];
	$sub_array[] = '<button type="button" name="confirm" id="'.$row["cust_id"].'" met="'.$row["met_id"].'" class="btn btn-success btn-xs confirm">Confirm</button>'.'&nbsp;'.'<button type="button" name="delete" id="'.$row["trns_id"].'" met="'.$row["met_id"].'" class="btn btn-danger btn-xs delete">Cancel</button>';
	$data[] = $sub_array;
}

$output = array(
	"draw"				=>	intval($_POST["draw"]),
	"recordsTotal"		=> 	$filtered_rows,
	"recordsFiltered"	=>	get_total_membership_records(),
	"data"				=>	$data
);
echo json_encode($output);