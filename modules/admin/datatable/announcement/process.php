<?php
include 'function.php';

if(!empty($_POST['checkdate']) && !empty($_POST['date']) && !empty($_POST['start']) && !empty($_POST['end'])){

	$date = $_POST['date'];
	$start = $_POST['start'];
	$end = $_POST['end'];

		$r = check_date($date, $start, $end);
		if($r == 0){

			echo 'Date and time available.';
		}else

			echo 'Date and time NOT available. <br/>';


}else
	echo '';


?>
