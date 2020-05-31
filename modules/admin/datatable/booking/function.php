<?php
function get_total_all_records()
{
	include('../db.php');
	$statement = $connection->prepare("SELECT * FROM tbl_event WHERE evn_status <> 'CANCELED'");
	$statement->execute();
	$result = $statement->fetchAll();
	return $statement->rowCount();
}

function get_latest_event(){
	include('../db.php');
	$statement = $connection->prepare("SELECT evn_id FROM tbl_event ORDER BY evn_id DESC LIMIT 1");
	$statement->execute();
	$result = $statement->fetch();
	return $result['evn_id'];
}



function approve_event_status($id){
	include('../db.php');
	$statement = $connection->prepare("UPDATE tbl_event SET evn_STATUS = 'APPROVED' WHERE evn_id = :id");

	$statement->bindValue(':id', $id, PDO::PARAM_INT);
	$statement->execute();
	return $statement;

}



function get_event_detail($id){
	include('../db.php');
	$statement = $connection->prepare("SELECT * FROM tbl_eventdetail WHERE evn_id = :id");
	$statement->bindValue(':id', $id, PDO::PARAM_INT);
	$statement->execute();
	return $statement->fetchAll();

}


function check_date($dates, $start, $end){
	include ('../db.php');
	$q = $connection->prepare("SELECT * FROM tbl_eventdetail WHERE evn_det_date = :dates AND (:start >= evn_det_time_start OR :end > evn_det_time_start) AND (:start <= evn_det_time_end OR :end < evn_det_time_end)");
	$q ->bindValue(':start', $start, PDO::PARAM_STR);
	$q -> bindValue(':end', $end, PDO::PARAM_STR);
	$q -> bindValue(':dates', $dates, PDO::PARAM_STR);
	$q->execute();
	$r = $q->rowCount();
	return $r;




}
?>
