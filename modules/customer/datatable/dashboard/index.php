<head>
    <script src="../../js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
</head>

<div class="content-container">
<?php
    if($client->check_login($_SESSION['id'])){
?>
    <div class="table-responsive dashboard-inactive">
        <h2>Please login at the gym to begin your workout</h2>
        <hr>
        <p>Prepare your member ID (if you brought one) and approach our friendly staff to assist you in logging in.</p>
    </div>
<?php
    }
    else{
        if($client->check_workoutplan($_SESSION['id']) == false){
?>
    <div class="table-responsive dashboard-inactive">
        <h2>You are logged in! But no workout plan :(</h2>
        <hr>
        <p>Please ask your assigned coach <b><?php echo $client->get_coach($_SESSION['id'])?></b> for today's workout plan.</p>
    </div>    
<?php
        }
        else{
?>
    <div class="table-responsive dashboard-active">
        <div class="dashboard-statistics">
            <div class="stats-box box-dark box" id="rec_info">
                
            </div>

            <div class="stats-box box-red box" id="log_timein">

            </div>

            <div class="stats-box box-gray box" id="log_progress">

            </div>
        </div>
        
        <div class="box customer-dashboard table-responsive">
            <h3 id="wrk_name"></h3>
            <h4 id="wrk_desc"></h4>
            <br>
            
            <table id="workout_table" class="table" style="width: 75%; margin:auto;">
                <thead style="background-color: unset;color: #b01f24;font-weight: bold;border-bottom: 2px #b01f24 solid;">
                    <tr>
                        <td>Activity</td>
                        <td>Sets</td>
                        <td>Status</td>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
<?php
            
        }
    }
?>
</div>

<script type="text/javascript">
     $(document).ready(function(){
         $.ajax({
            url:"datatable/dashboard/onload.php",
            method:"POST",
            data:{id:'<?php echo $_SESSION['id'];?>'},
            dataType:"JSON",
            success:function(data)
            {
                $('#rec_info').append(data.rec_info);
                $('#log_timein').append(data.log_timein);
                $('#log_progress').append(data.log_progress);
                
                $('#wrk_name').text(data.wrk_name);
                $('#wrk_desc').text(data.wrk_desc);
            }
         });
         
         var workoutTable = $('#workout_table').DataTable({
            "processing":true,
            "serverSide":true,
            "order":[],
            "ajax":{
                url:"datatable/dashboard/fetch.php",
                type: "POST",
                data:{id:'<?php echo $_SESSION['id'];?>'}
            },
            "columnDefs":[
                //{
                    { orderable: false, targets: '_all' }
                //},
            ],
            "paging":false,
            "bInfo": false,
            "bFilter": false
        });
     });
</script>