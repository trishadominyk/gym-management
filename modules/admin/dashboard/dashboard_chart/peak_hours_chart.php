<canvas id="peak-hours-chart" class="chartjs" width="auto" height="auto"></canvas>

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
                        "graphPeakHour": 1,

                    },
            success: function(data){

              console.log(data);

var color = [];

	var ctx = document.getElementById("peak-hours-chart");
    var myChart = new Chart(ctx, {
    	 type: 'line',
    data: {
        labels: ["6am","7am", "8am", "9am", "10am", "11am", "12pm", "1pm","2pm", "3pm", "4pm", "5pm", "6pm", "7pm", "8pm"],
        datasets: [{
            label: 'Average no. of visitors',
            data: data.timein,
            backgroundColor: randomColor(),

            borderWidth: 1,
      

        }]
    },
    options: {
         title: {
            display: true,
            text: 'Peak Visiting Hours'
        },
        scales: {
          yAxes: [{
               display: false,
               ticks: {
               beginAtZero: true
           }
        }],
        xAxes: [{
         ticks: {
             callback: function(tick, index, array) {
                 return (index % 2) ? "" : tick;
             },
             maxRotation: 0,
                  minRotation: 0
         }
     }]
        }
    }
    });
  }

});

});
</script>
