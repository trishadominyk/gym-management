<div class="box">
<div id="staffcont">
		<div id="staffhead">
			<h3><img src="../../img/icon/stafficon.png"> Class Management</h3>
		</div>
		  <div class="btnright">
            <button type="button" id="add_button" data-toggle="modal" data-target="#classModal" class="btn btn-info btn-md">New Class</button>
        </div>
</div>
			<div class="table-responsive">
				<br />
				<table id="user_data" class="table table-bordered table-striped" style="text-align: center;">
					<thead>
						<tr >
							<th style="text-align: center;" width="7%">Name</th>

							<th  style="text-align: center;" width="6%">Action</th>

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
						<h4 class="modal-title">New Class</h4>
					</div>
					<div class="modal-body">
						<label>Name</label>
						<input type="text" name="clcname" id="clc_name" class="form-control" />
						<br />
					</div>
					<div class="modal-footer">
						<input type="hidden" name="clcid" id="clc_id" />
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
		$('.modal-title').text("New Class");
		$('#action').val("Add");
		$('#operation').val("Add");

	});

	var dataTable = $('#user_data').DataTable({
		"processing":true,
		"serverSide":true,
		"order":[],
		"ajax":{
			url:"datatable/class_settings/fetch.php",
			method:"POST"
		},
		"columnDefs":[
			{
				"targets":[0,1],
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
		var lvlid = $('#lvl_id').val();


		if(stfemail != '' && stffirst != '' && stflast != '' && stfcont !='')
		{
			$.ajax({
				url:"datatable/class_settings/insert.php",
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
			alert("All Fields are Required");
		}
	});

	$(document).on('click', '.update', function(){
		var clc_id = $(this).attr("id");
		$.ajax({
			url:"datatable/class_settings/fetch_single.php",
			method:'POST',
			data:{clc_id:clc_id},
			dataType:"JSON",
			success:function(data)
			{
				$('#classModal').modal('show');
				$('#clc_name').val(data.clc_name);
				$('.modal-title').text("Edit Class");
				$('#clc_id').val(clc_id);
				$('#action').val("Edit");
				$('#operation').val("Edit");
			}
		})
	});


	$(document).on('click', '.delete', function(){
		var eqp_id = $(this).attr("id");
		if(confirm("Are you sure you want to dispose this item?"))
		{
			$.ajax({
				url:"datatable/class_settings/dispose.php",
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
