<?php
include('../db.php');

$output = array();

if(isset($_POST['id'])){
    $id = $_POST['id'];
    
    $month = date('m');
    $year = date('Y');
        
    $statement1 = $connection->prepare(
        "SELECT COUNT(trns_id) as total_month FROM tbl_transaction WHERE cust_id = $id AND MONTH(trns_date) = $month AND YEAR(trns_date) = $year"
    );
    
    $statement1->execute();
    $result1 = $statement1->fetchAll();
    
    if(!empty($result1)){
        foreach($result1 as $row){
            $trns_total = $row['total_month'];
        }
        
        $output['trns_total'] = $trns_total;
    }
    else
        $output['trns_total'] = '';
    
    
    $statement2 = $connection->prepare(
        "SELECT COUNT(trns_id) as total_all FROM tbl_transaction WHERE cust_id = $id"
    );
    
    $statement2->execute();
    $result2 = $statement2->fetchAll();
    
    if($result1){
        foreach($result2 as $row){
            $trns_all = $row['total_all'];
        }
        
        $output['trns_all'] = $trns_all;
    }
    else
        $output['trns_all'] = '';
    
    $statement3 = $connection->prepare(
        "SELECT * FROM tbl_bmi WHERE cust_id = $id ORDER BY bmi_date DESC LIMIT 1"
    );
    
    $statement3->execute();
    $result3 = $statement3->fetchAll();

    if(!empty($result3)){
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
        }
        
        $output['bmi_current'] = round($result, 2);
        $output['bmi_info'] = $info;
    }
    else{
        $output['bmi_current'] = '';
        $output['bmi_info'] = '';
    }
    
    $statement4 = $connection->prepare(
        "SELECT * FROM tbl_customer WHERE cust_id = $id"
    );
    
    $statement4->execute();
    $result4 = $statement4->fetch();
    
    $output['cust_name'] = $result4['cust_firstname'].' '.$result4['cust_lastname'];
    
    $output['cust_email'] = $result4['cust_email'];
    $output['cust_contact'] = $result4['cust_contact'];
    $output['cust_emergency'] = $result4['cust_emergency'];
    $output['cust_birthday'] = date('F d, Y', strtotime($result4['cust_birthday']));
}

echo json_encode($output);