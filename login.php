<?php
include 'library/config.php';
include 'classes/class.staff.php';
include 'classes/class.client.php';

$staff = new Staff();
$customer = new Client();

$output = array();

$operation = $_POST["operation"];
$email = $_POST["email"];
$password = md5($_POST["password"]);

switch($operation){
    case 'member':
        $login = $customer->customer_login($email, $password);
    break;
    case 'staff':
        $login = $staff->staff_login($email, $password);
    break;
}

if($login){
    $output['login'] = true;
    $output['level'] = strtolower($_SESSION['level']);
}
else
    array_push($output, array("login"=>false));

echo json_encode($output);