	<?php
include('../db.php');
include('function.php');



if(isset($_POST['approve'])){
	$id = $_POST['id'];

	$ra = approve_event_status($id);
	if($ra){
		echo 'Event Approved!';
	}else
		echo 'Error please consult the stupid developer.';

}



if(isset($_POST['addsingle'])){

	$evnid = $_POST['evnid'];
	$datesingle = $_POST['datesingle'];
	$endtimesingle = $_POST['endtimesingle'];
	$starttimesingle = $_POST['starttimesingle'];
	$venuesingle = $_POST['venuesingle'];

	$q = $connection->prepare('INSERT INTO tbl_eventdetail(evn_id, evn_det_date, evn_det_time_start, evn_det_time_end, evn_det_venue) VALUES(:evnid, :evndate, :evnstart, :evnend, :evnvenue)');

	$r = $q->execute(
				array(
					':evnid' => $evnid,
					':evndate' => $datesingle,
					':evnstart' => $starttimesingle,
					':evnend' => $endtimesingle,
					':evnvenue' => $venuesingle
			)
		);


 $output = array();
 $output['evndet'] = '';
 $q2 = get_event_detail($evnid);
  foreach($q2 as $row)
  {

  	$output['evndet'] .= '<tr id="row'.$row['evn_det_id'].'">
	 		<td><input type="date" name="date[]"  class="date-single" value="'.$row['evn_det_date'].'"/></td>
	 		<td><input type="time" name="starttime[]" class="starttime-single"  value="'.$row['evn_det_time_start'].'"></td>
	 		<td><input type="time" name="endtime[]" class="endtime-single"  value="'.$row['evn_det_time_end'].'"></td>
	 		<td><input type="text" name="venue[]" placeholder="Venue" class="venue-single"  value="'.$row['evn_det_venue'].'"></td>
	 		<td><button type="button" name="remove" id="'.$row['evn_det_id'].'" data-row="row'.$row['evn_det_id'].'" class="btn btn-danger btn-xs remove-details det-id">-</button></td>
	   		<input type="hidden" name="evndetid[]" value="'.$row['evn_det_id'].'"/> </tr>';
  }

 echo json_encode($output);

}



if(isset($_POST["operation"]))
{
	if($_POST["operation"] == "Add")
	{

		$evnname = $_POST['evnname'];
		$evndesc = $_POST['evndesc'];



	// 	$temp = explode(".",$_FILES['evnimg']['name']);
	// 	$link = "img/events".basename($_FILES['evnimg']['name']);
	// 	$target = "../../../../img/events/".".".end($temp);
	// 	$image = $_FILES['evnimg']['name'];
	// 	if (move_uploaded_file($_FILES['evnimg']['tmp_name'], $target)) {
	// 	   echo "File is valid, and was successfully uploaded.\n";
	//  } else {
	// 	   echo "Error uploading image!\n";
	//  }

$target_dir = "../../../../img/events/";
$target_file = $target_dir . rand(1000,1000000). '_' . basename($_FILES["evnimg"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));



// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
	$check = getimagesize($_FILES["evnimg"]["tmp_name"]);
	if($check !== false) {
			echo "File is an image - " . $check["mime"] . ".";
			$uploadOk = 1;
	} else {
			echo "File is not an image.";
			$uploadOk = 0;
	}
}
// Check if file already exists
if (file_exists($target_file)) {
	echo "Sorry, file already exists.";
	$uploadOk = 0;
}
// Check file size
if ($_FILES["evnimg"]["size"] > 500000) {
	echo "Sorry, your file is too large.";
	$uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
	echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
	$uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
	echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
	if (move_uploaded_file($_FILES["evnimg"]["tmp_name"], $target_file)) {
			echo "The file ". basename( $_FILES["evnimg"]["name"]). " has been uploaded.";
	} else {
			echo "Sorry, there was an error uploading your file.";
	}
}


		$q1 = $connection->prepare("INSERT INTO tbl_event(evn_image, evn_name, evn_desc, evn_status) VALUES (:image, :evnname,:evndesc,'APPROVED')");
		$q1->bindValue(':image', $target_file, PDO::PARAM_STR);
		$q1->bindValue(':evnname', $evnname, PDO::PARAM_STR);
		$q1->bindValue(':evndesc', $evndesc, PDO::PARAM_STR);
		$ra = $q1->execute();


			if(isset($_POST['date']) && isset($_POST['starttime']) && isset($_POST['endtime']) && isset($_POST['venue']) ){

				$dates = $_POST['date'];
				$starttime = $_POST['starttime'];
				$endtime = $_POST['endtime'];
				$venue = $_POST['venue'];

				$date_array = array();
				$starttime_array = array();
				$endtime_array = array();
				$venue_array = array();

				for($i = 0; $i < count($dates) && $i < count($starttime) && $i < count($endtime) && $i < count($venue); $i++){

					$date_array = $dates[$i];
					$starttime_array = $starttime[$i];
					$endtime_array = $endtime[$i];
					$venue_array = $venue[$i];

					$q = $connection->prepare("INSERT INTO tbl_eventdetail (evn_det_date, evn_id, evn_det_time_start, evn_det_time_end, evn_det_venue) VALUES( :dates, :evnid, :timestart, :timeend, :venue)");
					$resultB = $q->execute(
							 array( ':dates' => $date_array,

									':evnid' => get_latest_event(),
									':timestart' => $starttime_array,
									':timeend' => $endtime_array,
									':venue' => $venue_array
								)
						);

			}


			}

		if(!empty($resultB))
		{
			echo 'Data inserted.';
		}else
			echo 'Error';

	}
	if($_POST["operation"] == "Edit")
	{



		$imgFile = $_FILES['evnimg']['name'];
	  $tmp_dir = $_FILES['evnimg']['tmp_name'];
	  $imgSize = $_FILES['evnimg']['size'];
		$evnname = $_POST['evnnamedetails'];
		$evndesc = $_POST['evndescdetails'];
		$evnid = $_POST['evniddetails'];


	$upload_dir = '';
	$stmt_edit = $connection->prepare('SELECT evn_image FROM tbl_event WHERE evn_id =:id');
  $stmt_edit->execute(array(':id'=>$evnid));
  $edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
  extract($edit_row);

		if($imgFile)
  {
   $upload_dir = '../../../../img/events/'; // upload directory
   $imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
   $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
   $userpic = rand(1000,1000000).".".$imgExt;
   if(in_array($imgExt, $valid_extensions))
   {
    if($imgSize < 5000000)
    {
     unlink($edit_row['evn_image']);
     move_uploaded_file($tmp_dir,$upload_dir.$userpic);
    }
    else
    {
     $errMSG = "Sorry, your file is too large it should be less then 5MB";
    }
   }
   else
   {
    $errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
   }
  }
  else
  {
   // if no image selected the old image remain as it is.
   $userpic = $edit_row['evn_image']; // old image from database
  }


		$q1 = $connection->prepare("UPDATE tbl_event SET evn_name = :evnname, evn_desc = :evndesc, evn_image = :image WHERE evn_id = :id");
		$ra = $q1->execute(
			array(
				':evnname'	=>	$evnname,
				':evndesc'	=>	$evndesc,
				':id' => $evnid,
				':image' => $upload_dir.$userpic,
			)
		);

			$id = $_POST['evndetid'];
			$dates = $_POST['date'];
			$starttime = $_POST['starttime'];
			$endtime = $_POST['endtime'];
			$venue = $_POST['venue'];

			$id_array = array();
			$date_array = array();
			$starttime_array = array();
			$endtime_array = array();
			$venue_array = array();

			for($i = 0; $i < count($dates) && $i < count($starttime) && $i < count($endtime) && $i < count($venue) && $i<count($id); $i++){

				$id_array = $id[$i];
				$date_array = $dates[$i];
				$starttime_array = $starttime[$i];
				$endtime_array = $endtime[$i];
				$venue_array = $venue[$i];

			  $q = $connection->prepare("UPDATE tbl_eventdetail SET evn_det_date = :dates, evn_det_time_start = :timestart, evn_det_time_end = :timeend, evn_det_venue = :venue WHERE evn_det_id = :id");
			  $resultB = $q->execute(
			  		 array( ':dates' => $date_array,
			  		 		':timestart' => $starttime_array,
			  		 		':timeend' => $endtime_array,
			  		 		':venue' => $venue_array,
			  		 		':id' => $id_array
			  		  )
			  	);

			}
		if(!empty($resultB))
		{
			echo 'Data Updated';
		}else
			echo 'Error';
	}
}

?>
