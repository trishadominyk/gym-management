<head>
    <script src="../../js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
</head>

<div class="content-container">
    <div class="submenu-left list-nav">
        <h3>Clients</h3>
        
        <hr>
        
        <div>
            <h4>Filter Clients by:</h4>
            <ul class="list-nav">
                <a href="index.php?mod=client"><li>All</li></a>
                <a href="index.php?mod=client&sub=active"><li>Active Membership</li></a>
                <a href="index.php?mod=client&sub=expired"><li>Expired Membership</li></a>
                <a href="index.php?mod=client&sub=none"><li>No Membership</li></a>
                <hr>
                <a href="index.php?mod=client&sub=member"><li>Pending</li></a>
            </ul>
        </div>
    </div>

    <div class="mod-content">
        <div style="text-align: right; margin: 1%;">
            <button type="button" id="add_button" data-toggle="modal" data-target="#clientNew" class="btn btn-info btn-sm svg-middle"><?php echo file_get_contents('../../svg/ic_person_add.svg');?>&nbsp;New Client</button>
            
            <input type="text" name="cust_id" id="scan_id" class="form-control" style="width:160px;display:-webkit-inline-box;" placeholder="Scan ID" />
        </div>
        
        <div class="client-content box">
            <?php
                if($sub == 'member'){
                    require_once 'datatable/member/index.php';
                }
                else{
            ?>
            <span class="text-light">Clients > <?php echo $sub;?></span>
            <div class="table-responsive">
                <br/>

                <table id="client_data" class="table table-border table-striped" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th width="10%"></th>
                            <th width="10%">Membership</th>
                            <th>Email</th>
                            <th width="12%">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <?php
                }
            ?>
        </div>
    </div>
</div>

<div id="clientNew" class="modal fade">
	<div class="modal-dialog">
		<form method="post" id="user_form" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add New Client</h4>
				</div>
                
				<div class="modal-body">
					<label>First Name</label>
					<input type="text" name="custfname" id="cust_firstname" class="form-control" />
					<br />
					<label>Last Name</label>
					<input type="text" name="custlname" id="cust_lastname" class="form-control" />
					<br />
					<label>Email</label>
					<input type="text" name="custemail" id="cust_email" class="form-control" />
					<br />
                    <label>Birthday</label>
                    <input type="date" id="cust_birthday" name="custbirthday" class="form-control" />
                    <br />
                    <label>Contact Number</label>
                    <input type="text" id="cust_contact" name="custcontact" class="form-control" placeholder="Optional"/>
                    <br />
                    <label>Emergency Contact</label>
                    <input type="text" id="cust_emergency" name="custemergency" class="form-control" placeholder="Optional" />
                    <br />
                    <label>Password</label>
					<input type="password" autocomplete="off" name="custpassword" id="cust_password" class="form-control" />
					<br />
                    <label>Confirm Password</label>
					<input type="password" autocomplete="off" name="confirmpassword" id="confirm_password" class="form-control" />
					<br />
					
				</div>
				<div class="modal-footer">
					<input type="hidden" name="cust_id" id="cust_id" />
					<input type="hidden" name="operation" id="operation" />
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" name="action" id="action" class="btn btn-success" value="Add" />
				</div>
			</div>
		</form>
	</div>
</div>

<div id="recordView" class="modal fade">
	<div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Select class to time in</h4>
            </div>

            <div class="modal-body">
                <div class="table-responsive" id="client_record">
                    <table id='record_data' class='table table-border' style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Class</th><th>Sessions</th><th>Action</th>
                            </tr>
                        </thead>
                    </table>
                        
                    <table id='staff_data' style="width: 100%;" class="table">
                        <thead>
                            <tr><td colspan="2">Select a coach</td></tr>
                        </thead>
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

<div id="profileView" class="modal fade">
	<div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <form method="post" id="profile_form" enctype="multipart/form-data">
                    <div>
                        <h3>Profile Information</h3>
                    </div>
                    
                    <div id="profile-info">
                    </div>
                </form>
                
                <hr>
                
                <div class="table-responsive">
                    <h3>Transactions</h3>
                    <table id="transaction_table" class="table table-border table-striped" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Date  
                                    <select id="0" class="trans-search-input form-control input-sm" value="<?php echo date('Y');?>">
                                        <?php
                                            for($i=2016;$i<=date('Y');$i++){
                                        ?>
                                        <option value="<?php echo $i;?>" <?php if($i == date('Y')) echo 'selected';?>><?php echo $i;?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                </th>
                                <th>Code</th>
                                <th>Items</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

            <div class="modal-footer">
                    
            </div>
        </div>
	</div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip(); 
        
        var sub = '<?php echo $sub;?>';
        
        var dataTable = $('#client_data').DataTable({
            "processing":true,
            "serverSide":true,
            "order":[],
            "ajax":{
                url:"datatable/client/fetch.php",
                method:"POST",
                data:{sub:sub},
            },
            "columnDefs":[
                { orderable: false, targets: 0 },
                { orderable: false, targets: 1 },
                { orderable: false, targets: 2 },
                { orderable: true, targets: '_all' }
            ],
        });
        
        
        $('#add_button').click(function(){
            $('#user_form')[0].reset();
            $('.modal-title').text("Add New Client");
            $('#action').val("Add");
            $('#operation').val("Add");
        });
        
        $(document).on('submit', '#user_form', function(event){
            event.preventDefault();
            
            var custFirstname = $('#cust_firstname').val();
            var custLastname = $('#cust_lastname').val();
            var custEmail = $('#cust_email').val();
            var custPassword = $('#cust_password').val();
            var confirmPassword = $('#confirm_password').val();
            var custBirthday = $('#cust_birthday').val();
            
            if(custFirstname != '' && custLastname != '' && custEmail != '' && custPassword != '' && confirmPassword != '' && custBirthday != '')
            {
                if(custPassword == confirmPassword){
                    $.ajax({
                        url:"datatable/client/insert.php",
                        method:'POST',
                        data:new FormData(this),
                        contentType:false,
                        processData:false,
                        success:function(data)
                        {
                            alert(data);
                            $('#user_form')[0].reset();
                            
                            $("#clientNew").removeClass("in");
                            $(".modal-backdrop").remove();
                            $('#clientNew').hide();
                            
                            dataTable.ajax.reload();
                        }
                    });
                }
                else
                    alert("Passwords do not match. Try again.");
            }
            else
            {
                alert("Enter required fields.");
            }
        });
        
        $(document).on('click', '.view', function(){
            var cust_id = $(this).attr("id");
            timein(cust_id);
        });
        
        $(document).on('click', '.profile', function(){
            var cust_id = $(this).attr("id");
            
            $.ajax({
                url:"../customer/datatable/profile/onload.php",
                method:"POST",
                dataType:"JSON",
                data:{id:cust_id},
                success:function(data)
                {
                    $('#trns_total').text(data.trns_total);
                    $('#trns_all').text(data.trns_all);
                }
            });
            
            var transTable = $('#transaction_table').DataTable({
                "destroy":true,
                "processing":true,
                "serverSide":true,
                "order":[],
                "ajax":{
                    url:"../customer/datatable/transaction/fetch.php",
                    type: "POST",
                    data:{cust_id:cust_id},
                },
                "columnDefs":[
                    {
                        "targets":[0,1,2,3],
                        "orderable":false,
                    },
                ],
                "paging":false,
                "bInfo": false,
            });

            $("#transaction_table_filter").css("display","none");

            $('.trans-search-input').on('keyup click change', function(){   
                var i =$(this).attr('id');  // getting column index
                var v =$(this).val();  // getting search input value

                transTable.columns(i).search(v).draw();
            });
            
            get_customerinfo(cust_id);
        });
        
        $(document).on('click', '.barcode', function(){
            var cust_id = $(this).attr("id");
            
            window.open('datatable/client/barcode.php?id='+cust_id);
        });
        
        function get_customerinfo(cust_id){
            $.ajax({
                url:"../customer/datatable/profile/info.php",
                method:"POST",
                dataType:"JSON",
                data:{id:cust_id},
                success:function(data)
                {
                    $('#profile-info').empty();
                    $('#profile-info').append(data.profile);
                }
            });
        }
        
        $(document).on('submit', '#profile_form', function(event){
                event.preventDefault();

                var firstName = $("#firstName").val();
                var lastName = $("#lastName").val();
                var email = $("#email").val();
                var birthday = $("#birthday").val();
            
                var id = $("#edit_cust_id").val();
                
                if(firstName != null && lastName != null && email != null && birthday != null){
                    $.ajax({
                        url:"../customer/datatable/profile/edit.php",
                        method:'POST',
                        data:new FormData(this),
                        contentType:false,
                        processData:false,
                        success:function(data)
                        {
                            alert(data);
                           get_customerinfo(id);
                        }
                    });
                }
                else
                    alert('Please enter required fields.');
        });
        
        $("#profileView").on("hide.bs.modal", function (){
            $('#trns_total').empty();
            $('#trns_all').empty();
        });
        
        $('#scan_id').keydown(function(e){
            if (e.keyCode == 13) 
            {
                var cust_id = $('#scan_id').val();
                timein(cust_id);
            }
        });
        
        function timein(cust_id){
            $('#recordView').modal("show");
            $('#record_data').show();
            $('#staff_data').hide();
            
            var recordTable = $('#record_data').DataTable({
                "destroy":true,
                "processing":true,
                "serverSide":true,
                "order":[],
                "ajax":{
                    url:"datatable/client/record.php",
                    method:"POST",
                    data:{cust_id:cust_id}
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
            
            $('#recordView').modal('show');
            
            $("#recordView").on("hide.bs.modal", function (){
                $('#record_data').show();
                $('#staff_data').hide();
                
                recordTable.destroy();
                dataTable.ajax.reload();
            });        
        }
        
        $(document).on('click', '.timein', function(){
                var cust_id = $(this).attr("id");
                var rec_id = $(this).attr("rec");
                
                $('#record_data').hide();
                $('#staff_data').show();
                
                $.ajax({
                    url:"datatable/client/staff.php",
                    method:"POST",
                    dataType:"JSON",
                    data:{rec_id:rec_id},
                    success:function(data)
                    {
                        $('#stf_body').empty();
                        $('#stf_body').append(data.stf_body);
                    }
                });

                $(document).on('click', '.selectstaff', function(e){
                    var stf_id = $(this).attr("id");
                    
                    if(confirm("Time in client to logbook?"))
                    {
                        e.stopImmediatePropagation();
                        
                        $.ajax({
                            url:"datatable/client/timein.php",
                            method:"POST",
                            data:{cust_id:cust_id, rec_id:rec_id,stf_id:stf_id},
                            success:function(data)
                            {   
                                alert(data);
                                $('#stf_body').empty();
                                $('#stf_body').hide();
                                $('#client_record').show();
                                
                                $('#recordView').modal('hide');
                            }
                        });
                    }
                    else
                        return false;
                });
            });

            $(document).on('click', '.timeout', function(e){
                var cust_id = $(this).attr("id");
                var rec_id = $(this).attr("rec");

                if(!confirm("Time out client?")){
                    e.stopImmediatePropagation();
                    return false;
                }
                else{
                    $.ajax({
                        url:"datatable/client/timeout.php",
                        method:"POST",
                        data:{cust_id:cust_id, rec_id:rec_id},
                        success:function(data)
                        {
                            alert(data);
                            $('#record_data').DataTable().ajax.reload();
                            
                            $('#recordView').modal('hide');
                        }
                    });
                }
            });
    });
</script>