<?php
include('../db.php');

$statement = $connection->prepare("INSERT INTO tbl_bmi (bmi_height, bmi_weight, bmi_date, cust_id) VALUES (:bmi_height, :bmi_weight, CURDATE(), :cust_id)");

$result = $statement->execute(
    array(
        ':bmi_height'	=>	$_POST["bmi_height"],
        ':bmi_weight'	=>	$_POST["bmi_weight"],
		':cust_id'	    =>	$_POST["cust_id"]
	)
);

if(!empty($result)){
    $height = $_POST['bmi_height'];
    $weight = $_POST['bmi_weight'];
    
    $result = ($weight * 0.45) / pow(($height * 0.025), 2);
    
    if($result <= 18.5)
        $info = "Underweight";
    else if($result > 18.5 && $result <= 25)
        $info = "Normal";
    else if($result > 25 && $result <= 30)
        $info = "Overweight";
    else if($result > 30 && $result <= 35)
        $info = "Moderately Obese";
    else if($result > 35)
        $info = "Severely Obese";
 
    $output = array();
    $output['bmi_result'] = $result;
    $output['bmi_category'] = $info;
    
    echo json_encode($output);
}
else
    echo 'Error. Cannot insert';