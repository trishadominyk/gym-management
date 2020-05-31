<?php
class Equipment{
	public $db;
	
	public function __construct(){
		$this->db = new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
		if(mysqli_connect_errno()){
			echo "Database connection error.";
			exit;
		}
	}

	public function fnGetEquipment(){
		$sql = "SELECT eqp_name, eqp_serial, eqp_date_added, eqp_date_update, eqp_qty, cat_name FROM tbl_equipment, tbl_category WHERE tbl_equipment.cat_id = tbl_category.cat_id";
		$result = mysqli_query($this->db,$sql);
		while($row = mysqli_fetch_assoc($result)){
			$list[] = $row;
		}
		return $list;
	}


	public function fnNewEquipment($eqpname, $eqpqty, $catid){
		$sql ="INSERT INTO tbl_equipment(eqp_name, eqp_qty, cat_id, eqp_date_added) VALUES('$eqpname', '$eqpqty','$catid', CURDATE())";

		$result = mysqli_query($this->db,$sql) or die(mysqli_error() . "Cannot Insert Data!");
		return $result;
	}
}