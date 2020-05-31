<h3>Pending Clients</h3>
<span>with membership requests</span>
<br>
<br>
<table id="pending_membership" class="table table-border table-striped">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Membership</th>
            <th>Action</th>
        </tr>
    </thead>
</table>


<script type="text/javascript">
    $(document).ready(function(){
        var membershipTable = $('#pending_membership').DataTable({
            "processing":true,
            "serverSide":true,
            "order":[],
            "ajax":{
                url:"datatable/member/fetch.php",
                type: "POST"
            },
            "columnDefs":[
                {
                    "targets":[0,1,2,3],
                    "orderable":true,
                },
            ],
        });
        
        $(document).on('click', '.confirm', function(e){
            var cust_id = $(this).attr("id");
            var met_id = $(this).attr("met");
            
            if(confirm("Confirm membership?"))
            {
                e.stopImmediatePropagation();
                
                $.ajax({
                    url:"datatable/member/confirm.php",
                    method:"POST",
                    data:{cust_id:cust_id,met_id:met_id},
                    success:function(data)
                    {
                        alert(data);
                        membershipTable.ajax.reload();
                    }
                });
            }
            else
                return false;
        });
        
        $(document).on('click', '.delete', function(e){
            var trns_id = $(this).attr("id");
            var met_id = $(this).attr("met");
            
            if(confirm("Delete request?"))
            {
                e.stopImmediatePropagation();
                
                $.ajax({
                    url:"datatable/member/delete.php",
                    method:"POST",
                    data:{trns_id:trns_id,met_id:met_id},
                    success:function(data)
                    {
                        alert(data);
                        membershipTable.ajax.reload();
                    }
                });
            }
            else
                return false;
        });
        
        $(document).on('click', '.new', function(e){
            var cust_id = $(this).attr("id");
            var met_id = $(this).attr("met");
            
            if(confirm("Confirm membership?"))
            {
                e.stopImmediatePropagation();
                
                $.ajax({
                    url:"datatable/member/new.php",
                    method:"POST",
                    data:{cust_id:cust_id,met_id:met_id},
                    success:function(data)
                    {
                        alert(data);
                        membershipTable.ajax.reload();
                    }
                });
            }
            else
                return false;
        });
    });
</script>