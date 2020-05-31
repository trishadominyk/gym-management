<?php
include('../db.php');
include('function.php');

$output = array();

if(isset($_POST['cls_id']) && $_POST['cls_id'] != ''){
    $id = $_POST['cls_id'];
    $date = date('Y-m-d');
    
    $query = '';
    $query .= "SELECT R.rec_id, U.cust_firstname, U.cust_lastname, U.cust_id, R.rec_enroll, R.rec_expire, R.rec_session_remain, M.mem_status
                FROM (tbl_record R
                INNER JOIN tbl_transaction T ON R.trns_id = T.trns_id
                INNER JOIN tbl_transitems I ON T.trns_id = I.trns_id
                INNER JOIN tbl_class C ON I.cls_id = C.cls_id)
                INNER JOIN tbl_customer U ON T.cust_id = U.cust_id
                LEFT OUTER JOIN tbl_membership M ON U.mem_id = M.mem_id
                WHERE C.cls_id = $id AND R.rec_expire > '$date' ";

    if(isset($_POST["search"]["value"]))
        $query .= 'AND (U.cust_firstname LIKE "%'.$_POST["search"]["value"].'%" OR U.cust_lastname LIKE "%'.$_POST["search"]["value"].'%") ';

    if(isset($_POST["order"]))
        $query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
    else
        $query .= 'ORDER BY U.cust_lastname ASC ';

    if($_POST["length"] != -1)
        $query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];

    $statement = $connection->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $data = array();
    $filtered_rows = $statement->rowCount();

    foreach($result as $row){
        $name = $row["cust_firstname"]." ".$row["cust_lastname"];

        $membership = $row["mem_status"];
        if($membership == "EXPIRED")
            $memstat = '<span class="btn-gray btn-xs" style="font-size: x-small;">'.$membership.'</span>';
        else if($membership == "ACTIVE")
            $memstat = '<span class="btn-green btn-xs" style="font-size: x-small;">'.$membership.'</span>';
        else
            $memstat = '<span class="btn-red btn-xs" style="font-size: x-small;">NONE</span>';

        /*$record = '<button type="button" name="transaction" id="'.$row["cust_id"].'" class="btn btn-gray btn-xs btn-fullcircle profile">'.file_get_contents('../../../../svg/ic_profile.svg').'</button>';*/
        
        $valid = date('M d, Y', strtotime($row['rec_enroll'])).' - '.date('M d, Y', strtotime($row['rec_expire']));
        
        $profile = '<button type="button" name="select" id="'.$row["cust_id"].'" data-toggle="tooltip" title="View client profile" class="btn btn-info btn-xs btn-fullcircle profile">'.file_get_contents('../../../../svg/ic_profile.svg').'</button>';

        $sub_array = array();
        $sub_array[] = $profile;
        $sub_array[] = $name;
        $sub_array[] = $memstat;
        $sub_array[] = $valid;
        $sub_array[] = $row['rec_session_remain'];
        $sub_array[] = date('M d, Y (l)', strtotime(check_lastlog($row['rec_id'])));
        
        $data[] = $sub_array;
    }

    $output = array(
        "draw"				=>	intval($_POST["draw"]),
        "recordsTotal"		=> 	$filtered_rows,
        "recordsFiltered"	=>	get_total_all_records($query),
        "data"				=>	$data
    );
}
echo json_encode($output);