<?php
include('../db.php');
include('function.php');

$output = array();
$id = $_POST['id'];

if($id != 'membership'){
    $query = "SELECT * FROM tbl_class C INNER JOIN tbl_classcategory CC ON C.clc_id = CC.clc_id WHERE C.clc_id = $id ORDER BY C.cls_name";

    $statement = $connection->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();

    $output['tbl'] = '';
    $output['tbl'] .= '<table class="table table-striped table-border"><thead><tr><td>Class</td><td>Rate</td></tr></thead><tbody>';

    foreach($result as $row)
    {
        $output['title'] = $row['clc_name'];
        $output['tbl'] .= '<tr><td><b>'.$row['cls_name'].'</b></td><td>Php '.number_format($row['cls_rate'],2).'</td></tr>';
    }

    $output['tbl'] .= '</tbody></table><span>*rates are subject to change</span><br><span>*class sessions are valid for only a period of 1 month (30 days)</span>';
}
else{
    $query = "SELECT * FROM tbl_membershiptype";

    $statement = $connection->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();

    $output['title'] = 'MEMBERSHIPS';
    $output['tbl'] = '';
    $output['tbl'] .= '<table class="table table-striped table-border"><thead><tr><td>Membership</td><td>Rate</td></tr></thead><tbody>';

    foreach($result as $row)
    {
        $output['tbl'] .= '<tr><td><b>'.$row['met_name'].'</b></td><td>Php '.number_format($row['met_rate'],2).'</td></tr>';
    }

    $output['tbl'] .= '</tbody></table><span>*rates are subject to change</span>';
}
echo json_encode($output);
?>