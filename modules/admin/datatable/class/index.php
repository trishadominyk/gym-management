 <div class="box">
    <div id="svcscont">
      <div id="staffhead">
                <h3><img src="../../img/icon/classicon.png"> Class Types</h3>
      </div>
      <div class="btnright">
                <button type="button" id="add_button" data-toggle="modal" data-target="#classModal" class="btn btn-info btn-md">New Class</button>
      </div>

    </div>

    <div class="table-responsive">
        <br />
        <table id="user_data" class="table table-bordered table-striped" style="width: 100%;">
            <thead>
                <tr>
                    <th width="6%">Name</th>
                    <th width="7%">Description</th>
                    <th width="8%">Rate</th>
                    <th width="5%">Session</th>
                    <th width="8%">Category</th>
                    <th width="5%">Status</th>
                    <th width="9%">Action</th>
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
                    <h4 class="modal-title">Add New Class</h4>
                </div>

                <div class="modal-body">
                    <label>Name</label>
                    <input type="text" name="clsname" id="cls_name" class="form-control" />
                    <br>

                    <label>Description</label>
                    <textarea name="clsdesc" id="cls_desc" class="form-control"> </textarea>
                    <br>

                    <label>Rate</label>
                    <input type="number" step="0.00" name="clsrate" id="cls_rate" class="form-control" />
                    <br>

                    <label>Sessions</label>
                    <input type="number" step="0.00" name="clssessions" id="cls_sessions" class="form-control"/>
                    <br>

                    <label>Category</label>
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
                    <input type="hidden" name="cls_id" id="cls_id" />
                    <input type="hidden" name="operation" id="operation" />
                    <input type="submit" name="action" id="action" class="btn btn-success" value="Add" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript" language="javascript">
$(document).ready(function(){

    var dataTable = $('#user_data').DataTable({
		"processing":true,
		"serverSide":true,
		"order":[],
		"ajax":{
			url:"datatable/class/fetch.php",
			method:"POST"
		},
		"columnDefs":[
			{
				"targets":[0,1,2,3,4,5,6],
				"orderable":false,
			},
		],

	});

	$('#add_button').click(function(){
		$('#user_form')[0].reset();
		$('.modal-title').text("Add New Class");
		$('#action').val("Add");
		$('#operation').val("Add");
	});

	$(document).on('submit', '#user_form', function(event){
		event.preventDefault();
		var clsName = $('#cls_name').val();
		var clsRate = $('#cls_rate').val();

		var clsSessions = $('#cls_sessions').val();
		var clcid = $('#clc_id').val();
		if(clsName != '' && clsRate != '' && clsSessions != '' && clcid != '')
		{
			$.ajax({
				url:"datatable/class/insert.php",
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
		var cls_id = $(this).attr("id");
		$.ajax({
			url:"datatable/class/fetch_single.php",
			method:"POST",
			data:{cls_id:cls_id},
			dataType:"JSON",
			success:function(data)
			{
				$('#classModal').modal('show');
				$('#cls_name').val(data.cls_name);
				$('#cls_rate').val(data.cls_rate);
        $('#cls_desc').val(data.cls_desc);
				$('#cls_sessions').val(data.cls_sessions);
				$('#clc_id').val(data.clc_id);
				$('.modal-title').text("Edit Class");
				$('#cls_id').val(cls_id);
				$('#action').val("Edit");
				$('#operation').val("Edit");

			}
		})
	});

	$(document).on('click', '.delete', function(){
		var cls_id = $(this).attr("id");
		var action = $(this).attr("action");
		if(confirm("Are you sure you want to continue?"))
		{
			$.ajax({
				url:"datatable/class/delete.php",
				method:"POST",
				data:{cls_id:cls_id,action:action},
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
