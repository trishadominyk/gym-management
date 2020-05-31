<?php
include('../../../../library/db.php');

$id = $_POST['id'];

$statement3 = $connection->prepare(        
    "SELECT * FROM tbl_bmi WHERE cust_id = $id"
);

$statement3->execute();
$result3 = $statement3->fetchAll();

if($result3){
    $output = array();
    foreach($result3 as $row){

        $height = $row['bmi_height'];
        $weight = $row['bmi_weight'];

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

        array_push($output, array("bmi_date"=>date('M d, Y', strtotime($row['bmi_date'])), "bmi_result"=>round($result,2), "bmi_info"=>$info));
    }

    echo json_encode($output);
}