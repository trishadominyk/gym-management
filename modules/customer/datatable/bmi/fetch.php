<?php
include('../../../../library/db.php');

$id = $_POST['id'];

$statement3 = $connection->prepare(        
    "SELECT * FROM tbl_bmi WHERE cust_id = $id"
);

$statement3->execute();
$result3 = $statement3->fetchAll();


$data = array();

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
        
        $sub_array = array();
        $sub_array[] = date('M d, Y', strtotime($row['bmi_date']));
        $sub_array[] = round($result,2);
        $sub_array[] = $info;
        $data[] = $sub_array;
    }

$output = array(
	"draw"				=>	intval($_POST["draw"]),
	"data"				=>	$data
);

echo json_encode($output);
