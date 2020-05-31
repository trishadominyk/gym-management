<div class="repbox">
	<h4>Sales report</h4>
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
          <div id="table-sales-class"></div>
		     
        
          <div class="classgraph">
              <canvas id="canvasB"></canvas>
          </div>
            <div id="table-sales-membership"></div>
	 </div>


</div>

<script type="text/javascript">
	

function getmonth(date){
  var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
  var newdate = new Date(date);
    month = Number(newdate.getMonth());

    return months[month];
}


     var randomColorFactor = function() {
            return Math.round(Math.random() * 255);
        };

            var randomColor = function() {
            return 'rgba(' + randomColorFactor() + ',' + randomColorFactor() + ',' + randomColorFactor() + ',1)';
        };

$(document).ready(function(){

   
   $(document).on("click", "#class-sales-rep", function(e){
     e.preventDefault();

    
      var datestart = $("#datestart").val();
      var dateend = $("#dateend").val();


     window.open ("report/report_class_sales.php?start="+datestart+"&end="+dateend);



   });


     $(document).on("click", "#membership-sales-rep", function(e){
     e.preventDefault();

    
      var datestart = $("#datestart").val();
      var dateend = $("#dateend").val();


     window.open ("report/report_membership_sales.php?start="+datestart+"&end="+dateend);



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
                    "graphClassSales": 1,
                    "datestart": datestart,
                    "dateend": dateend
                },
        success: function(data){
           
        
        //graph for membership
                  var clc_name = [];
                  var totalamount = [];
                  var color = [];
         
              
                    for(var i in data){
                        clc_name.push(data[i].clcname);
                        totalamount.push(data[i].totalamount);
                        color.push(randomColor());

                    }

                      var chartdata = {

                        labels: clc_name,
                       datasets:[
                            {
                              label: 'Total Amount',
                              data: totalamount,
                              backgroundColor: color
                            }
                            ]
                        };


                var ctx = document.getElementById("canvas").getContext("2d");

                var barGraph = new Chart(ctx, {
                    type: 'horizontalBar',
                    data: chartdata,
                     showTooltips: true,
                    options: {
                  
                    // Elements options apply to all of the options unless overridden in a dataset
                    // In this case, we are setting the border of each bar to be 2px wide and green
                     scales: {

				        xAxes: [{
				            ticks: {
				                beginAtZero: true
				            }
				        }]
				    },
                    elements: {
                        rectangle: {
                           borderWidth: 2,
                            borderSkipped: 'left'
                        }
                    },
                    responsive: true,

                    legend: {
                        display: false,
                        position: 'bottom',
                    },
                    title: {
                        display: true,
                        text: 'Total Class Sales'
                    }

                },
                      });



             $.ajax({

                url: "report/process.php",
                type: "POST",
                async: false,
                dataType: "JSON",
                data: {
                    "graphMembershipSales": 1,
                    "datestart": datestart,
                    "dateend": dateend
                },
                success: function(d){
                  
                           //graph for membership
                  var met_name = [];
                  var totalamountB = [];
                  var color = [];

                    for(var l in d){
                        met_name.push(d[l].metname);
                        totalamountB.push(d[l].totalamountmem);
                        color.push(randomColor());
                    }

                      var chartdataB = {

                        labels: met_name,
                       datasets:[
                            {
                              label: 'Total Amount',
                              data: totalamountB,
                              backgroundColor: color
                            }]
                        };


                var ctxB = document.getElementById("canvasB").getContext("2d");

                var barGraphC = new Chart(ctxB, {
                    type: 'bar',
                    data: chartdataB,
                     showTooltips: true,
                    options: {
                  
                    // Elements options apply to all of the options unless overridden in a dataset
                    // In this case, we are setting the border of each bar to be 2px wide and green
                     scales: {

                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    },
                    elements: {
                        rectangle: {
                           borderWidth: 2,
                            borderSkipped: 'left'
                        }
                    },
                    responsive: true,

                    legend: {
                        display: false,
                        position: 'bottom',
                    },
                    title: {
                        display: true,
                        text: 'Total Membership Sales'
                    }

                },
                      });

           


                

            //end of success function for graph
                }
            });

           $.ajax({
                url: "report/process.php",
                type: "POST",
                async: false,
                data: {
                    "salesTable": 1,
                    "datestart": datestart,
                    "dateend": dateend
                },
                success: function(da){
                   $('#table-sales-class').html(da);

                } 

              });

              $.ajax({
                url: "report/process.php",
                type: "POST",
                async: false,
                data: {
                    "membershipTableSales": 1,
                    "datestart": datestart,
                    "dateend": dateend
                },
                success: function(db){
                   $('#table-sales-membership').html(db);

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

