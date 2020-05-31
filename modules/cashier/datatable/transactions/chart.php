<div>
    <canvas id="class-sales-chart" class="chartjs" width="100%" height="100%"></canvas>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        var randomColorFactor = function() {
            return Math.round(Math.random() * 255);
        };
        var randomColor = function() {
            return 'rgba(' + randomColorFactor() + ',' + randomColorFactor() + ',' + randomColorFactor() + ',.7)';
        };
        
        $.ajax({
            url: "../admin/dashboard/dashboard_chart/process.php",
            type: "POST",
            dataType: "JSON",
            async: false,
            data: {
                "currYearClassSales": 1,
            },
            success: function(data){
                var clc_name = [];
                var totalamount = [];
                var color = [];

                for(var i in data){
                    clc_name.push(data[i].clcname);
                    totalamount.push(data[i].totalamount);
                    color.push(randomColor());
                }
                
                var ctx = document.getElementById("class-sales-chart");
                
                var myChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: clc_name,
                        datasets: [{
                            label: 'Total amount',
                            data: totalamount,
                            backgroundColor: color
                        }]
                    },
                    options: {
                        //responsive: true,
                        title: {
                        display: true,
                        text: 'Sales Overview for <?php echo date('Y');?>'
                    },
                  /*scales: {
                      xAxes: [{
                         ticks: {
                           beginAtZero: true
                         },
                         display: false,
                         gridLines: {
                           display: false,
                         }
                    }]
                  }*/
                    }
                });
            }//END OF AJAX SUCCESS FUNCTION
        });
    });
</script>
