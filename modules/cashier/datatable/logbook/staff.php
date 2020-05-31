<?php
include('../db.php');
include('function.php');

$date = date('Y-m-d');

$sql = "SELECT S.stf_id, S.stf_firstname, S.stf_lastname, S.stf_email FROM tbl_staff S
INNER JOIN tbl_level L ON S.lvl_id = L.lvl_id
WHERE L.lvl_name <> 'ADMIN' AND L.lvl_name <> 'CASHIER'";

$statement = $connection->prepare($sql);
$statement->execute();
$result = $statement->fetchAll();

$data = array();
foreach($result as $row){
    if(check_loggedin($row["stf_id"]) == 0){
        $name = $row["stf_lastname"].", ".$row["stf_firstname"];

        $sub_array = array();
        $sub_array[] = '<b>'.$name.'</b><br><span>'.$row["stf_email"].'</span>';
        $sub_array[] = '<button type="button" name="timein" class="btn btn-success btn-xs timein" id="'.$row["stf_id"].'">Time In</button>';
        
        $data[] = $sub_array;
    }
}

$output = array(
	"draw"				=>	intval($_POST["draw"]),
	"recordsFiltered"	=>	get_total_logbook_records($sql),
	"data"				=>	$data
);

echo json_encode($output);  // send data as json format