<head>
    <script src="../../js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
</head>

<div class="content-container">
    <?php
        include('function.php');
        
        $temp_cust = (isset($_SESSION['temp_cust'])) ? $_SESSION['temp_cust'] : '0' ;
    ?>
    <div class="right-enroll">
        <div class="box enroll-container">
            <div class="right-header">
                <div id="trns_id"></div>
            </div>
            
            <div class="right-body">
                <div>
                    <table style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        
                        <tbody id="list_data">
                            
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="right-footer">
                <div id="trns_btn"></div>
            </div>
        </div>
    </div>
    
    <div id="trns_items" class="left-enroll">
    </div>
</div>
    
<div id="clientSearch" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="user_form" action="index.php?mod=enroll" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Search Client</h4>
                </div>

                <div class="modal-body">
                    <div class="box table-responsive" id="client_search">
                        <table id="client_data" class="table table-border table-striped" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Membership</th>
                                    <th>Email</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
    
<div id="clientNew" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="user_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add New Client</h4>
                </div>
                
                <div class="modal-body">
                    <label>First Name</label>
					<input type="text" name="custfname" id="cust_firstname" class="form-control" />
					<br />
					<label>Last Name</label>
					<input type="text" name="custlname" id="cust_lastname" class="form-control" />
					<br />
					<label>Email</label>
					<input type="text" name="custemail" id="cust_email" class="form-control" />
					<br />
                    <label>Password</label>
					<input type="password" autocomplete="off" name="custpassword" id="cust_password" class="form-control" />
					<br />
                    <label>Confirm Password</label>
					<input type="password" autocomplete="off" name="confirmpassword" id="confirm_password" class="form-control" />
					<br />
                </div>
                
                <div class="modal-footer">
                    <input type="hidden" name="cust_id" id="cust_id" />
                    <input type="hidden" name="operation" id="operation" />
                    <input type="submit" name="action" id="action" class="btn btn-success" value="Add" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="promoView" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
                
            <div class="modal-body">
                <table id="promo_data" class="table table-border" style="width: 100%;">
                    <thead>
                        <tr style="display:hidden;">
                            <th>Select Promo</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function(){
        //check for current transaction on load
        $.ajax({
            url:"datatable/enroll/onload.php",
            method:"POST",
            dataType:"JSON",
            success:function(data)
            {
                $('#trns_items').append(data.trns_items);
                $('#trns_id').append(data.trns_id);
                $('#list_data').append(data.list_data);
                $('#trns_btn').append(data.trns_btn);
            }
        });
        
        $(document).on('click', '.enroll', function(){
            var action = 'class';
            var cls_id = $(this).attr("id");
            var cust_id = <?php echo $temp_cust;?>;
                
            if(cust_id != 0){
                $.ajax({
                    url:"datatable/enroll/enroll.php",
                    method:"POST",
                    data:{cls_id:cls_id,cust_id:cust_id,action:action},
                    success:function(data)
                    {
                        alert(data);
                        location.reload();
                    }
                });
            }
        });
            
        $(document).on('click', '.membership', function(){
            var action = 'membership';
            var met_id = $(this).attr("id");
            var cust_id = <?php echo $temp_cust;?>;
                
            if(cust_id != 0){
                $.ajax({
                    url:"datatable/enroll/enroll.php",
                    method:"POST",
                    data:{met_id:met_id,cust_id:cust_id,action:action},
                    success:function(data)
                    {
                        alert(data);
                        location.reload();
                    }
                });
            }
        });
        
        $(document).on('click', '.remove', function(e){
            var id = $(this).attr("id");
            var type = $(this).attr("action");
            
            if(confirm("Remove item?")){
                e.stopImmediatePropagation();
                
                $.ajax({
                    url:"datatable/enroll/remove.php",
                    method:"POST",
                    data:{id:id,type:type},
                    success:function(data)
                    {
                        alert(data);
                        location.reload();
                    }
                });
            }
        });
        
        $(document).on('click', '.cancel', function(e){
            if(confirm("Cancel current transaction?")){
                e.stopImmediatePropagation();
                
                $.ajax({
                    url:"datatable/enroll/cancel.php",
                    method:"POST",
                    success:function(data)
                    {
                        alert(data);
                        location.reload();
                    }
                });
            }
        });
        
        $(document).on('click', '.pay', function(e){
            e.preventDefault();
            var stf_id = <?php echo $_SESSION['id'];?>;
            var cust_id = <?php echo $temp_cust;?>;
            
            if(cust_id != 0){
                if(confirm("Confirm Transaction?")){
                    e.stopImmediatePropagation();
                    
                    $.ajax({
                        url:"datatable/enroll/pay.php",
                        type:"POST",
                        data:{cust_id:cust_id,stf_id:stf_id},
                        dataType:"JSON",
                        async:false,
                        success:function(data)
                        {
                            alert(data.message);
                            location.reload();
                            //trns_id.push(data.trns_id);
                            print_receipt(data.trns_id);
                        }
                    });
                }
            }  
        });
        
        function print_receipt(trns_id){
            window.open ("datatable/transactions/print_receipt.php?id="+trns_id);
        }
        
        $(document).on('click', '.new', function(){
            var clientTable = $('#client_data').DataTable({
                "destroy":true,
                "processing":true,
                "serverSide":true,
                "order":[],
                "ajax":{
                    url:"datatable/enroll/client.php",
                    method:"POST"
                },
                "columnDefs":[
                    {
                        "targets":[0,1,2,3],
                        "orderable":false
                    },
                ],
            });
            
            $('#clientSearch').modal('show');
            
            $('#add_button').click(function(){
                $('#user_form')[0].reset();
                $('#action').val("Add");
                $('#operation').val("Add");
            });
            
            $(document).on('submit', '#user_form', function(event){
                event.preventDefault();
                var custFirstname = $('#cust_firstname').val();
                var custLastname = $('#cust_lastname').val();
                var custEmail = $('#cust_email').val();
                if(custFirstname != '' && custLastname != '' && custEmail != '' && custPassword != '' && confirmPassword != '')
                {
                    $.ajax({
                        url:"datatable/client/insert.php",
                        method:'POST',
                        data:new FormData(this),
                        contentType:false,
                        processData:false,
                        success:function(data)
                        {
                            $('#user_form')[0].reset();
                            $('#clientNew').modal('hide');
                            alert(data);
                            clientTable.ajax.reload();
                        }
                    });
                }
                else
                {
                    alert("All Fields are Required");
                }
            }); 
            
            $(document).on('click', '.select', function(e){
                var cust_id = $(this).attr("id");

                if(confirm("Confirm client?"))
                {
                    e.stopImmediatePropagation();
                    
                    $.ajax({
                        url:"datatable/enroll/newtemp.php",
                        method:"POST",
                        data:{cust_id:cust_id},
                        success:function(data)
                        {
                            //alert(data);
                            
                            $('#clientSearch').modal('hide');
                            location.reload();
                            
                            //$('.left-enroll').reload();
                        }
                    });
                }
                else
                    return false;
            });
            
            $('#clientSearch').on('hidden.bs.modal', function () {
                clientTable.destroy();
            });
            
            $('#clientNew').on('hidden.bs.modal', function () {
                clientTable.ajax.reload();
            });
        });
        
        $(document).on('click', '.promo', function(){
            var trtp_id = $(this).attr("id");
            var action = $(this).attr("action");
            var type = $(this).attr("cls");

            var promoTable = $('#promo_data').DataTable({
                "destroy":true,
                "processing":true,
                "serverSide":true,
                "order":[],
                "ajax":{
                    url:"datatable/enroll/promo.php",
                    method:"POST",
                    data:{action:action,type:type}
                },
                "columnDefs":[
                    {orderable: false, targets: '_all'}
                ],
                "paging": false,
                "bInfo": false,
                "bFilter": false
            });
            
            $(document).on('click', '.selectpromo', function(e){
                var prm_id = $(this).attr("id");

                if(confirm("Select promo?"))
                {
                    e.stopImmediatePropagation();
                    
                    $.ajax({
                        url:"datatable/enroll/selectpromo.php",
                        method:"POST",
                        data:{trtp_id:trtp_id,prm_id:prm_id},
                        success:function(data)
                        {
                            $('#promoView').modal('hide');
                            alert(data);
                            location.reload();
                        }
                    });
                }
                else
                    return false;
            });
        });
    });
        /*$(document).on("click", ".print", function(e){
            e.preventDefault();
            var id = $(this).attr("id");
                
            window.open ("datatable/transactions/print_receipt.php?id="+id);
        });*/
</script>