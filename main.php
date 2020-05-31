<!-- SAMPLE -->
        <section class="bg-primary" id="about">
            <div class="container">
                <div class="row">
                    <div class="about-right">
                        <?php
                            if(!isset($_SESSION['login'])){
                        ?>
                        <div class="module form-module">
                            <img src="img/logo.png" alt="logo" style="width: 30%;margin-left: 35%;margin-top: 5%;"/>

                            <div class="form">
                                <h2>Member Login to 6100</h2>
                                <form id="login" action="" method="POST" name="login">
                                  <input id="email" type="text" name="email" placeholder="Email"/>
                                  <input id="password" type="password" name="password" autocomplete="off" placeholder="Password"/>
                                    <input id="operation" type="hidden" name="operation" value="member" />
                                  <input id="button" type="submit" name="submit" value="Log In"/>
                                </form>

                                  <div class="cta toggle">Staff Portal</div>
                            </div>

                            <div class="form">
                                <h2>Staff Login to 6100</h2>
                                    <form id="login" action="" method="POST" name="login">
                                        <input id="email" type="text" name="email" placeholder="Staff Email"/>
                                        <input id="password" type="password" name="password" autocomplete="off" placeholder="Password"/>
                                        <input id="operation" type="hidden" name="operation" value="staff" />
                                        <input id="button" type="submit" name="submit" value="Log In"/>
                                    </form>

                                    <div class="cta toggle">Member Portal</div>
                            </div>
                        </div>

                        <script type="text/javascript">
                            $('.toggle').click(function(){
                              // Switches the Icon
                              $(this).children('i').toggleClass('fa-pencil');
                              // Switches the forms
                              $('.form').animate({
                                height: "toggle",
                                'padding-top': 'toggle',
                                'padding-bottom': 'toggle',
                                opacity: "toggle"
                              }, "slow");
                            });
                        </script>
                        <?php
                            }
                            else{
                        ?>
                        <img src="img/logo.png" alt="logo"/>
                        <?php
                            }
                        ?>
                    </div>

                    <div class="about-left">
                        <h2 class="section-heading text-center">Let's get fit!</h2>
                        <hr class="light">
                        <p class="text-faded">Training in martial arts is an exciting way to improve your fitness, body composition, and health. It promotes fat loss and improves body composition because they blend functional movements with strength training, cardiovascular conditioning, agility, mobility and flexibility, spatial awareness, and gross motor control. And if you choose wisely you'll get some great self defense skills as a bonus.</p>
                        <p class="text-faded">Oh, and being a member in our gym has benefits too!
                        <a href="#classes" style="color:white;font-weight:bold;">Click here</a> to learn more about our membership.</p>
                        <p><b>You can choose from the following classes below:</b></p>
                    </div>
                </div>
            </div>
        </section>

        <section class="no-padding" id="services">
            <div class="container-fluid">
                <div class="row no-gutter popup-gallery">
                    <?php
                        $classcat = $category->get_categories();
                        foreach($classcat as $row){
                    ?>
                    <div class="col-lg-4 col-sm-6">
                        <a id="<?php echo $row['clc_id'];?>" class="portfolio-box">
                            <img src="img/classes/<?php echo $row['clc_id'];?>.jpg" class="img-responsive" alt="">
                            <div class="portfolio-box-caption">
                                <div class="portfolio-box-caption-content">
                                    <div class="project-category text-faded">
                                        Classes Offered
                                    </div>
                                    <div class="project-name">
                                        <?php echo $row['clc_name'];?>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php
                        }
                    ?>

                    <div class="col-lg-6 col-sm-6">
                        <a id="membership" class="portfolio-box portfolio-lg">
                        <img src="img/classes/membership.jpg" class="img-responsive" alt="">
                            <div class="portfolio-box-caption">
                                <div class="portfolio-box-caption-content">
                                    <div class="project-category text-faded">
                                        Services Offered
                                    </div>
                                    <div class="project-name">
                                        MEMBERSHIPS
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-6 col-sm-6">
                        <div class="portfolio-box portfolio-lg">
                            <div id="service-content" class="service-padding">
                                <div class="col-lg-12 text-center main-calendar">
                                    <h2><?php echo file_get_contents('svg/ic_gym.svg');?><br>Select a service to view rates.</h2>
                                    <p>Click an image.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="video" class="bg-black">
            <div class="container-fluid">
                <div class="row no-gutter popup-gallery">
                    <div class="row">
                        <div class="col-lg-4 text-center service-padding">
                            <div class="col-lg-12">
                                <h1>Kick your way to your #fitnessgoal.</h1>
                                <span>Visit 6100 Martials Arts & Fitness Gym for faster results.</span>
                                <br><br><br>
                                <button toggle="modal" data-target="#tipsModal" class="btn btn-xl btn-main btn-primary tips">View Tips</button>
                            </div>
                        </div>
                        <div class="col-lg-8 text-center">
                            <iframe src="https://www.facebook.com/plugins/video.php?href=https%3A%2F%2Fwww.facebook.com%2Fadrian.hillana%2Fvideos%2F1794180917274223%2F&show_text=0&width=840" width="85%" height="415px" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allowFullScreen="true"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="events" class="no-padding bg-white">
            <div class="row">
                <div class="col-lg-5 text-center" style="max-height:720px;">
                    <div class="announcements">
                        <?php echo file_get_contents('svg/ic_announcement.svg');?>
                        <br>

                        <table class="table table-border">
                            <?php
                                $announcement = $staff->get_announcements();

                                if(!empty($announcement)){
                                    foreach($announcement as $row){
                            ?>
                            <tr>
                                <td>
                                    <span>Date posted: <?php echo date('F d, Y', strtotime($row['ann_date']));?></span>
                                    <h4><?php echo $row['ann_title'];?></h4>
                                    <span><?php echo $row['ann_content'];?></span>
                                </td>
                            </tr>
                            <?php
                                    }
                                }
                            ?>
                        </table>
                    </div>
                    <img src="img/events.jpg" class="img-responsive" alt="events" style="height:720px;max-width:unset;">
                </div>
                <div class="col-lg-7 text-center main-calendar">
                    <div>
                        <h4>Calendar of Events</h4>

                        <div id="calendarmain" class="col-centered">
                            <?php
                                $sql = "SELECT * FROM tbl_event E, tbl_eventdetail ED WHERE E.evn_id = ED.evn_id AND E.evn_status <> 'CANCELED'";
                                $req = $connection->prepare($sql);
                                $req->execute();
                                $events = $req->fetchAll();
                            ?>
                        </div>

                        <span class="txt-small">*Visit our <a href="https://www.facebook.com/MMA6100/">Facebook page</a> for more information.</span>
                    </div>
                </div>
            </div>
        </section>

        <section id="registration">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h2 class="section-heading">Avail A Membership</h2>
                        <hr class="primary">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-6 text-center">
                        <div class="service-box">
                            <i class="fa fa-4x fa-diamond text-primary sr-icons"><?php echo file_get_contents('svg/ic_discount.svg');?></i>
                            <h3>Get Special Discounts</h3>
                            <p class="text-muted">Get special enrollment discounts on all classes.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 text-center">
                        <div class="service-box">
                            <i class="fa fa-4x fa-paper-plane text-primary sr-icons"><?php echo file_get_contents('svg/ic_online_prof.svg');?></i>
                            <h3>Online Member Profiles</h3>
                            <p class="text-muted">Go online and view all your records and profile. Also, check out our other online features!</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 text-center">
                        <div class="service-box">
                            <i class="fa fa-4x fa-newspaper-o text-primary sr-icons"><?php echo file_get_contents('svg/ic_up_to_date.svg');?></i>
                            <h3>Stay Up to Date</h3>
                            <p class="text-muted">We keep you updated on events and promos. Never miss an occassion with us.</p>
                        </div>
                    </div>
                </div>

                <br>
                <br>

                <div class="row">
                    <div class="col-lg-12 col-md-10 text-center">
                        <?php
                            if(!isset($_SESSION['level'])){
                        ?>
                        <button id="<?php echo $register = (isset($_SESSION['id'])) ? $_SESSION['id']: '';?>" class="btn btn-success btn-xl sr-button register" toggle="modal" data-target="#registrationModal">Register Now</button>
                        <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
        </section>

        <section id="contact" class="bg-dark">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2 text-center">
                        <h2 class="section-heading">Contact Us</h2>
                        <hr class="primary">
                    </div>

                    <div class="contact-left">
                        <script>
                            function initMap() {
                                var location = {lat: 10.677275, lng: 122.954113};

                                var map = new google.maps.Map(document.getElementById('map'), {
                                    center: location,
                                    zoom: 18
                                });

                                var marker = new google.maps.Marker({
                                  position: location,
                                  map: map
                                });
                            }
                        </script>

                        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyANhmxXSotE4QlT-tAOhd_WdIYa2EYCpQc&callback=initMap"></script>
                        <div id="map" style="width: 100%; height: 450px;"></div>
                    </div>

                    <div class="contact-right">
                        <div>
                            <p><?php echo file_get_contents('svg/ic_place.svg');?> 10th Lacson Street, Bacolod City, 6100</p>
                        </div>
                        <div>
                            <p><?php echo file_get_contents('svg/ic_phone.svg');?> 435-8795</p>
                        </div>
                        <div>
                            <p>
                                <?php echo file_get_contents('svg/ic_computer.svg');?> <a href="https://www.facebook.com/MMA6100/">facebook.com/MMA6100</a>
                            </p>
                        </div>
                        <div>
                            <p>
                                <?php echo file_get_contents('svg/ic_camera.svg');?> <a href="https://www.instagram.com/leverage6100">instagram.com/leverage6100</a>
                            </p>
                        </div>
                        <div>
                            <h4><?php echo file_get_contents('svg/ic_time.svg');?>Operating Hours:</h4>
                            <span>6:00AM - 11:00AM</span><br>
                            <p>Mon - Fri</p>

                            <span>2:00PM - 8:00PM</span>
                            <p>Sat</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

<!-- Modal For Event -->
<div class="modal fade" id="ModalDetails" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="calendarmain-modal-dialog" role="document">
        <div class="modal-content">
            <form class="form-horizontal" method="POST" action="editEventTitle.php">

			     <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="myModalLabel">Event Details</h4>
                </div>

                <div class="modal-body">
                    <div class="form-group event-poster-form">
                        
                        <div id="event-poster"></div>
                    </div>
                
                    <div class="event-det-form">
                        <div class="form-group">
                           <label for="title" class="col-sm-2 control-label">Title</label>
                            <br>
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

<!--Modal For Register-->
<div id="registrationModal" class="modal fade">
	<div class="modal-dialog">
		<form method="post" id="registration_form" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Registration</h4>
				</div>

				<div class="modal-body">
                    <div id="registration-right">
                        <label>First Name</label>
                        <input type="text" id="firstName" name="firstName" class="form-control" />
                        <br>
                        
                        <label>Last Name</label>
                        <input type="text" id="lastName" name="lastName" class="form-control" />
                        <br>
                        
                        <label>Email</label>
                        <input type="text" id="register_email" name="email" class="form-control" />
                        <br>
                        
                        <label>Birthday</label>
                        <input type="date" id="birthday" name="birthday" class="form-control" />
                        <br>
                        
                        <label>Password</label>
                        <input type="password" id="register_password" name="password" class="form-control" />
                        <br>
                        
                        <label>Confirm Password</label>
                        <input type="password" id="register_confirmpassword" name="confirmpassword" class="form-control" />
                        <br>
                        
                        <label>Contact Number</label>
                        <input type="text" id="contact" name="contact" class="form-control" placeholder="Optional"/>
                        <br>
                        
                        <label>Emergency Contact</label>
                        <input type="text" id="emergency" name="emergency" class="form-control" placeholder="Optional" />
                        <br>
                    </div>
					
                    <div id="registration-left">
                        <h4>Select a membership</h4><br>
                        <?php
                            $list = $staff->get_memberships();
                            if(!empty($list)){
                                foreach($list as $membership){
                        ?>
                        <input type="radio" id="membership" name="membership" value="<?php echo $membership['met_id'];?>"> <?php echo $name = $membership['met_name'].' - Php '.$membership['met_rate'];?>
                        <br>
                        <br>
                        <?php
                                }
                            }
                        ?>
                    </div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <input type="submit" name="action" id="action" class="btn btn-success" value="Register" />
				</div>
			</div>
		</form>
	</div>
</div>

<div id="servicesModal" class="modal fade">
	<div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="service-title"></h4>
                <span>Enroll Today at 6100 Martial Arts & Fitness</span>
            </div>

            <div class="modal-body">
				<div>
                    <div id="service-content-modal"></div>
                </div>
            </div>
        </div>
	</div>
</div>

<div id="tipsModal" class="modal fade">
	<div class="modal-dialog modal-lg">
        <div class="modal-content bg-dark">
            <div class="modal-header" style="border-bottom:unset;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <p class="text-center">Begin your martial arts journey with us.</p>
            </div>

            <div class="modal-body">
				<div>
                   <iframe width="854" height="480" src="https://www.youtube.com/embed/yi9ClPA44dk" frameborder="0" allowfullscreen></iframe>
                </div>
                <br>
                <div>
                    <div class="row">
                        <div class="col-lg-4 col-md-6 text-center">
                            <i class="fa fa-4x fa-newspaper-o text-primary sr-icons"><?php echo file_get_contents('svg/ic_research.svg');?></i>
                            <h4>Do your research</h4>
                            <span>Before joining a gym to start getting into the MMA, you need to research options. Join a gym where MMA is a key player. A gym where lots of MMA fighters attend is the best to go for your classes. Lanna MMA is the leading school which allows students to graduate from one level to the next. In fact our classes can now fit everyone’s schedule and run six days a week.</span>
                        </div>
                        <div class="col-lg-4 col-md-6 text-center">
                            <i class="fa fa-4x fa-newspaper-o text-primary sr-icons"><?php echo file_get_contents('svg/ic_enjoy.svg');?></i>
                            <h4>Do you enjoy it?</h4>
                            <span>Before you join the classes, you have to figure out if you really enjoy the sport. One thing people don’t know is that even if they have experience in other martial disciplines, MMA might not be right for them. So, take your time to figure out if your really enjoy it.</span>
                        </div>
                        <div class="col-lg-4 col-md-6 text-center">
                            <i class="fa fa-4x fa-newspaper-o text-primary sr-icons"><?php echo file_get_contents('svg/ic_honest.svg');?></i>
                            <h4>Be honest</h4>
                            <span>Once you have made your decision to keep at it, the next thing you need to do is to get open about your fitness levels. This way, your trainer will know where to begin because they don’t want you to end up harming yourself. And you should never worry about being embarrassed; recall everyone has to begin from somewhere.</span>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-4 col-md-6 text-center">
                            <i class="fa fa-4x fa-newspaper-o text-primary sr-icons"><?php echo file_get_contents('svg/ic_stretch.svg');?></i>
                            <h4>Always stretch</h4>
                            <span>You need to understand that MMA is not just about strength. In this discipline, flexibility also plays a big part. It is prudent to stretch after the MMA workouts because that is the way to help you improve your flexibility. And for your information, this is likely to become the easiest part of your training. Do not skip stretching; it can put you back at the starting point.</span>
                        </div>
                        <div class="col-lg-4 col-md-6 text-center">
                            <i class="fa fa-4x fa-newspaper-o text-primary sr-icons"><?php echo file_get_contents('svg/ic_bodybuilding.svg');?></i>
                            <h4>Forget about bodybuilding</h4>
                            <span>MMA and bodybuilding are like oil and water; they don’t mix. Although you need a high level of strength so as to overpower your opponents, lots of bodybuilding can drastically limit yourself. You should note that MMA and bodybuilding use very different techniques. For instance, while MMA is fluid in its techniques, bodybuilding is single jointed and static. However, MMA still requires that you do some weight training but forget about bulging muscles like the weightlifters.</span>
                        </div>
                        <div class="col-lg-4 col-md-6 text-center">
                            <i class="fa fa-4x fa-newspaper-o text-primary sr-icons"><?php echo file_get_contents('svg/ic_core.svg');?></i>
                            <h4>Work on your core</h4>
                            <span>If you train in your core, you will be able to increase your power of kicks and punches. Your core is where your strength comes from and is the center of your being.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
</div>


<script src="js/moment.min.js"></script>
<script src="js/fullcalendar.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('click', '.portfolio-box', function(){
            var id = $(this).attr("id");

            $.ajax({
                url:"modules/admin/datatable/class/fetch_category.php",
                method:"POST",
                data:{id:id},
                dataType:"JSON",
                success:function(data)
                {
                    //show modal
                    $('#servicesModal').modal('show');

                    //append for modal
                    $('#service-title').text(data.title);
                    $('#service-content-modal').empty();
                    $('#service-content-modal').append(data.tbl);
                }
            });
        });

        $('#calendarmain').fullCalendar({
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
                  $('#ModalDetails #event-poster').empty();
                  $('#ModalDetails #event-poster').append(event.imageUrl);
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
              $image = '<img src='. substr($event['evn_image'], 12).'>';
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

        $(document).on('click', '.register', function(){
            var cust_id = $(this).attr("id");

            $('#registrationModal').modal('show');
            
            /*if(cust_id != ''){
                //show register modal
                $('#registrationModal').modal('show');
            }
            else{
                alert('You must have a client record with 6100 Martial Arts and Fitness to register. Login to continue.');
            }*/

            $(document).on('submit', '#registration_form', function(event){
                event.preventDefault();

                var firstName = $("#firstName").val();
                var lastName = $("#lastName").val();
                var email = $("#register_email").val();
                var birthday = $("#birthday").val();
                var password = $("#register_password").val();
                var confirmpass = $("#register_confirmpassword").val();
                
                var membership = $("input[name=membership]:checked").val();
                
                if(firstName != null && lastName != null && email != null && password != null && confirmpass != null && birthday != null){
                    if(membership != null){
                        //check if password and confirm are same
                        if(password == confirmpass){
                            $.ajax({
                                url:"modules/customer/datatable/registration/register.php",
                                method:'POST',
                                data:new FormData(this),
                                contentType:false,
                                processData:false,
                                success:function(data)
                                {
                                    alert(data);
                                    $('#registrationModal').modal('hide');
                                }
                            });
                        }
                        else
                            alert('Passwords do not match.');
                    }
                    else
                        alert('Please select a membership.');
                }
                else
                    alert('Please enter required fields.');

                /*if(met_id != null){
                    register_membership(cust_id,met_id);
                    $('#registrationModal').modal('hide');
                }
                else
                    alert('Select a membership!');*/
            });
        });
        
        $(document).on('click', '.tips', function(){
            $('#tipsModal').modal('show');
        });
    });
</script>
