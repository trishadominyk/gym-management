<?php
class Membership{
	public $db;
	
	public function __construct(){
		$this->db = new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
		if(mysqli_connect_errno()){
			echo "Database connection error.";
			exit;
		}
	}

	public function fngetmembershiptype(){
		$sql="SELECT * FROM tbl_membershiptype ORDER BY met_id";
		$result = mysqli_query($this->db,$sql);
		while($row = mysqli_fetch_assoc($result)){
			$list[] = $row;
		}
		return $list;
	}


	public function fnNewMembershipType($metname, $metrate, $metduration){
		$sql ="INSERT INTO tbl_membershiptype(met_name, met_rate, met_duration) VALUES('$metname', '$metrate','$metduration')";

		$result = mysqli_query($this->db,$sql) or die(mysqli_error() . "Cannot Insert Data!");
		return $result;
	}


	public function fnUpdateMembershipType($metid, $metname, $metrate, $metduration){
		$sql ="UPDATE tbl_membershiptype SET met_name = '$metname' , met_rate = '$metrate', met_duration='$metduration' WHERE met_id='$metid'";

		$result = mysqli_query($this->db,$sql) or die(mysqli_error() . "Cannot Update Data!");
		return $result;
	}
}