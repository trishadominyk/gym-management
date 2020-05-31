<?php 
require('../../../../fpdf/fpdf.php');
require ('../../../../library/db.php');
//include 'function.php';

if(isset($_GET["id"])){
    function get_total($connection,$id){
        $q = $connection->prepare('SELECT trns_total FROM tbl_transaction WHERE trns_id = :id');
        $q->bindValue(':id', $id, PDO::PARAM_STR);
        $q->execute();
        $data = $q->fetch(PDO::FETCH_OBJ);
        return $data->trns_total;
    }
    
    function get_customer($connection,$id){
        $q = $connection->prepare('SELECT C.cust_firstname, C.cust_lastname FROM tbl_transaction T 
        INNER JOIN tbl_customer C ON T.cust_id = C.cust_id
        WHERE T.trns_id = :id');
        $q->bindValue(':id', $id, PDO::PARAM_STR);
        $q->execute();
        $data = $q->fetch(PDO::FETCH_OBJ);
        $name = $data->cust_firstname.' '.$data->cust_lastname;
        return $name;
    }
    
    function get_date($connection,$id){
        $q = $connection->prepare('SELECT DATE(trns_date) as trns_date FROM tbl_transaction
        WHERE trns_id = :id');
        $q->bindValue(':id', $id, PDO::PARAM_STR);
        $q->execute();
        $data = $q->fetch(PDO::FETCH_OBJ);
        return date('F d, Y', strtotime($data->trns_date));
    }
    
    class PDF extends FPDF{
        function header(){
            $id = $_GET['id'];
            $this->Image('../../../../img/logo.png',10,6, 30);
            $this->SetFont('Arial','',14);
            $this->Cell(130,10, '6100 Martial Arts and Fitness',0,0,'C');
            $this->Ln();
            
            $this->SetFont('Arial','',8);
            $this->Cell(108,0, '10th Lacson Street, Bacolod City',10,0,'C');
            $this->Ln();
            
            $this->SetFont('Arial','',8);
            $this->Cell(100,10, 'Printed '.date('F d, Y'), 0, 0, 'C');
            $this->Ln();
            
            
            $this->Ln(15);	
        }
        function footer(){
            $this->SetY(-15);
            $this->SetFont('Arial', '', 8);
            $this->Cell(0, 0, 'This serves as your official receipt.',0,0,'C');
        }
        function headerTable(){
            
        }
        function viewTable($connection){
            $id = $_GET['id'];
            
            $this->setFont('Arial', '', 11);
            $id = $_GET['id'];
            $q = $connection->prepare('SELECT * FROM (tbl_transaction T
            INNER JOIN tbl_transitems I ON T.trns_id = I.trns_id
            LEFT JOIN tbl_class C ON I.cls_id = C.cls_id
            LEFT JOIN tbl_membershiptype M ON I.met_id = M.met_id
            LEFT JOIN tbl_promo P ON I.prm_id = P.prm_id)
            WHERE T.trns_id = :id');
            $q->bindValue(':id', $id, PDO::PARAM_STR);
            $q->execute();
            
            $this->setFont('Arial', '', 11);$this->Cell(100,5,'Customer: '.get_customer($connection, $id),100,0,'L');
            $this->setFont('Arial', '', 11);$this->Cell(100,5,'Transaction Date: '.get_date($connection, $id),100,10,'R');
            $this->Ln();
            
            $this->SetFont('Arial','', 11);
            $this->Cell(100,10,'Item Description',1,0,'L');
            $this->Cell(100,10,'Amount',1,0,'L');

            $this->Ln();
            
            while($data = $q->fetch(PDO::FETCH_OBJ)){
                $this->SetFont('Arial','', 11);

                if($data->cls_id != null){
                    $this->Cell(100,10,$data->cls_name,1,0,'L');
                    $this->Cell(100,10,'Php '.number_format($data->cls_rate,2),1,0,'L');
                    
                    if($data->prm_id != 0){
                        $this->Ln();
                        $this->Cell(100,10,$data->prm_code,1,0,'L');
                        $this->Cell(100,10,'Php -'.number_format($data->prm_discount,2),1,0,'L');
                    }
                }
                else{
                    $this->Cell(100,10,$data->met_name,1,0,'L');
                    $this->Cell(100,10,'Php '.number_format($data->met_rate,2),1,0,'L');
                }
                $this->Ln();
            }
            
            $this->Cell(200,10,'Total: Php '.number_format(get_total($connection, $id),2),1,0,'R');
            $this->Ln();
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