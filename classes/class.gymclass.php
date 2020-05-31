<?php
class GymClass{
	public $db;

	public function __construct(){
		$this->db = new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
		if(mysqli_connect_errno()){
			echo "Database connection error.";
			exit;
		}
	}


	public function fngetallclass(){
		$sql="SELECT * FROM tbl_class ORDER BY cls_name";
		$result = mysqli_query($this->db,$sql);
		while($row = mysqli_fetch_assoc($result)){
			$list[] = $row;
		}
		return $list;
	}

	public function fngetclassrows(){
		$sql = "SELECT  COUNT(*) FROM tbl_class";
		$result=mysqli_query($this->db,$sql);
		$row=mysqli_fetch_row($result);

		$totalrows = $row[0];

		return $totalrows;
	}

	public function fnNewClass($clsname, $clsrate, $clsduration, $clssession){
		$sql ="INSERT INTO tbl_class(cls_name, cls_rate, cls_duration, cls_sessions) VALUES('$clsname', '$clsrate','$clsduration', '$clssession')";

		$result = mysqli_query($this->db,$sql) or die(mysqli_error() . "Cannot Insert Data!");
		return $result;
	}

	public function fnSearchClass($searchval, $limit){
		$sql="SELECT * FROM tbl_class WHERE cls_name LIKE '%$searchval%' $limit";
		$result = mysqli_query($this->db,$sql);
		while($row = mysqli_fetch_assoc($result)){
			$list[] = $row;
		}
		return $list;
	}

	public function fngetsearchclassrows($searchval){
		$sql = "SELECT  COUNT(*) FROM tbl_class WHERE cls_name LIKE '%$searchval%'";
		$result=mysqli_query($this->db,$sql);
		$row=mysqli_fetch_row($result);

		$totalrows = $row[0];

		return $totalrows;
	}

	public function fnGetClassInfo($classid){
		$sql="SELECT * FROM tbl_class WHERE cls_id = '$classid'";
		$result = mysqli_query($this->db,$sql);
		while($row = mysqli_fetch_assoc($result)){
			$list[] = $row;
		}
		return $list;
	}


	public function fnUpdateClass($clsid, $clsname, $clsrate, $clsduration, $clssession){
		$sql ="UPDATE tbl_class SET cls_name = '$clsname' , cls_rate = '$clsrate', cls_duration='$clsduration', cls_sessions = '$clssession' WHERE cls_id='$clsid'";

		$result = mysqli_query($this->db,$sql) or die(mysqli_error() . "Cannot Update Data!");
		return $result;
	}


}
