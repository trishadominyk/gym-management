<?php
function count_current_members(){
	include('../../library/db.php');
	$statement = $connection->prepare("SELECT COUNT(mem_id) as cntmem FROM tbl_membership WHERE mem_status <> 'EXPIRED' ");
	$statement->execute();
    $f = $statement->fetch();
    $value =  $f["cntmem"];
    return $value ;
}

function count_expired_members(){
	include('../../library/db.php');
	$statement = $connection->prepare("SELECT COUNT(mem_id) as cntexp FROM tbl_membership WHERE mem_status <> 'ACTIVE' ");
	$statement->execute();
    $f = $statement->fetch();
    $value =  $f["cntexp"];
    return $value ;
}

function count_curmonth_members(){
	include('../../library/db.php');
	$statement = $connection->prepare("SELECT COUNT(mem_id) as cntcurmnth FROM tbl_membership WHERE mem_date_added = CURDATE()");
	$statement->execute();
    $f = $statement->fetch();
    $value =  $f["cntcurmnth"];
    return $value ;
}

function count_muaythai_active(){
	include('../../library/db.php');
	$query = $connection->prepare("SELECT COUNT(R.rec_id) as countMT FROM tbl_classcategory CC LEFT JOIN tbl_class C ON CC.clc_id = C.clc_id LEFT JOIN tbl_transitems TI ON TI.cls_id = C.cls_id LEFT JOIN tbl_transaction T ON TI.trns_id = T.trns_id LEFT JOIN tbl_record R ON R.trns_id = T.trns_id WHERE CC.clc_name = 'MUAY THAI' AND R.rec_session_remain <> '0'");
	$query->execute();
	$result = $query->fetch();
	if($result != null){
		$value = $result['countMT'];
	}else
		$value = 0;

	return $value;
}


function count_boxing_active(){
	include('../../library/db.php');
	$query = $connection->prepare("SELECT COUNT(R.rec_id) as countMT FROM tbl_classcategory CC LEFT JOIN tbl_class C ON CC.clc_id = C.clc_id LEFT JOIN tbl_transitems TI ON TI.cls_id = C.cls_id LEFT JOIN tbl_transaction T ON TI.trns_id = T.trns_id LEFT JOIN tbl_record R ON R.trns_id = T.trns_id WHERE CC.clc_name = 'BOXING' AND R.rec_session_remain <> '0'");
	$query->execute();
	$result = $query->fetch();
		if($result != null){
		$value = $result['countMT'];
	}else
		$value = 0;

	return $value;
}

function count_jj_active(){
	include('../../library/db.php');
	$query = $connection->prepare("SELECT COUNT(R.rec_id) as countMT FROM tbl_classcategory CC LEFT JOIN tbl_class C ON CC.clc_id = C.clc_id LEFT JOIN tbl_transitems TI ON TI.cls_id = C.cls_id LEFT JOIN tbl_transaction T ON TI.trns_id = T.trns_id LEFT JOIN tbl_record R ON R.trns_id = T.trns_id WHERE CC.clc_name = 'JIU JITSU' AND R.rec_session_remain <> '0'");
	$query->execute();
	$result = $query->fetch();
	if($result != null){
		$value = $result['countMT'];
	}else
		$value = 0;

	return $value;
}

function count_events(){
	include '../../library/db.php';
	$q = $connection->prepare("SELECT COUNT(evn_id) as countEvn FROM tbl_event WHERE evn_status = 'PENDING'");
	$q->execute();
	$r = $q->fetch();
	if($r != null){
		$value = $r['countEvn'];
	}else
		$value = 0;

	return $value;
}

function count_total_sales(){
    include '../../library/db.php';
    $date = date('Y');
	$q = $connection->prepare("SELECT SUM(trns_total) as total_sale FROM tbl_transaction WHERE YEAR(trns_date) = $date");
	$q->execute();
	$r = $q->fetch();
	if($r['total_sale'] != null)
		$value = $r['total_sale'];
	else
		$value = 0;

	return $value;
}

function count_daily_sales(){
    include '../../library/db.php';
    $date = date('Y-m-d');
	$q = $connection->prepare("SELECT SUM(trns_total) as total_sale FROM tbl_transaction WHERE DATE(trns_date) = '$date'");
	$q->execute();
	$r = $q->fetch();
	if($r['total_sale'] != null)
		$value = $r['total_sale'];
	else
		$value = 0.00;

	return $value;
}

function count_monthly_sales(){
include '../../library/db.php';
    $date = date('Y-m-d');
	$q = $connection->prepare("SELECT SUM(trns_total) as total_sale FROM tbl_transaction WHERE MONTH(trns_date) = MONTH(CURRENT_TIMESTAMP)");
	$q->execute();
	$r = $q->fetch();
	if($r['total_sale'] != null)
		$value = $r['total_sale'];
	else
		$value = 0.00;

	return $value;

}

?>
