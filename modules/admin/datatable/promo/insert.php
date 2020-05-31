<?php
include('../db.php');
include('function.php');
if(isset($_POST["operation"]))
{
	if($_POST["operation"] == "Add")
	{
		$q1 = $connection->prepare("INSERT INTO tbl_promo(prm_code, prm_desc, prm_date_start, prm_date_end, prm_discount, prm_max) VALUES(:prm_code, :prm_desc, :prm_date_start, :prm_date_end, :prm_discount, :prm_max)");
	$ra = $q1->execute(
			array(
					':prm_code' => $_POST['prmcode'],
					':prm_desc' => $_POST['prmdesc'],
					':prm_date_start' => $_POST['prmdatestart'],
					':prm_date_end' => $_POST['prmdateend'],
					':prm_discount' => $_POST['prmdiscount'],
					':prm_max' => $_POST['prmmax']
				 )
		);



	if(isset($_POST['classtypes'])){
		$classtypes = $_POST['classtypes'];
			foreach ($classtypes as $value) {
			$statement = $connection->prepare("INSERT INTO tbl_promoclass(cls_id, prm_id) VALUES(:clsid, :prmid)");
			$resultA = $statement->execute(
				array(
					':clsid' => $value,
					':prmid' => get_latest_promo_id()
				)
			);
			}
	}

	if(isset($_POST['memtypes'])){
		$memtypes = $_POST['memtypes'];
		foreach ($memtypes as $valueB) {
			$statement = $connection->prepare("INSERT INTO tbl_promomembershiptype(met_id, prm_id) VALUES(:metid, :prmid)");
			$resultB = $statement->execute(
				array(
						':metid' => $valueB,
						':prmid' => get_latest_promo_id()
				)
			);
			}
	}


	}
	if($_POST["operation"] == "Edit")
	{

		$statement = $connection->prepare("UPDATE tbl_promo SET prm_date_start = :datestart, prm_date_end = :dateend, prm_status = 'OPEN' WHERE prm_id = :prmid");
		$result = $statement->execute(
			array(
				':datestart' =>	$_POST["datefrom"],
				':dateend' =>	$_POST["dateto"],
				':prmid' => $_POST['prmid_dtp']
			)
		);
		if(!empty($result))
		{
			echo 'Data Updated';
		}else
			echo 'GAGO KA BA?';
	}

}

?>
