<?php
class Category{
	public $db;

	public function __construct(){
		$this->db = new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
		if(mysqli_connect_errno()){
			echo "Database connection error.";
			exit;
		}
	}
//add this
    public function fnGetCategory(){
		$sql = "SELECT * FROM tbl_classcategory";
		$result = mysqli_query($this->db,$sql);
		while($row = mysqli_fetch_assoc($result)){
			$list[] = $row;
		}
		return $list;
	}

	public function get_categories(){
		$sql = "SELECT * FROM tbl_classcategory";
		$result = mysqli_query($this->db,$sql);
		while($row = mysqli_fetch_assoc($result)){
			$list[] = $row;
		}
		return $list;
	}

	public function get_category(){
		$sql = "SELECT * FROM tbl_category";
		$result = mysqli_query($this->db,$sql);
		while($row = mysqli_fetch_assoc($result)){
			$list[] = $row;
		}
		return $list;
	}

	function fn_get_class_list(){

	$statement = $connection->prepare("SELECT * FROM tbl_class");
	$statement->execute();
	$result = $statement->fetchAll();
	return $result;
	}


		public function fnGetClassCategory(){
		$sql = "SELECT * FROM tbl_classcategory";
		$result = mysqli_query($this->db,$sql);
		while($row = mysqli_fetch_assoc($result)){
			$list[] = $row;
		}
		return $list;
	}
}
