<?php
include 'function.php';
if(isset($_POST['graphMembership'])){
	$start = $_POST['datestart'];
	$end = $_POST['dateend'];
	$ra = graph_membership($start, $end);
	echo json_encode($ra);
}

if(isset($_POST['membershipTable'])){
	$start = $_POST['datestart'];
	$end = $_POST['dateend'];
	$r = get_membership_table($start, $end);
	?>

    <div align="right"><button class="btn btn-sm btn-gray svg-middle" name="btn-mem-rep" id="memrep"><?php echo file_get_contents('../../../svg/ic_print.svg');?> Print Report</button></div>
	<br/>
	<br/>
	 <table id="user_data" class="table table-bordered table-striped">
     <thead>
     <tr >

     	<td colspan="4" style="text-align: center;	"> <b> Membership Report</b></td>
     </tr>
     <tr>
     	<td colspan="4" style="text-align: center;	"><?php echo $date = date('F d, Y', strtotime($start)).' - '.date('F d, Y', strtotime($end))?></td>
     </tr>
      <tr>
       <th width="25%">Member Name</th>
       <th width="25%">Date Added</th>
       <th width="25%">Date Expire</th>
       <th width="25%">Status</th>
      </tr>
     </thead>
     <tbody>

    <?php
	foreach($r as $row){
	?>
	<tr>
		<td><?php echo $name = $row['cust_firstname'].' '.$row['cust_lastname'];?></td>
		<td><?php echo date('F d, Y', strtotime($row['mem_date_added']));?></td>
		<td><?php echo date('F d, Y', strtotime($row['mem_date_expire']));?></td>
		<td><?php echo $row['mem_status'];?></td>
		</tr>
	<?php
	}
	?>

     </tbody>
    </table>



<?php
}


if(isset($_POST['graphClassSales'])){
	$datestart = $_POST['datestart'];
	$dateend = $_POST['dateend'];
	$rb = get_class_category();
	$data_array = array();
	foreach($rb as $row){
		$data_array[] = array(
			'clcname' => $row['clc_name'],
			'totalamount' => graph_class_sales($row['clc_id'],$datestart, $dateend)
		);
	}
	echo json_encode($data_array);
}

if(isset($_POST['graphMembershipSales'])){
	$datestart = $_POST['datestart'];
	$dateend = $_POST['dateend'];
	$ra = get_membership_type();
	$data_array= array();
	foreach($ra as $row)
	{
		$data_array[] =array(
				'metname' => $row['met_name'],
				'totalamountmem' => graph_membership_sales($row['met_id'], $datestart, $dateend)
		);
	}
	echo json_encode($data_array);


}

//class sales table
if(isset($_POST['salesTable'])){
	$start = $_POST['datestart'];
	$end = $_POST['dateend'];
	$r = get_class_list_sales();
	?>
	<div align="right"><button class="btn btn-sm btn-gray svg-middle" id="class-sales-rep"><?php echo file_get_contents('../../../svg/ic_print.svg');?> Print Report</button></div>
	<br/>

	 <table id="user_data" class="table table-bordered table-striped">
     <thead>
     <tr>

     		<td colspan="2" style="text-align: center;	"> <b> Class Types Total Sales Report </b></td>
     </tr>
     <tr>

     	<td colspan="2" style="text-align: center;	"><?php echo $date = date('F d, Y', strtotime($start)).' - '.date('F d, Y', strtotime($end))?></td>
     </tr>
      <tr>
       <th width="25%">Class Name</th>
       <th width="25%">Total Sales</th>
      </tr>
     </thead>
     <tbody>
    <?php
	foreach($r as $row){
		$id = $row['cls_id'];
		$rb = get_totalamount_class_sales($start,$end,$id);

		foreach($rb as $value){
	?>
	<tr>
		<td><?php echo $row['cls_name'];?></td>
		<td><?php echo $value['totalamount'];?></td>
		</tr>
	<?php
		}
	}
	?>
     </tbody>
    </table>
<?php

}


if(isset($_POST['membershipTableSales'])){
	$start = $_POST['datestart'];
	$end = $_POST['dateend'];
	$r = get_memtype_list_sales();
	?>
	<div align="right"><button class="btn btn-sm btn-gray svg-middle" id="membership-sales-rep"><?php echo file_get_contents('../../../svg/ic_print.svg');?> Print Report</button></div>
	<br/>

	 <table id="mem_data" class="table table-bordered table-striped">
     <thead>
     <tr>
     	   <tr>

     		<td colspan="2" style="text-align: center;	"> <b> Membership Types Total Sales Report </b></td>
     </tr>
     	<td colspan="2" style="text-align: center;	"><?php echo $date = date('F d, Y', strtotime($start)).' - '.date('F d, Y', strtotime($end))?></td>
     </tr>
      <tr>
       <th width="25%">Membership Type Name</th>
       <th width="25%">Total Sales</th>
      </tr>
     </thead>
     <tbody>
    <?php
	foreach($r as $row){
		$id = $row['met_id'];
		$rb = get_totalamount_memtype_sales($start,$end,$id);

		foreach($rb as $value){
	?>
	<tr>
		<td><?php echo $row['met_name'];?></td>
		<td><?php echo $value['totalamount'];?></td>
		</tr>
	<?php
		}
	}
	?>
     </tbody>
    </table>
<?php
}

if(isset($_POST['graphEqp'])){
	$datestart = $_POST['datestart'];
	$dateend = $_POST['dateend'];
	$ra = graph_available_equipment();
	$rb = graph_repair_equipment($datestart,$dateend);
	$rc = graph_disposed_equipment($datestart,$dateend);
	echo json_encode(array($ra, $rb, $rc));
}

//available equipment
if(isset($_POST['availEqpTable'])){
	$start = $_POST['datestart'];
	$end = $_POST['dateend'];
	$r = get_avail_equipment();
	?>
	<div align="right"><button class="btn btn-sm btn-gray svg-middle" id="avail-eqp-rep"><?php echo file_get_contents('../../../svg/ic_print.svg');?> Print Report</button></div>
	<br/>
	 <table id="user_data" class="table table-bordered table-striped">
     <thead>
     <tr >

     	<td colspan="2" style="text-align: center;	"> <b>Available Equipments</b></td>
     </tr>
     <tr>
     	<td colspan="2" style="text-align: center;	"><?php echo $date = date('F d, Y', strtotime($start)).' - '.date('F d, Y', strtotime($end))?></td>
     </tr>
      <tr>
       <th width="50%">Serial</th>
       <th width="50%">Equipment Name</th>
      </tr>
     </thead>
     <tbody>

    <?php
	foreach($r as $row){
	?>
	<tr>
		<td><?php echo $row['eqp_serial']?></td>
		<td><?php echo $row['eqp_name'];?></td>
		</tr>
	<?php
	}
	?>

     </tbody>
    </table>
<?php
}

//repair availables
if(isset($_POST['repEqpTable'])){
	$start = $_POST['datestart'];
	$end = $_POST['dateend'];
	$r = get_repair_equipment($start, $end);
	?>
	<div align="right"><button class="btn btn-sm btn-gray svg-middle" id="repair-eqp-rep"><?php echo file_get_contents('../../../svg/ic_print.svg');?> Print Report</button></div>
	<br/>
	 <table id="user_data" class="table table-bordered table-striped">
     <thead>
     <tr >

     	<td colspan="3" style="text-align: center;	"> <b>Under Repair Equipments</b></td>
     </tr>
     <tr>
     	<td colspan="3" style="text-align: center;	"><?php echo $date = date('F d, Y', strtotime($start)).' - '.date('F d, Y', strtotime($end))?></td>
     </tr>
      <tr>
       <th width="25%">Serial</th>
       <th width="25%">Date damaged</th>
       <th width="25%">Name</th>
      </tr>
     </thead>
     <tbody>

    <?php
	foreach($r as $row){
	?>
	<tr>
		<td><?php echo $row['eqp_serial'];?></td>
		<td><?php echo date('F d, Y', strtotime($row['eqp_date_update']));?></td>
		<td><?php echo $row['eqp_name'];?></td>
		</tr>
	<?php
	}
	?>

     </tbody>
    </table>
<?php
}

//disposed ni pre
if(isset($_POST['dispEqpTable'])){
	$start = $_POST['datestart'];
	$end = $_POST['dateend'];
	$r = get_disposed_equipment($start, $end);
	?>
	<div align="right"><button class="btn btn-sm btn-gray svg-middle" id="disposed-eqp-rep"><?php echo file_get_contents('../../../svg/ic_print.svg');?> Print Report</button></div>
	<br/>
	 <table id="user_data" class="table table-bordered table-striped">
     <thead>
     <tr >

     	<td colspan="3" style="text-align: center;	"> <b>Disposed Equipments</b></td>
     </tr>
     <tr>
     	<td colspan="3" style="text-align: center;	"><?php echo $date = date('F d, Y', strtotime($start)).' - '.date('F d, Y', strtotime($end))?></td>
     </tr>
      <tr>
       <th width="25%">Serial</th>
       <th width="25%">Date disposed</th>
       <th width="25%">Name</th>
      </tr>
     </thead>
     <tbody>

    <?php
	foreach($r as $row){
	?>
	<tr>
		<td><?php echo $row['eqp_serial']?></td>
		<td><?php echo date('F d, Y', strtotime($row['eqp_date_update']));?></td>
		<td><?php echo $row['eqp_name'];?></td>
		</tr>
	<?php
	}
	?>

     </tbody>
    </table>
<?php
}



//event booking
if(isset($_POST['table-event-book-approved'])){


	$datestart = $_POST['datestart'];
	$dateend = $_POST['dateend'];

	$r = get_event_booked_approved($datestart, $dateend);
	?>
	<div align="right"><button class="btn btn-sm btn-gray svg-middle" id="btn-evn-app"><?php echo file_get_contents('../../../svg/ic_print.svg');?> Print Report</button></div>
	<br/>
	 <table id="event_data" class="table table-bordered table-striped">
     <thead>
     <tr>
     	<td colspan="5" style="text-align: center;	"> <b>Approved Events</b></td>
     </tr>
     <tr>
     	<td colspan="5" style="text-align: center;	"><?php echo $date = date('F d, Y', strtotime($datestart)).' - '.date('F d, Y', strtotime($dateend))?></td>
     </tr>
      <tr>
       <th width="10%">Name</th>
       <th width="10%">Date</th>
       <th width="10%">Time Start</th>
       <th width="10%">Time End</th>
       <th width="10%">Venue</th>
      </tr>
     </thead>
     <tbody>

    <?php
	foreach($r as $row){
	?>
	<tr>
		<td><?php echo $row['evn_name']?></td>
		<td><?php echo $row['evn_det_date'];?></td>
		<td><?php echo $row['evn_det_time_start'];?></td>
		<td><?php echo $row['evn_det_time_end'];?></td>
		<td><?php echo $row['evn_det_venue'];?></td>
		</tr>
	<?php
	}
	?>

     </tbody>
    </table>
<?php
}



if(isset($_POST['table-event-book-canceled'])){



	$datestart = $_POST['datestart'];
	$dateend = $_POST['dateend'];

	$r = get_event_booked_canceled($datestart, $dateend);
	?>
	<div align="right"><button class="btn btn-sm btn-gray svg-middle" id="btn-evn-cncl"><?php echo file_get_contents('../../../svg/ic_print.svg');?> Print Report</button></div>
	<br/>
	 <table id="event_data" class="table table-bordered table-striped">
     <thead>
     <tr>
     	<td colspan="5" style="text-align: center;	"> <b>Canceled Events</b></td>
     </tr>
     <tr>
     	<td colspan="5" style="text-align: center;	"><?php echo $date = date('F d, Y', strtotime($datestart)).' - '.date('F d, Y', strtotime($dateend))?></td>
     </tr>
      <tr>
       <th width="10%">Name</th>
       <th width="10%">Date</th>
       <th width="10%">Time Start</th>
       <th width="10%">Time End</th>
       <th width="10%">Venue</th>
      </tr>
     </thead>
     <tbody>

    <?php
	foreach($r as $row){
	?>
	<tr>
		<td><?php echo $row['evn_name']?></td>
		<td><?php echo $row['evn_det_date'];?></td>
		<td><?php echo $row['evn_det_time_start'];?></td>
		<td><?php echo $row['evn_det_time_end'];?></td>
		<td><?php echo $row['evn_det_venue'];?></td>
		</tr>
	<?php
	}
	?>

     </tbody>
    </table>
<?php
}





if(isset($_POST['graph-event'])){
	$datestart = $_POST['datestart'];
	$dateend = $_POST['dateend'];
	$ra = graph_approved_events($datestart,$dateend);
	$rc = graph_canceled_events($datestart,$dateend);
	echo json_encode(array($ra,$rc));
}




if(isset($_POST['stafflogtable'])){

	$datestart = $_POST['datestart'];
	$dateend = $_POST['dateend'];

	$r = get_staff_log($datestart, $dateend);
	?>
	<div align="right"><button class="btn btn-sm btn-gray svg-middle" id="btn-staff-log"><?php echo file_get_contents('../../../svg/ic_print.svg');?> Print Report</button></div>
	<br/>
	 <table id="stafflog_data" class="table table-bordered table-striped">
     <thead>
     <tr>
     	<td colspan="5" style="text-align: center;	"> <b>Staff log</b></td>
     </tr>
     <tr>
     	<td colspan="5" style="text-align: center;	"><?php echo $date = date('F d, Y', strtotime($datestart)).' - '.date('F d, Y', strtotime($dateend))?></td>
     </tr>
      <tr>
       <th width="10%">Name</th>
       <th width="10%">Date</th>
       <th width="10%">Time in</th>
       <th width="10%">Time out</th>
      </tr>
     </thead>
     <tbody>

    <?php
	foreach($r as $row){
	?>
	<tr>
		<td><?php echo $row->stf_firstname.' '.$row->stf_lastname; ?></td>
		<td><?php echo date('F d, Y', strtotime($row->stf_log_date)); ?></td>
		<td><?php echo date('h:i:s A', strtotime($row->stf_log_in)); ?></td>
		<td><?php echo date('h:i:s A', strtotime($row->stf_log_out)); ?></td>

		</tr>
	<?php
	}
	?>

     </tbody>
    </table>
<?php
}


if(isset($_POST['studentlogtable'])){

	$datestart = $_POST['datestart'];
	$dateend = $_POST['dateend'];

	$r = get_student_log($datestart, $dateend);
	?>
	<div align="right"><button class="btn btn-sm btn-gray svg-middle" id="btn-stud-log"><?php echo file_get_contents('../../../svg/ic_print.svg');?> Print Report</button></div>
	<br/>
	 <table id="stafflog_data" class="table table-bordered table-striped">
     <thead>
     <tr>
     	<td colspan="5" style="text-align: center;	"> <b>Client log</b></td>
     </tr>
     <tr>
     	<td colspan="5" style="text-align: center;	"><?php echo $date = date('F d, Y', strtotime($datestart)).' - '.date('F d, Y', strtotime($dateend))?></td>
     </tr>
      <tr>
       <th width="10%">Name</th>
       <th width="10%">Date</th>
       <th width="10%">Time in</th>
       <th width="10%">Time out</th>
      </tr>
     </thead>
     <tbody>

    <?php
	foreach($r as $row){
	?>
	<tr>
		<td><?php echo $row->cust_firstname.' '.$row->cust_lastname; ?></td>
		<td><?php echo date('F d, Y', strtotime($row->log_date)); ?></td>
		<td><?php echo date('h:i:s A', strtotime($row->log_timein)); ?></td>
		<td><?php echo date('h:i:s A', strtotime($row->log_timeout)); ?></td>

		</tr>
	<?php
	}
	?>

     </tbody>
    </table>
<?php
}


if(isset($_POST['studentloggraph'])){

	$r = get_top_student_log($_POST['datestart'], $_POST['dateend']);

	$data= array();
	foreach($r as $row){
		  array_push($data, array('name' => $row->cust_firstname.' '.$row->cust_lastname, 	'cnt' => $row->cnt ));
			// $data[] = array(
			// 	'name' => $row['cust_firstname'].' '.$row['cust_lastname'],
			// 	'cnt' =>$row['cnt']
			// );
	}
	echo json_encode($data);
}

?>
