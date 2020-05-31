<?php
include('../db.php');

if(!empty($_POST['trtp_id']) && !empty($_POST['prm_id'])){
    $statement = $connection->prepare(
        "UPDATE tbl_transtemp SET prm_id = :prm_id WHERE trtp_id = :trtp_id"
    );
    $result = $statement->execute(
        array(
            ':prm_id'	=>	$_POST["prm_id"],
            ':trtp_id'	=>	$_POST["trtp_id"]
        )
    );

    if(!empty($result))
        echo 'Promo availed.';
    else
        echo 'Unsuccessful';
}