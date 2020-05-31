<div class="repbox">
	<h4>Client log report</h4>
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
				<canvas id="canvas1"></canvas>
		</div>


    <div id="student-log-table"></div>

	 </div>


</div>

<script type="text/javascript">

$(document).ready(function(){

   $(document).on("click", "#btn-stud-log", function(){



      var datestart = $("#datestart").val();
      var dateend = $("#dateend").val();


     window.open ("report/report_student_log.php?start="+datestart+"&end="+dateend);


   });


$("#submit_buttton").click(function(){

	var datestart = $("#datestart").val();
	var dateend = $("#dateend").val();
	var randomColorFactor = function() {
						 return Math.round(Math.random() * 255);
				 };
	var randomColor = function() {
						 return 'rgba(' + randomColorFactor() + ',' + randomColorFactor() + ',' + randomColorFactor() + ',.7)';
				 };

	if(datestart != '' && dateend != ''){

	$.ajax({
			url: "report/process.php",
			type: "POST",
			dataType: "JSON",
			async: false,
			data: {
					"studentloggraph": 1,
					"datestart": datestart,
					"dateend": dateend
			},success: function(data){
				console.log(data);


		var name = [];
		var count = [];
		var color = [];

			for(var i in data){
					name.push(data[i].name);
					count.push(data[i].cnt);
					color.push(randomColor());
			}


					var chartdata = {

						labels: name,
					 datasets:[
								{
									label: 'No. of visits',
									data: count,
									backgroundColor: color
								}
								]
						};


		var ctx = document.getElementById("canvas1").getContext("2d");

		var barGraph = new Chart(ctx, {
				type: 'horizontalBar',
				data: chartdata,
				 showTooltips: true,
				options: {
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
						display: true,
						position: 'top',
				},
				title: {
						display: true,
						text: 'Top 5 visiting clients from' +  datestart + 'to' +dateend 
				}

		},
					});

            $.ajax({
					                url: "report/process.php",
					                type: "POST",
					                async: false,
					                data: {
					                    "studentlogtable": 1,
					                    "datestart": datestart,
					                    "dateend": dateend
					                },
					        success: function(dat){
					            $('#student-log-table').html(dat);



										}
					        })

	}//end of ajx
	})








        }else
            alert('Please select a date.');

						//para sa graph
    });
});
</script>
