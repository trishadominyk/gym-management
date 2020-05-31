<?php
include('../db.php');
include('function.php');

$date = date('Y-m-d');

if(!empty($_POST['cust_id'])){
    $id = $_POST['cust_id'];
    
    if(!empty($_REQUEST)){
        // storing  request (ie, get/post) global array to a variable 
        $requestData = $_REQUEST;

        $columns = array( 
        // datatable column index  => database column name
            0 => 'trns_date'
        );

        $sql = "SELECT T.trns_id, T.trns_date, T.trns_code, T.trns_total FROM tbl_transaction T";

       if(!empty($requestData['columns'][0]['search']['value'])){
            $sql.=" WHERE YEAR(T.trns_date) = ".$requestData['columns'][0]['search']['value']." AND T.cust_id = $id";
        }
        
        else
            $sql.=" WHERE YEAR(T.trns_date) = ".date('Y')." AND T.cust_id = $id";
        
        
            $sql .= ' ORDER BY T.trns_date ASC ';

        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        $filtered_rows = $statement->rowCount();

        $data = array();
        foreach($result as $row){
            $sub_array = array();

            $sub_array[] = date("D M d, Y h:i A", strtotime($row["trns_date"]));
            $sub_array[] = $row["trns_code"];
            $sub_array[] = get_items($row["trns_id"]);
            $sub_array[] = 'Php '.number_format($row["trns_total"],2);

            $data[] = $sub_array;
        }

        $output = array(
            "draw"				=>	intval($_POST["draw"]),
            "recordsTotal"		=> 	$filtered_rows,
            "recordsFiltered"	=>	get_total_transaction_records($sql),
            "data"				=>	$data
        );

        echo json_encode($output);  // send data as json format
    }
}