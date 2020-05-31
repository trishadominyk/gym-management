<?php
    include '../admin/dashboard/function.php';
?>

<head>
    <script src="../../js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script src="../../js/bootstrapv337.min.js"></script>
    <script src="../../js/Chart.bundle.js"></script>
</head>

<div class="content-container">
    <div class="log-summary">
        <div class="logbook-table table-responsive box">
            <div>
                <span class="text-light">Sales > Transactions</span>
            </div>
            <br>
            
            <table id="logbook_table" class="table table-border table-striped" style="width: 100%;">
                <thead>
                    <tr style="background-color: white; color: #b01f24;">
                        <td colspan="2"valign="middle" class="date_today">From: <input type="date" id="0" class="log-search-input form-control input-sm datepicker"></td>
                        <td colspan="2"valign="middle" class="date_today">To: <input type="date" id="0" class="log-search-input form-control input-sm datepicker"></td>
                    </tr>
                    <tr>
                        <th width="18%">Date</th>
                        <th>Code</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Customer</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    
    <div class="log-statistics">
        <div class="stats-box stats-box-lg box box-gray">
            <h4>Php 
                <?php
                    echo $sales = number_format(count_daily_sales(),2);
                ?>
            </h4>
            <hr>
            <p>Today's Sales</p>
        </div>
        
        <div class="stats-box stats-box-lg box">
            <?php require_once 'datatable/transactions/chart.php';?>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        var logTable = $('#logbook_table').DataTable({
            "processing":true,
            "serverSide":true,
            "order":[],
            "ajax":{
                url:"datatable/transactions/fetch.php",
                type: "POST"
            },
            "columnDefs":[
                //{
                    { orderable: true, targets: 1 },
                    { orderable: true, targets: 2 },
                    { orderable: true, targets: 3 },
                    { orderable: false, targets: '_all' }
                //},
            ]
        });
        
        $("#logbook_table_filter").css("display","none");
        
        $('.log-search-input').on('keyup click change', function(){   
            var i =$(this).attr('id');  // getting column index
            var v =$(this).val();  // getting search input value
            
            $(this).val(v); 
            
            logTable.columns(i).search(v).draw();
            staffLogTable.columns(i).search(v).draw();
        });
        
        $(document).on('click', '.print', function(e){
            e.preventDefault();
                var id = $(this).attr("id");
                
                window.open ("datatable/transactions/print_receipt.php?id="+id);
        });
    });
</script>