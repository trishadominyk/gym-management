<canvas id="peak-month-chart" class="chartjs" width="auto" height="325"></canvas>

<script type="text/javascript">
$(document).ready(function(){
	var ctx = document.getElementById("peak-month-chart");

    var randomColorFactor = function() {
            return Math.round(Math.random() * 255);
        };
    var randomColor = function() {
            return 'rgba(' + randomColorFactor() + ',' + randomColorFactor() + ',' + randomColorFactor() + ',.7)';
        };


				    $.ajax({
				                url: "dashboard/dashboard_chart/process.php",
				                type: "POST",
				                dataType: "JSON",
				                async: false,
				                data: {
				                    "graphPeakMonth": 1,

				                },
				        success: function(data){

        var myChart = new Chart(ctx, {
    	 type: 'horizontalBar',
    data: {
        labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
        datasets: [{
            label: 'Average no. of bookings',
            data: data.monthcount,
            backgroundColor: randomColor(),
            borderWidth: 1
        }]
    },
    options: {
         title: {
            display: true,
            text: 'Peak Booking Month'
        },
        scales: {
					xAxes: [{
							 display: false,
					}],
           reverse: false,

              ticks: {
                beginAtZero: true
              }
        }
    }
    });
	}
});

});
</script>
