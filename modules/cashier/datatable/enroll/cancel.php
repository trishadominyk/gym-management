<?php
session_start();

include('../db.php');
include("function.php");

$result = delete_temptrans();

if(!empty($result)){
    echo 'Transaction cancelled.';
}
else
    echo 'Unsuccessful';