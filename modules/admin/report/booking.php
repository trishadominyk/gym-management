<div class="repbox">
    <h4>Event booking report</h4>
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

    <br/>
    <br/>

    <div id="table-event-book-approved">

    </div>    
    <br/>
    <br/>

        <div id="table-event-book-canceled">

    </div>

     </div>

        
</div>

<script type="text/javascript">
    
$(document).ready(function(){

  //APROVE EVENTS
   $(document).on("click", "#btn-evn-app", function(e){
     e.preventDefault();
      var datestart = $("#datestart").val();
      var dateend = $("#dateend").val();
     window.open ("report/report_event_approved.php?start="+datestart+"&end="+dateend);
   });

   //CANCELED EVENTS
   $(document).on("click", "#btn-evn-cncl", function(e){
     e.preventDefault();
      var datestart = $("#datestart").val();
      var dateend = $("#dateend").val();
     window.open ("report/report_event_cancel.php?start="+datestart+"&end="+dateend);
   });

          
    $("#submit_buttton").click(function(){
        var datestart = $("#datestart").val();
        var dateend = $("#dateend").val();

        if(datestart != '' && dateend != ''){


             $.ajax({
                url: "report/process.php",
                method: "POST", 
                async: false,
                dataType: "JSON",
                data:{
                    "graph-event": 1,
                    "datestart": datestart,
                    "dateend": dateend
                },
             success: function(data){

                console.log(data);
                  var evn_status = [''];
                    var evn_count_approved = [];
                     var evn_count_canceled = [];
         
                    for(var x=0;x<data[0].length;x++){
                       evn_count_approved.push(data[0][x].evncount_app);
                       evn_count_canceled.push(data[1][x].evncount_can);
                    }

                var chartdata = {
                        labels: evn_status,
                        datasets:[
                            {
                              label: 'Approved',
                              borderColor: 'green',
                              data: evn_count_approved,
                              backgroundColor: 'green'
                            },
                            {
                              label: 'Canceled',
                              borderColor: 'red',
                              data: evn_count_canceled,
                              backgroundColor: 'red'
                            }
                            ]
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
                      display:true
                    },
                    title: {
                        display: true,
                        text: 'Total number of events as of '  + datestart + ' to ' + dateend
                    }

                },
                      });
      
                }  //end of success function
            }) // end ka ajax



            $.ajax({
                url: "report/process.php",
                method: "POST", 
                async: false,
                data:{
            
                    "table-event-book-approved": 1,
                    "datestart": datestart,
                    "dateend": dateend
                },
             success: function(data){

             $('#table-event-book-approved').html(data);
      
                }  //end of success function
            }) // end ka ajax


             $.ajax({
                url: "report/process.php",
                method: "POST", 
                async: false,
                data:{
                    "table-event-book-canceled": 1,
                    "datestart": datestart,
                    "dateend": dateend
                },
             success: function(data){

             $('#table-event-book-canceled').html(data);
      
                }  //end of success function
            })//end ka ajax


            $.ajax({
                url: "report/process.php",
                method: "POST", 
                async: false,
                data:{
                    "table-event-book-pending": 1,
                    "datestart": datestart,
                    "dateend": dateend
                },
             success: function(data){

             $('#table-event-book-pending').html(data);
      
                }  //end of success function
            }) //end ka ajax






            }else
                alert('Please select a date.');




        
        });//end ka onlick fray

});
</script>

    