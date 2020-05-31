	<?php
include('../db.php');
include('function.php');


if(isset($_POST["operation-ann"])){
	if($_POST["operation-ann"] == "Add"){

$anntitle = $_POST['anntitle'];
$anncont = $_POST['anncontent'];
$anndate = $_POST['anndate'];


		$q1 = $connection->prepare("INSERT INTO tbl_announcement(ann_title, ann_content, ann_date) VALUES (:title, :content,:date)");
		$q1->bindValue(':title', $anntitle, PDO::PARAM_STR);
		$q1->bindValue(':content', $anncont, PDO::PARAM_STR);
		$q1->bindValue(':date', $anndate, PDO::PARAM_STR);
		$ra = $q1->execute();

		if(!empty($ra)){
			echo 'Data inserted.';
		}else
			echo 'Error inserting data';

	}
	if($_POST["operation-ann"] == "Edit")
	{
		$anntitle = $_POST['anntitle'];
		$anncont = $_POST['anncontent'];
		$anndate = $_POST['anndate'];
		$annid = $_POST['annid'];


		$q1 = $connection->prepare("UPDATE tbl_announcement SET ann_title = :title, ann_content = :content, ann_date = :date WHERE ann_id = :id");
		$ra = $q1->execute(
			array(
				':title'	=>	$anntitle,
				':content'	=>	$anncont,
				':date'	=>	$anndate,
				':id' => $annid
			)
		);

		}
		if(!empty($ra))
		{
			echo 'Data Updated';
		}else
			echo 'Error';
	}


?>
