<?php
class WorkoutPlan{
	public $db;
	
	public function __construct(){
		$this->db = new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
		if(mysqli_connect_errno()){
			echo "Database connection error.";
			exit;
		}
	}
    
    public function get_workoutplans($id){
		$sql = "SELECT W.wrk_id, W.wrk_name 
                FROM tbl_workoutplan W
                INNER JOIN tbl_workoutclass WC ON W.wrk_id = WC.wrk_id
                INNER JOIN tbl_classcategory CC ON WC.clc_id = CC.clc_id
                INNER JOIN tbl_staffclass SC ON CC.clc_id = SC.clc_id
                INNER JOIN tbl_staff S ON SC.stf_id = SC.stf_id
                WHERE S.stf_id = $id
				GROUP BY W.wrk_name";
		$result = mysqli_query($this->db,$sql);
		while($row = mysqli_fetch_assoc($result)){
			$list[] = $row;
		}
		return $list;
	}
    
    public function new_workoutplan(){
        
    }
}