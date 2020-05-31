<div class="box-booking">
        <div id="eventbookingcont" class="box">
            <div class="table-responsive" style="margin-top:3%;">
                <h3>Upcoming Events <button type="button" id="add_button" data-toggle="modal" data-target="#bookEvnModal" class="btn btn-info btn-sm" style="float:right;">New Event</button></h3>

                <table id="user_data" class="table table-bordered table-striped" style="background-color:white;">
                    <thead>
                        <tr style="background-color: white; color: #b01f24;">
                    
                            <td class="date_today" style="text-align: right; vertical-align: middle;    " width="30%"><?php echo file_get_contents('../../svg/ic_today.svg');?>&nbsp;Today: <?php echo date('l, M d, Y');?></td>
                        </tr>
                        <tr>
                            <th width="5%">Name</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

    <div id="calendarFinal-booking">
		<?php require_once 'dashboard/calendarFinal/index.php';?>
	</div>
</div>





<div id="bookEvnModal" class="modal fade">
	<div class="event-modal-dialog">
		<form method="post" id="user_form" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add New Class</h4>
				</div>
				<div class="event-modal-body">

          <label>Upload Poster</label>
					<input type="file" name="evnimg" id="evn_image" class="form-control" />
					<br />
					<label>Name</label>
					<input type="text" name="evnname" id="evn_name" class="form-control" />
					<br />
					<label>Description</label>
					<textarea name="evndesc" id="evn_desc" class="form-control" > </textarea>
					<br />

				</div>


				<div><span id="check_date"></span></div>
				<table id="multiple-input-table">

				<thead>
						<tr>
							<th>Date</th>
							<th>Start</th>
							<th>End</th>
							<th>Venue</th>
							<th>Action</th>

						</tr>
				</thead>

				<tbody id="table-input">
					<tr>
						<td><input type="date" name="date[]" id="date-add" class="date date-change"/></td>
						<td><input type="time" name='starttime[]' class="starttime date-change" id="starttime"></td>
						<td> <input type="time" name='endtime[]' class='endtime date-change' id="endtime"></td>
						<td><input type="text" name="venue[]" placeholder="Venue" class="venue" id="venue"></td>
						<td><center> <button type="button" name="add" id="add" class="btn btn-success btn-xs add">+</button> </center></td>
					</tr>

				</tbody>
					</table>

				<div class="event-modal-footer">
					<input type="hidden" name="evnid" id="evn_id" />
					<input type="hidden" name="operation" id="operation"  />
					<input type="submit" name="action" id="action-add" class="btn btn-success" value="Add" />
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</form>
	</div>
</div>


<div id="bookEvnModal-details" class="modal fade">
	<div class="event-modal-dialog">
		<form method="post" id="user-form-details" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Event Details</h4>
				</div>
        <div id="evn-img-details">

        </div>

				<div class="event-modal-body-edit">


          <br/>
					<label>Name</label>
					<input type="text" name="evnnamedetails" id="evn_name_details" class="form-control" />
					<br />
					<label>Description</label>
					<textarea type="text" name="evndescdetails" id="evn_desc_details" class="form-control"> </textarea>
					<br />

				</div>
				<div id="multiple-input">
          <br>
					<table id="multiple-input-table-details" style="width: 100%;">
						<thead>
							<tr>
								<th>Date</th>
								<th>Start</th>
								<th>End</th>
								<th>Venue</th>
								<th>Action</th>

							</tr>
						</thead>
						<tbody id="table_evn_details">
						</tbody>
						<tr>
							<td> <input type='date' name='date[]' id="date-single" class='date-single'/></td>
							<td><input type='time' name='starttime[]' class='starttime-single' id='starttime-single'></td>
							<td> <input type='time' name='endtime[]' class='endtime-single' id='endtime-single'></td>
							<td><input type='text' name='venue[]' placeholder='Venue' class='venue-single' id='venue-single'></td>
							<td> <button type='button' name='remove' data-row='row' class='btn btn-success btn-xs add-single'>+</button></td>
						</tr>
					</table>
				</div>
				<div class="event-modal-footer">
					<input type="hidden" name="evniddetails" id="evn_id_details" />
					<input type="hidden" name="operation" id="operation-details"  />
					<input type="submit" name="action" id="action-details" class="btn btn-success" value="Save" />
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript" language="javascript" >
$(document).ready(function(){

  var today = new Date().toISOString().split('T')[0];
  document.getElementsByName("date[]")[0].setAttribute('min', today);

  $('.endtime').on('change', function(){
      var timestart = $('.starttime').val();
      var endtime = $('.endtime').val();

      if (endtime < timestart){
        alert("End-time is greater than time start-time.");
        $('#action-add').prop('disabled', true);
      }else{
        $('#action-add').prop('disabled', false);
      }

  });

  $('.endtime-single').on('change', function(){
      var timestart = $('#starttime-single').val();
      var endtime = $('#endtime-single').val();

      if (endtime < timestart){
        alert("End-time is greater than time start-time.");
        $('#action').prop('disabled', true);
      }else{
        $('#action').prop('disabled', false);
      }

  });




	$('#add_button').click(function(){
		$('#user_form')[0].reset();
		$('.modal-title').text("Add New Event");
		$('#action-add').show();
			$('#action-add').val("Add");
      $('#operation').val("Add");


	});


	$('.date-change').on('key-up click change', function(){


		var date = $('#date-add').val();
		var start = $('#starttime').val();
		var end = $('#endtime').val();



		$.ajax({
			url: "datatable/booking/process.php",
			method:'POST',
			data:{
				checkdate: 1,
				date: date,
				start: start,
				end: end
			},
			success:function(data)
			{
				$('#check_date').html(data);
			}
		});
	});

	var dataTable = $('#user_data').DataTable({
		"processing":true,
		"serverSide":true,
		"order":[],
		"ajax":{
			url:"datatable/booking/fetch.php",
			method:"POST"
		},
		"columnDefs":[
			{
				"targets":[0,1],
				"orderable":false,
			},
		],
        "bInfo": false
	});

    //month picker
    $('.month-selecter').on('key-up click change', function(){
        var i = $(this).attr('id');  // getting column index
        var v = $(this).val();  // getting search input value

        $(this).val(v);

        dataTable.columns(i).search(v).draw();
    });

    $("#user_data_filter").css("display","none");
      $("#user_data_length").css("display","none");


	//para mag add single event frey
	$(document).on('click', '.add-single', function(){

	 var evn_id = $('#evn_id_details').val();
	 var datesingle  = $('#date-single').val();
	 var starttimesingle = $('#starttime-single').val();
	 var endtimesingle = $('#endtime-single').val();
	 var venuesingle = $('#venue-single').val();

	 $.ajax({
	 	url:"dataTable/booking/insert.php",
	 	method:"POST",
	 	data:{ addsingle: 1, evnid: evn_id, datesingle: datesingle, starttimesingle:starttimesingle, endtimesingle: endtimesingle, venuesingle: venuesingle
	 	},
	 	dataType:"JSON",
	 	success: function(data){
	 			$("#date-single").val('');
	 			$('#starttime-single').val('');
	 			$('#endtime-single').val('');
	 			$('#venue-single').val('');
        $('#table_evn_details').empty();
        $('#table_evn_details').append(data.evndet);
	 	}

	 })//end ka ajax pre


	});


	$(document).on('click', '.det-id', function(){

	 var evn_det_id = $(this).attr("id");

	if(confirm("Are you sure you want to remove?")){
		var removeRow = $(this).data("row");
	    $('#' +removeRow).remove();


	  		$.ajax({
	  			url:"datatable/booking/delete.php",
	  			method:"POST",
	  			data:{
	  				'delete-details': 1,
	  				'evn_det_id':evn_det_id
	  			},
	  			dataType:"JSON",
	  			success:function(data)
	  			{

	  			}
	  		})
	  	}
	 });//end ni sng click ka det-id pre


	$(document).on('click', '.update', function(){
		var evn_id = $(this).attr("id");
    	$('#evn-img-details').empty();
		$('#evn_name_details').empty();
		$('#evn_desc_details').empty();
		$('#table_evn_details').empty();
		$('#evn_id_details').empty();

		$.ajax({
			url:"datatable/booking/fetch_single.php",
			method:"POST",
			data:{evn_id:evn_id},
			dataType:"JSON",
			success:function(data)
			{
				$('#bookEvnModal-details').modal('show');
        $('#evn-img-details').append(data.evn_image);
				$('#evn_name_details').val(data.evn_name);
				$('#evn_desc_details').val(data.evn_desc);
				$('#table_evn_details').append(data.evn_det);
				$('.modal-title').text("Event Details");
				$('#evn_id_details').val(evn_id);
				$('#action-details').val("Edit");
				$('#operation-details').val("Edit");

			}
		})
	});//click ka update pre


	//para ni mag cancel event frey
	$(document).on('click', '.cancel', function(){
		var id = $(this).attr("id");
		if(confirm("Are you sure you want to cancel this event?"))
		{
			$.ajax({
				url:"datatable/booking/delete.php",
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



	//PARA SA MODAL MAG ADD MULTIPLE ROWS FREY
	 var count = 1;

	 $('.add').click(function(){
	 	var date2;
	 	var start2;
	 	var end2;

	  count = count + 1;
	  var html_code = "<tr id='row"+count+"'>";

	   html_code += "<td> <input type='date' name='date[]' id='date-add' class='date date-change'/> </td> <td><input type='time' name='starttime[]' class='starttime date-change'id='starttime'> </td> <td> <input type='time' name='endtime[]' class='endtime date-change' id='endtime'></td> <td><input type='text' name='venue[]' placeholder='Venue' class='venue' id='venue'></td> <td> <button type='button' name='remove' data-row='row"+count+"' class='btn btn-danger btn-xs remove'>-</button></td>";
	   html_code += "</tr>";

	   $('#table-input').append(html_code);

	   $('.date').on('key-up click change', function(){
	   		date2 = $(this).val();
	   });

	   $('.starttime').on('key-up click change', function(){
	   		start2 = $(this).val();
	   });

	   $('.endtime').on('key-up click change', function(){
	   		end2 = $(this).val();
	   });

	   $('.date-change').on('key-up click change', function(){
		$.ajax({
			url: "datatable/booking/process.php",
			method:'POST',
			data:{
				checkdate: 1,
				date: date2,
				start: start2,
				end: end2
			},
			success:function(data)
			{
				$('#check_date').html(data);
			}
		});
	});


	 });
	 $(document).on('click', '.remove', function(){
	  var delete_row = $(this).data("row");
	  $('#' + delete_row).remove();
	 });

	 $(document).on('submit', '#user_form', function(event){
		event.preventDefault();

    var form = $('#user_form')[0];

	  var Add = 'Add';
		$.ajax({
				url:"datatable/booking/insert.php",
				method:'POST',
        data: new FormData(form),
        contentType:false,
        processData:false,
        success:function(data)
				{
					alert(data);
					$('#user_form')[0].reset();
					$('#table_evn_details').empty();
					$('#bookEvnModal').modal('hide');
					dataTable.ajax.reload();
                    location.reload();
				}
			});


	});//end sng submit

  $(document).on('submit', '#user-form-details', function(event){
   event.preventDefault();

   var form = $('#user-form-details')[0];


   $.ajax({
       url:"datatable/booking/insert.php",
       method:'POST',
       data: new FormData(form),
       contentType:false,
       processData:false,
       success:function(data)
       {
         alert(data);
         $('#user-form-details')[0].reset();
         $('#table_evn_details').empty();
         $('#bookEvnModal').modal('hide');
         dataTable.ajax.reload();
                   location.reload();
       }
     });


 });//end sng submit


	// // para mag view kg incase mag edit sng event frey
	//  $(document).on('submit', '#user-form-details', function(event){
	// 	event.preventDefault();
  //
	// 	var operation = 'Edit';
	// 	var action = 'Edit';
  //
  //
	// 	var date = [];
	//   	var timestart = [];
	//   	var timeend = [];
	//   	var venue = [];
	//   	var evnName = $('#evn_name_details').val();
	//  	var evnDesc = $('#evn_desc_details').val();
	//  	var evnId = $('#evn_id_details').val();
	//  	var evnDetId = [];
  //
  //
	//  	  $('.det-id').each(function(){
	//   		 evnDetId.push($(this).attr("id"));
	// 	  });
	//   	  $('.date-single').each(function(){
	//   		 date.push($(this).val());
	// 	  });
	// 	  $('.starttime-single').each(function(){
	// 	   	timestart.push($(this).val());
	// 	  });
	// 	  $('.endtime-single').each(function(){
	// 	   	timeend.push($(this).val());
	// 	  });
	// 	  $('.venue-single').each(function(){
	// 	   	venue.push($(this).val());
	// 	  });
  //
	// 	$.ajax({
	// 			url:"datatable/booking/insert.php",
	// 			method:'POST',
	// 			data:{evnname:evnName, evndesc: evnDesc, date:date, start:timestart, end:timeend, venue: venue, operation: operation, action: action, evnid: evnId, evndetid: evnDetId},
	// 			success:function(data)
	// 			{
	// 				alert(data);
	// 				$('#user-form-details')[0].reset();
	// 				$('#bookEvnModal-details').modal('hide');
	// 				dataTable.ajax.reload();
	// 			}
	// 		});
  //
	// });//end ya ni frey

	 //
	 $(document).on('click', '.approve', function(){
	  var id = $(this).attr("id");
		if(confirm('Are you sure you want to approve event?')){
		$.ajax({
				url:"datatable/booking/insert.php",
				method:'POST',
				data:{
					'approve': 1,
					'id': id
				},
				success:function(data)
				{
					alert(data);
					dataTable.ajax.reload();
				}
			});
		}else
			alert('Please Try Again.');


	 });



});
</script>
