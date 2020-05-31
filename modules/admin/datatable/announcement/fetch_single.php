<?php
include ('../db.php');

if(isset($_POST['ann_id'])){
 $output = array();
 $statement = $connection->prepare("SELECT * FROM tbl_announcement WHERE  ann_id = '".$_POST["ann_id"]."'");
 $statement->execute();
 $result = $statement->fetchAll();

 foreach($result as $row)
 {
   $output["ann_title"] = $row["ann_title"];
  $output["ann_content"] = $row["ann_content"];
   $output["ann_date"] = $row["ann_date"];
 }
 echo json_encode($output);
}
?>
