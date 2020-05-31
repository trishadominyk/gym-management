<head>
    <script src="../../js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
</head>

<div class="content-container">
    <div class="submenu-left list-nav" style="position:unset;">
        <h3>Classes</h3>
        
        <hr>
        
        <div id="class_nav">
            
        </div>
    </div>
    
    <div class="mod-content">
        <div class="box table-responsive">
            <span id="cls_name" class="text-light"></span>
            <br>
            <br>
            
            <table id="class_table" class="table table-border table-striped" style="width: 100%;">
                <thead>
                    <tr>
                        <th width="5%"></th>
                        <th>Name</th>
                        <th>Membership</th>
                        <th>Valid</th>
                        <th>Sessions</th>
                        <th>Last Log</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div id="progressView" class="modal fade">
	<div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title" id="cust_name_modal"></h3>
                <span>Email: <span id="cust_email_modal"></span></span><br>
                <span>Contact: <span id="cust_contact_modal"></span></span><br>
                <span>In case of emergency: <span id="cust_emergency_modal"></span></span><br>
                <span>Birthday: <span id="cust_birthday_modal"></span></span><br>
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


<script type="text/javascript">
    $(document).ready(function(){
        $.ajax({
            url:"datatable/class/onload.php",
            method:"POST",
            data:{id:'<?php echo $_SESSION['id'];?>', cls_id:'<?php echo $sub;?>'},
            dataType:"JSON",
            success:function(data)
            {
                $('#cls_name').text(data.cls_name);
                $('#class_nav').append(data.list_nav);
                
                var classTable = $('#class_table').DataTable({
                    "processing":true,
                    "serverSide":true,
                    "order":[],
                    "ajax":{
                        url:"datatable/class/fetch.php",
                        type: "POST",
                        data:{cls_id:<?php echo $sub;?>}
                    },
                    "columnDefs":[
                        //{
                            { orderable: true, targets: 0 },
                            { orderable: true, targets: 1 },
                            { orderable: false, targets: '_all' }
                        //},
                    ],
                });
            }
        });
                
        function retrieve_clientinfo(cust_id){
            $.ajax({
                url:"../customer/datatable/profile/onload.php",
                method:"POST",
                data:{id:cust_id},
                dataType:"JSON",
                success:function(data)
                {
                    $('#cust_name_modal').empty();
                    $('#cust_email_modal').empty();
                    $('#cust_contact_modal').empty();
                    $('#cust_emergency_modal').empty();
                    $('#cust_birthday_modal').empty();
                    
                    $('#cust_name_modal').text(data.cust_name);
                    $('#cust_email_modal').text(data.cust_email);
                    $('#cust_contact_modal').text(data.cust_contact);
                    $('#cust_emergency_modal').text(data.cust_emergency);
                    $('#cust_birthday_modal').text(data.cust_birthday);
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
    });
</script>