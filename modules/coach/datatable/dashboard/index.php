<head>
    <script src="../../js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
</head>

<div class="content-container">
    <div class="dashboard-right">
        <div class="box table-responsive">
            <span class="date_today" style="float:right;"><?php echo file_get_contents('../../svg/ic_today.svg');?>&nbsp;Today: <?php echo date('l M j, Y');?></span>
            
            <table id="client_data" class="table table-border table-striped" style="width: 100%;">
                <thead>
                    <tr>
                        <th width="10%">Log Time</th>
                        <th>Name</th>
                        <th>Class</th>
                        <th>Progress</th>
                        <th width="10%">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    
    <div class="dashboard-left">
        <div class="client-info box box-gray">
            <h4 id="cust_name">Client Info</h4>
            <hr>
            
            <h1 id="pro_percentage" style="text-align:center;font-weight:bold;"></h1>
            <div id="progressrate"></div>
            <h3 id="wrk_name"></h3>
            <span id="wrk_desc"></span>
            <br>
            <br>
            
            <span id="pro_start"></span>
            <br>
            <span id="pro_end"></span>
        </div>
        <br>
        <div class="box box-dark">
            <h4>Routine Details</h4>

            <hr class="light">
            
            <div class="col-lg-12 col-md-10 text-center" style="margin-bottom: 25px;"><span class="routine_btn"></span></div>
            
            <table class="routine_table" style="width:100%;">
                <thead>
                    <th>Activity</th>
                    <th>Sets</th>
                    <th>Status</th>
                    <th>Action</th>
                </thead>
                <tbody id="routine_content"></tbody>
            </table>
        </div>
    </div>
</div>

<div id="workoutView" class="modal fade">
	<div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Select class to time in</h4>
            </div>

            <div class="modal-body">
                <div class="table-responsive" id="client_record">
                    <table id='workout_data' class='table table-border' style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                        
                    <table id='staff_data' style="width: 100%;">
                        <tbody id="stf_body">
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer">
                    
            </div>
        </div>
	</div>
</div>

<div id="progressView" class="modal fade">
	<div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title" id="cust_name_modal"></h3>
                <span id="cust_email_modal"></span>
            </div>
            
            <div class="modal-body">
                <div class="stats-box box-dark box" id="avg_progress"></div>
                
                <div id="client_progreport">
                    <div id="progress-chart">
                        <h4 id="cust-name"></h4>
                        <canvas id="canvas" style="width:100%;"></canvas>
                    </div>
                    
                    <div>
                        <table id="progress_table" class="table table-border table-striped" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Percentage</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('click', '.workout', function(){
            $('#cust_name').empty();
            $('#progressrate').empty();
            $('#pro_percentage').empty();
            $('#wrk_name').empty();
            $('#wrk_desc').empty();
            $('.routine_btn').empty();
            $('#routine_content').empty();
            $('#pro_start').empty();
            $('#pro_end').empty();
            
            var log_id = $(this).attr("id");
            
            $.ajax({
                url:"datatable/dashboard/profile.php",
                method:"POST",
                dataType:"JSON",
                data:{log_id:log_id},
                success:function(data)
                {
                   $('#cust_name').text(data.cust_name);
                   $('#progressrate').append(data.progress);
                   $('#pro_percentage').text(data.pro_percentage);
                   $('#wrk_name').text(data.wrk_name);
                   $('#wrk_desc').text(data.wrk_desc);
                   $('#pro_start').text(data.pro_start);
                   $('#pro_end').text(data.pro_end);
                    
                    $('.routine_btn').append(data.routine_btn);
                    $('#routine_content').append(data.routine_content);
                }
            });
            
            $(document).on('click', '.activityprog', function(){
                var acp_id = $(this).attr("id");
                var action = $(this).attr("action");

                $.ajax({
                    url:"datatable/dashboard/activityprogress.php",
                    method:"POST",
                    data:{acp_id:acp_id,action:action},
                    success:function(data)
                    {
                       $.ajax({
                        url:"datatable/dashboard/profile.php",
                        method:"POST",
                        dataType:"JSON",
                        data:{log_id:log_id},
                        success:function(data)
                        {
                            $('#cust_name').empty();
                            $('#progressrate').empty();
                            $('#pro_percentage').empty();
                            $('#wrk_name').empty();
                            $('#wrk_desc').empty();
                            $('#pro_start').empty();
                            $('#pro_empty').empty();
                            $('.routine_btn').empty();
                            $('#routine_content').empty();
                            $('#cust_name').text(data.cust_name);
                            $('#progressrate').append(data.progress);
                            $('#pro_percentage').append(data.pro_percentage);
                           $('#wrk_name').text(data.wrk_name);
                           $('#wrk_desc').text(data.wrk_desc);
                           $('#pro_start').text(data.pro_start);
                           $('#pro_end').text(data.pro_end);
                            $('#routine_content').append(data.routine_content);
                            $('.routine_btn').append(data.routine_btn);
                        }
                    });
                    }
                });
            });
            
            $(document).on('click', '.finish', function(){
                var pro_id = $(this).attr("id");
                
                $.ajax({
                    url:"datatable/dashboard/finish.php",
                    method:"POST",
                    data:{pro_id:pro_id},
                    success:function(data)
                    {
                        location.reload();
                    }
                });
            });
        });
        
        $(document).on('click', '.add', function(){
            var log_id = $(this).attr("id");
            
            var workoutTable = $('#workout_data').DataTable({
                "processing":true,
                "serverSide":true,
                "order":[],
                "ajax":{
                    url:"datatable/dashboard/workout.php",
                    method:"POST",
                    data:{log_id:log_id}
                },
                "columnDefs":[
                    {
                        "targets":[0,1,2],
                        "orderable":false
                    },
                ],
                "paging": false,
                "bInfo": false,
                "bFilter": false
            });
            
            $('#workoutView').modal('show');
            
            $("#workoutView").on("hide.bs.modal", function() {
                workoutTable.destroy();
            });
            
            $(document).on('click', '.addworkout', function(e){
                var wrk_id = $(this).attr("id");

                if(confirm("Select this workout?")){
                    e.stopImmediatePropagation();
                    
                    $.ajax({
                        url:"datatable/dashboard/addworkout.php",
                        method:"POST",
                        data:{log_id:log_id,wrk_id:wrk_id},
                        success:function(data)
                        {
                            alert(data);
                            workoutTable.destroy();

                            clientTable.ajax.reload();

                            $('#workoutView').modal('hide');
                        }
                    });
                }
            });
        });
        
        function retrieve_clientinfo(cust_id){
            $.ajax({
                url:"../customer/datatable/profile/onload.php",
                method:"POST",
                data:{id:cust_id},
                dataType:"JSON",
                success:function(data)
                {
                    $('#cust_name_modal').text(data.cust_name);
                    $('#cust_email_modal').text(data.cust_email);
                }
            });
        }
        
        $(document).on('click', '.profile', function(){
            var cust_id = $(this).attr("id");
            
            retrieve_clientinfo(cust_id);
            
            $.ajax({
                url:"../customer/datatable/logs/chartdata.php",
                method:"POST",
                dataType:"JSON",
                data:{id:cust_id},
                success:function(data)
                {
                    var date = [];
                    var progress = [];

                    for(var i=0;i<data.length;i++){
                        date.push(data[i].log_date);
                        progress.push(data[i].pro_percentage);
                    }

                    var chartdata = {
                        labels: date,
                        datasets:[
                            {
                                label: 'Progress',
                                borderColor: '#b01f24',
                                data: progress,
                                backgroundColor: 'transparent',
                                lineTension: 0,
                                pointRadius: 5,
                                pointBackgroundColor: 'white',
                                borderWidth: 2,

                            }
                        ]
                    };

                    var ctx = document.getElementById("canvas").getContext("2d");

                    var lineGraph = new Chart(ctx,{
                        type: 'line',
                        data: chartdata,
                        options:{
                            scales:{
                                xAxes: [{
                                    display: true,
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Date'
                                    },
                                    ticks: {
                                        fontSize: 10,
                                        fontColor: 'lightgrey'
                                    }
                                }],
                                yAxes: [{
                                    display: true,
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Percentage'
                                    },
                                }]
                            }
                        },
                        responsive: true,
                        tooltips: {
                            backgroundColor: 'white'
                        }
                    });
                }
            });
            
            var progressTable = $('#progress_table').DataTable({
                "destroy":true,
                "processing":true,
                "serverSide":true,
                "order":[],
                "ajax":{
                    url:"../customer/datatable/logs/progress.php",
                    type: "POST",
                    data:{cust_id:cust_id},
                },
                "columnDefs":[
                    {
                        "targets":[0,1],
                        "orderable":false,
                    },
                ],
                "paging":false,
                "bInfo": false,
                "bFilter": false 
            });
            
            $.ajax({
                url:"../customer/datatable/logs/onload.php",
                method:"POST",
                dataType:"JSON",
                data:{id:cust_id},
                success:function(data)
                {
                     $('#avg_progress').empty();
                     $('#avg_progress').append(data.avg_progress);
                }
            });
            
            $('#progressView').modal('show');
        });
        
        var clientTable = $('#client_data').DataTable({
           "processing":true,
            "serverSide":true,
            "order":[],
            "ajax":{
                url:"datatable/dashboard/client.php",  
                method:"POST",
                data:{stf_id:<?php echo $_SESSION['id'];?>}
            },
            "columnDefs":[
                {
                    "targets":[0,1,2,3,4],
                    "orderable":false
                }
            ],
            "bInfo": false,
            "bFilter": false
        });
    });
</script>