<div class="box">
    <div id="svcscont">
  		<div id="staffhead">
  			<h3><img src="../../img/icon/membershipicon.png">Membership Type</h3>
  		</div>
  		<div class="btnright">
  					<button type="button" id="add_button" data-toggle="modal" data-target="#classModal" class="btn btn-info btn-md">New Membership Type</button>
          </div>
    </div>

	<div class="table-responsive">
        <br>
        <table id="user_data" class="table table-bordered table-striped">
            <thead>
				<tr>
				    <th width="18%">Name</th>
				    <th width="8%">Rate</th>
				    <th width="8%">Duration</th>
				    <th width="10%">Status</th>
                    <th width="10%">Action</th>
				</tr>
            </thead>
        </table>

    </div>
</div>

<div id="classModal" class="modal fade">
	<div class="modal-dialog">
		<form method="post" id="user_form" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add New Membership Type</h4>
				</div>
				<div class="modal-body">
					<label>Name</label>
					<input type="text" name="metname" id="met_name" class="form-control" />
					<br />
					<label>Rate</label>
					<input type="number" step="0.00" name="metrate" id="met_rate" class="form-control" />
					<br />
					<label>Duration (Days)</label>
					<input type="number" step="0.00" name="metduration" id="met_duration" class="form-control" />
					<br />

				</div>
				<div class="modal-footer">
					<input type="hidden" name="met_id" id="met_id" />
					<input type="hidden" name="operation" id="operation" />
					<input type="submit" name="action" id="action" class="btn btn-success" value="Add" />
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</form>
	</div>
</div>

<script type="text/javascript" language="javascript" >
$(document).ready(function(){
    $('#add_button').click(function(){
		$('#user_form')[0].reset();
		$('.modal-title').text("Add New Class");
		$('#action').val("Add");
		$('#operation').val("Add");

	});

	var dataTable = $('#user_data').DataTable({
		"processing":true,
		"serverSide":true,
		"order":[],
		"ajax":{
			url:"datatable/membership/fetch.php",
			method:"POST"
		},
		"columnDefs":[
			{
				"targets":[0,1, 2, 3,4],
				"orderable":false
			},
		],

	});

	$(document).on('submit', '#user_form', function(event){
		event.preventDefault();
		var metName = $('#met_name').val();
		var metRate = $('#met_rate').val();
		var metDuration = $('#met_duration').val();

		if(metName != '' && metRate != '' && metDuration != '')
		{
			$.ajax({
				url:"datatable/membership/insert.php",
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
		var met_id = $(this).attr("id");
		$.ajax({
			url:"datatable/membership/fetch_single.php",
			method:"POST",
			data:{met_id:met_id},
			dataType:"JSON",
			success:function(data)
			{
				$('#classModal').modal('show');
				$('#met_name').val(data.met_name);
				$('#met_rate').val(data.met_rate);
				$('#met_duration').val(data.met_duration);
				$('.modal-title').text("Edit Membership");
				$('#met_id').val(met_id);
				$('#action').val("Edit");
				$('#operation').val("Edit");
			}
		})
	});

	$(document).on('click', '.delete', function(){
		var met_id = $(this).attr("id");
		var action = $(this).attr("action");
		if(confirm("Are you sure you want to delete this?"))
		{
			$.ajax({
				url:"datatable/membership/delete.php",
				method:"POST",
				data:{met_id:met_id, action:action},
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
