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
    $this->Cell(200,15,'Canceled Event',0,0,'C');
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
		$this->Cell(40,10,'Name',1,0,'C');
		$this->Cell(40,10,'Date',1,0,'C');
		$this->Cell(40,10,'Time start',1,0,'C');
		$this->Cell(40,10,'Time end',1,0,'C');
		$this->Cell(40,10,'Venue',1,0,'C');
		$this->Ln();
	}
	function viewTable($connection){
		$this->setFont('Arial', '', 11);
		$start = $_GET['start'];
		$end = $_GET['end'];
		$q = $connection->prepare('SELECT E.evn_name, ED.evn_det_date, ED.evn_det_time_start, ED.evn_det_time_end, ED.evn_det_venue  FROM tbl_event E LEFT OUTER JOIN tbl_eventdetail ED ON E.evn_id = ED.evn_id WHERE evn_det_date BETWEEN :start AND :end AND E.evn_status = "CANCELED" ORDER BY ED.evn_det_date');
		$q->bindValue(':start', $start, PDO::PARAM_STR);
		$q->bindValue(':end', $end, PDO::PARAM_STR);
		$q->execute();
		while($data = $q->fetch(PDO::FETCH_OBJ)){

			$this->SetFont('Arial','', 11);
			$this->Cell(40,10,$data->evn_name,1,0,'L');
			$this->Cell(40,10,date('F d, Y', strtotime($data->evn_det_date)),1,0,'L');
			$this->Cell(40,10,date('h:i:s A', strtotime($data->evn_det_time_start)),1,0,'L');
			$this->Cell(40,10,date('h:i:s A', strtotime($data->evn_det_time_end)),1,0,'L');	
			$this->Cell(40,10,$data->evn_det_venue,1,0,'L');		
			$this->Ln();
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