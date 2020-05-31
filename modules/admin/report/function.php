<?php
function graph_membership($start, $end){
    include('../../../library/db.php');

$q = $connection->prepare('SELECT COUNT(mem_id) as countmem, mem_status FROM tbl_membership WHERE mem_date_added BETWEEN :start AND :end GROUP BY mem_status');
	$q->bindValue(':start', $start, PDO::PARAM_STR);
	$q->bindValue(':end', $end, PDO::PARAM_STR);
	$q->execute();
	$r = $q->fetchAll();
	return $r;

}


function get_membership_table($start, $end){
	include('../../../library/db.php');

	$q=$connection->prepare('SELECT cust_firstname, cust_lastname, mem_date_added, mem_date_expire, mem_status FROM(tbl_membership M INNER JOIN tbl_customer C ON M.cust_id = C.cust_id) WHERE mem_date_added BETWEEN :start AND :end ORDER BY mem_status, mem_date_added');

	$q->bindValue(':start', $start, PDO::PARAM_STR);
	$q->bindValue(':end', $end, PDO::PARAM_STR);
	$q->execute();
	$r = $q->fetchAll();
	return $r;
}

function get_membership_type(){
	include('../../../library/db.php');
	$q=$connection->prepare('SELECT met_id, met_name FROM tbl_membershiptype');
	$q->execute();
	$r = $q->fetchAll();
	return $r;
}


function graph_membership_sales($id, $start, $end){
     include('../../../library/db.php');

    $q = $connection->prepare('SELECT SUM(I.trni_amount) as totalamount
    	FROM tbl_transaction T
    	INNER JOIN tbl_transitems I ON T.trns_id = I.trns_id
    	INNER JOIN tbl_membershiptype M ON I.met_id = M.met_id
    	WHERE T.trns_date BETWEEN :start AND :end AND I.met_id = :id'
    	);

	$q->bindValue(':start', $start, PDO::PARAM_STR);
	$q->bindValue(':end', $end, PDO::PARAM_STR);
	$q->bindValue(':id', $id, PDO::PARAM_STR);
	$q->execute();
	$r = $q->fetch();
	if($r != null){
		$totalamount = $r['totalamount'];
	}else
		$totalamount = 0;
	return $totalamount;
}

function get_class_category(){
	include('../../../library/db.php');
	$q=$connection->prepare('SELECT clc_id, clc_name FROM tbl_classcategory');
	$q->execute();
	$r = $q->fetchAll();
	return $r;
}

function graph_class_sales($id, $start, $end){
     include('../../../library/db.php');

    $q = $connection->prepare('SELECT SUM(I.trni_amount) as totalamount
    	FROM tbl_transaction T
    	INNER JOIN tbl_transitems I ON T.trns_id = I.trns_id
    	INNER JOIN tbl_class C ON I.cls_id = C.cls_id
    	INNER JOIN tbl_classcategory A ON A.clc_id = C.clc_id
    	WHERE T.trns_date BETWEEN :start AND :end AND A.clc_id = :id'
    	);

	$q->bindValue(':start', $start, PDO::PARAM_STR);
	$q->bindValue(':end', $end, PDO::PARAM_STR);
	$q->bindValue(':id', $id, PDO::PARAM_STR);
	$q->execute();
	$r = $q->fetch();
	if($r != null){
		$totalamount = $r['totalamount'];
	}else
		$totalamount = 0;
	return $totalamount;
}


/*function graph_membership_sales($start, $end){
	include('../../../library/db.php');
	$q=$connection->prepare('SELECT SUM(trni_amount) as total, met_id FROM (tbl_transitems INNER JOIN tbl_transaction ON tbl_transitems.trns_id = tbl_transaction.trns_id) WHERE trns_date BETWEEN :start AND :end AND tbl_transitems.met_id <> 0 GROUP BY met_id');

	$q->bindValue(':start', $start, PDO::PARAM_STR);
	$q->bindValue(':end', $end, PDO::PARAM_STR);
	$q->execute();
	$r = $q->fetchAll();
	return $r;
}	*/


function get_membershiptype_sales($id){
	include('../../../library/db.php');
	$q=$connection->prepare('SELECT met_name FROM tbl_membershiptype WHERE met_id = :id LIMIT 1');
	$q->bindValue(':id', $id, PDO::PARAM_INT);
	$q->execute();
	$r = $q->fetch();
    $value =  $r['met_name'];
	return $value;
}

function get_class_list_sales(){
	include('../../../library/db.php');
	$q=$connection->prepare('SELECT * FROM tbl_class');
	$q->execute();
	$r = $q->fetchAll();
	return $r;

}

function get_totalamount_class_sales($start, $end, $id){
	include('../../../library/db.php');
	$q=$connection->prepare('SELECT SUM(trni_amount) as totalamount
  FROM tbl_transitems,tbl_transaction
  WHERE tbl_transitems.trns_id = tbl_transaction.trns_id
  AND tbl_transaction.trns_date
  BETWEEN :start
  AND :end
  AND tbl_transitems.cls_id = :id');

	$q->bindValue(':start', $start, PDO::PARAM_STR);
	$q->bindValue(':end', $end, PDO::PARAM_STR);
	$q->bindValue(':id', $id, PDO::PARAM_STR);
	$q->execute();
	$r = $q->fetchAll();
	return $r;
}


function get_memtype_list_sales(){
	include('../../../library/db.php');
	$q=$connection->prepare('SELECT * FROM tbl_membershiptype');
	$q->execute();
	$r = $q->fetchAll();
	return $r;

}

function get_totalamount_memtype_sales($start, $end, $id){
	include('../../../library/db.php');
	$q=$connection->prepare('SELECT SUM(trni_amount) as totalamount FROM tbl_transitems,tbl_transaction WHERE tbl_transitems.trns_id = tbl_transaction.trns_id AND tbl_transaction.trns_date BETWEEN :start AND :end AND tbl_transitems.met_id = :id');

	$q->bindValue(':start', $start, PDO::PARAM_STR);
	$q->bindValue(':end', $end, PDO::PARAM_STR);
	$q->bindValue(':id', $id, PDO::PARAM_STR);
	$q->execute();
	$r = $q->fetchAll();
	return $r;
}


function graph_available_equipment(){
	include('../../../library/db.php');
	$q=$connection->prepare('SELECT count(eqp_name) as countavail FROM tbl_equipment E, tbl_category C WHERE E.cat_id = C.cat_id AND eqp_status = "AVAILABLE" GROUP BY eqp_status LIMIT 1');

	$q->execute();
	$r = $q->fetchAll();
	return $r;
}

function graph_repair_equipment($start, $end){
    include('../../../library/db.php');

$q = $connection->prepare('SELECT count(eqp_name) as countrep FROM tbl_equipment E, tbl_category C WHERE E.cat_id = C.cat_id AND eqp_status = "REPAIR" AND eqp_date_update BETWEEN :start AND :end GROUP BY eqp_status LIMIT 1');

	$q->bindValue(':start', $start, PDO::PARAM_STR);
	$q->bindValue(':end', $end, PDO::PARAM_STR);
	$q->execute();
	$r = $q->fetchAll();
	if($r == null){
		$data_array= array();
		$data_array[] =array(
					'countrep' => 0
			);
		$r = $data_array;
	}
	return $r;

}

function graph_disposed_equipment($start, $end){
    include('../../../library/db.php');

$q = $connection->prepare('SELECT count(eqp_name) as countdisp FROM tbl_equipment E, tbl_category C WHERE E.cat_id = C.cat_id AND eqp_status = "DISPOSED" AND eqp_date_update BETWEEN :start AND :end GROUP BY eqp_status LIMIT 1 ');

	$q->bindValue(':start', $start, PDO::PARAM_STR);
	$q->bindValue(':end', $end, PDO::PARAM_STR);
	$q->execute();
	$r = $q->fetchAll();
	if($r == null){
		$data_array= array();
		$data_array[] =array(
					'countdisp' => 0
			);
		$r = $data_array;
	}
	return $r;

}


function get_avail_equipment(){
	 include('../../../library/db.php');

	 $q = $connection->prepare('SELECT * FROM tbl_equipment WHERE eqp_status = "AVAILABLE" ORDER BY eqp_name');

	 $q->execute();
	 $r = $q-> fetchAll();
	 return $r;
}


function get_repair_equipment($start, $end){
	 include('../../../library/db.php');
	 $q = $connection->prepare('SELECT * FROM tbl_equipment WHERE eqp_status = "REPAIR" AND eqp_date_update BETWEEN :start AND :end ORDER BY eqp_name');
	 $q->bindValue(':start', $start, PDO::PARAM_STR);
	 $q->bindValue(':end', $end, PDO::PARAM_STR);
	 $q->execute();
	 $r = $q-> fetchAll();
	 return $r;
}

function get_disposed_equipment($start, $end){
	 include('../../../library/db.php');
	 $q = $connection->prepare('SELECT * FROM tbl_equipment WHERE eqp_status = "DISPOSED" AND eqp_date_update BETWEEN :start AND :end ORDER BY eqp_name');
	 $q->bindValue(':start', $start, PDO::PARAM_STR);
	 $q->bindValue(':end', $end, PDO::PARAM_STR);
	 $q->execute();
	 $r = $q-> fetchAll();
	 return $r;
}


function get_event_booked_approved($start, $end){
	include('../../../library/db.php');
	 $q = $connection->prepare('SELECT E.evn_name, ED.evn_det_date, ED.evn_det_time_start, ED.evn_det_time_end, ED.evn_det_venue  FROM tbl_event E LEFT OUTER JOIN tbl_eventdetail ED ON E.evn_id = ED.evn_id WHERE evn_det_date BETWEEN :start AND :end AND E.evn_status = "APPROVED"');
	 $q->bindValue(':start', $start, PDO::PARAM_STR);
	 $q->bindValue(':end', $end, PDO::PARAM_STR);
	 $q->execute();
	 $r = $q-> fetchAll();
	 return $r;
}


function get_event_booked_canceled($start, $end){
	include('../../../library/db.php');
	 $q = $connection->prepare('SELECT E.evn_name, ED.evn_det_date, ED.evn_det_time_start, ED.evn_det_time_end, ED.evn_det_venue  FROM tbl_event E LEFT OUTER JOIN tbl_eventdetail ED ON E.evn_id = ED.evn_id WHERE evn_det_date BETWEEN :start AND :end AND E.evn_status = "CANCELED"');
	 $q->bindValue(':start', $start, PDO::PARAM_STR);
	 $q->bindValue(':end', $end, PDO::PARAM_STR);
	 $q->execute();
	 $r = $q-> fetchAll();
	 return $r;
}



function graph_approved_events($start, $end){
		include('../../../library/db.php');
	 $q = $connection->prepare('SELECT COUNT(E.evn_id) as evncount_app, E.evn_status  FROM tbl_event E INNER JOIN tbl_eventdetail ED ON E.evn_id = ED.evn_id WHERE evn_det_date BETWEEN :start AND :end AND E.evn_status = "APPROVED" GROUP BY E.evn_status');
	 $q->bindValue(':start', $start, PDO::PARAM_STR);
	 $q->bindValue(':end', $end, PDO::PARAM_STR);
	 $q->execute();
	 $r = $q-> fetchAll();
	 if($r == null){
		$data_array= array();
		$data_array[] =array(
					'evncount_app' => '0',
					'evn_status' => 'APPROVED'
			);
		$r = $data_array;
	}
	 return $r;
}




function graph_canceled_events($start, $end){
		include('../../../library/db.php');
	 $q = $connection->prepare('SELECT COUNT(E.evn_id) as evncount_can, E.evn_status  FROM tbl_event E INNER JOIN tbl_eventdetail ED ON E.evn_id = ED.evn_id WHERE evn_det_date BETWEEN :start AND :end AND E.evn_status = "CANCELED" GROUP BY E.evn_status');
	 $q->bindValue(':start', $start, PDO::PARAM_STR);
	 $q->bindValue(':end', $end, PDO::PARAM_STR);
	 $q->execute();
	 $r = $q-> fetchAll();
	 	 if($r == null){
		$data_array= array();
		$data_array[] =array(
					'evncount_can' => '0',
					'evn_status' => 'CANCELED'
			);
		$r = $data_array;
	}

	 return $r;
}

function get_staff_log($start, $end){
	include '../../../library/db.php';
	$q = $connection->prepare('SELECT S.stf_firstname, S.stf_lastname, SL.stf_log_date, SL.stf_log_in, SL.stf_log_out  FROM tbl_staff S INNER JOIN tbl_stafflogbook SL ON SL.stf_id = S.stf_id WHERE SL.stf_log_date >= :start AND SL.stf_log_date <= :end');
	$q->bindValue(':start', $start, PDO::PARAM_STR);
	$q->bindValue(':end', $end, PDO::PARAM_STR);
	$q->execute();
	$r = $q->fetchAll(PDO::FETCH_OBJ);
	return $r;

}


function get_student_log($start, $end){
	include '../../../library/db.php';
	$q = $connection->prepare('SELECT C.cust_firstname, C.cust_lastname, L.log_date, L.log_timein, L.log_timeout  FROM tbl_logbook L INNER JOIN tbl_customer C ON L.cust_id = C.cust_id WHERE L.log_date >= :start AND L.log_date <= :end');
	$q->bindValue(':start', $start, PDO::PARAM_STR);
	$q->bindValue(':end', $end, PDO::PARAM_STR);
	$q->execute();
	$r = $q->fetchAll(PDO::FETCH_OBJ);
	return $r;
}


function get_top_student_log($start, $end){
  include '../../../library/db.php';
  $q = $connection->prepare('SELECT COUNT(log_id) as cnt, C.cust_firstname, C.cust_lastname FROM(tbl_logbook L INNER JOIN tbl_customer C ON L.cust_id = C.cust_id) WHERE L.log_date >= :start AND L.log_date <= :end GROUP BY L.cust_id ORDER BY cnt DESC LIMIT 5');
  $q->bindValue(':start', $start, PDO::PARAM_STR);
  $q->bindValue(':end', $end, PDO::PARAM_STR);
  $q->execute();
  $r = $q->fetchAll(PDO::FETCH_OBJ);
  return $r;
}
?>
