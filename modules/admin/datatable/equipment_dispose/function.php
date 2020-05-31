<?php

function get_total_all_records()
{
	include('../db.php');
	$statement = $connection->prepare("SELECT E.eqp_status,  E.eqp_serial, E.eqp_id, E.eqp_name,C.cat_name, C.cat_id, E.cat_id FROM(tbl_equipment E INNER JOIN tbl_category C ON E.cat_id = C.cat_id) WHERE E.eqp_status = 'DISPOSED'");
	$statement->execute();
	$result = $statement->fetchAll();
	return $statement->rowCount();
}

?>