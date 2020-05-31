<?php 
session_start();

include ('../db.php');
include ('function.php');

$output = array();
    
if(isset($_SESSION['temp_cust'])){
    //output class list
    $output['trns_items'] = '';
    
    $category = retrieve_categories();
    foreach($category as $row){
        $output['trns_items'] .= '<div class="col-lg-10 col-lg-offset-1 text-center item-container"><h3>'.$row['clc_name'].'</h3>';
        
        //disable class category if one class is enrolled
        if(check_class($row['clc_id']) == 0){
            $class = retrieve_classes($row['clc_id']);
            foreach($class as $subrow){
                $output['trns_items'] .= '<div class="enroll-item col-lg-3 col-md-6 text-center enroll" id="'.$subrow['cls_id'].'" data-toggle="tooltip" title="'.$subrow['cls_desc'].'"><h4>'.$subrow['cls_name'].'</h4><p>Php '.number_format($subrow['cls_rate'],2).'</p>
                </div>';
            }
        }
        else{
            $class = retrieve_classes($row['clc_id']);
            foreach($class as $subrow){
                $output['trns_items'] .= '<div class="enroll-item col-lg-3 col-md-6 text-center enroll-selected" id="'.$subrow['cls_id'].'" data-toggle="tooltip" title="'.$subrow['cls_desc'].'"><h4>'.$subrow['cls_name'].'</h4><p>Php '.number_format($subrow['cls_rate'],2).'</p>
                </div>';
            }
        }
        
        $output['trns_items'] .= '</div>';
    }
    
    //output memberships
    $output['trns_items'] .= '<div class="col-lg-10 col-lg-offset-1 text-center item-container"><h3>Memberships</h3>';
    if(check_membershiptype() == 0){
        $membership = retrieve_memberships();
        foreach($membership as $row){
            $output['trns_items'] .= '<div class="enroll-item membership" id="'.$row['met_id'].'"><h4>'.$row['met_name'].'</h4><p>Php '.number_format($row['met_rate'],2).'</p></div>';
        }
    }
    else{
        $membership = retrieve_memberships();
        foreach($membership as $row){
            $output['trns_items'] .= '<div class="enroll-item enroll-selected" id="'.$row['met_id'].'"><h4>'.$row['met_name'].'</h4><p>Php '.number_format($row['met_rate'],2).'</p></div>';
        }
    }
    $output['trns_items'] .= '</div>';
    
    //output receipt-side
    $output['list_data'] = '<tr>';
    $listresult = retrieve_listdata();
    foreach($listresult as $row){
        $trtp_id = $row['trtp_id'];
        $id = ($row['cls_id'] != null) ? $row['cls_id'] : $row['met_id'];
        
        $name = ($row['cls_id'] != null) ? $row['cls_name'] : $row['met_name'];
        $amount = ($row['cls_id'] != null) ? $row['cls_rate'] : $row['met_rate'];
        $type = ($row['cls_id'] != null) ? 'class' : 'membership';
        
        $output['list_data'] .= '<td>'.$name.'</td>
        <td>Php '.number_format($amount,2).'</td>';
        
        //check promo
        if(check_promos($id,$type) && check_promoavailed($trtp_id))
            $promo = '<button type="button" data-toggle="modal" data-target="#promoView" class="btn btn-default btn-xs svg-middle promo" id="'.$trtp_id.'" action="'.$id.'" cls="'.$type.'">'.file_get_contents('../../../../svg/ic_discount_sm.svg').'</button> ';
        else
            $promo = '';
        
        $output['list_data'] .= '<td>'.$promo.'<button type="button" class="svg-middle close remove" id="'.$id.'" action="'.$type.'">&times</button> </td></tr>';
        
        //check promo
        if(!check_promoavailed($trtp_id)){
            $prmdetail = retrieve_promodetail($trtp_id);
            foreach($prmdetail as $promo){
                $output['list_data'] .= '<tr><td>'.$promo['prm_code'].'</td><td>- Php '.number_format($promo['prm_discount'],2).'</td><td><button type="button" class="svg-middle close remove" id="'.$trtp_id.'" action="promo">&times</button></tr>';
            }
        }
    }
    //output total
    $output['list_data'] .= '<tr><td>Total</td><td><b>Php '.number_format(get_total(),2).'</b></td></tr>';
    
    $output['trns_btn'] = '<button class="btn btn-lg btn-default cancel">Cancel</button><button class="btn btn-success pay btn-lg pay">Pay</button>';
    
    $output['trns_id'] = '<p style="float:left">Customer: '.get_customer($_SESSION['temp_cust']).'</p><span>'.date('l, M d, Y').'</span><h4>Transaction: 000'.count_transaction().'</h4>';
}
else{
    $output['trns_items'] = '<div><button class="btn btn-success btn-lg btn-main new">New Transaction</button></div>';   
    $output['list_data'] = '<td colspan="3"><p>Click new transaction to begin.</p></td>';
    $output['trns_btn'] = '';
    
    $output['trns_id'] = '<span>'.date('l, M d, Y').'</span><h4>Transaction: 000'.count_transaction().'</h4>';
}
    
echo json_encode($output);