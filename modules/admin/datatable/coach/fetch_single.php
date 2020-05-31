<?php
include ('../db.php');
if(!empty($_POST['stf_id'])){
$output = array();
$query = '';
$query .= "SELECT clc_name FROM (tbl_staffclass SC INNER JOIN tbl_classcategory CC ON SC.clc_id = CC.clc_id) WHERE SC.stf_id = '".$_POST["stf_id"]."'";
$statement = $connection->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$data = array();
foreach($result as $row)
{
	$sub_array = array();
	$sub_array[] = $row["clc_name"];
	$data[] = $sub_array;
}
$output = array(
	"data" =>	$data
);
echo json_encode($output);
}
?>
