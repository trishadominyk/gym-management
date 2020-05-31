<?php
include ('../db.php');

if(isset($_POST['cat_id'])){
 $output = array();
 $statement = $connection->prepare(
  "SELECT * FROM tbl_category WHERE cat_id = '".$_POST["cat_id"]."' LIMIT 1");
 $statement->execute();
 $result = $statement->fetchAll();
 foreach($result as $row)
 {
  $output["cat_name"] = $row["cat_name"];
 }
 echo json_encode($output);
}
?>
