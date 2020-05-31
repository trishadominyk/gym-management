<?php
include ('../db.php');

if(isset($_POST['stf_id'])){
 $output = array();
 $statement = $connection->prepare(
  "SELECT S.stf_email, S.stf_firstname, S.stf_lastname, S.stf_contact, L.lvl_name, S.lvl_id, L.lvl_id FROM(tbl_staff S INNER JOIN tbl_level L ON S.lvl_id = L.lvl_id) WHERE stf_id = '".$_POST["stf_id"]."' LIMIT 1");
 $statement->execute();
 $result = $statement->fetchAll();
 foreach($result as $row)
 {
  $output["stf_email"] = $row["stf_email"];
  $output["stf_firstname"] = $row["stf_firstname"];
  $output["stf_lastname"] = $row["stf_lastname"];
  $output["stf_contact"] = $row["stf_contact"];
  $output["lvl_id"] = $row["lvl_id"];
  $output["lvl_name"] = $row["lvl_name"];

 }
 echo json_encode($output);
}
?>
