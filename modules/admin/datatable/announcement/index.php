<div class="box-booking">
    <div id="booking-cont">
        <div id="booking" class="box">
            <div class="table-responsive">
                <h3>Announcements <button type="button" id="btn-add-ann" data-toggle="modal" data-target="#annModal" class="btn btn-info btn-sm" style="float:right; ">New Announcement</button></h3>

                <table id="announcement_data" class="table table-bordered table-striped" style="background-color:white;">

                </table>
            </div>
        </div>
        <br>
    </div>


</div>

<div id="annModal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="ann_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">New announcement</h4>
                </div>

                <div class="modal-body">
                    <label>Title</label>
                    <input type="text" name="anntitle" id="ann_title" class="form-control" required/>
                    <br>

                    <label>Content</label>
                    <textarea name="anncontent" rows="5" cols="80" class="form-control" id="ann_content" required></textarea>
                    <br>

                    <label>Date</label>
                    <input type="date" name="anndate" id="ann_date" class="form-control" required />
                    <br>

                </div>

                <div class="modal-footer">
                    <input type="hidden" name="annid" id="ann_id" />
                    <input type="hidden" name="operation-ann" id="operation-ann" />
                    <input type="submit" name="action-ann" id="ann-action" class="btn btn-success" value="Add" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript" language="javascript" >
$(document).ready(function(){

  var today = new Date().toISOString().split('T')[0];
  document.getElementsByName("anndate")[0].setAttribute('min', today);


	$('#btn-add-ann').click(function(){
		$('#ann_form')[0].reset();
		$('.modal-title').text("Add New Event");
		$('#btn-add-ann').show();
		$('#ann-action').val("Add");
    $('#operation-ann').val("Add");
	});

	var dataTable = $('#announcement_data').DataTable({
	  processing:true,
		serverSide:true,
		order:[],
		ajax:{
			url:"datatable/announcement/fetch.php",
			method:"POST"
		},

		"columnDefs":[
       { "width": "84%", "targets": 0 },
			{
        "targets":[0,1],
				"orderable":false,
        "display": false
			},
		],
        "bInfo": false,
        "iDisplayLength": 3
	});

    $("#announcement_data_filter").css("display","none");
  $("#announcement_data thead").css("display","none");

    $("#announcement_data").css("width","100%");
    $("#announcement_data_length").css("display","none");

	$(document).on('click', '.edit', function(){
		var ann_id = $(this).attr("id");
		$.ajax({
			url:"datatable/announcement/fetch_single.php",
			method:"POST",
			data:{ann_id:ann_id},
			dataType:"JSON",
			success:function(data)
			{
				$('#annModal').modal('show');
				$('#ann_title').val(data.ann_title);
				$('#ann_content').val(data.ann_content);
        $('#ann_date').val(data.ann_date);
				$('.modal-title').text("Event Details");
				$('#ann_id').val(ann_id);
				$('#ann-action').val("Edit");
				$('#operation-ann').val("Edit");


			}
		})
	});//click ka update pre


	//para ni mag cancel event frey
	$(document).on('click', '.cancel', function(){
		var id = $(this).attr("id");
		if(confirm("Are you sure you want to cancel this event?"))
		{
			$.ajax({
				url:"datatable/announcement/delete.php",
				method:"POST",
				data:{
					'cancel': 1,
					'id': id
				},
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

  $(document).on('submit', '#ann_form', function(event){
    event.preventDefault();
    var annTitle = $('#ann_title').val();
    var annContent = $('#ann_content').val();
    var annDate = $('#ann_date').val();

    if(annTitle != '' && annContent != '' && annDate != '')
    {
      $.ajax({
        url:"datatable/announcement/insert.php",
        method:'POST',
        data:new FormData(this),
        contentType:false,
        processData:false,
        success:function(data)
        {
          $('#ann_form')[0].reset();
          $('#annModal').modal('hide');
          dataTable.ajax.reload();
        }
      });
    }
    else
    {
      alert("All Fields are Required");
    }
  });





});
</script>
