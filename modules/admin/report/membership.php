<div class="repbox">
	<h4>Membership report</h4>
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

    <div id="membershipgraphone">
          <canvas id="canvas"></canvas>

    </div>
    <div id="membership_table"></div>
      
	 </div>

	 	
</div>

<script type="text/javascript">
	
function getmonth(date){
  var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
  var newdate = new Date(date);
    month = Number(newdate.getMonth());

    return months[month];
}

$(document).ready(function(){


   $(document).on("click", "#memrep", function(){


    
      var datestart = $("#datestart").val();
      var dateend = $("#dateend").val();


     window.open ("report/report_membership.php?start="+datestart+"&end="+dateend);


   });

	 $("#submit_buttton").click(function(){
        var datestart = $("#datestart").val();
        var dateend = $("#dateend").val();

        if(datestart != '' && dateend != ''){
            $.ajax({
                url: "report/process.php",
                type: "POST",
                dataType: "JSON",
                async: false,
                data: {
                    "graphMembership": 1,
                    "datestart": datestart,
                    "dateend": dateend
                },
        success: function(data){
           

        //graph for membership
         
                  var mem_status = [];
                  var mem_count = [];
         
              
                    for(var i in data){
                        mem_status.push(data[i].mem_status);
                        mem_count.push(data[i].countmem);
                    }

                      var chartdata = {

                        labels: mem_status,
                       datasets:[
                            {
                              label: 'No of customer',
                              borderColor: '#cacaca',
                              data: [mem_count[0], mem_count[1]],
                              backgroundColor: ['green', 'red']
                            }]
                        };
                   

                var ctx = document.getElementById("canvas").getContext("2d");

                var barGraph = new Chart(ctx, {
                    type: 'bar',
                    data: chartdata,
                    options: {
                  
                    scales: {
                    yAxes: [{
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
                            borderColor: 'rgb(0, 255, 0)',
                            borderSkipped: 'left'
                        }
                    },
                    responsive: true,

                    legend: {
                      display:false
                    },
                    title: {
                        display: true,
                        text: 'Total Number of Memberships.'
                    }

                },
                      });


                

             $.ajax({

                url: "report/process.php",
                type: "POST",
                async: false,
                data: {
                    "membershipTable": 1,
                    "datestart": datestart,
                    "dateend": dateend
                },
                success: function(d){

                    $("#membership_table").html(d);
                }
            });



           //end of success function for graph
                }
            })
            }else
                alert('Please select a date.');
        
        });
     
});
</script>

