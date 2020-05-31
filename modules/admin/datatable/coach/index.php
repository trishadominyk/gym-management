<div class="box">
<div id="staffcont">
		<div id="staffhead">
			<h3><img src="../../img/icon/stafficon.png"> Coach Management</h3>
		</div>
</div>
			<div class="table-responsive">
				<br />
				<table id="user_data" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th width="9%">Email</th>
							<th width="10%">Last, First Name</th>
							<th width="10%">Mobile No.</th>

							<th width="8%">Action</th>

						</tr>
					</thead>
				</table>

			</div>

	<div id="clientSearch" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="user_form" action="index.php?mod=enroll" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Class</h4>
                </div>

                <div class="modal-body">
                    <div class="box table-responsive" id="client_search">


                        <table id="class_data" class="table table-border table-striped" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
	<div id="classModal" class="modal fade">
		<div class="modal-dialog">
			<form method="post" id="class_form" enctype="multipart/form-data">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">New Class</h4>
					</div>
					<div class="modal-body">

						<label>Class Name</label>
						<br/>
							<select style="width: 50%;" name="clcid" id="clc_id" class="form-control" required>
								<?php
									$clclist = $category->fnGetClassCategory();
									foreach($clclist as $value){
										if($value)
									?>
										<option value="<?php echo $value['clc_id'];?>">
										<?php echo $value['clc_name'];?>
										</option>
									<?php
									}
								?>
							</select>

					</div>
					<div class="modal-footer">
						 <input type="hidden" name="stfid" id="stf_id" value=""/>
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

	$(document).on('click', '.add', function(){
		$('#class_form')[0].reset();
		$('.modal-title').text("New Class");
		$('#action').val("Add");
		$('#operation').val("Add");
		$('#classModal').modal('show');

		var stf_id = $(this).attr("id");
		var stfid = $('#stf_id').val(stf_id);

		$(document).on('submit', '#class_form', function(event){
			event.preventDefault();
			if(stfid != '')
			{
				$.ajax({
					url:"datatable/coach/insert.php",
					method:'POST',
					data:new FormData(this),
					contentType:false,
					processData:false,
					success:function(data)
					{

						$('#class_form')[0].reset();
						$('#classModal').modal('hide');
						dataTable.ajax.reload();
						alert(data);

					}
				});
			}
			else
			{
				alert("All Fields are Required");
			}
		});

	});

	var dataTable = $('#user_data').DataTable({
		"processing":true,
		"serverSide":true,
		"order":[],
		"ajax":{
			url:"datatable/coach/fetch.php",
			method:"POST"
		},
		"columnDefs":[
			{
				"targets":[0,1, 2, 3],
				"orderable":false
			},
		],

	});



	$(document).on('click', '.viewclass', function(){
		var stf_id = $(this).attr("id");


		var classTable = $('#class_data').DataTable({
			"processing":true,
			"serverSide":true,
			"order":[],
			"ajax":{
				url:"datatable/coach/fetch_single.php",
				method:"POST",
				data:{stf_id:stf_id}
			},
			"columnDefs":[
				{
					"targets":[0],
					"orderable":false
				},
			],
			 "paging": false,
                "bInfo": false,
                "bFilter": false

		});

		$('#clientSearch').modal('show');

		$("#clientSearch").on("hide.bs.modal", function () {
                classTable.destroy();
            });


	});



	$(document).on('click', '.delete', function(){
		var eqp_id = $(this).attr("id");
		if(confirm("Are you sure you want to dispose this item?"))
		{
			$.ajax({
				url:"datatable/coach/dispose.php",
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
