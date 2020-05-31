<?php 
include ('../db.php');

if(isset($_POST['met_id'])){  
 $output = array();
 $statement = $connection->prepare(
  "SELECT * FROM tbl_membershiptype 
  WHERE met_id = '".$_POST["met_id"]."' 
  LIMIT 1"
 );
 $statement->execute();
 $result = $statement->fetchAll();
 foreach($result as $row)
 {
  $output["met_name"] = $row["met_name"];
  $output["met_rate"] = $row["met_rate"];
  $output["met_duration"] = $row["met_duration"];


 }
 echo json_encode($output);
}  
?>