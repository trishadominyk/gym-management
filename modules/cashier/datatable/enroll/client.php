<?php
include('../db.php');
include('function.php');

$output = array();

$query = '';
$query .= "SELECT C.cust_id, C.cust_email, C.cust_firstname, C.cust_lastname, C.mem_id, M.mem_status FROM tbl_customer C
LEFT JOIN tbl_membership M ON C.mem_id = M.mem_id ";

if(isset($_POST["search"]["value"]))
	$query .= 'WHERE C.cust_firstname LIKE "%'.$_POST["search"]["value"].'%" OR C.cust_lastname LIKE "%'.$_POST["search"]["value"].'%" OR C.cust_email LIKE "%'.$_POST["search"]["value"].'%"';
    
if(isset($_POST["order"]))
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
else
	$query .= 'ORDER BY C.cust_lastname ASC ';

if($_POST["length"] != -1)
	$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];

$statement = $connection->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$data = array();
$filtered_rows = $statement->rowCount();

foreach($result as $row){
	$name = $row["cust_lastname"].", ".$row["cust_firstname"];
    
    $membership = $row["mem_status"];
    if($membership == "EXPIRED")
        $memstat = '<span class="btn-gray btn-xs">'.$membership.'</span>';
    else if($membership == "ACTIVE")
        $memstat = '<span class="btn-green btn-xs">'.$membership.'</span>';
    else
        $memstat = '<span class="btn-red btn-xs">NONE</span>';
    
    $sub_array = array();
	$sub_array[] = $name;
	$sub_array[] = $memstat;
	$sub_array[] = $row["cust_email"];
	$sub_array[] = '<button type="button" name="select" id="'.$row["cust_id"].'" class="btn btn-success btn-xs select">Select</button>';
	$data[] = $sub_array;
}

$output = array(
	"draw"				=>	intval($_POST["draw"]),
	"recordsTotal"		=> 	$filtered_rows,
	"recordsFiltered"	=>	get_total_all_records(),
	"data"				=>	$data
);
echo json_encode($output);