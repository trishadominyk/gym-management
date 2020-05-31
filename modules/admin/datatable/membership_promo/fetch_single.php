<?php 
include ('../db.php');

if(isset($_POST['prm_id'])){  
 $output = array();
 $statement = $connection->prepare(
  "SELECT prm_desc FROM tbl_promo WHERE prm_id = '".$_POST["prm_id"]."' LIMIT 1");
 $statement->execute();
 $result = $statement->fetchAll();
 foreach($result as $row)
 {	
  $output["prm_desc"] = $row["prm_desc"];

 }
 echo json_encode($output);
}  
?>