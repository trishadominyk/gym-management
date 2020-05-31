<?php
function get_total_logbook_records($q){
	include('../db.php');
	$statement = $connection->prepare("$q");
	$statement->execute();
	$result = $statement->fetchAll();
    
	return $statement->rowCount();
}

function get_transaction_items($id){
    include('../db.php');
    $statement = $connection->prepare
    (
        "SELECT C.cls_name, M.met_name FROM tbl_transitems I
        LEFT JOIN tbl_class C ON I.cls_id = C.cls_id
        LEFT JOIN tbl_membershiptype M ON I.met_id = M.met_id
        WHERE I.trns_id = $id"
    );
	$statement->execute();
	$result = $statement->fetchAll();
    
    return $result;
}