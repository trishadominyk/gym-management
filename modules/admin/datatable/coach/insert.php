<?php
include('../db.php');
include('function.php');
if(!empty($_POST["operation"]))
{
	if($_POST["operation"] == "Add")
	{
		$checkquery = $connection->prepare("SELECT * FROM tbl_staffclass WHERE stf_id = '".$_POST["stfid"]."' AND clc_id = '".$_POST["clcid"]."'"); 
		$checkquery->execute();
		$checkresult = $checkquery->rowCount();
		if($checkresult == 0){
			$statement = $connection->prepare("INSERT INTO tbl_staffclass(clc_id, stf_id) VALUES(:clcid, :stfid)");
			$result = $statement->execute(
				array(
					':clcid' => $_POST["clcid"],
					':stfid'	=>	$_POST["stfid"]
					)
				);
			if($result){
				echo 'Data inserted.';
			}else{
				echo 'Data not inserted.';
			};
		}else
			echo 'Class already added.';
		
	}
}

?>