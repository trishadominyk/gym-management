<?php

function get_total_all_records()
{
	include('../db.php');
	$statement = $connection->prepare("SELECT * FROM tbl_promo");
	$statement->execute();
	$result = $statement->fetchAll();
	return $statement->rowCount();
}

function get_latest_promo_id(){
		include('../db.php');
	$statement = $connection->prepare("SELECT prm_id FROM tbl_promo ORDER BY prm_id DESC LIMIT 1");
	$statement->execute();
	$result = $statement->fetch();
	return $result['prm_id'];

}

function get_class_name($id){
	include('../db.php');

	$q = $connection->prepare("SELECT cls_name FROM tbl_class WHERE cls_id = :id");

	$q->bindValue(':id', $id, PDO::PARAM_INT);
	$q->execute();
	$r = $q->fetch();
	if($r != null){
		$result = $r['cls_name'];
	}else
		$result = 'No data Available';
	return $result;
}

function get_memtype_name($id){
	include('../db.php');

	$q = $connection->prepare("SELECT met_name FROM tbl_membershiptype WHERE met_id = :id");

	$q->bindValue(':id', $id, PDO::PARAM_INT);
	$q->execute();
	$r = $q->fetch();
	if($r != null){
		$result = $r['met_name'];
	}else
		$result = 'No data Available';
	return $result;
	
}

function check_promo_code($code){
	include('../db.php');
	$checkquery = $connection->prepare("SELECT * FROM tbl_promo WHERE prm_code = :code");
	$checkquery->bindValue(':code', $code, PDO::PARAM_STR);
	$checkquery->execute();
	$r = $checkquery->fetchAll();
	return $checkquery->rowCount();		
}

?>