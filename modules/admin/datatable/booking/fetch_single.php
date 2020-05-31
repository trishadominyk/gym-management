<?php
include ('../db.php');

if(isset($_POST['evn_id'])){
 $output = array();
 $statement = $connection->prepare(
  "SELECT * FROM tbl_event E, tbl_eventdetail ED
  WHERE E.evn_id = ED.evn_id AND E.evn_id = '".$_POST["evn_id"]."'"
 );
 $statement->execute();
 $result = $statement->fetchAll();

$output["evn_det"] = '';
$name = '';
$desc = '';
$image = '';
 foreach($result as $row)
 {
 	$name = $row["evn_name"];
 	$desc = $row["evn_desc"];
  $image = '<img src="'. substr($row["evn_image"], 6).'"> </img> <br> <input type="file" name="evnimg"/>';
 	$output["evn_det"] .= '<tr id="row'.$row['evn_det_id'].'">
 		<td><input type="date" name="date[]"  class="date-single" value="'.$row['evn_det_date'].'"/></td>
 		<td><input type="time" name="starttime[]" class="starttime-single"  value="'.$row['evn_det_time_start'].'"></td>
 		<td><input type="time" name="endtime[]" class="endtime-single"  value="'.$row['evn_det_time_end'].'"></td>
 		<td><input type="text" name="venue[]" placeholder="Venue" class="venue-single"  value="'.$row['evn_det_venue'].'"></td>
 		<td><button type="button" name="remove" id="'.$row['evn_det_id'].'" data-row="row'.$row['evn_det_id'].'" class="btn btn-danger btn-xs remove-details det-id">-</button></td>
   		<input type="hidden" name="evndetid[]" value="'.$row['evn_det_id'].'"/> </tr>';
 }

 $output["evn_name"] = $name;
 $output["evn_desc"] = $desc;
 $output["evn_image"] = $image;

 echo json_encode($output);
}
?>
