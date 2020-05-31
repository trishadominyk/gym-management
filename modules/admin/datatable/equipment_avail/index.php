<div class="box">
    <div id="svcscont">
        <div id="eqpavail"> 
            <h2><img src="../../img/icon/equipmentsicon.png"> Available Equipments</h2>
        </div>


    </div>


    <div class="table-responsive">
        <br />
        <table id="user_data" class="table table-bordered table-striped" style="width: 100%;">
            <thead>
                <tr>
                    <th>Serial</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th width="15%">Action</th>
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
					<select style="width: 50%;" name="catid" id="cat_id" class="form-control" required>
						<?php


							$catlist = $category->fnGetCategory();
							foreach($catlist as $value){
							?>
								<option value="<?php echo $value['cat_id'];?>">
								<?php echo $value['cat_name'];?>
								</option>
							<?php
							}
						?>
					</select>

					<button type="button" id="" data-toggle="modal" data-target="" class="btn btn-success btn-lg"> +</button>

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
			url:"datatable/equipment_avail/fetch.php",
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
				url:"datatable/equipment_avail/insert.php",
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
				url:"datatable/equipment_avail/update_single_eqp.php",
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
				url:"datatable/equipment_avail/dispose.php",
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
