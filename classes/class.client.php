<?php
class Client{
	public $db;

	public function __construct(){
		$this->db = new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
		if(mysqli_connect_errno()){
			echo "Database connection error.";
			exit;
		}
	}

    public function get_client($id){
        $sql = "SELECT * FROM tbl_customer WHERE cust_id = '$id' OR cust_code = '$id'";
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

    public function mobile_customer_login($email, $password){
        $sql = "SELECT * FROM tbl_customer
                WHERE cust_email = '$email' AND cust_password = '$password'";
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

	public function customer_login($email, $password){
		$sql = "SELECT C.cust_id, C.cust_firstname, C.cust_lastname, C.cust_email FROM tbl_customer C
                INNER JOIN tbl_membership M ON C.mem_id = M.mem_id
				WHERE C.cust_email = '$email' AND C.cust_password = '$password' AND M.mem_status = 'ACTIVE'";
		$result = mysqli_query($this->db,$sql);
		$userdata = mysqli_fetch_array($result);
		$count_row = $result->num_rows;

		if($count_row == 1){
            session_start();
			$_SESSION['login'] = true;
			$_SESSION['id'] = $userdata['cust_id'];
			$_SESSION['email'] = $userdata['cust_email'];
			$_SESSION['username'] = $userdata['cust_firstname']." ".$userdata['cust_lastname'];
			$_SESSION['level'] = 'CUSTOMER';
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



    public function get_userprofile($id){
        $sql = "SELECT C.cust_firstname, C.cust_lastname, C.cust_email, M.mem_status, M.mem_date_added, M.mem_date_expire, T.met_name
        FROM tbl_customer C
        INNER JOIN tbl_membership M ON C.mem_id = M.mem_id
        INNER JOIN tbl_membershiptype T ON M.met_id = T.met_id
        WHERE C.cust_id = $id";
        $result = mysqli_query($this->db,$sql);
		while($row = mysqli_fetch_assoc($result)){
			$list[] = $row;
		}
		return $list;
    }

    public function get_enrolledclass($id){
        $date = date('Y-m-d');

        $sql = "SELECT L.cls_name, R.rec_session_remain
        FROM tbl_record R
        INNER JOIN tbl_transaction T ON R.trns_id = T.trns_id
        INNER JOIN tbl_transitems I ON T.trns_id = I.trns_id
        INNER JOIN tbl_class L ON I.cls_id = L.cls_id
        WHERE T.cust_id = $id AND rec_expire >= '$date'";
        $result = mysqli_query($this->db,$sql);
		while($row = mysqli_fetch_assoc($result)){
			$list[] = $row;
		}
		return $list;
    }

    public function get_currentbmi($id){
        $sql = "SELECT * FROM tbl_bmi WHERE cust_id = $id ORDER BY bmi_date DESC LIMIT 1";
        $result = mysqli_query($this->db,$sql);
        $row = mysqli_fetch_assoc($result);

        if($row){
            $height = $row['bmi_height'];
            $weight = $row['bmi_weight'];

            $result = ($weight * 0.45) / pow(($height * 0.025), 2);

            if($result <= 18.5)
                $info = "Underweight";
            else if($result > 18.5 && $result <= 25)
                $info = "Normal";
            else if($result > 25 && $result <= 30)
                $info = "Overweight";
            else if($result > 30 && $result <= 35)
                $info = "Moderately Obese";
            else if($result > 35)
                $info = "Severely Obese";

            return $result.' '.$info;
        }
        else
            return 'No BMI info';
    }

    public function get_temporarytrans(){
        $sql = "SELECT * FROM tbl_transtemp";
        $result = mysqli_query($this->db,$sql);
        $row = mysqli_fetch_assoc($result);
        $value = $row['cust_id'];

        return $value;
    }

    public function check_login($id){
        $date = date('Y-m-d');
        $sql = "SELECT * FROM tbl_logbook WHERE cust_id = $id AND log_timeout IS NULL AND log_date = '$date'";
        $result = mysqli_query($this->db,$sql);
        $check = $this->db->query($sql);

        $count = $check->num_rows;
        if($count > 0)
            return false;
        else
            return true;
    }

		public function get_logid($id){
			$date = date('Y-m-d');
			$sql = "SELECT log_id FROM tbl_logbook
			WHERE cust_id = $id AND log_timeout IS NULL AND log_date = '$date'
			LIMIT 1";
			$result = mysqli_query($this->db,$sql);

			$value ='';
			if($result){
				while($row = mysqli_fetch_assoc($result)){
						$value = $row['log_id'];
				}
				return $value;
			}else {
					return false;
			}

		}

		public function get_current_class($id){
			$q = "SELECT * FROM (tbl_logbook L
	    INNER JOIN tbl_record R ON L.rec_id = R.rec_id
	    INNER JOIN tbl_transaction T ON T.trns_id = R.trns_id
	    INNER JOIN tbl_transitems I ON T.trns_id = I.trns_id
	    INNER JOIN tbl_class C ON I.cls_id = C.cls_id)
	    INNER JOIN tbl_progress P ON L.log_id = P.log_id
	    INNER JOIN tbl_workoutplan W ON L.wrk_id = W.wrk_id
	    INNER JOIN tbl_staff S ON L.stf_id = S.stf_id
	    WHERE L.log_id = $id";

			$result = mysqli_query($this->db, $q);


			$list = array();
			if($result){
					while($row = mysqli_fetch_assoc($result)){
							$list[] = $row;
					}
					return $list;
			}
			else
					return false;

		}

		public function get_workout_plan($id){
			$q = "SELECT A.act_name, AP.acp_status, WA.wra_sets
            FROM tbl_logbook L
            INNER JOIN tbl_progress P ON L.log_id = P.log_id
            INNER JOIN tbl_actprogress AP ON P.pro_id = AP.pro_id
            INNER JOIN tbl_workoutact WA ON AP.wra_id = WA.wra_id
            INNER JOIN tbl_activity A ON WA.act_id = A.act_id
            WHERE L.log_id = $id";

			$result = mysqli_query($this->db, $q);

			if($result){
					while($row = mysqli_fetch_assoc($result)){
							$list[] = $row;
					}
					return $list;
			}
			else
					return false;
		}

    public function check_workoutplan($id){
        $date = date('Y-m-d');

        $sql = "SELECT * FROM tbl_logbook WHERE cust_id = $id AND log_timeout IS NULL AND log_date = '$date' AND wrk_id != 0";
        $result = mysqli_query($this->db,$sql);
        $check = $this->db->query($sql);

        $count_row = $check->num_rows;

        if($count_row == 0)
            return false;
        else
            return true;
    }

    public function get_coach($id){
        $sql = "SELECT S.stf_firstname, S.stf_lastname FROM tbl_logbook L INNER JOIN tbl_staff S ON L.stf_id = S.stf_id WHERE L.cust_id = $id AND L.log_timeout IS NULL and log_date = CURDATE()";
        $result = mysqli_query($this->db,$sql);
        $row = mysqli_fetch_assoc($result);
        $value = $row['stf_firstname']." ".$row['stf_lastname'];

        return $value;
    }

		public function get_client_logs($id){
			$q = "SELECT S.stf_firstname, S.stf_lastname, L.log_id, L.log_date, L.log_timein, L.log_timeout, C.cls_name, R.rec_id FROM tbl_logbook L
	    INNER JOIN tbl_record R ON L.rec_id = R.rec_id
	    INNER JOIN tbl_transaction T ON R.trns_id = T.trns_id
	    INNER JOIN tbl_transitems I ON T.trns_id = I.trns_id
	    INNER JOIN tbl_class C ON I.cls_id = C.cls_id
		INNER JOIN tbl_staff S ON L.stf_id = S.stf_id
	    WHERE L.cust_id = '$id'
	    ORDER BY L.log_date DESC";

			$result = mysqli_query($this->db, $q);
			$count_row = $result->num_rows;

			if($count_row > 0){
					while($row = mysqli_fetch_assoc($result)){
							$list[] = $row;
					}
					return $list;
			}
			else
					return false;


		}

		public function get_record_details($id){
			$q = "SELECT A.act_name, AP.acp_status, WA.wra_sets
            FROM tbl_logbook L
            INNER JOIN tbl_progress P ON L.log_id = P.log_id
            INNER JOIN tbl_actprogress AP ON P.pro_id = AP.pro_id
            INNER JOIN tbl_workoutact WA ON AP.wra_id = WA.wra_id
            INNER JOIN tbl_activity A ON WA.act_id = A.act_id
            WHERE L.log_id = $id";

						$result = mysqli_query($this->db, $q);
						$list = array();

						if($result){
							while($row = mysqli_fetch_assoc($result)){
								$list[] = $row;
							}
							return $list;
						}else
							return false;
		}


    public function mobile_client_login($email, $password){
		$sql = "SELECT * FROM tbl_customer
				WHERE cust_email = '$email' AND cust_password = '$password'";
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

	public function get_client_progress($id){
		$sql = "SELECT L.log_id,L.log_date, P.pro_percentage FROM tbl_progress P
				INNER JOIN tbl_logbook L ON P.log_id = L.log_id
				WHERE L.cust_id = $id LIMIT 10";
		$result = mysqli_query($this->db,$sql);
		$count_row = $result->num_rows;

		if($count_row != 0){
			while($row = mysqli_fetch_assoc($result)){
				$list[] = $row;
			}
			return $list;
		}
		else
			return false;
	}

    public function get_logbook_workout($id){
        $sql = "SELECT P.pro_id, A.act_name, AP.acp_id, AP.acp_status, WA.wra_sets
            FROM tbl_logbook L
            INNER JOIN tbl_progress P ON L.log_id = P.log_id
            INNER JOIN tbl_actprogress AP ON P.pro_id = AP.pro_id
            INNER JOIN tbl_workoutact WA ON AP.wra_id = WA.wra_id
            INNER JOIN tbl_activity A ON WA.act_id = A.act_id
            WHERE L.log_id = $id";
		$result = mysqli_query($this->db,$sql);
		$count_row = $result->num_rows;

		if($count_row != 0){
			while($row = mysqli_fetch_assoc($result)){
				$list[] = $row;
			}
			return $list;
		}
		else
			return false;
    }
}
