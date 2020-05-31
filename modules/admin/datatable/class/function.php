<?php
function get_total_all_records()
{
	include('../db.php');
	$statement = $connection->prepare("SELECT * FROM(tbl_class C INNER JOIN tbl_classcategory CC ON C.clc_id = CC.clc_id)");
	$statement->execute();
	$result = $statement->fetchAll();
	return $statement->rowCount();
}

?>
