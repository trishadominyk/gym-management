<?php
include 'function.php';

if(isset($_POST['prmcode']) && !empty($_POST['prmcode'])){
	$ra = check_promo_code($_POST['prmcode']);
	if($ra){
		echo 'Promo code already exists.<br/>';
	}
	else{
		echo 'Promo code qualified.<br/>';
	}
}
else
	echo '';

?>
