<div class="box">
<div id="svcscont">
		<div id="staffhead">
			<h3><img src="../../img/icon/promosicon.png">Promo</h3>
		</div>
			<div class="btnright">
            <button id="add_button" type="button" data-toggle="modal" data-target="#classPromoModal" class="btn btn-info btn-md">New Promo</button>
					</div>
</div>
			<div>
				<br />
				<table id="user_data" class="table table-bordered table-striped" style="width: 100%;">
					<thead>
						<tr>
							<th width="8%">Code</th>
							<th width="15%">Date Valid</th>
							<th width="8%">Discount</th>
							<th width="8%">Max Slots</th>
							<th width="8%">Remaining Slots</th>
							<th width="8%">Status</th>
							<th width="15%">Action</th>

						</tr>
					</thead>
				</table>

			</div>

<div id="promodescmodal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="desc_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title-details"></h3>
                </div>

                <div class="modal-body">
                <center><h3> Description </h3></center>
                 <hr>

                   <div id="prmdescription"></div>

                    <center><h3> Classes with Promo </h3></center>
                         <hr>
                    <div id="classname"></div>
                    <center><h3> Membership with Promo </h3></center>
                    <hr>
                       <div id="metname"></div>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="dtpModal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="dtp_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title-dtp"></h3>
                </div>

                <div class="modal-body">

                <center><b>Old Date</b></center>
                <hr/>
                <div id="currdate"> </div>
                <br/>

                <center><b>New Date</b></center>
                <hr/>
               <center><input type="date" name="datefrom" id="dtpfrom"> &nbsp;TO&nbsp;
                <input type="date" name="dateto" id="dtpto"></center>
                <br/>

                </div>
                   <div class="modal-footer">
				<input type="hidden" name="prmid_dtp" id="prm_id_dtp" />
				<input type="hidden" name="operation" id="dtp_operation" />
				<input type="submit" name="dtpaction" id="dtp_action" class="btn btn-success"  />
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
            </div>

        </form>
    </div>
</div>


	<div id="classPromoModal" class="modal fade">
		<div class="classPromoModal-dialog">
			<form method="post" id="class_promo_form" enctype="multipart/form-data">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">New Promo</h4>
					</div>
					<div class="modal-body-class-promo">
						<label>Promo code</label>
						<input type="text" name="prmcode" id="prm_code" class="form-control" />

						<span id="check_name"></span>
						<br />
							<label>Description</label>
						<textarea type="text" name="prmdesc" id="prm_desc" class="form-control"> </textarea>
						<br/>
						<label>Date Start</label>
						<input type="date" name="prmdatestart" id="prm_date_start" class="form-control" />
						<br />
						<label>Date End</label>
						<input type="date" name="prmdateend" id="prm_date_end" class="form-control" />
						<br />
						<label>Discount</label>
						<input type="number" name="prmdiscount" id="prm_discount" class="form-control" />
						<br/>
						<label>Maximum Slots</label>
						<input type="number" name="prmmax" id="prm_max" class="form-control" />
					</div>
                    
                    <div id="mem-cont-rdbtn">
							<h3> Select Membershiptype</h3>
						<br/>
						<?php

							$rb = $membership->fngetmembershiptype();
							if($rb){
							foreach ($rb as $valueB){

						?>
						<input type="checkbox" name="memtypes[]" value="<?php echo $valueB['met_id'];?>"> <?php echo $valueB['met_name'];?>
						<br/>
						<br/>

						<?php
							}
						}
						?>
					</div>

					<div class="class-cont-rdbtn">
						<h3> Select class</h3>
						<br/>
						<?php

							$ra = $gymclass->fngetallclass();
							if($ra){
							foreach ($ra as $value){

						?>
						<input type="checkbox" name="classtypes[]" value="<?php echo $value['cls_id'];?>"> <?php echo $value['cls_name'];?>
						<br/>
						<br/>

						<?php
							}
						}
						?>
					</div>
					<div class="modal-footer">
						<input type="hidden" name="prmid" id="prm_id" />
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




	$('#prm_code').on('keyup click change', function(){
		var prmcode = $('#prm_code').val();
		$.ajax({
			url: "datatable/promo/process.php",
			method:'POST',
			data:{prmcode:prmcode},
			success:function(data)
			{
				$('#check_name').html(data);
			}
		});
	});




	$('#add_button').click(function(){
		$('#class_promo_form')[0].reset();
		$('.modal-title').text("New Promo");
		$('#action').val("Add");
		$('#operation').val("Add");
	});

	var dataTable = $('#user_data').DataTable({
		"processing":true,
		"serverSide":true,
		"order":[],
		"ajax":{
			url:"datatable/promo/fetch.php",
			method:"POST"
		},
		"columnDefs":[
			{
				"targets":[0,1, 2, 3, 4,5, 6],
				"orderable":false
			},
		],

	});


    $(document).on('submit', '#dtp_form', function(event){
		event.preventDefault();

		var prmdatestart = $('#dtpfrom').val();
		var prmdateend = $('#dtpto').val();

		$.ajax({
			url:"datatable/promo/insert.php",
			method:'POST',
			data:new FormData(this),
			contentType:false,
			processData:false,
			success:function(data)
			{
			$('#dtp_form')[0].reset();
			$('#dtpModal').modal('hide');
			dataTable.ajax.reload();
			alert(data);
			},
			error: function(data){
				alert('error!');
			}
	   });
	});

	$(document).on('submit', '#class_promo_form', function(event){
		event.preventDefault();
		var prmcode = $('#prm_code').val();
		var prmdatestart = $('#prm_date_start').val();
		var prmdateend = $('#prm_date_end').val();
		var prmdiscount = $('#prm_discount').val();
		var prmmax = $('#prm_max').val();
		var prmdesc = $('#prm_desc').val();


		if(prmcode != '' && prmdatestart != '' && prmdateend != '' && prmdiscount !='' && prmmax != '')
		{
			if(confirm('Are you sure you want to proceed?')){
				$.ajax({
				url:"datatable/promo/insert.php",
				method:"POST",
				data:new FormData(this),
				contentType:false,
				processData:false,
				success:function(data)
				{
					$('#class_promo_form')[0].reset();
					$('#classPromoModal').modal('hide');

					dataTable.ajax.reload();

				}
			});
			}else{
				return false;
			}

		}
		else
		{
			alert("All Fields are Required");
		}
	});

		$(document).on('click', '.view', function(){
		var prm_id = $(this).attr("id");
		$('#prmdescription').empty(); // empty the div before fetching and adding new data
		$('#classname').empty();
		$('#metname').empty();
		$('.modal-title-details').empty();
		$.ajax({
			url:"datatable/promo/fetch_single.php",
			method:'POST',
			data:{prm_id:prm_id},
			dataType:"JSON",
			success:function(data)
			{
				$('#prmdescription').append(data[0].prm_desc);
				$('#classname').append(data[1].clsname);
				$('#metname').append(data[2].metname);
				$('#promodescmodal').modal('show');
				$('#prm_id_dtp').val(prm_id);
				$('.modal-title-details').text("Promo Code: " + data[0].prm_code);
			},

		})
	});


	$(document).on('click', '.renew', function(){
		var prm_id = $(this).attr("id");
		$('.modal-title-dtp').empty();
		$('#currdate').empty();
		$.ajax({
			url:"datatable/promo/fetch_single.php",
			method:'POST',
			data:{prm_id:prm_id},
			dataType:"JSON",
			success:function(data)
			{
				$('#currdate').append(data[0].prm_date);
				$('#dtpModal').modal('show');
				$('.modal-title-dtp').text("Promo Code: " + data[0].prm_code);
				$('#prm_id_dtp').val(prm_id);
				$('#dtp_action').val("Edit");
				$('#dtp_operation').val("Edit");
			},

		})
	});




	$(document).on('click', '.delete', function(){
		var prm_id = $(this).attr("id");
		var action = $(this).attr("action");
		if(confirm("Are you sure you want to continue?"))
		{
			$.ajax({
				url:"datatable/promo/deactivate.php",
				method:"POST",
				data:{prm_id:prm_id, action:action},
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
