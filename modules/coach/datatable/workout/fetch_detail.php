<?php
include('../db.php');
include('function.php');

$output = array();

if(isset($_POST['wrk_id'])){
    $id = $_POST['wrk_id'];
    
    $query = '';
    $query .= "SELECT * FROM tbl_workoutact WA 
    INNER JOIN tbl_activity A ON WA.act_id = A.act_id
    INNER JOIN tbl_workoutplan W ON WA.wrk_id = W.wrk_id
    WHERE WA.wrk_id = $id AND WA.wra_status = 'ACTIVE' ";

    $statement = $connection->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $data = array();
    $filtered_rows = $statement->rowCount();

    $wrk_name = get_wrkname($id);
    $wrk_desc = get_wrkdesc($id);
    
    foreach($result as $row){
        $sub_array = array();
        
        $buttons = '<button id="'.$row['wra_id'].'" class="btn btn-xs btn-danger remove">Remove</button>';
        
        $sub_array[] = $row['act_name'];
        $sub_array[] = $row['wra_sets'];
        $sub_array[] = $buttons;
        
        $data[] = $sub_array;
    }
    
    $edit_btn = '<button id="'.$id.'" class="btn btn-xs btn-default edit" data-toggle="modal" data-target="#workoutNew" style="margin-right: 5px;">Edit</button>';
    
    $activity_add = '<label>Name</label><select name="act_name" id="act_name" class="form-control">';
    $activitylist = get_activities($id);
    
    foreach($activitylist as $value){
        $activity_add .= '<option value="'.$value['act_id'].'">'.$value['act_name'].'</option>';
    }
    $activity_add .="</select>";
    
    $activity_add .="<br><label>Sets</label><input type='number'name='wra_sets' id='wra_sets' class='form-control' />";
    
    $activity_btn = '<input type="hidden" id="wrk_id" name="wrk_id" value="'.$id.'" />';
    $activity_btn .= '<input type="submit" name="submit" class="btn btn-xs btn-success addactivity" value="Add Activity" />';

    $output = array(
        "recordsTotal"		=> 	$filtered_rows,
        "data"				=>	$data,
        "table_name"        =>  $wrk_name,
        "edit_btn"          =>  $edit_btn,
        "activity_btn"      =>  $activity_btn,
        "activity_add"      =>  $activity_add,
        "wrk_id"            =>  $id,
        "wrk_name"          =>  $wrk_name,
        "wrk_desc"          =>  $wrk_desc
    );
}
echo json_encode($output);