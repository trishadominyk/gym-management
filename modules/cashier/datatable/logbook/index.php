<head>
    <script src="../../js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
</head>

<div class="content-container">
    <div class="log-summary">
        <div class="box table-responsive logbook-type">
            <div style="clear:both; margin-bottom: 3%;">
                <span class="text-light">Logbook > Clients</span>
                <button type="button" id="staff_logbook" class="btn btn-xs btn-default toggle" style="float: right;">Switch to Staff Logbook</button>
            </div>
            
            <table id="logbook_table" class="table table-border table-striped" style="width: 100%;">
                <thead>
                    <tr style="background-color: white; color: #b01f24;">
                        <td colspan="2" valign="middle">From: <input type="date" id="0" class="log-search-input form-control input-sm datepicker"></td>
                        <td colspan="2" valign="middle">To: <input type="date" id="0" class="log-search-input form-control input-sm datepicker"></td>
                    </tr>
                    <tr>
                        <th width="15%">Date</th>
                        <th>Name</th>
                        <th>Time In</th>
                        <th>Time Out</th>
                        <th>Class</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
        
        <div class="box table-responsive logbook-type" style="display: none;">
            <div style="clear:both; margin-bottom:3%;">
                <span class="text-light">Logbook > Staff</span>
            
                <button type="button" id="staff_logbook" class="btn btn-xs btn-default toggle" style="float: right;">Switch to Client Logbook</button>
            </div>
            
            <div class="stflogbook-right">
                <table id="staff_logtable" class="table table-border table-striped" style="width: 100%;">
                    <thead>
                        <tr style="background-color: white; color: #b01f24;">
                            <td valign="middle">From: <input type="date" id="0" class="log-search-input form-control input-sm datepicker">
                            </td>
                            <td>
                                To: <input type="date" id="0" class="log-search-input form-control input-sm datepicker">
                            </td>
                        </tr>
                        <tr>
                            <th width="15%">Date</th>
                            <th>Name</th>
                            <th>Time In</th>
                            <th>Time Out</th>
                        </tr>
                    </thead>
                </table>
            </div>
            
            <div class="stflogbook-left">
                <h4>Select Staff</h4>
                <table class="table table-border" id="staff_table" style="width: 100%;">
                    <thead style="display:none;">
                        <tr>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    
    <div class="log-detail">
        <div class="box box-gray table-responsive">
            <h3>Client Record</h3>
            <hr>
            <ul>
                <li>Name: <span id="cust_name"></span></li>
                <li>Class: <span id="cls_name"></span></li>
                <li>Valid: <span id="rec_valid"></span></li>
                <li>Remaining Session(s): <span id="session_remain"></span></li>
            </ul>
        </div>
        <br>
        <div class="box box-dark table-responsive">
            <h3>Workout Plan</h3>
            <hr>
            <ul>
                <li id="stf_name" style="font-style:italic;text-align:center;"></li>
                <li><h4 id="wrk_name"></h4></li>
                <li id="act_name"></li>
            </ul>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        var logTable = $('#logbook_table').DataTable({
            "processing":true,
            "serverSide":true,
            "order":[],
            "ajax":{
                url:"datatable/logbook/fetch.php",
                type: "POST"
            },
            "columnDefs":[
                //{
                    { orderable: true, targets: 1 },
                    { orderable: true, targets: 2 },
                    { orderable: true, targets: 3 },
                    { orderable: false, targets: '_all' }
                //},
            ],
            "paging": false
        });
        
        $("#logbook_table_filter").css("display","none");
        
        var staffLogTable = $('#staff_logtable').DataTable({
            "processing":true,
            "serverSide":true,
            "order":[],
            "ajax":{
                url:"datatable/logbook/fetch_staff.php",
                type: "POST"
            },
            "columnDefs":[
                //{
                    { orderable: true, targets: 2 },
                    { orderable: true, targets: 3 },
                    { orderable: false, targets: '_all' }
                //},
            ],
            "paging": false
        });
        
        $("#staff_logtable_filter").css("display","none");
        
        $('.log-search-input').on('keyup click change', function(){   
            var i =$(this).attr('id');  // getting column index
            var v =$(this).val();  // getting search input value
            
            $(this).val(v); 
            
            logTable.columns(i).search(v).draw();
            staffLogTable.columns(i).search(v).draw();
        });
        
        var staffTable = $('#staff_table').DataTable({
            "processing":true,
            "serverSide":true,
            "order":[],
            "ajax":{
                url:"datatable/logbook/staff.php",
                type: "POST"
            },
            "columnDefs":[
                {
                    "targets":[0,1],
                    "orderable":false
                },
            ],
            "paging": false,
            "bInfo": false,
            "bFilter": false
        });
        
        $(document).on('click', '.details', function(){
            var rec_id = $(this).attr("rec");
            var log_id = $(this).attr("id");
            
            $.ajax({
                url:"datatable/logbook/fetch_detail.php",
                method:"POST",
                data:{rec_id:rec_id,log_id:log_id},
                dataType:"JSON",
                success:function(data)
                {
                    $('#cust_name').text(data.cust_name);
                    $('#cls_name').text(data.cls_name);
                    $('#rec_valid').text(data.rec_valid);
                    $('#session_remain').text(data.rec_session_remain);
                    
                    $('#stf_name').text(data.stf_name);
                    $('#wrk_name').text(data.wrk_name);
                    $('#act_name').empty();
                    $('#act_name').append(data.act_name);
                }
            })
        });
        
        $(document).on('click', '.timeout', function(e){
            var log_id = $(this).attr("id");
            var stf_id = $(this).attr("stfid");

            if(confirm("Log out client?"))
            {
                e.stopImmediatePropagation();
                
                $.ajax({
                    url:"datatable/client/timeout.php",
                    method:"POST",
                    data:{log_id:log_id,stf_id:stf_id},
                    success:function(data)
                    {
                        alert(data);
                        logTable.ajax.reload();
                    }
                });
            }
            else
                return false;
        });
        
        $(document).on('click', '.timeoutstaff', function(e){
            var stf_id = $(this).attr("id");

            if(confirm("Log out staff?"))
            {
                e.stopImmediatePropagation();
                
                $.ajax({
                    url:"datatable/client/timeout.php",
                    method:"POST",
                    data:{stf_id:stf_id},
                    success:function(data)
                    {
                        alert(data);
                        staffLogTable.ajax.reload();
                        staffTable.ajax.reload();
                    }
                });
            }
            else
                return false;
        });
        
        $(document).on('click', '.timein', function(e){
            var stf_id = $(this).attr("id");
            
            if(confirm("Time in coach?"))
            {
                e.stopImmediatePropagation();
                
                $.ajax({
                    url:"datatable/client/timein.php",
                    method:"POST",
                    data:{stf_id:stf_id},
                    success:function(data)
                    {
                        alert(data);
                        staffLogTable.ajax.reload();
                        staffTable.ajax.reload();
                    }
                });
            }
            else
                return false;
        });
    });
</script>


<script type="text/javascript">
    $('.toggle').click(function(){
        // Switches the forms  
        $('.logbook-type').animate({
            height: "toggle",
            'padding-top': 'toggle',
            'padding-bottom': 'toggle',
            opacity: "toggle"
        }, "slow");
    });
</script>