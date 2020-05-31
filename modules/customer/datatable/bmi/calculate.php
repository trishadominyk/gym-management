<?php 
include ('../db.php');

//if(isset($_POST['rec_id'])){  
    $id = $_POST['cust_id'];
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
    
    $output['bmi_info'] = "Your BMI is ";
    $output['bmi_result'] = round($result,2);
    $output['bmi_category'] = $info;
    $output['bmi_button'] = '<button class="btn btn-success new" id="'.$id.'" weight="'.$weight.'" height="'.$height.'"> Record</button>';
    
    echo json_encode($output);
//}
//else
  //  echo "Error retrieving.";
