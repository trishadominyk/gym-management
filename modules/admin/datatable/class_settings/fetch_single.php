<?php 
include ('../db.php');

if(isset($_POST['clc_id'])){  
 $output = array();
 $statement = $connection->prepare(
  "SELECT * FROM tbl_classcategory WHERE clc_id = '".$_POST["clc_id"]."' LIMIT 1");
 $statement->execute();
 $result = $statement->fetchAll();
 foreach($result as $row)
 {	
  $output["clc_name"] = $row["clc_name"];
 }
 echo json_encode($output);
}  
?>