<?php
include 'function.php';

if(isset($_POST['stfemail']) && !empty($_POST['stfemail'])){
	$ra = get_staff_email($_POST['stfemail']);
	if($ra){
		echo 'Email already exist.<br/>';
	}
	else{
		echo 'Email is qualified.<br/>';
	}
}
else
	echo '';
 ?>
