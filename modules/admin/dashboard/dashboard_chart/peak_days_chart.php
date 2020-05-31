
	<canvas id="peak-days-chart" class="chartjs" width="auto" height="auto"></canvas>

<script type="text/javascript">
$(document).ready(function(){

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
                    "graphPeakDay": 1,

                },
        success: function(data){

            console.log(data);
                /*  var count = [];
                    for(var i in data){
                        count.push(data[i].ctl);

                    }*/

                var ctx = document.getElementById("peak-days-chart");
                var myChart = new Chart(ctx, {
                     type: 'bar',


                data: {
                    labels: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
                    datasets: [{
                        label: 'Average no. of visitors',
                        data: data.day,
                        backgroundColor: randomColor(),
                    }]
                },
                options: {
									title: {
                        display: true,
                        text: 'Peak Visiting Days'
                    },
                    scales: {
                       yAxes: [{
                        	ticks: {
                            beginAtZero: true
                        	},
													display: false,
													gridLines: {
														display: false,
													}
                     }]
                    }
                }
                });

        }//END OF AJAX SUCCESS FUNCTION

    });



});


</script>
