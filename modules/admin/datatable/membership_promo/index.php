<div class="box">
<div id="staffcont"> 
		<div id="staffhead"> 
			<h3><img src="../../img/icon/promosicon.png"> Promo Management</h3>
		</div>
		  <div align="right">
            <button type="button" id="add_button" data-toggle="modal" data-target="#classPromoModal" class="btn btn-info btn-md">New Promo</button>
        </div>
</div>
			<div class="table-responsive">		
				<br />
				<table id="user_data" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th width="8%">Code</th>
							<th width="8%">Date Start</th>
							<th width="8%">Date End</th>
							<th width="8%">Discount</th>
							<th width="8%">Max Slots</th>
							<th width="8%">Remaining Slots</th>
							<th width="8%">Status</th>
							<th width="12%">Action</th>
				
						</tr>
					</thead>
				</table>
				
			</div>
	
	<div id="promodescmodal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="user_form" action="index.php?mod=enroll" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Class</h4>
                </div>

                <div class="modal-body">
                   
                
                        
                        <label id="prmdescription"></label>
                    
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
						<br />
							<label>Description</label>
						<input type="text" name="prmdesc" id="prm_desc" class="form-control" />
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

					<div class="class-cont-rdbtn"> 
						<h3> Select Membership Type</h3>
						<br/>
						<?php
						
							$ra = $membership->fngetmembershiptype();
							if($ra){
							foreach ($ra as $value){

						?>
						<input type="checkbox" name="classtypes[]" value="<?php echo $value['met_id'];?>"> <?php echo $value['met_name'];?></input>
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

	$('#add_button').click(function(){
		$('#user_form')[0].reset();
		$('.modal-title').text("New Promo");
		$('#action').val("Add");
		$('#operation').val("Add");

	});
	
	var dataTable = $('#user_data').DataTable({
		"processing":true,
		"serverSide":true,
		"order":[],
		"ajax":{
			url:"datatable/membership_promo/fetch.php",
			method:"POST"
		},
		"columnDefs":[
			{
				"targets":[0,1, 2, 3, 4,5, 6 ,7],
				"orderable":false
			},
		],

	});

	$(document).on('submit', '#user_form', function(event){
		event.preventDefault();
		var prmcode = $('#prm_code').val();
		var prmdatestart = $('#prm_date_start').val();
		var prmdateend = $('#prm_date_end').val();
		var prmdiscount = $('#prm_discount').val();
		var prmmax = $('#prm_max').val();
		var prmdesc = $('#prm_desc').val();
	

		if(prmcode != '' && prmdatestart != '' && prmdateend != '' && prmdiscount !='' && prmmax != '')
		{
			$.ajax({
				url:"datatable/membership_promo/insert.php",
				method:'POST',
				data:new FormData(this),
				contentType:false,
				processData:false,
				success:function(data)
				{
					$('#membership_promo_form')[0].reset();
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
	
	$(document).on('click', '.view', function(){
		var prm_id = $(this).attr("id");
		$.ajax({
			url:"datatable/membership_promo/fetch_single.php",
			method:'POST',
			data:{prm_id:prm_id},
			dataType:"JSON",
			success:function(data)
			{
				$('#promodescmodal').modal('show');
				$('#prmdescription').text(data.prm_desc);
				$('.modal-title').text("Promo Description");
		

			}
		})
	});


	
	
	
	$(document).on('click', '.delete', function(){
		var eqp_id = $(this).attr("id");
		if(confirm("Are you sure you want to remove this promo?"))
		{
			$.ajax({
				url:"datatable/promo/dispose.php",
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