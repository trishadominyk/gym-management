<?php
include 'function.php';

if(isset($_POST['graphPeakDay'])){
	$r = graph_peak_day();
	$data_array = array();
	$monday = array();
	$array = array(0,0,0,0,0,0);
		foreach($r as $row){
			$data_array[] = array(
				'ctl' => $row['ctl']
			);
			switch ($row['daynme']) {
				case 'Monday':
					$monday = array(0=>(double)$row['ctl']);
					break;
					case 'Tuesday':
						$monday = array(1=>(double)$row['ctl']);
					break;
					case 'Wednesday':
						$monday = array(2=>(double)$row['ctl']);
					break;
					case 'Thursday':
						$monday = array(3=>(double)$row['ctl']);
					break;
					case 'Friday':
						$monday = array(4=>(double)$row['ctl']);
					break;
					case 'Saturday':
						$monday = array(5=>(double)$row['ctl']);
					break;
			}
			$array = array_replace($array,$monday);
		}
		echo json_encode(array( "day"=>$array));
}


//PEAK HOURS NI PRE
if(isset($_POST['graphPeakHour'])){
	$r = graph_peak_hour();
	$data_array = array();
	$monday = array();
	$array = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
		foreach($r as $row){
			$data_array[] = array(
				'ctl' => $row['ctl']
			);
			switch ($row['timein']) {
				case '6':
					$monday = array(0=>(double)$row['ctl']);
					break;
					case '7':
						$monday = array(1=>(double)$row['ctl']);
					break;
					case '8':
						$monday = array(2=>(double)$row['ctl']);
					break;
					case '9':
						$monday = array(3=>(double)$row['ctl']);
					break;
					case '10':
						$monday = array(4=>(double)$row['ctl']);
					break;
					case '11':
						$monday = array(5=>(double)$row['ctl']);
					break;
					case '12':
						$monday = array(6=>(double)$row['ctl']);
					break;
					case '13':
						$monday = array(7=>(double)$row['ctl']);
					break;
					case '14':
						$monday = array(8=>(double)$row['ctl']);
					break;
					case '15':
						$monday = array(9=>(double)$row['ctl']);
					break;
					case '16':
						$monday = array(10=>(double)$row['ctl']);
					break;
					case '17':
						$monday = array(11=>(double)$row['ctl']);
					break;
					case '18':
						$monday = array(12=>(double)$row['ctl']);
					break;
					case '19':
						$monday = array(13=>(double)$row['ctl']);
					break;
					case '20':
						$monday = array(14=>(double)$row['ctl']);
					break;
			}
			$array = array_replace($array,$monday);
		}
		echo json_encode(array( "timein"=>$array));
}

if(isset($_POST['graphPeakMonth'])){
	$r = graph_peak_month();
	$data_array = array();
	$monday = array();
	$array = array(0,0,0,0,0,0,0,0,0,0,0,0);
		foreach($r as $row){
			$data_array[] = array(
				'evncnt' => $row['evncnt']
			);
			switch ($row['monthname']) {
				case 'January':
					$monday = array(0=>(double)$row['evncnt']);
					break;
					case 'February':
						$monday = array(1=>(double)$row['evncnt']);
					break;
					case 'March':
						$monday = array(2=>(double)$row['evncnt']);
					break;
					case 'April':
						$monday = array(3=>(double)$row['evncnt']);
					break;
					case 'May':
						$monday = array(4=>(double)$row['evncnt']);
					break;
					case 'June':
						$monday = array(5=>(double)$row['evncnt']);
					break;
					case 'July':
						$monday = array(6=>(double)$row['evncnt']);
					break;
					case 'August':
						$monday = array(7=>(double)$row['evncnt']);
					break;
					case 'September':
						$monday = array(8=>(double)$row['evncnt']);
					break;
					case 'October':
						$monday = array(9=>(double)$row['evncnt']);
					break;
					case 'November':
						$monday = array(10=>(double)$row['evncnt']);
					break;
					case 'December':
						$monday = array(11=>(double)$row['evncnt']);
					break;
			}
			$array = array_replace($array,$monday);
		}
		echo json_encode(array("monthcount"=>$array));
}

if(isset($_POST['currYearClassSales'])){

	$rb = get_class_category();
	$data_array = array();
	foreach($rb as $row){
		$data_array[] = array(
			'clcname' => $row['clc_name'],
			'totalamount' => graph_class_sales($row['clc_id'])
		);
	}
	echo json_encode($data_array);
}

?>
