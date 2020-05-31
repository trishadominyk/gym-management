<?php
    include('../../library/db.php');

    $sql = "SELECT * FROM tbl_event E, tbl_eventdetail ED WHERE E.evn_id = ED.evn_id AND E.evn_status <> 'CANCELED'";
    $req = $connection->prepare($sql);
    $req->execute();
    $events = $req->fetchAll();
?>

<div class="row-calendar">
    <div class="col-lg-12 text-center">
        <h4>Calendar of Events</h4>

        <div id="calendar" class="col-centered">
        </div>
    </div>
</div>
<!-- /.row -->




<!-- Modal -->
<div class="modal fade" id="ModalDetails" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form-horizontal" method="POST" action="editEventTitle.php">
			     <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="myModalLabel">Event Details</h4>
                </div>

                <div class="modal-body">

                  <div class="form-group">


                    <div id="event-poster-admin">
                    </div>
                  </div>



                    <div class="form-group">


      					   <label for="title" class="col-sm-2 control-label">Title</label>
                        <div class="col-sm-10">
                            <input type="text" name="title" class="form-control" id="title" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="title" class="col-sm-2 control-label">Date</label>

                        <div class="col-sm-10">
                            <input type="text" name="title" class="form-control" id="date" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="title" class="col-sm-2 control-label">Time Start</label>

                        <div class="col-sm-10">
                            <input type="text" name="title" class="form-control" id="start" readonly>
                        </div>
                    </div>

                    <div class="form-group">
					   <label for="title" class="col-sm-2 control-label">Time End</label>

                        <div class="col-sm-10">
					       <input type="text" name="title" class="form-control" id="end" readonly>
					   </div>
				    </div>

				    <div class="form-group">
					   <label for="title" class="col-sm-2 control-label">Venue</label>

                        <div class="col-sm-10">
					       <input type="text" name="title" class="form-control" id="venue" readonly>
                        </div>
                    </div>

                    <input type="hidden" name="id" class="form-control" id="id">
                </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			  </div>
			</form>
        </div>
    </div>
</div>


    <!-- /.container -->

    <!-- jQuery Version 1.11.1 -->



	<!-- FullCalendar -->
	<script src='../../js/moment.min.js'></script>
	<script src='../../js/fullcalendar.min.js'></script>

	<script>

	$(document).ready(function() {

		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,basicWeek'
			},
			editable: false,
			eventLimit: true,
			selectable: true,
			selectHelper: true,
			eventRender: function(event, element) {
				element.bind('click', function() {
          $('#ModalDetails #event-poster-admin').empty();
          $('#ModalDetails #event-poster-admin').append(event.imageUrl);
					$('#ModalDetails #id').val(event.id);
					$('#ModalDetails #title').val(event.title);
					$('#ModalDetails #date').val(moment(event.date).format('YYYY-MM-DD'));
					$('#ModalDetails #start').val(moment(event.start).format('h:mm'));
					$('#ModalDetails #end').val(moment(event.end).format('h:mm'));
					$('#ModalDetails #venue').val(event.venue);
					$('#ModalDetails').modal('show');
				});
			},
			eventDrop: function(event, delta, revertFunc) {

				edit(event);

			},
			eventResize: function(event,dayDelta,minuteDelta,revertFunc) {

				edit(event);

			},
			events: [
			<?php foreach($events as $event):
				$id = $event['evn_id'];
				$name = $event['evn_name'];
				$date = $event['evn_det_date'];
				$start = $event['evn_det_date'].' '.$event['evn_det_time_start'];
				$end = $event['evn_det_date'].' '.$event['evn_det_time_end'];
				$venue = $event['evn_det_venue'];
        $image = '<img src='. substr($event['evn_image'], 6).'>';
			?>
				{
					id: '<?php echo $id; ?>',
					title: '<?php echo $name; ?>',
					date: '<?php echo $date; ?>',
					start: '<?php echo $start; ?>',
					end: '<?php echo $end; ?>',
					allDay: false,
					venue: "<?php echo $venue; ?>",
          imageUrl: "<?php echo $image;?>"
				},
			<?php endforeach; ?>
			]
		});

		function edit(event){
			start = event.start.format('YYYY-MM-DD');
			if(event.end){
				end = event.end.format('YYYY-MM-DD HH:mm:ss');
			}else{
				end = start;
			}
			id =  event.id;

			Event = [];
			Event[0] = id;
			Event[1] = start;
			Event[2] = end;

			$.ajax({
			 url: '../../calendarFinal/editEventDate.php',
			 type: "POST",
			 data: {Event:Event},
			 success: function(rep) {
					if(rep == 'OK'){
						alert('Saved');
					}else{
						alert('Could not be saved. try again.');
					}
				}
			});
		}

	});

</script>
