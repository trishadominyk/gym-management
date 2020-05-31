<div class="repbox">
	<h4>Staff log report</h4>
	<hr class="longhr">
	<div id="repdatebox"> 
		
			<div class="modal-body">
				<div id="datestartcont">
					<label>Date Start</label>
					<input type="date" name="dtstart" id="datestart" class="form-control"/>
				</div>
				<div id="dateendcont">	
					<label>Date End</label>
					<input type="date" name="dtend" id="dateend" class="form-control" />
				</div>

				<div id="dateendcont">
					<input type="submit" name="submit" id="submit_buttton" class="btn btn-success" value="Submit" />

				</div>
			</div>
		
	</div>


	<div id="resultarea">
   

    <div id="staff-log-table"></div>

	 </div>

	 	
</div>

<script type="text/javascript">
	
$(document).ready(function(){

   $(document).on("click", "#btn-staff-log", function(){


    
      var datestart = $("#datestart").val();
      var dateend = $("#dateend").val();


     window.open ("report/report_staff_log.php?start="+datestart+"&end="+dateend);


   });


$("#submit_buttton").click(function(){
        var datestart = $("#datestart").val();
        var dateend = $("#dateend").val();

        if(datestart != '' && dateend != ''){
            $.ajax({
                url: "report/process.php",
                type: "POST",
                async: false,
                data: {
                    "stafflogtable": 1,
                    "datestart": datestart,
                    "dateend": dateend
                },
        success: function(data){
            $('#staff-log-table').html(data);
                }
            
        })
        }else
            alert('Please select a date.');    
    });
});
</script>

