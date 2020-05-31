<div id="resultarea">
    <canvas id="canvas" style="width:100%;"></canvas>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $.ajax({
            url:"datatable/logs/chartdata.php",
            method:"POST",
            dataType:"JSON",
            data:{id:'<?php echo $_SESSION["id"];?>'},
            success:function(data)
            {
                var date = [];
                var progress = [];
                
                for(var i=0;i<data.length;i++){
                    date.push(data[i].log_date);
                    progress.push(data[i].pro_percentage);
                }
                
                var chartdata = {
                    labels: date,
                    datasets:[
                        {
                            label: 'Progress',
                            borderColor: '#b01f24',
                            data: progress,
                            backgroundColor: 'transparent',
                            lineTension: 0,
                            pointRadius: 5,
                            pointBackgroundColor: 'white',
                            borderWidth: 2,
                            
                        }
                    ]
                };
                
                var ctx = document.getElementById("canvas").getContext("2d");

                var lineGraph = new Chart(ctx,{
                    type: 'line',
                    data: chartdata,
                    options:{
                        scales:{
                            xAxes: [{
                                display: true,
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Date'
                                },
                                ticks: {
                                    fontSize: 10,
                                    fontColor: 'lightgrey'
                                }
                            }],
                            yAxes: [{
                                display: true,
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Percentage'
                                },
                            }]
                        }
                    },
                    responsive: true,
                    tooltips: {
                        backgroundColor: 'white'
                    }
                });
            }
        });
    });
</script>