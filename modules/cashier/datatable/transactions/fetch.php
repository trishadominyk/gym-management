<?php
include('../db.php');
include('function.php');

$date = date('Y-m-d');

// storing  request (ie, get/post) global array to a variable  
$requestData = $_REQUEST;

$sql = "SELECT * FROM tbl_transaction T INNER JOIN tbl_customer C ON T.cust_id = C.cust_id ";

$datefrom = (!empty($requestData['columns'][0]['search']['value'])) ? $requestData['columns'][0]['search']['value'] : $date;
$dateto = (!empty($requestData['columns'][1]['search']['value'])) ? $requestData['columns'][1]['search']['value'] : $date;

$sql.="WHERE DATE(T.trns_date) >= '".$datefrom."' AND DATE(T.trns_date) <= '".$dateto."' ";

if(isset($_POST["order"]))
	$sql .= ' ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
else
	$sql .= ' ORDER BY T.trns_date DESC ';

if($_POST["length"] != -1)
    $sql .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];

$statement = $connection->prepare($sql);
$statement->execute();
$result = $statement->fetchAll();
$filtered_rows = $statement->rowCount();

$timeout = '';
$data = array();
foreach($result as $row){
    $sub_array = array();
	$sub_array[] = date("F d, Y", strtotime($row["trns_date"]));
    $sub_array[] = $row['trns_code'];
	
    $items = '';
    $list = get_transaction_items($row['trns_id']);
    foreach($list as $value){
        if($value['cls_name'] != NULL)
            $items .= '<span>'.$value['cls_name'].'</span><br>';
        else
            $items .= '<span>'.$value['met_name'].'</span><br>';
	}
    
    $sub_array[] = $items;
    $sub_array[] = 'Php '.number_format($row['trns_total'], 2);
    $sub_array[] = $row['cust_firstname'].' '.$row['cust_lastname'];
	$sub_array[] = '<button type="button" id="'.$row["trns_id"].'" class="btn btn-gray btn-sm print svg-middle">'.file_get_contents('../../../../svg/ic_print.svg').'</button>';
	$data[] = $sub_array;
}

$output = array(
	"draw"				=>	intval($_POST["draw"]),
	"recordsTotal"		=> 	$filtered_rows,
	"recordsFiltered"	=>	get_total_logbook_records($sql),
	"data"				=>	$data
);

echo json_encode($output);  // send data as json format