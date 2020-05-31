<?php

function get_class_category(){
	include('../../../../library/db.php');
	$q=$connection->prepare('SELECT clc_id, clc_name FROM tbl_classcategory');
	$q->execute();
	$r = $q->fetchAll();
	return $r;
}

function graph_class_sales($id){
include('../../../../library/db.php');

    $q = $connection->prepare('SELECT SUM(I.trni_amount) as totalamount
    	FROM tbl_transaction T
    	INNER JOIN tbl_transitems I ON T.trns_id = I.trns_id
    	INNER JOIN tbl_class C ON I.cls_id = C.cls_id
    	INNER JOIN tbl_classcategory A ON A.clc_id = C.clc_id
    	WHERE YEAR(T.trns_date) = YEAR(CURRENT_TIMESTAMP) AND A.clc_id = :id'
    	);
	$q->bindValue(':id', $id, PDO::PARAM_STR);
	$q->execute();
	$r = $q->fetch();
	if($r != null){
		$totalamount = $r['totalamount'];
	}else
		$totalamount = 0;

	return $totalamount;
}


function graph_peak_day(){
    include('../../../../library/db.php');

	$q = $connection->prepare('SELECT AVG(countlog) ctl, daynme FROM (SELECT COUNT(log_id) as countlog, DAYNAME(log_date) daynme FROM tbl_logbook WHERE DAYNAME(log_date) <> "Sunday" GROUP BY log_date ORDER BY DAYOFWEEK(log_date))tbl_logbook GROUP BY daynme ORDER BY DEFAULT(daynme)');
	$q->execute();
	$r = $q->fetchAll();
	return $r;

}


function graph_peak_hour(){
    include('../../../../library/db.php');

	$q = $connection->prepare('SELECT AVG(countlog) ctl, HOUR(timein) timein, log_date FROM (SELECT COUNT(log_id) as countlog, log_timein timein, log_date FROM tbl_logbook GROUP BY log_date,HOUR(log_timein) ORDER BY log_timein)tbl_logbook GROUP BY HOUR(timein) ORDER BY DEFAULT(timein)');
	$q->execute();
	$r = $q->fetchAll();
	return $r;

}

function graph_peak_month(){
  include ('../../../../library/db.php');
  $q = $connection->prepare('SELECT AVG(evncount) evncnt, monthname FROM (SELECT COUNT(evn_det_id)/COUNT(DISTINCT YEAR(evn_det_date)) evncount, MONTHNAME(evn_det_date) monthname FROM tbl_eventdetail GROUP BY monthname) T GROUP BY monthname ORDER BY monthname DESC');
  $q->execute();
  $r=$q->fetchAll();
  return $r;
}

?>
