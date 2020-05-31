<?php
function retrieve_categories(){
    include('../db.php');
    
    $statement = $connection->prepare(
    "SELECT * FROM tbl_classcategory"
    );
    $statement->execute();
    $result = $statement->fetchAll();
    
    return $result;
}

function retrieve_classes($id){
    include('../db.php');
    
    $statement = $connection->prepare(
    "SELECT C.cls_id, C.cls_name, C.cls_rate, C.cls_desc 
    FROM tbl_classcategory T 
    INNER JOIN tbl_class C ON T.clc_id = C.clc_id 
    WHERE C.clc_id = $id 
    ORDER BY C.cls_rate DESC"
    );
    $statement->execute();
    $result = $statement->fetchAll();
    
    return $result;
}

function check_class($id){
    include('../db.php');
    
    $statement = $connection->prepare(
        "SELECT T.clc_name 
        FROM tbl_transtemp R
        INNER JOIN tbl_class C ON R.cls_id = C.cls_id
        INNER JOIN tbl_classcategory T ON C.clc_id = T.clc_id 
        WHERE T.clc_id = $id"
    );
    $statement->execute();
    $result = $statement->fetchAll();
    
    return $statement->rowCount();
}

function check_membershiptype(){
    include('../db.php');
    
    $statement = $connection->prepare(
        "SELECT * FROM tbl_transtemp WHERE met_id <> 0"
    );
    $statement->execute();
    $result = $statement->fetchAll();
    
    return $statement->rowCount();
}

function get_classcategory($id){
    include('../db.php');

	$statement = $connection->prepare(
        "SELECT CC.clc_id FROM tbl_classcategory CC INNER JOIN tbl_class C ON CC.clc_id = C.clc_id WHERE C.cls_id = $id"
    );
	$statement->execute();
    $f = $statement->fetch();
    
    return $f['clc_id'];
}

function check_enrolled($class, $cust){
    include('../db.php');
    $date = date('Y-m-d');
    
    $category = get_classcategory($class);
    
    $statement = $connection->prepare(
        "SELECT T.cust_id FROM tbl_record R
        INNER JOIN tbl_transaction T ON R.trns_id = T.trns_id
        INNER JOIN tbl_transitems I ON T.trns_id = I.trns_id
        INNER JOIN tbl_class C ON I.cls_id = C.cls_id
        INNER JOIN tbl_classcategory A ON C.clc_id = A.clc_id
        WHERE A.clc_id = $category AND T.cust_id = $cust AND R.rec_session_remain > 0 AND R.rec_expire >= '$date'"
    );
    $statement->execute();
    $result = $statement->fetchAll();
    
    return $statement->rowCount();
}

function check_membership($id){
    include('../db.php');
    
    $statement = $connection->prepare(
    "SELECT C.cust_id FROM tbl_customer C
    INNER JOIN tbl_membership M ON C.mem_id = M.mem_id
    INNER JOIN tbl_membershiptype T ON M.met_id = T.met_id
    WHERE C.cust_id = $id AND M.mem_status = 'ACTIVE'"
    );
    $statement->execute();
    $result = $statement->fetchAll();
    
    return $statement->rowCount();
}

function check_pendingmembership($id){
    include('../db.php');
    
    $statement = $connection->prepare(
        "SELECT C.cust_id FROM tbl_customer C 
        INNER JOIN tbl_transaction T ON C.cust_id = T.cust_id
        INNER JOIN tbl_transitems I ON T.trns_id = I.trns_id
        INNER JOIN tbl_membershiptype M ON M.met_id = I.met_id WHERE C.cust_id = $id AND I.trni_remarks = 'PENDING'"
    );
    $statement->execute();
    $result = $statement->fetchAll();
    
    return $statement->rowCount();
}

function retrieve_memberships(){
    include('../db.php');
    
    $statement = $connection->prepare(
        "SELECT * FROM tbl_membershiptype"
    );
    $statement->execute();
    $result = $statement->fetchAll();
    
    return $result;
}

function retrieve_listdata(){
    include('../db.php');
    
    $statement = $connection->prepare(
        "SELECT T.trtp_id, C.cls_id, C.cls_name, C.cls_rate, M.met_id, M.met_name, M.met_rate, P.prm_id, P.prm_code FROM tbl_transtemp T
        LEFT OUTER JOIN tbl_class C ON T.cls_id = C.cls_id
        LEFT OUTER JOIN tbl_membershiptype M ON T.met_id = M.met_id
        LEFT OUTER JOIN tbl_promo P ON T.prm_id = P.prm_id"
    );
    $statement->execute();
    $result = $statement->fetchAll();
    
    return $result;
}

function count_transaction(){
    include('../db.php');
    
    $date = date('Y-m-d');

	$statement = $connection->prepare("SELECT * FROM tbl_transaction WHERE trns_date=''$date");
	$statement->execute();
    $count = $statement->rowCount();
    
    return $count+1;
}

function get_customer($id){
    include('../db.php');

	$statement = $connection->prepare(
        "SELECT * FROM tbl_customer WHERE cust_id = $id"
    );
	$statement->execute();
    $f = $statement->fetch();
    $value =  $f["cust_firstname"].' '.$f["cust_lastname"];
    
    return $value;
}

function delete_temptrans(){
    include('../db.php');
    
    $statement = $connection->prepare("DELETE FROM tbl_transtemp");
    
    unset($_SESSION['temp_cust']);
    
    return $statement->execute();
}

function empty_temptrans(){
    include('../db.php');
    
    $statement = $connection->prepare("DELETE FROM tbl_transtemp");
    
    return $statement->execute();
}

function get_total_all_records(){
	include('../db.php');
	$statement = $connection->prepare("SELECT * FROM tbl_customer");
	$statement->execute();
	$result = $statement->fetchAll();
    
	return $statement->rowCount();
}

function generate_code(){
    include('../db.php');
    
    $date = date('Y-m-d');

	$statement = $connection->prepare("SELECT * FROM tbl_transaction WHERE trns_date LIKE '$date %'");
	$statement->execute();
    $count = $statement->rowCount();
    $count++;
    
    $datecode = date('mdy');
    $code = $datecode.'-'.$count;
    
    return $code;
}

function retrieve_transid($id){
    include('../db.php');
    
    $statement = $connection->prepare(
        "SELECT trns_id FROM tbl_transaction WHERE cust_id = $id ORDER BY trns_date DESC LIMIT 1"
    );
    $statement->execute();
    $row = $statement->fetch();
        
    return $row['trns_id'];
}

function get_total(){
    include('../db.php');

	$statement = $connection->prepare(
        "SELECT SUM(C.cls_rate) AS cls_total, SUM(M.met_rate) AS met_total 
        FROM tbl_transtemp T
        LEFT OUTER JOIN tbl_class C ON T.cls_id = C.cls_id
        LEFT OUTER JOIN tbl_membershiptype M ON T.met_id = M.met_id"
    );
	$statement->execute();
    $row = $statement->fetch();
    
    $cls_total = ($row['cls_total'] != null) ? $row['cls_total'] : 0;
    $met_total = ($row['met_total'] != null) ? $row['met_total'] : 0;
    
    //get_discount
    $discount = get_total_discount();
    
    $total =  ($cls_total + $met_total) - $discount;
    
    return $total;
}

function get_total_discount(){
    include('../db.php');

	$statement = $connection->prepare(
        "SELECT SUM(P.prm_discount) AS discount_total
        FROM tbl_transtemp T
        INNER JOIN tbl_promo P ON T.prm_id = P.prm_id"
    );
	$statement->execute();
    $row = $statement->fetch();
    
    return $row['discount_total'];
}

function get_itemamount($id, $type, $promo){
    include('../db.php');
    
    if($type == 'class'){
        $statement = $connection->prepare(
            "SELECT * FROM tbl_class WHERE cls_id = $id"
        );
        $statement->execute();
        $f = $statement->fetch();
        
        $amount =  $f["cls_rate"];
        
        if($promo != 0){
            $statement = $connection->prepare(
                "SELECT * FROM tbl_promo WHERE prm_id = $promo"
            );
            $statement->execute();
            $f = $statement->fetch();
            
            $amount = $amount - $f["prm_discount"];
        }
        
        return $amount;
    }
    else if($type == 'membership'){
        $statement = $connection->prepare(
            "SELECT * FROM tbl_membershiptype WHERE met_id = $id"
        );
        $statement->execute();
        $f = $statement->fetch();
        
        $amount =  $f["met_rate"];
        
        if($promo != 0){
            $statement = $connection->prepare(
                "SELECT * FROM tbl_promo WHERE prm_id = $promo"
            );
            $statement->execute();
            $f = $statement->fetch();
            
            $amount = $amount - $f["prm_discount"];
        }
        
        return $amount;
    }
}

function get_membershipid($id){
    include('../db.php');
    
    $statement = $connection->prepare(
        "SELECT * FROM tbl_membership WHERE cust_id = :cust_id ORDER BY mem_date_added DESC LIMIT 1"
    );
    $statement->execute(
        array(
            ':cust_id'  =>  $id
        )
    );
    $row = $statement->fetch();
    
    return $row['mem_id'];
}

function generate_expiredate($id){
    include('../db.php');
    
    $statement = $connection->prepare(
        "SELECT * FROM tbl_membershiptype WHERE met_id = :met_id"
    );
    $statement->execute(
        array(
            ':met_id'  =>  $id
        )
    );
    $row = $statement->fetch();
    
    //solve for expiry date
    $date = date("Y-m-d");
    $expire = date("Y-m-d", strtotime($date."+ ".$row['met_duration']." days"));
    
    return $expire;
}

/*function generate_expiredate_rec(){
    include('../db.php');
    
    $statement = $connection->prepare(
        "SELECT * FROM tbl_class WHERE cls_id = :cls_id"
    );
    $statement->execute(
        array(
            ':cls_id'  =>  $id
        )
    );
    $row = $statement->fetch();
    
    //solve for expiry date
    $date = date("Y-m-d");
    $expire = date("Y-m-d", strtotime($date."+ ".$row['cls_duration']." days"));
    
    return $expire;
}*/

function get_sessions($id){
    include('../db.php');
    
    $statement = $connection->prepare(
        "SELECT * FROM tbl_class WHERE cls_id = :cls_id"
    );
    $statement->execute(
        array(
            ':cls_id'  =>  $id
        )
    );
    $row = $statement->fetch();
    
    return $row['cls_sessions'];
}

function update_membership($met, $cust){
    include('../db.php');
    
    $statement = $connection->prepare(
        "INSERT INTO tbl_membership(mem_date_added, mem_date_expire, met_id, mem_status, cust_id)
        VALUES(:mem_date_added, :mem_date_expire, :met_id, :mem_status, :cust_id)"
    );
    $result = $statement->execute(
        array(
            ':mem_date_added'   =>  date('Y-m-d'),
            ':mem_date_expire'  =>  generate_expiredate($met),
            ':met_id'   =>  $met,
            ':mem_status'   =>  'ACTIVE',
            ':cust_id'  =>  $cust
        )
    );
    
    if(!empty($result)){
        //get membership id
        $mem_id = get_membershipid($cust);
        
        if(isset($mem_id)){
        //update tbl_customer
            $statement = $connection->prepare(
                "UPDATE tbl_customer SET mem_id = $mem_id WHERE cust_id = $cust"
            );
            $result = $statement->execute();
            
            if(!empty($result))
                echo 'Succesfully availed a membership. Customer record has been updated. \n';
        }
        else
            echo 'Error.';
    }
    else
        echo 'Error. Cannot update membership.';
}

function insert_record($trans,$class){
    include('../db.php');
    
    $date = date('Y-m-d');
    
    $statement = $connection->prepare(
        "INSERT INTO tbl_record(trns_id, rec_session_remain, rec_enroll, rec_expire)
        VALUES(:trns_id, :rec_session_remain, :rec_enroll, :rec_expire)"
    );
    $result = $statement->execute(
        array(
            ':trns_id'   =>  $trans,
            ':rec_session_remain'  =>  get_sessions($class),
            ':rec_enroll'   =>  date('Y-m-d'),
            ':rec_expire'   =>  date("Y-m-d", strtotime($date."+ 30 days"))
        )
    );

    /*if(!empty($result))
        echo 'Class Purchased. ';
    else
        echo 'Unsuccessful Record Update. ';*/
}

function check_promos($id,$type){
    include('../../../../library/db.php');
    
    switch($type){
        case 'class':
            $statement = $connection->prepare(
                "SELECT * FROM tbl_promoclass WHERE cls_id = :cls_id"
            );
            $result = $statement->execute(
                array(
                    ':cls_id'   =>  $id
                )
            );
            $check = $statement->rowCount();

            if($check > 0)
                return true;
            else
                return false;
        break;
        case 'membership':
            $statement = $connection->prepare(
                "SELECT * FROM tbl_promomembershiptype WHERE met_id = :met_id"
            );
            $result = $statement->execute(
                array(
                    ':met_id'   =>  $id
                )
            );
            $check = $statement->rowCount();

            if($check > 0)
                return true;
            else
                return false;
        break;
    }
}

function check_promoavailed($id){
    include('../../../../library/db.php');
    
    $statement = $connection->prepare(
        "SELECT * FROM tbl_transtemp WHERE trtp_id = :trtp_id AND prm_id <> 0"
    );
    $result = $statement->execute(
        array(
            ':trtp_id'   =>  $id
        )
    );
    $check = $statement->rowCount();

    if($check == 0)
        return true;
    else
        return false;
}

function check_table(){
    include('../../../../library/db.php');
    
    $statement = $connection->prepare(
        "SELECT * FROM tbl_transtemp"
    );
    $result = $statement->execute();

    if($result)
        return true;
    else
        return false;
}

function retrieve_promos($id,$type){
    include('../../../../library/db.php');
    
    switch($type){
        case 'class':
            $statement = $connection->prepare(
                "SELECT * FROM tbl_promoclass PC
                INNER JOIN tbl_promo P ON PC.prm_id = P.prm_id
                WHERE PC.cls_id = :cls_id"
            );
            $result = $statement->execute(
                array(
                    ':cls_id'   =>  $id
                )
            );
            
            return $statement->fetchAll();
        break;
        case 'membership':
            $statement = $connection->prepare(
                "SELECT * FROM tbl_promomembershiptype PM 
                INNER JOIN tbl_promo P ON PM.prm_id = P.prm_id
                WHERE PM.met_id = :met_id"
            );
            $result = $statement->execute(
                array(
                    ':met_id'   =>  $id
                )
            );
            
            return $statement->fetchAll();
        break;
    }
}

function retrieve_promodetail($id){
    include('../../../../library/db.php');
    
    $statement = $connection->prepare(
        "SELECT P.prm_id, P.prm_code, P.prm_discount FROM tbl_transtemp T
        INNER JOIN tbl_promo P ON T.prm_id = P.prm_id
        WHERE T.trtp_id = :trtp_id"
    );
    $result = $statement->execute(
        array(
            ':trtp_id'   =>  $id
        )
    );
    
    return $statement->fetchAll();
}