<?php
include('../db.php');

if(isset($_POST['id']) && isset($_POST['type'])){
    if($_POST['type'] == 'class'){
        $statement = $connection->prepare(
            "DELETE FROM tbl_transtemp WHERE cls_id = :cls_id"
        );
        $result = $statement->execute(
            array(
                ':cls_id'	=>	$_POST["id"]
            )
        );
    }
    else if($_POST['type'] == 'membership'){
        $statement = $connection->prepare(
            "DELETE FROM tbl_transtemp WHERE met_id = :met_id"
        );
        $result = $statement->execute(
            array(
                ':met_id'	=>	$_POST["id"]
            )
        );
    }
    else if($_POST['type'] == 'promo'){
        $statement = $connection->prepare(
            "UPDATE tbl_transtemp SET prm_id = 0 WHERE trtp_id = :trtp_id"
        );
        $result = $statement->execute(
            array(
                ':trtp_id'	=>	$_POST["id"]
            )
        );
    }

    if(!empty($result))
        echo 'Item removed.';
    else
        echo 'Unsuccessful';
}