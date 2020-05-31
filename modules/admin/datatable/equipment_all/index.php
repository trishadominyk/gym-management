<div class="box">
    <div id="svcscont">
        <div id="staffhead">
            <h2><img src="../../img/icon/equipmentsicon.png"> Equipments</h2>
        </div>

        <div class="btnright">
            <button type="button" id="add_button" data-toggle="modal" data-target="#classModal" class="btn btn-info btn-md">New Equipment</button>
        </div>
    </div>


    <div class="table-responsive">
        <br />
        <table id="user_data" class="table table-bordered table-striped" style="width: 100%;">
            <thead>
                <tr>
                    <th width="15%">Serial</th>
                    <th width="8%">Name</th>

                    <th width="8%">Category</th>
                    <th width="8%">Action</th>
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
						<label>Name</label>
						<input type="text" name="eqpname" id="eqp_name" class="form-control" />
						<br />
						<label>Quantity</label>
						<input type="number" name="eqpqty" id="eqp_qty" class="form-control" />
						<br />
						<label>Category</label>
						<br/>
						<select style="width: 50%;" name="catid" id="cat_id" class="form-co ntrol" required>
							<?php


								$catlist = $category->get_category();
								foreach($catlist as $value){
								?>
									<option value="<?php echo $value['cat_id'];?>">
									<?php echo $value['cat_name'];?>
									</option>
								<?php
								}
							?>
						</select>

					</div>
					<div class="modal-footer">
						<input type="hidden" name="stf_id" id="stf_id" />

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
		$('.modal-title').text("New Equipment");
		$('#action').val("Add");
		$('#operation').val("Add");

	});

	var dataTable = $('#user_data').DataTable({
		"processing":true,
		"serverSide":true,
		"order":[],
		"ajax":{
			url:"datatable/equipment_all/fetch.php",
			method:"POST"
		},
		"columnDefs":[
			{
				"targets":[0,1, 2, 3],
				"orderable":false
			},
		],

	});

	$(document).on('submit', '#user_form', function(event){
		event.preventDefault();
		var eqpname = $('#eqp_name').val();
		var eqpqty = $('#eqp_qty').val();
		var catid = $('#cat_id').val();


		if(eqpname != '' && eqpqty != '' && catid != '')
		{
			$.ajax({
				url:"datatable/equipment_all/insert.php",
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
		var eqp_id = $(this).attr("id");
		var action = $(this).attr("action");

		if(confirm("Are you sure you want to " + action + "?"))
		{
			$.ajax({
				url:"datatable/equipment_all/update_single_eqp.php",
				method:"POST",
				data:{eqp_id:eqp_id, action:action},
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

	$(document).on('click', '.delete', function(){
		var eqp_id = $(this).attr("id");
		if(confirm("Are you sure you want to dispose this item?"))
		{
			$.ajax({
				url:"datatable/equipment_all/dispose.php",
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
