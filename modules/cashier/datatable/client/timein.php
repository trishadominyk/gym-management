<?php
include('../db.php');
include("function.php");

if(isset($_POST["cust_id"]) && isset($_POST["rec_id"]) && isset($_POST["stf_id"])){
    $code = generate_logcode();
    $date = date("Y-m-d");
    $time = date("H:i:s");
    
    $statement = $connection->prepare(
		"INSERT INTO tbl_logbook(log_code, log_date, log_timein, cust_id, rec_id, stf_id) VALUES('$code', '$date', '$time', :cust_id, :rec_id, :stf_id)"
	);
	$result = $statement->execute(
		array(
			':cust_id'	=>	$_POST["cust_id"],
			':rec_id'	=>	$_POST["rec_id"],
			':stf_id'	=>	$_POST["stf_id"]
		)
	);
	
	if(!empty($result))
	{
        //update record function here ples
        $update = update_record($_POST["rec_id"]);
        if($update)
            echo 'Client successfully timed in.';
	}
}
else if(isset($_POST["stf_id"])){
    $date = date("Y-m-d");
    $time = date("H:i:s");
    
    $statement = $connection->prepare(
		"INSERT INTO tbl_stafflogbook(stf_log_date, stf_log_in, stf_id) VALUES('$date', '$time', :stf_id)"
	);
	$result = $statement->execute(
		array(
			':stf_id'	=>	$_POST["stf_id"]
		)
	);
	
	if(!empty($result))
	{
        echo 'Staff successfully timed in.';
	}
}