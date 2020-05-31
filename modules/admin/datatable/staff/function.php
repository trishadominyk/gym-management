<?php

function get_total_all_records()
{
	include('../db.php');
	$statement = $connection->prepare("SELECT S.stf_id, S.stf_email, S.stf_firstname, S.stf_lastname, S.stf_contact, S.lvl_id,L.lvl_id, L.lvl_name FROM(tbl_staff S INNER JOIN tbl_level L ON S.lvl_id = L.lvl_id)" );
	$statement->execute();
	$result = $statement->fetchAll();
	return $statement->rowCount();
}

function get_staff_email($email){
	include '../db.php';
	$q = $connection->prepare('SELECT * FROM tbl_staff WHERE stf_email = :email');
	$q->bindValue(':email', $email, PDO::PARAM_STR);
	$q->execute();
	$r = $q->fetchAll();
	return $q->rowCount();

}

?>
