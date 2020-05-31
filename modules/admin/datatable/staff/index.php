	<div class="box">
<div id="staffcont">
		<div id="staffhead">
			<h3><img src="../../img/icon/stafficon.png"> Staff Management</h3>
		</div>
		  <div class="btnright">
            <button type="button" id="add_button" data-toggle="modal" data-target="#classModal" class="btn btn-info btn-md">New Staff</button>
        </div>
</div>
			<div class="table-responsive">
				<br />
				<table id="user_data" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th width="7%">Email</th>
							<th width="8%">Last, First Name</th>
							<th width="8%">Mobile No.</th>
							<th width="8%">Staff Type</th>
							<th width="6%">Action</th>

						</tr>
					</thead>
				</table>

			</div>


	<div id="classModal" class="modal fade">
		<div class="modal-dialog">
			<form method="post" id="user_form" enctype="multipart/form-data">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">New Equipment</h4>
					</div>
					<div class="modal-body">
						<label>Email</label>
						<input type="text" name="stfemail" id="stf_email" class="form-control" />
							<span id="check_email"></span>
						<br />

						<label>First Name</label>
						<input type="text" name="stffirst" id="stf_firstname" class="form-control" />
						<br />
						<label>Last Name</label>
						<input type="text" name="stflast" id="stf_lastname" class="form-control" />
						<br />
						<label>Mobile No.</label>
						<input type="number" name="stfcont" id="stf_contact" class="form-control" />
						<br />
						<div id="pass">
						<label>Password</label>
						<input type="password" name="stfpas" id="stf_pas" class="form-control" />
						<br />
						</div>
						<div id="confirmpass">
						<label>Confirm Password</label>
						<input type="password" name="stfconpas" id="stf_conpas" class="form-control" />
						<br />
						</div>
						<label>Staff Type</label>
						<br/>
							<select style="width: 50%;" name="lvlid" id="lvl_id" class="form-control" required>
								<?php
									$stflist = $staff->fnGetStaffLvl();
									foreach($stflist as $value){
										if($value)
									?>
										<option value="<?php echo $value['lvl_id'];?>">
										<?php echo $value['lvl_name'];?>
										</option>
									<?php
									}
								?>
							</select>

					</div>
					<div class="modal-footer">
						<input type="hidden" name="stfid" id="stf_id" />
						<input type="hidden" name="operation" id="operation" />
						<input type="submit" name="action" id="action" class="btn btn-success" value="Add" />
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript" language="javascript" >
$(document).ready(function(){

	$('#add_button').click(function(){
		$('#user_form')[0].reset();
		$('.modal-title').text("New Staff");
		$('#action').val("Add");
		$('#operation').val("Add");

	});

	$('#stf_email').on('keyup click change', function(){
		var stfemail = $('#stf_email').val();
		$.ajax({
			url: "datatable/staff/process.php",
			method:'POST',
			data:{stfemail:stfemail},
			success:function(data)
			{
				$('#check_email').html(data);
			}
		});
	});

	var dataTable = $('#user_data').DataTable({
		"processing":true,
		"serverSide":true,
		"order":[],
		"ajax":{
			url:"datatable/staff/fetch.php",
			method:"POST"
		},
		"columnDefs":[
			{
				"targets":[0,1, 2, 3, 4],
				"orderable":false
			},
		],

	});

	$(document).on('submit', '#user_form', function(event){
		event.preventDefault();
		var stfemail = $('#stf_email').val();
		var stffirst = $('#stf_firstname').val();
		var stflast = $('#stf_lastname').val();
		var stfcont = $('#stf_contact').val();
		var stfpas = $('#stf_pas').val();
		var stfconpas = $('#stf_conpas').val();
		var lvlid = $('#lvl_id').val();

		if(stfpas == stfconpas){
			if(stfemail != '' && stffirst != '' && stflast != '' && stfcont !='')
		{
			$.ajax({
				url:"datatable/staff/insert.php",
				method:'POST',
				data:new FormData(this),
				contentType:false,
				processData:false,
				success:function(data)
				{
					$('#user_form')[0].reset();
					$('#classModal').modal('hide');
					dataTable.ajax.reload();
				}
			});
		}
		else
		{
			alert("Please fill up all information required.");
		}
		}else
			alert("Password doesn't match. Please try again.");




	});

	$(document).on('click', '.update', function(){
		var stf_id = $(this).attr("id");
		$.ajax({
			url:"datatable/staff/fetch_single.php",
			method:'POST',
			data:{stf_id:stf_id},
			dataType:"JSON",
			success:function(data)
			{
				$('#classModal').modal('show');
				$('#stf_email').val(data.stf_email);
				$('#stf_lastname').val(data.stf_lastname);
				$('#stf_firstname').val(data.stf_firstname);
				$('#stf_contact').val(data.stf_contact);
				$('#lvl_id').val(data.lvl_id);
				$('.modal-title').text("Edit Staff");
				$('#stf_id').val(stf_id);
				$('#action').val("Edit");
				$('#operation').val("Edit");
				var pass = document.getElementById('pass');
				pass.style.display = "none";
				var confirmpass = document.getElementById('confirmpass');
				confirmpass.style.display = "none";


			}
		})
	});





	$(document).on('click', '.delete', function(){
		var eqp_id = $(this).attr("id");
		if(confirm("Are you sure you want to dispose this item?"))
		{
			$.ajax({
				url:"datatable/staff/dispose.php",
				method:"POST",
				data:{eqp_id:eqp_id},
				success:function(data)
				{
					alert(data);
					dataTable.ajax.reload();
				}
			});
		}
		else
		{
			return false;
		}
	});




});
</script>
