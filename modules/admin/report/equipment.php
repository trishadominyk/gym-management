<div class="repbox">
	<h4>Equipment report</h4>
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
    <div class="classgraph">
        <canvas id="canvas"></canvas>
    </div>

    <div id="eqp-avail-table">

    </div>



    <div id="eqp-rep-table">

    </div>


    <div id="eqp-disp-table">

    </div>
	 </div>

	 	
</div>

<script type="text/javascript">
	
$(document).ready(function(){

  $(document).on("click", "#avail-eqp-rep", function(){    
      var datestart = $("#datestart").val();
      var dateend = $("#dateend").val();
      window.open ("report/report_available_equipment.php?start="+datestart+"&end="+dateend);
   });

  $(document).on("click", "#repair-eqp-rep", function(){    
      var datestart = $("#datestart").val();
      var dateend = $("#dateend").val();
      window.open ("report/report_repair_equipment.php?start="+datestart+"&end="+dateend);
   });

    $(document).on("click", "#disposed-eqp-rep", function(){    
      var datestart = $("#datestart").val();
      var dateend = $("#dateend").val();
      window.open ("report/report_disposed_equipment.php?start="+datestart+"&end="+dateend);
   });
	      
    $("#submit_buttton").click(function(){
        var datestart = $("#datestart").val();
        var dateend = $("#dateend").val();

        if(datestart != '' && dateend != ''){
            $.ajax({
                url: "report/process.php",
                method: "POST", 
                dataType:"JSON",
                async: false,
                data:{
                    "graphEqp": 1,
                    "datestart": datestart,
                    "dateend": dateend
                },
        success: function(data){
        console.log(data);
            //graph for membership
         var eqp_count_available = [];
         var eqp_count_repair = [];
         var eqp_count_disposed = [];
         var count = 0;
         var status = ['']
           
          for(var x=0;x<data[0].length;x++){
                    eqp_count_available.push(data[0][x].countavail);
                    eqp_count_repair.push(data[1][x].countrep);
                    eqp_count_disposed.push(data[2][x].countdisp);
          }

          var chartdata = {
                    labels: status,
                    datasets:[
                            {
                              label: 'Available',
                              borderColor: 'green',
                              data: eqp_count_available,
                              backgroundColor: 'green'
                            },
                            {
                              label: 'Under Repair',
                              borderColor: 'orange',
                              data: eqp_count_repair,
                              backgroundColor: 'orange'
    
                            },
                            {
                              label: 'Disposed',
                              borderColor: 'red',
                              data: eqp_count_disposed,
                              backgroundColor: 'red'
    
                            }
                            ]
                        };

                var ctx = document.getElementById("canvas").getContext("2d");
                var barGraph = new Chart(ctx, {
                    type: 'horizontalBar',
                    data: chartdata,
                    options: {
                  
                    scales: {
                    xAxes: [{
                              ticks: {
                                  beginAtZero: true
                              }
                          }]
                      },
                    // Elements options apply to all of the options unless overridden in a dataset
                    // In this case, we are setting the border of each bar to be 2px wide and green
                    elements: {
                        rectangle: {
                           borderWidth: 2,
                          
                        }
                    },
                    responsive: true,

                    legend: {
                    
                        position: 'top',
                    },
                    title: {
                      position:'top',
                        display: true,
                        text: 'Total Number of Equipments'
                    }

                },
                      });

            $.ajax({
                url: "report/process.php",
                type: "POST",
                async: false,
                data: {
                    "availEqpTable": 1,
                      "datestart": datestart,
                    "dateend": dateend
                },
                success: function(d){

                    $("#eqp-avail-table").html(d);
                }
            });


            $.ajax({
                url: "report/process.php",
                type: "POST",
                async: false,
                data: {
                    "repEqpTable": 1,
                    "datestart": datestart,
                    "dateend": dateend
                },
                success: function(da){
                    $("#eqp-rep-table").html(da);
                }
            });

              $.ajax({
                url: "report/process.php",
                type: "POST",
                async: false,
                data: {
                    "dispEqpTable": 1,
                    "datestart": datestart,
                    "dateend": dateend
                },
                success: function(da){
                    $("#eqp-disp-table").html(da);
                }
            });



        //end of success function
                }
            })
            }else
                alert('Please select a date.');
        
        });

});
</script>

