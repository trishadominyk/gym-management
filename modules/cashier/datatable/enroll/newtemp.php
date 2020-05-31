<?php
session_start();

include('../db.php');
include("function.php");

if(isset($_POST["cust_id"])){
    $_SESSION['temp_cust'] = $_POST['cust_id'];
    
    //empty table just in case
    if(check_table()){
        empty_temptrans();
    }
    
    echo 'Begin Transaction';
}