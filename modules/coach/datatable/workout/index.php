<head>
    <script src="../../js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
</head>

<div class="content-container">
    <div class="submenu-left list-nav">
        <h3>Workout Plans</h3>
        
        <hr>
        
        <div id="workout_nav">
        </div>
    </div>
    
    <div class="mod-content">
        <div class="workout-btn">
            <span id="clc_name" class="text-light">Workout Plans > All </span>
            
            <button id="add_button" type="button" toggle="modal" data-target="#workoutNew" class="btn btn-sm btn-info add">New Workout</button>
        </div>
        
        <div class="box box-red workout-left">
            <h3>Select a Workout</h3>
            
            <div class="table-responsive">
                <table class="table table-border" id="workout_table" style="width: 100%;">
                    <thead style="display:none;">
                        <tr>
                            <th></th>
                            <th width="5%"></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        
        <div class="workout-right">
            <div id="activities_list" class="box">
                <span id="edit_btn"></span>
                <h4 id="table_name"></h4>
                
                <table class="table table-border" id="activity_table" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>Activity</th>
                            <th width="15%">Sets</th>
                            <th width="10%"></th>
                        </tr>
                    </thead>
                </table>
            </div>
            <br>
            <div id="activities_add" class="box">
                <p>Add Activities</p>
                
                <form method="post" id="activity_form" enctype="multipart/form-data">
                    <div id="activity_add"></div>
                    <br>
                    <span id="activity_btn"></span>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="workoutNew" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="workout_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title" id="wrk_title">Add New Workout Plan</h4>
                </div>
                
                <div class="modal-body">
                    <form>
                        <div class="wrk_step">
                            <div>
                                <p class="text-light">Workout Information</p>
                            </div>

                            <div>
                                <label>Name</label>
                                <input type="text" name="wrk_name" id="wrk_name" class="form-control" />
                                <br />

                                <label>Description</label>
                                <textarea rows="5" cols="80" type="text" name="wrk_description" id="wrk_description" class="form-control"></textarea>
                                <br />
                                
                                <label>Available: </label><br>
                                <?php
                                    $class = $category->get_categories();
                                
                                    foreach($class as $value){
                                ?>
                                <input type="checkbox" name="wrk_class[]" value="<?php echo $value['clc_id'];?>" class="checkbox-inline" /><?php echo $value['clc_name'];?>
                                <?php
                                    }
                                ?>
                                <br>
                            </div>
                            
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                <input type="hidden" name="wrk_action" id="wrk_action" value="ADD" />
                                <input type="hidden" name="wrk_id" id="wrk_id" value="0" />
                                <input type="submit" name="submit" class="btn btn-success" value="Save" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $.ajax({
            url:"datatable/workout/onload.php",
            method:"POST",
            dataType:"JSON",
            data:{clc_id:'<?php echo $sub;?>'},
            success:function(data)
            {
                $('#workout_nav').append(data.list_nav);
                $('#clc_name').text(data.clc_name);
                
                var workoutTable = $('#workout_table').DataTable({
                    "processing":true,
                    "serverSide":true,
                    "order":[],
                    "ajax":{
                        url:"datatable/workout/fetch.php",
                        type: "POST",
                        data:{clc_id:'<?php echo $sub;?>'}
                    },
                    "columnDefs":[
                        //{
                            { orderable: false, targets: '_all' }
                        //},
                    ],
                    "paging":false,
                    "bInfo": false,
                    //"bFilter": false
                });
            }
        });
        
        $(document).on('click', '.view', function(){
            
            $('#edit_btn').empty();
            
            var wrk_id = $(this).attr("id");
            
            var activityTable = $('#activity_table').DataTable({
                "destroy":true,
                "processing":true,
                "serverSide":true,
                "order":[],
                "ajax":{
                    url:"datatable/workout/fetch_detail.php",
                    type: "POST",
                    data:{wrk_id:wrk_id}
                },
                "columnDefs":[
                    //{
                        { orderable: false, targets: '_all' }
                    //},
                ],
                "paging":false,
                "bInfo": false,
                "bFilter": false
            });
            
            $.ajax({
                url:"datatable/workout/fetch_detail.php",
                type:"POST",
                dataType:"JSON",
                data:{wrk_id:wrk_id},
                success: function(data)
                {
                    $('#table_name').text('');
                    $('#edit_btn').empty();
                    
                    $('#table_name').text(data.table_name);
                    $('#edit_btn').append(data.edit_btn);
                    
                    $('#activity_btn').append(data.activity_btn);
                    $('#activity_add').empty();
                    $('#activity_add').append(data.activity_add);
                }
            });
        });
        
        $('#add_button').click(function(){
            $('#wrk_title').text("New Workout Plan");
            $('#workout_form')[0].reset();
            $('#workoutNew').modal('show');
        });
        
        $(document).on('submit', '#workout_form', function(event){
            event.preventDefault();
                
            var wrk_name = $('#wrk_name').val();
            var wrk_descrip = $('#wrk_description').val();
            var action = $('#wrk_action').val();
            
            var classes = new Array();

            if(wrk_name != '' && wrk_descrip != '')
            {
                    $.ajax({
                        url:"datatable/workout/insert.php",
                        method:'POST',
                        data:new FormData(this),
                        contentType:false,
                        processData:false,
                        success:function(data)
                        {
                            $('#workout_form')[0].reset();
                            $(".modal-backdrop").remove();
                            $('#workoutNew').modal('hide');
                            
                            $('#workout_table').DataTable().ajax.reload();
                            activityTable.destroy();
                            $('#table_name').empty();
                            $('#edit_btn').empty();
                            $('#activity_btn').empty();
                            $('#activity_add').empty();
                            
                            alert(data);
                        }
                    });
            }
            else
            {
                alert("All Fields are Required");
            }
        });
        
        $(document).on('click', '.edit', function(){
            var wrk_id = $(this).attr("id");
            
            $.ajax({
                url:"datatable/workout/fetch_detail.php",
                type:"POST",
                dataType:"JSON",
                data:{wrk_id:wrk_id},
                success: function(data)
                {
                    $('#wrk_title').text("Edit Workout Plan");
                    $('#wrk_name').val(data.wrk_name);
                    $('#wrk_description').val(data.wrk_desc);
                    $('#wrk_id').val(wrk_id);
                    $('#wrk_action').val("EDIT");
                }
            });
        });
        
        $(document).on('submit', '#activity_form', function(event){
            event.preventDefault();
                
            var act_name = $('#act_name').val();
            var wra_sets = $('#wra_sets').val();
            
            var classes = new Array();

            if(act_name != '' && wra_sets != 0 && wra_sets != '')
            {
                $.ajax({                        
                    url:"datatable/workout/insertactivity.php",
                    method:'POST',
                    data:new FormData(this),
                    contentType:false,
                    processData:false,
                    success:function(data)
                    {
                        alert(data);
                        $('#activity_table').DataTable().ajax.reload();
                        //activityTable.ajax.reload();
                        $('#activity_form')[0].reset();
                    }
                });
            }
            else
            {
                alert("All Fields are Required");
            }
        });
        
        $(document).on('click', '.remove', function(){
            var wra_id = $(this).attr("id");
            
            $.ajax({
                url:"datatable/workout/remove.php",
                type:"POST",
                data:{wra_id:wra_id},
                success: function(data)
                {
                    alert(data);
                    $('#activity_table').DataTable().ajax.reload();
                }
            });
        });
    });
</script>