<?php
function get_total_transaction_records($q){
	include('../db.php');
	$statement = $connection->prepare("$q");
	$statement->execute();
	$result = $statement->fetchAll();
    
	return $statement->rowCount();
}

function get_items($id){
    include('../db.php');
    
	$statement = $connection->prepare(
        "SELECT C.cls_name FROM tbl_transitems I
        INNER JOIN tbl_class C ON I.cls_id = C.cls_id
        WHERE I.trns_id = $id"
    );
	$statement->execute();
	$result = $statement->fetchAll();
    
    $items = '';
    foreach($result as $row){
        $items .= '<span>'.$row['cls_name'].'</span>';
    }
    
    $statement2 = $connection->prepare(
        "SELECT M.met_name FROM tbl_transitems I
        INNER JOIN tbl_membershiptype M ON I.met_id = M.met_id
        WHERE I.trns_id = $id"
    );
	$statement2->execute();
	$result2 = $statement2->fetchAll(PDO::FETCH_ASSOC);
    
    foreach($result2 as $row){
        $items .= '<span>'.$row['met_name'].'</span>';
    }
    
    return $items;
}