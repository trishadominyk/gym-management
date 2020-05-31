<?php
include('../db.php');

$id = $_POST['id'];
$action = strtoupper($_POST['action']);

$statement = $connection->prepare("UPDATE tbl_customer set cust_status = '$action' WHERE cust_id = $id");

$result = $statement->execute();

$msg = 'Client '.strtolower($action);

if(!empty($result))
    echo $msg;
else
    echo 'Error. Cannot insert';