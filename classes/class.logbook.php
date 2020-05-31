<?php
class Log{
	public $db;
	
	public function __construct(){
		$this->db = new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
		if(mysqli_connect_errno()){
			echo "Database connection error.";
			exit;
		}
	}
    
    public function get_visitstats(){
        $date = date('Y-m-');
        
        $sql = "SELECT * FROM tbl_logbook WHERE log_date LIKE '$date%'";
        $result=mysqli_query($this->db,$sql);
		
		return $result->num_rows;
    }
}