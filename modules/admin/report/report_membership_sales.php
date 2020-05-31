<?php 
require('../../../fpdf/fpdf.php');
require ('../../../library/db.php');
//include 'function.php';

if(isset($_GET["start"]) && isset($_GET["end"])){
class PDF extends FPDF{
	function header(){
	$start = $_GET['start'];
	$end = $_GET['end'];
	$this->Image('../../../img/logo.png',10,6, 30);
    $this->SetFont('Arial','',14);
    $this->Cell(200,15,'Class Type Sales Report',0,0,'C');
    $this->Ln();
     $this->SetFont('Arial','',11);
    $this->Cell(200,0, date('F d, Y', strtotime($start)).' - '.date('F d, Y', strtotime($end)), 0, 0, 'C');
    $this->Ln(15);	
	}
	function footer(){
		$this->SetY(-15);
		$this->SetFont('Arial', '', 8);
		$this->Cell(0, 10, 'Page'.$this->PageNo().'/{nb}',0,0,'C');
	}
	function headerTable(){
		$this->SetFont('Arial','', 11);
		$this->Cell(100,10,'Name',1,0,'C');
		$this->Cell(100,10,'Total Amount',1,0,'C');

		$this->Ln();
	}
	function viewTable($connection){
		$this->setFont('Arial', '', 11);
		$start = $_GET['start'];
		$end = $_GET['end'];


		$q1=$connection->prepare('SELECT met_id, met_name FROM tbl_membershiptype');
		$q1->execute();
		$r = $q1->fetchAll();

		foreach ($r as $value){
			$id = $value['met_id'];

			$q=$connection->prepare('SELECT SUM(I.trni_amount) as totalamount FROM tbl_transaction T INNER JOIN tbl_transitems I ON T.trns_id = I.trns_id
    		INNER JOIN tbl_membershiptype M ON I.met_id = M.met_id WHERE T.trns_date BETWEEN :start AND :end AND I.met_id = :id');

	    	$q->bindValue(':id', $id, PDO::PARAM_STR);
			$q->bindValue(':start', $start, PDO::PARAM_STR);
			$q->bindValue(':end', $end, PDO::PARAM_STR);
			$q->execute();
			while($data = $q->fetch(PDO::FETCH_OBJ)){
				$this->SetFont('Arial','', 11);
				$this->Cell(100,10,$value['met_name'],1,0,'L');
				$this->Cell(100,10,$data->totalamount,1,0,'L');
				$this->Ln();
			}
		}
	}
}
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage('P','Letter',0);
$pdf->headerTable();
$pdf->viewTable($connection);
$pdf->Output();
}

?>