<?php
class Promo{
	public $db;
	
	public function __construct(){
		$this->db = new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
		if(mysqli_connect_errno()){
			echo "Database connection error.";
			exit;
		}
	}

	public function fnGetPromos(){
		$sql="SELECT * FROM tbl_promo ORDER BY prm_id";
		$result = mysqli_query($this->db,$sql);
		while($row = mysqli_fetch_assoc($result)){
			$list[] = $row;
		}
		return $list;
	}
	public function fnNewPromo($prmcode, $prmdesc, $prmdatestart, $prmdateend, $prmdiscount){
		$sql ="INSERT INTO tbl_promo(prm_code, prm_desc, prm_date_start, prm_date_end, prm_discount) VALUES('$prmcode', '$prmdesc','$prmdatestart', '$prmdateend', '$prmdiscount')";

		$result = mysqli_query($this->db,$sql) or die(mysqli_error() . "Cannot Insert Data!");
		return $result;
	}
	public function fnUpdatePromo($prmid, $prmcode, $prmdesc, $prmdiscount, $prmdatestart, $prmdateend){
		$sql ="UPDATE tbl_promo SET prm_code = '$prmcode' , prm_desc = '$prmdesc', prm_discount='$prmdiscount', prm_date_start = '$prmdatestart', prm_date_end = '$prmdateend' WHERE prm_id='$prmid'";

		$result = mysqli_query($this->db,$sql) or die(mysqli_error() . "Cannot Update Data!");
		return $result;
	}
}