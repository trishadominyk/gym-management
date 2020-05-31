<?php
include('../db.php');
include('function.php');

$output = array();
$data = array();

$date = date('Y-m-d');
$filtered_rows = 0;

if(isset($_POST['stf_id'])){
    $classlist = get_classlist($_POST['stf_id']);
    foreach($classlist as $value){
        $query = '';
        $query .= "
                    SELECT L.log_id, L.wrk_id, L.log_timein, U.cust_id, U.cust_firstname, U.cust_lastname, C.cls_name
                    FROM tbl_logbook L
                    INNER JOIN tbl_record R ON L.rec_id = R.rec_id
                    INNER JOIN tbl_transaction T ON R.trns_id = T.trns_id
                    INNER JOIN tbl_transitems I ON T.trns_id = I.trns_id
                    INNER JOIN tbl_class C ON I.cls_id = C.cls_id
                    INNER JOIN tbl_classcategory CC ON C.clc_id = CC.clc_id
                    INNER JOIN tbl_customer U ON T.cust_id = U.cust_id
                    WHERE CC.clc_id = :clc_id AND (L.stf_id = :stf_id OR L.stf_id = 0) AND L.log_date = '$date'
                    ORDER BY L.log_timein DESC ";

        if($_POST["length"] != -1)
            $query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];

        $statement = $connection->prepare($query);
        $statement->execute(
            array(
                ':stf_id'   =>  $_POST['stf_id'],
                ':clc_id'   =>  $value['clc_id']
            )
        );
        $result = $statement->fetchAll();
        $filtered_rows .= $statement->rowCount();

        foreach($result as $row){
            $name = $row["cust_lastname"].", ".$row["cust_firstname"];
            
            $profile = '<button type="button" name="select" id="'.$row["cust_id"].'" data-toggle="tooltip" title="View client profile" class="btn btn-info btn-xs btn-fullcircle profile">'.file_get_contents('../../../../svg/ic_profile.svg').'</button>';
            
            $action = ($row['wrk_id'] > 0) ? '<button type="button" name="select" id="'.$row["log_id"].'" data-toggle="tooltip" title="View workout" class="btn btn-primary btn-xs btn-fullcircle workout">'.file_get_contents('../../../../svg/ic_list.svg').'</button>' : '<button type="button" name="select" id="'.$row["log_id"].'" data-toggle="tooltip" title="Add workout" class="btn btn-primary btn-xs btn-fullcircle add">'.file_get_contents('../../../../svg/ic_add.svg').'</button>';
            
            switch(get_status($row["log_id"])){
                case 'ONGOING':
                    $status = '<span class="btn-success btn-xs">ONGOING</span>';
                break;
                case 'FINISHED':
                    $status = '<span class="btn-danger btn-xs">FINISHED</span>';
                break;
                default:
                    $status = '<span class="btn-gray btn-xs">NO ROUTINE</span>';
                break;
            }
                
            $sub_array = array();
            $sub_array[] = date("h:i A", strtotime($row["log_timein"]));
            $sub_array[] = $name;
            $sub_array[] = $row["cls_name"];
            $sub_array[] = $status;
            $sub_array[] = $profile.'&nbsp;'.$action;
            
            $data[] = $sub_array;
        }
    }
    
    
    $output = array(
        "draw"				=>	intval($_POST["draw"]),
        "recordsTotal"		=> 	$filtered_rows,
        "recordsFiltered"	=>	get_total_all_records($_POST['stf_id']),
        "data"				=>	$data
    );
    echo json_encode($output);
}