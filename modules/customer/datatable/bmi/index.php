<head>
    <script src="../../js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
</head>

<div class="table-responsive">
    <div class="bmi-calculator">
        <form class="bmi-form" method="post" id="bmi_form" enctype="multipart/form-data">
            <label>Height (in)</label>
            <input type="number" name="bmi_height" id="bmi_height" class="form-control"/>
            <br>
            <label>Weight (lb)</label>
            <input type="number" name="bmi_weight" id="bmi_weight" class="form-control"/>
            <br>
            <input type="hidden" name="cust_id" id="cust_id" value="<?php echo $_SESSION['id'];?>"/>
            <input type="submit" name="action" id="action" class="btn-gray" style="width: 95%;"/>
        </form>
    </div>
    
    <div class="bmi-result">
        <h3>BMI Calculator</h3>
        <hr>
        
        <span id="bmi_info"></span>
        <h4><span id="bmi_result"></span></h4>
        <p><span id="bmi_category"></span></p>
        
        <div class="bmi-btns">
            <span id="bmi_add"></span>
            <button class="btn btn-dark history" toggle="modal" data-target="#bmiHistory">View History</button>
        </div>
    </div>
</div>

<div id="bmiHistory" class="modal fade">
	<div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">BMI History</h4>
            </div>
                
            <div class="modal-body">
                <div id="bmi-graph">
                    <div id="resultarea">
                        <canvas id="canvas" style="width:100%;"></canvas>
                    </div>

                    <script type="text/javascript">
                        $(document).ready(function(){
                            $.ajax({
                                url:"datatable/bmi/chartdata.php",
                                method:"POST",
                                dataType:"JSON",
                                data:{id:'<?php echo $_SESSION["id"];?>'},
                                success:function(data)
                                {
                                    var date = [];
                                    var result = [];

                                    for(var i=0;i<data.length;i++){
                                        date.push(data[i].bmi_date);
                                        result.push(data[i].bmi_result);
                                    }

                                    var chartdata = {
                                        labels: date,
                                        datasets:[
                                            {
                                                label: 'BMI',
                                                borderColor: '#b01f24',
                                                data: result,
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
                                                        labelString: 'BMI'
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
                </div>
                <br>
                <div id="bmi-table">
                    <table id="bmi_data" class="table table-bordered table-striped" style="width:100%;">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>BMI</th>
                                <th>Info</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            
            <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
	</div>
</div>


<script type="text/javascript">
    $(document).ready(function(){
       $(document).on('submit', '#bmi_form', function(event){ 
           event.preventDefault();
           
           var bmiHeight = $('#bmi_height').val();
           var bmiWeight = $('#bmi_weight').val();
           
           $('#bmi_add').text("");
           
           if(bmiHeight != '' && bmiWeight != ''){
               $.ajax({
                   url:"datatable/bmi/calculate.php",
                   method: 'POST',
                   dataType: 'JSON',
                   data:new FormData(this),
                        contentType:false,
                        processData:false,
                        success:function(data)
                        {
                            $('#bmi_info').text(data.bmi_info);
                            $('#bmi_result').text(data.bmi_result);
                            $('#bmi_category').text(data.bmi_category);
                            $('#bmi_add').append(data.bmi_button);
                        }
               });
           }
           else
               alert("Please fill up all fields.");
       });
        
        $(document).on('click', '.new', function(e){
           var cust_id = $(this).attr("id");
           var bmi_height = $(this).attr("height");
           var bmi_weight = $(this).attr("weight");
            
            if(confirm("Record current BMI?")){
                e.stopImmediatePropagation();
                
                $.ajax({
                    url:"datatable/bmi/record.php",
                    method:"POST",
                    data:{cust_id:cust_id, bmi_height:bmi_height, bmi_weight:bmi_weight},
                    dataType:"JSON",
                    success:function(data)
                    {
                        alert('Successfully Recorded.');
                        $('#bmi_form')[0].reset();
                        $('#bmi_info').text("");
                        $('#bmi_result').text("");
                        $('#bmi_category').text("");
                        $('#bmi_add').text("");
                        
                        $('#bmi_current').empty();
                        $('#bmi_current').text(data.bmi_result + " " + data.bmi_category);
                    }
                });
            }
        });
        
        $(document).on('click', '.history', function(){
            $('#bmiHistory').modal("show");
            
            var dataTable = $('#bmi_data').DataTable({
                "destroy":true,
                "processing":true,
                "serverSide":true,
                "order":[],
                "ajax":{
                    url:"datatable/bmi/fetch.php",
                    method:"POST",
                    data:{id:'<?php echo $_SESSION['id'];?>'}
                },
                "columnDefs":[
                    {
                        "targets":[0,1,2],
                        "orderable":false,
                    },
                ],
                "paging": false,
                "bInfo": false,
                "bFilter": false
            });
        });
    });
</script>