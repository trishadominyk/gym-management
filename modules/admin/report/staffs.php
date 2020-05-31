<div class="repbox">
	<h4>Client report</h4>
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
        <canvas id="canvas"></canvas>

	 </div>

	 	
</div>

<script type="text/javascript">
	
$(document).ready(function(){


	     $("#submit_buttton").click(function(){
        var datestart = $("#datestart").val();
        var dateend = $("#dateend").val();

        if(datestart != '' && dateend != ''){
            $.ajax({
                url: "report/clientrepajax.php",
                method: "POST", 
                async: false,
                data:{
                    "date": 1,
                    "datestart": datestart,
                    "dateend": dateend
                },
        success: function(data){
            
        $("#resultarea").html(data);
        
        var MONTHS = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

        var randomScalingFactor = function() {
            return (Math.random() > 0.5 ? 1.0 : -1.0) * Math.round(Math.random() * 100);
        };
        var randomColorFactor = function() {
            return Math.round(Math.random() * 255);
        };
        var randomColor = function() {
            return 'rgba(' + randomColorFactor() + ',' + randomColorFactor() + ',' + randomColorFactor() + ',.7)';
        };

        var barChartData = {
            labels: ["January", "February", "March", "April", "May", "June", "July"],
            datasets: [{
                label: 'With enrolled classes',
                backgroundColor: "rgba(220,220,220,0.5)",
                data: []
            }, {
                label: 'Active',
                backgroundColor: "rgba(151,187,205,0.5)",
                data: []
            }, {
                label: 'Expired',
                backgroundColor: "rgba(151,187,205,0.5)",
                data: []
            }]

        };

              var ctx = document.getElementById("canvas").getContext("2d");
              var month=[];
            window.myBar = new Chart(ctx, {
                type: 'line',
                data: barChartData,
                options: {
                    // Elements options apply to all of the options unless overridden in a dataset
                    // In this case, we are setting the border of each bar to be 2px wide and green
                    elements: {
                        rectangle: {
                            borderWidth: 2,
                            borderColor: 'rgb(0, 255, 0)',
                            borderSkipped: 'bottom'
                        }
                    },
                    responsive: true,
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Total number of customer(s) as of'
                    }
                }
            });
                }
            })
            }else
                alert('Please select a date.');
        
        });

});
</script>

