<?php
include('function.php');

$output = array();

$result = retrieve_promos($_POST['action'],$_POST['type']);

foreach($result as $row){
    switch($_POST['type']){
        case 'class':
            $sub_array = array();
            $sub_array[] = '<b>'.$row["prm_code"].'</b><br><span>'.$row['prm_desc'].'</span>';
            $sub_array[] = 'Php '.$row['prm_discount'];
            $sub_array[] = '<button type="button" name="promo" id="'.$row["prm_id"].'" class="btn btn-success btn-xs selectpromo">Select</button>';
            $data[] = $sub_array;
        break;
        case 'membership':
            $sub_array = array();
            $sub_array[] = '<b>'.$row["prm_code"].'</b><br><span>'.$row['prm_desc'].'</span>';
            $sub_array[] = 'Php '.$row['prm_discount'];
            $sub_array[] = '<button type="button" name="promo" id="'.$row["prm_id"].'" class="btn btn-success btn-xs selectpromo">Select</button>';
            $data[] = $sub_array;
        break;
    }
}

$output = array(
	"draw"				=>	intval($_POST["draw"]),
	"data"				=>	$data
);
echo json_encode($output);