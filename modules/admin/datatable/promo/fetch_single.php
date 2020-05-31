<?php
include ('../db.php');
include 'function.php';

if(isset($_POST['prm_id'])){

//PROMO DESC
$output = array();
 $statement = $connection->prepare(
  "SELECT prm_desc, prm_code, prm_date_start, prm_date_end FROM tbl_promo WHERE prm_id = '".$_POST["prm_id"]."' LIMIT 1");
 $statement->execute();
 $result = $statement->fetchAll();

$output['prm_desc'] = '';
$output['prm_code'] = '';
$output['prm_date'] = '';

foreach($result as $row)
 {
 	$output['prm_desc'] .=  '<center> <p>'.$row['prm_desc'].'</p> </center>';
 	$output['prm_code'] .=  $row['prm_code'];
 	$output['prm_date'] .=  '<center>'.$row['prm_date_start'].' TO '.$row['prm_date_end'].'</center>';

 }

//CLASS TYPES
$outputB = array();
$statement2 = $connection->prepare("SELECT cls_id FROM tbl_promoclass WHERE prm_id = '".$_POST["prm_id"]."'");
$statement2->execute();
$result2 = $statement2->fetchAll();
 $outputB['clsname'] ='';
foreach($result2 as $valueA){
	 $outputB['clsname'] .= '<center><p>'.get_class_name($valueA['cls_id']).'</p></center>';

}


//MEMBERSHIP TYPE
$outputC = array();
	$outputC['metname'] = '';
$statement3 = $connection->prepare("SELECT met_id FROM tbl_promomembershiptype WHERE prm_id = '".$_POST["prm_id"]."'");
$statement3->execute();
$result3 = $statement3->fetchAll();
foreach ($result3 as $valueB) {
	$outputC['metname'] .= '<center><p>'.get_memtype_name($valueB['met_id']).'</p></center>';
}

 echo json_encode(array($output, $outputB, $outputC));
}
?>
