<head>
    <script src="../../js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
</head>

<div class="table-responsive">
    <div class="table-responsive">
        <h3>Transactions</h3>
        <table id="transaction_table" class="table table-border table-striped" style="width: 100%;">
            <thead>
                <tr>
                    <th>Date  
                        <select id="0" class="trans-search-input form-control input-sm" value="<?php echo date('Y');?>">
                            <?php
                                for($i=2016;$i<=date('Y');$i++){
                            ?>
                            <option value="<?php echo $i;?>" <?php if($i == date('Y')) echo 'selected';?>><?php echo $i;?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </th>
                    <th>Code</th>
                    <th>Items</th>
                    <th>Total</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
         var transTable = $('#transaction_table').DataTable({
            "processing":true,
            "serverSide":true,
            "order":[],
            "ajax":{
                url:"datatable/transaction/fetch.php",
                type: "POST",
                data:{cust_id:<?php echo $_SESSION['id'];?>},
            },
            "columnDefs":[
                {
                    "targets":[0,1,2,3],
                    "orderable":false,
                },
            ],
            "paging":false,
            "bInfo": false,
        });
             
        $("#transaction_table_filter").css("display","none");
             
        $('.trans-search-input').on('keyup click change', function(){   
            var i =$(this).attr('id');  // getting column index
            var v =$(this).val();  // getting search input value
            
            transTable.columns(i).search(v).draw();
        });
        
        $(document).on('click', '.details', function(){
            
        });
    });
</script>