<?php
include('../db.php');

$output = array();

if(isset($_POST['id'])){
    $id = $_POST['id'];
        
    $statement1 = $connection->prepare(
        "SELECT * FROM tbl_customer WHERE cust_id = $id"
    );
    
    $statement1->execute();
    $result1 = $statement1->fetchAll();
    
    $output['profile'] = '';
    
    if(!empty($result1)){
        foreach($result1 as $row){
            $output['profile'] .= '<span>Added: '.date('F d, Y', strtotime($row['cust_date_added'])).'</span><br><br>';
            
            $output['profile'] .= '<label>First Name</label><input type="text" name="firstName" id="firstName" value="'.$row['cust_firstname'].'" class="form-control"/><br>';
            
            $output['profile'] .= '<label>Last Name</label><input type="text" name="lastName" id="lastName" value="'.$row['cust_lastname'].'" class="form-control"/><br>';
            
            $output['profile'] .= '<label>Birthday</label><input type="date" name="birthday" id="birthday" value="'.date($row['cust_birthday']).'" class="form-control"/><br>';
            
            $output['profile'] .= '<label>Email</label><input type="text" name="email" id="email" value="'.$row['cust_email'].'" class="form-control"/><br>';
            
            $output['profile'] .= '<label>Contact</label><input type="text" name="contact" id="contact" value="'.$row['cust_contact'].'" placeholder="Optional" class="form-control"/><br>';
            
            $output['profile'] .= '<label>Emergency Contact</label><input type="text" name="emergency" id="emergency" value="'.$row['cust_emergency'].'" placeholder="Optional" class="form-control"/><br>';
            
            $output['profile'] .= '<input type="hidden" name="cust_id" id="edit_cust_id" value="'.$row['cust_id'].'" />';
            
            $output['profile'] .= '<div><input type="submit" name="action" id="action" class="form-control btn btn-success" value="Save" /><br></div><br>';
        }
    }
}

echo json_encode($output);