<head>
    <script src="../../js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
</head>

        <div style="text-align: right; margin: 1%;">
            <button type="button" id="add_button" data-toggle="modal" data-target="#clientNew" class="btn btn-info btn-sm svg-middle"><?php echo file_get_contents('../../svg/ic_person_add.svg');?>&nbsp;New Client</button>
            
            <input type="text" name="cust_id" id="scan_id" class="form-control" style="width:160px;display:-webkit-inline-box;" placeholder="Scan ID" />
        </div>
        
        <div class="box">
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

<div id="profileView" class="modal fade">
	<div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Profile Information</h4>
            </div>

            <div class="modal-body">
                <form method="post" id="profile_form" enctype="multipart/form-data">
                    <div id="profile-info">
                    </div>
                </form>
            </div>
            
            <div class="modal-footer">
                    
            </div>
        </div>
	</div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
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
        
        $(document).on('click', '.profile', function(){
            var cust_id = $(this).attr("id");
            get_customerinfo(cust_id);
            
        });
        
        $('#scan_id').keydown(function(e){
            if (e.keyCode == 13) 
            {
                var cust_id = $('#scan_id').val();
                get_customerinfo(cust_id);
            }
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
                    
                    $('#profileView').modal('show');
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
        
        $('[data-toggle="tooltip"]').tooltip(); 
        
        $(document).on('click', '.barcode', function(){
            var cust_id = $(this).attr("id");
            window.open('../../modules/cashier/datatable/client/barcode.php?id='+cust_id);
        });
        
        $(document).on('click', '.update', function(){
            var id = $(this).attr("id");
            var action = $(this).attr("action");
            
            $.ajax({
                url:"datatable/client/update.php",
                method:"POST",
                data:{id:id,action:action},
                success:function(data)
                {
                    alert(data);
                    dataTable.ajax.reload();
                }
            });
        });
    });
</script>