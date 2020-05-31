<?php
include ('../db.php');

if(isset($_POST['cls_id'])){
 $output = array();
 $statement = $connection->prepare("SELECT C.clc_id, CC.clc_id, cls_desc,cls_name,cls_status,cls_rate, cls_sessions,clc_name FROM(tbl_class C INNER JOIN tbl_classcategory CC ON C.clc_id = CC.clc_id) WHERE cls_id = '".$_POST["cls_id"]."' LIMIT 1");
 $statement->execute();
 $result = $statement->fetchAll();
 foreach($result as $row)
 {
  $output["cls_name"] = $row["cls_name"];
    $output["cls_desc"] = $row["cls_desc"];
  $output["cls_rate"] = $row["cls_rate"];
  $output["cls_sessions"] = $row["cls_sessions"];
  $output["clc_name"] = $row["clc_name"];
  $output["clc_id"] = $row["clc_id"];

 }
 echo json_encode($output);
}
?>
