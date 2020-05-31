<?php

function get_total_all_records()
{
	include('../db.php');
	$statement = $connection->prepare("SELECT E.eqp_serial, E.eqp_id, E.eqp_date_update, E.eqp_status,C.cat_name, C.cat_id, E.cat_id FROM(tbl_equipment E INNER JOIN tbl_category C ON E.cat_id = C.cat_id) WHERE E.eqp_status = 'OKAY' ");
	$statement->execute();
	$result = $statement->fetchAll();
	return $statement->rowCount();
}

?>