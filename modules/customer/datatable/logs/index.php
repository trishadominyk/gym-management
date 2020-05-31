<head>
    <script src="../../js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
</head>

<div class="content-container">
    <div class="log-statistics">
        <div class="stats-box box-gray box">
            <h4>Last Log</h4>
            <hr class="light">
            <span id="last_date">Date</span><br>
            <span id="last_class">Class</span><br>
            <span id="last_in">In</span><br>
            <span id="last_out">Out</span><br>
        </div>
        
        <div class="stats-box box-red box" id="class-stats">
            <?php
                $list = $client->get_enrolledclass($_SESSION['id']);
                if(!empty($list)){
                    foreach($list as $value){
            ?>
            <h4><?php echo $value['cls_name'];?></h4>
            <span>Session(s) remain: <?php echo $value['rec_session_remain'];?></span>
            <br>
            <?php
                    }
                }
            ?>
            
            <hr class="light">
            <p>Current Class</p>
        </div>
        
        <div class="stats-box box-dark box" id="avg_progress">
        </div>
        
        <div class="stats-box box-gray box">
            <p>Number of visits for <?php echo $month = date('F');?></p>
            <h3 id="visit_stats"></h3>
        </div>
    </div>
    
    <div class="log-summary">
        <div class="logbook-table table-responsive box">
            <h3>Logbook</h3>
            
            <table id="logbook_table" class="table table-border table-striped" style="width: 100%;">
                <thead>
                    <tr style="background-color: white; color: #b01f24;">
                        <td colspan="2" valign="middle">From: <input type="date" id="0" class="log-search-input form-control input-sm datepicker"></td>
                        <td colspan="3" valign="middle">To: <input type="date" id="1" class="log-search-input form-control input-sm datepicker"></td>
                    </tr>
                    <tr>
                        <th>Date</th>
                        <th>In</th>
                        <th>Out</th>
                        <th>Class</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    
    <div class="progress-tab">
        <div class="table-responsive box">
            <h3>Progress</h3>
            
            <div class="progress-chart">
                <?php require_once 'datatable/logs/progresschart.php';?>
            </div>
        </div>
    </div>
</div>

<div id="logDetails" class="modal fade">
    <div class="modal-dialog" style="width: 70%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>
            </div>

            <div class="modal-body">
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
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $.ajax({
            url:"datatable/logs/onload.php",
            method:"POST",
            dataType:"JSON",
            data:{id:'<?php echo $_SESSION["id"];?>'},
            success:function(data)
            {
                 $('#avg_progress').append(data.avg_progress);
                $('#visit_stats').text(data.visit_stats);
                
                $('#last_date').text(data.last_date);
                $('#last_class').text(data.last_class);
                $('#last_in').text(data.last_in);
                $('#last_out').text(data.last_out);
                
                var logTable = $('#logbook_table').DataTable({
                    "processing":true,
                    "serverSide":true,
                    "order":[],
                    "ajax":{
                        url:"datatable/logs/fetch.php",
                        type: "POST",
                        data:{cust_id:<?php echo $_SESSION['id'];?>},
                    },
                    "columnDefs":[
                        {
                            "targets":[0,1,2,3,4],
                            "orderable":true,
                        },
                    ],
                    "bInfo": false
                });
                    
                $("#logbook_table_filter").css("display","none");
                    
                $('.log-search-input').on('keyup click change', function(){   
                    var i =$(this).attr('id');  // getting column index
                    var v =$(this).val();  // getting search input value
                    
                    $(this).val(v); 

                    logTable.columns(i).search(v).draw();
                });
            }
        });
            
        $(document).on('click', '.details', function(){
            var log_id = $(this).attr("id");
            
            $.ajax({
                url:"datatable/dashboard/onload.php",
                method:"POST",
                data:{log_id:log_id},
                dataType:"JSON",
                success:function(data)
                {
                    $('.modal-title').text(data.log_date);
                    $('#rec_info').append(data.rec_info);
                    $('#log_timein').append(data.log_timein);
                    $('#log_progress').append(data.log_progress);

                    $('#wrk_name').text(data.wrk_name);
                    $('#wrk_desc').text(data.wrk_desc);
                }
             });
            
            $('#clientSearch').modal('show');
            
            var workoutTable = $('#workout_table').DataTable({
                "processing":true,
                "serverSide":true,
                "order":[],
                "ajax":{
                    url:"datatable/dashboard/fetch.php",
                    type: "POST",
                    data:{log_id:log_id}
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
            
            $("#logDetails").on("hide.bs.modal", function() {
                //$('body').removeClass('modal-open');
                $('.modal-backdrop').remove();

                $('.modal-title').empty();
                $('#rec_info').empty();
                $('#log_timein').empty();
                $('#log_progress').empty();

                $('#wrk_name').text('');
                $('#wrk_desc').text('');

                workoutTable.destroy();
            });
        });
    });
</script>