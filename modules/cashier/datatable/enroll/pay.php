<?php
session_start();

include('../db.php');
include('function.php');

if(isset($_POST['cust_id']) && isset($_POST['stf_id'])){
    $output['message'] = '';
    
    $statement = $connection->prepare(
        "INSERT INTO tbl_transaction(cust_id, trns_code, trns_date, trns_total, stf_id)
        VALUES(:cust_id, :trns_code, :trns_date, :trns_total, :stf_id)"
    );
    $result = $statement->execute(
        array(
            ':cust_id'	=>	$_POST["cust_id"],
            ':trns_code'	=>	generate_code(),
            ':trns_date'	=>	date('Y-m-d H:i:s'),
            ':trns_total'	=>	get_total(),
            ':stf_id'	=>	$_POST["stf_id"]
        )
    );
    
    //retrieve trns_id
    $trns_id = retrieve_transid($_POST['cust_id']);
    
    $output['trns_id'] = $trns_id;
    
    $list = retrieve_listdata();
    if($list){
        foreach($list as $row){
            $type = ($row['cls_id'] != null) ? 'class' : 'membership';
            $promo = ($row['prm_id'] != null) ? $row['prm_id'] : '0';
            
            if($type == 'class'){
                $statement = $connection->prepare(
                    "INSERT INTO tbl_transitems(trni_amount, trns_id, cls_id, trni_remarks, prm_id)
                    VALUES(:trni_amount, :trns_id, :cls_id, :trni_remarks, :prm_id)"
                );
                
                $result = $statement->execute(
                    array(
                        ':trni_amount'  => get_itemamount($row["cls_id"], $type, $row["prm_id"]),
                        ':trns_id'      =>	$trns_id,
                        ':cls_id'       =>	$row["cls_id"],
                        ':trni_remarks' =>  'PAID',
                        ':prm_id'       =>  $promo
                    )
                );

                if(!empty($result))
                    insert_record($trns_id, $row['cls_id']);
                else
                    $output['message'] .= 'Unsuccessful class purchase. ';
            }
            else if($type == 'membership'){
                $statement = $connection->prepare(
                    "INSERT INTO tbl_transitems(trni_amount, trns_id, met_id, trni_remarks, prm_id)
                    VALUES(:trni_amount, :trns_id, :met_id, :trni_remarks, :prm_id)"
                );
                $result = $statement->execute(
                    array(
                        ':trni_amount'  => get_itemamount($row["met_id"], $type, $row["prm_id"]),
                        ':trns_id'      => $trns_id,
                        ':met_id'       => $row["met_id"],
                        ':trni_remarks' => 'PAID',
                        ':prm_id'       => $promo
                    )
                );
                
                if(!empty($result)){
                    update_membership($row["met_id"], $_POST["cust_id"]);
                }
                else{
                    $output['message'] .= 'Unsuccessful membership purchase';
                }
            }
        }

        if(!empty($result)){
            delete_temptrans();
            
            $output['message'] .= 'Transaction Successful. Printing Receipt...';
        }
        else
            $output['message'] .= 'Unsuccessful';
    }
    else
        $output['message'] .= 'Please select an item.';
    
    echo json_encode($output);
}