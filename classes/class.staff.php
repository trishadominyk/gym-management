<?php
class Staff{
	public $db;

	public function __construct(){
		$this->db = new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
		if(mysqli_connect_errno()){
			echo "Database connection error.";
			exit;
		}
	}

	public function staff_login($email, $password){
		$sql = "SELECT S.stf_id, S.stf_email, S.stf_firstname, S.stf_lastname, L.lvl_id, L.lvl_name
				FROM (tbl_staff S
				INNER JOIN tbl_level L ON L.lvl_id = S.lvl_id)
				WHERE S.stf_email = '$email' AND S.stf_password = '$password'";
		$result = mysqli_query($this->db,$sql);
		$userdata = mysqli_fetch_array($result);
		$count_row = $result->num_rows;

		if($count_row == 1){
            session_start();

			$_SESSION['login'] = true;
			$_SESSION['id'] = $userdata['stf_id'];
			$_SESSION['email'] = $userdata['stf_email'];
			$_SESSION['username'] = $userdata['stf_firstname']." ".$userdata['stf_lastname'];
			$_SESSION['level'] = $userdata['lvl_name'];

			return true;
		}
		else
			return false;
	}

	public function get_session(){
		if(isset($_SESSION['login']) && $_SESSION['login'] == true)
			return true;
		else
			return false;
	}

	/*public function get_level($id){
		$sql = "SELECT * FROM tbl_level WHERE lvl_id = $id";
		$result=mysqli_query($this->db,$sql);
		$row = mysqli_fetch_assoc($result);
		$value = $row['lvl_name'];

		return $value;
	}*/


	public function fnGetStaffLvl(){
		$sql="SELECT * FROM tbl_level";
		$result = mysqli_query($this->db,$sql);
		while($row = mysqli_fetch_assoc($result)){
			$list[] = $row;
		}
		return $list;
	}

	public function fnGetStaff(){
		$sql="SELECT stf_id, stf_email, stf_firstname, stf_lastname, stf_contact, lvl_name FROM tbl_staff, tbl_level WHERE tbl_staff.lvl_id = tbl_level.lvl_id";
		$result = mysqli_query($this->db,$sql);
		while($row = mysqli_fetch_assoc($result)){
			$list[] = $row;
		}
		return $list;
	}


	public function fnNewStaff($stf_email, $stf_firstname, $stf_lastname, $stf_contact, $lvl_id){
		$sql ="INSERT INTO tbl_staff(stf_email, stf_firstname, stf_lastname, stf_contact, lvl_id) VALUES('$stf_email', '$stf_firstname','$stf_lastname', '$stf_contact', '$lvl_id')";

		$result = mysqli_query($this->db,$sql) or die(mysqli_error() . "Cannot Insert Data!");
		return $result;
	}

    public function get_announcements(){
        $sql="SELECT * FROM tbl_announcement ORDER BY ann_date DESC LIMIT 10";
		$result = mysqli_query($this->db,$sql);
		while($row = mysqli_fetch_assoc($result)){
			$list[] = $row;
		}
		return $list;
    }

    public function get_memberships(){
        $sql="SELECT * FROM tbl_membershiptype ORDER BY met_name ASC";
		$result = mysqli_query($this->db,$sql);
		while($row = mysqli_fetch_assoc($result)){
			$list[] = $row;
		}
		return $list;
    }

    /**MOBILE FUNCTIONS**/

	public function mobile_staff_login($email, $password){
		$sql = "SELECT S.stf_id, S.stf_email, S.stf_firstname, S.stf_lastname, L.lvl_id, L.lvl_name
				FROM (tbl_staff S
				INNER JOIN tbl_level L ON L.lvl_id = S.lvl_id)
				WHERE S.stf_email = '$email' AND S.stf_password = '$password'";
		$result = mysqli_query($this->db,$sql);
		$count_row = $result->num_rows;

		if($count_row == 1){
			while($row = mysqli_fetch_assoc($result)){
				$list[] = $row;
			}
			return $list;
		}
		else
			return false;
	}

    public function retrieve_details($id){
        $sql="SELECT * FROM tbl_staff WHERE stf_id = $id LIMIT 1";
		$result = mysqli_query($this->db,$sql);
		while($row = mysqli_fetch_assoc($result)){
			$list[] = $row;
		}
		return $list;
    }

    public function retrieve_classes($id){
        $sql="SELECT C.cls_id, C.cls_name
        FROM tbl_staff S
        INNER JOIN tbl_staffclass SC ON S.stf_id = SC.stf_id
        INNER JOIN tbl_classcategory CC ON SC.clc_id = CC.clc_id
        INNER JOIN tbl_class C ON CC.clc_id = C.clc_id
        WHERE S.stf_id = $id";
		$result = mysqli_query($this->db,$sql);
		while($row = mysqli_fetch_assoc($result)){
			$list[] = $row;
		}
		return $list;
    }

    public function get_logbook($id){
        $date = date('Y-m-d');


        $sql="SELECT L.log_id, L.wrk_id, L.log_timein, U.cust_id, U.cust_firstname, U.cust_lastname, U.cust_id, C.cls_name, R.rec_session_remain
		FROM tbl_logbook L
        INNER JOIN tbl_record R ON L.rec_id = R.rec_id
        INNER JOIN tbl_transaction T ON R.trns_id = T.trns_id
        INNER JOIN tbl_transitems I ON T.trns_id = I.trns_id
        INNER JOIN tbl_class C ON I.cls_id = C.cls_id
        INNER JOIN tbl_classcategory CC ON C.clc_id = CC.clc_id
        INNER JOIN tbl_customer U ON T.cust_id = U.cust_id
        WHERE (L.stf_id = $id OR L.stf_id = 0) AND L.log_date = '$date'
        ORDER BY L.log_timein DESC";
		$result = mysqli_query($this->db,$sql);

		if($result){
			while($row = mysqli_fetch_assoc($result)){
				$list[] = $row;
			}
			return $list;
		}
		else
			return false;
    }

    public function get_activities(){
        $sql="SELECT * FROM tbl_activity";
		$result = mysqli_query($this->db,$sql);
		while($row = mysqli_fetch_assoc($result)){
			$list[] = $row;
		}
		return $list;
    }

		public function get_staff($id){
				$sql="SELECT * FROM tbl_staff WHERE stf_id = $id";
		$result = mysqli_query($this->db,$sql);
		while($row = mysqli_fetch_assoc($result)){
			$list[] = $row;
		}
		return $list;
		}

    public function retrieve_workoutactivities($wrk_id){
        $sql="SELECT A.act_name, WA.wra_sets FROM tbl_workoutact WA INNER JOIN tbl_activity A ON WA.act_id = A.act_id WHERE WA.wrk_id = $wrk_id";
		$result = mysqli_query($this->db,$sql);
		while($row = mysqli_fetch_assoc($result)){
			$list[] = $row;
		}
		return $list;
    }

    public function get_classlist($cls_id){
        $date = date('Y-m-d');

        $sql="SELECT R.rec_id, U.cust_firstname, U.cust_lastname, R.rec_enroll, R.rec_expire, R.rec_session_remain, M.mem_status
                FROM (tbl_record R
                INNER JOIN tbl_transaction T ON R.trns_id = T.trns_id
                INNER JOIN tbl_transitems I ON T.trns_id = I.trns_id
                INNER JOIN tbl_class C ON I.cls_id = C.cls_id)
                INNER JOIN tbl_customer U ON T.cust_id = U.cust_id
                LEFT OUTER JOIN tbl_membership M ON U.mem_id = M.mem_id
                WHERE C.cls_id = $cls_id AND R.rec_expire > '$date'
                ORDER BY U.cust_lastname ASC";
		$result = mysqli_query($this->db,$sql);
		while($row = mysqli_fetch_assoc($result)){
			$list[] = $row;
		}
		return $list;
    }
    
    public function update_activityprogress($acp_id,$action){
        $sql="UPDATE tbl_actprogress SET acp_status = '$action'
                WHERE acp_id = $acp_id";
        $result = mysqli_query($this->db,$sql) or die(mysqli_error() . "Cannot Edit Data");

        return $result;
    }
    
    public function get_proid($acp_id){
        $sql="SELECT pro_id FROM tbl_actprogress WHERE acp_id = $acp_id LIMIT 1";
        $result=mysqli_query($this->db,$sql);
		$row=mysqli_fetch_assoc($result);
		$value = $row['pro_id'];
		return $value;
    }
    
    public function count_activities($pro_id,$action){
        switch($action){
            case 'TOTAL':
                $sql="SELECT COUNT(acp_id) AS count FROM tbl_actprogress 
                WHERE pro_id = $pro_id LIMIT 1";
            break;
            default:
                $sql="SELECT COUNT(acp_id) AS count FROM tbl_actprogress 
                WHERE pro_id = $pro_id AND acp_status = '$action' LIMIT 1";
            break;
        }
        
        $result=mysqli_query($this->db,$sql);
        $row=mysqli_fetch_assoc($result);
        $value = $row['count'];
        
        return $value;
    }
    
    public function update_progress($pro_id,$percentage){
        $sql="UPDATE tbl_progress SET pro_percentage = $percentage WHERE pro_id = $pro_id";
        $result = mysqli_query($this->db,$sql) or die(mysqli_error() . "Cannot Edit Data");
        
        return $result;
    }
    
    public function retrieve_workout($id){
        $sql="SELECT W.wrk_id, W.wrk_name, W.wrk_desc FROM tbl_logbook L
        INNER JOIN tbl_record R ON L.rec_id = R.rec_id
        INNER JOIN tbl_transaction T ON R.trns_id = T.trns_id
        INNER JOIN tbl_transitems I ON T.trns_id = I.trns_id
        INNER JOIN tbl_class C ON I.cls_id = C.cls_id
        INNER JOIN tbl_classcategory CC ON C.clc_id = CC.clc_id
        INNER JOIN tbl_workoutclass WC ON CC.clc_id = WC.clc_id
        INNER JOIN tbl_workoutplan W ON WC.wrk_id = W.wrk_id
        WHERE L.log_id = $id ORDER BY W.wrk_name ASC";
		$result = mysqli_query($this->db,$sql);
		while($row = mysqli_fetch_assoc($result)){
			$list[] = $row;
		}
		return $list;
    }
    
    public function assign_workout($log,$wrk){
        $sql="UPDATE tbl_logbook SET wrk_id = $wrk WHERE log_id = $log";
        $result = mysqli_query($this->db,$sql) or die(mysqli_error() . "Cannot Edit Data");
        
        return $result;
    }
    
    public function new_progress($log){
        $sql="INSERT INTO tbl_progress(log_id) VALUES($log)";
        $result = mysqli_query($this->db,$sql) or die(mysqli_error() . "Cannot Insert Data");
        
        return $result;
    }
    
    public function get_progressid($log){
        $sql="SELECT pro_id FROM tbl_progress WHERE log_id = $log";
        $result=mysqli_query($this->db,$sql);
		$row=mysqli_fetch_assoc($result);
		$value = $row['pro_id'];
		return $value;
    }
    
    public function get_progactivities($id){
        $sql="SELECT * FROM tbl_workoutact WHERE wrk_id = $id AND wra_status = 'ACTIVE'";
		$result = mysqli_query($this->db,$sql);
		while($row = mysqli_fetch_assoc($result)){
			$list[] = $row;
		}
		return $list;
    }
    
    public function new_progactivities($progress,$activity){
        $sql="INSERT INTO tbl_actprogress(wra_id, pro_id)
        VALUES($activity, $progress)";
        $result = mysqli_query($this->db,$sql) or die(mysqli_error() . "Cannot Insert Data");
        
        return $result;
    }
    
    public function finish_workout($pro_id){
        $sql="UPDATE tbl_progress SET pro_status = 'FINISHED'
        WHERE pro_id = $pro_id";
        $result = mysqli_query($this->db,$sql) or die(mysqli_error() . "Cannot Insert Data");
        
        return $result;
    }
    
    public function edit_staff($fname,$lname,$contact,$email,$id){
        $sql="UPDATE tbl_staff SET stf_firstname = '$fname', stf_lastname = '$lname', stf_contact = '$contact', stf_email = '$email' WHERE stf_id = $id";
        $result = mysqli_query($this->db,$sql) or die(mysqli_error() .'Cannot Insert Data');
        
        return $result;
    }
}
