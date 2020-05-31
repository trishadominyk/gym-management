<head>
    <script src="../../js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
</head>

<div class="content-container">
    <div class="profile-left">
        <?php
            $list = $client->get_userprofile($_SESSION['id']);

            foreach($list as $value){
        ?>
        <div class="box">
            <div class="header">
                <h3><?php echo $name = $value['cust_firstname']." ".$value['cust_lastname'];?></h3>
                    
                <p><?php echo $value['cust_email'];?></p>
            </div>

            <div class="modal-body" style="text-align: center;">
                <img src="../../img/profile.png" alt="member profile" align="middle" class="profile-img"/>
                <br><br>
                <a href="index.php?mod=settings" class="btn btn-success">Edit Profile</a>
            </div>

            <div class="footer">
                <h4><b>MEMBERSHIP</b></h4>
                <p><?php echo $value['met_name'];?></p>
                <p>Date Registered: <?php echo $value['mem_date_added'];?></p>
                <p>Date Expire: <?php echo $value['mem_date_expire'];?></p>
                <p>
                    Status: 
                    <?php 
                        $membership = $value["mem_status"];

                        if($membership == "EXPIRED")
                            $memstat = '<span class="btn-gray btn-xs">'.$membership.'</span>';
                        else if($membership == "ACTIVE")
                            $memstat = '<span class="btn-green btn-xs">'.$membership.'</span>';
                        else
                            $memstat = '<span class="btn-red btn-xs">NONE</span>';

                        echo $memstat;
                    ?>
                </p>
            </div>
        </div>
        
            <?php
                if($membership != 'ACTIVE'){
            ?>
            
        <br>
        <div class="renew-btn">
            <button class="btn-gray renew">Renew your membership</button>
        </div>
            <?php
                    }
                }
            ?>  
    </div>
    
    <div class="profile-right">
        <div class="profile-content">
            <div class="box" style="padding: 0;">
                <?php
                    require_once 'datatable/bmi/index.php';
                ?>
            </div>
            <br>
            
            <div class="trans-statistics">
                <div class="stats-box box-dark box">
                    <h2 id="trns_total"></h2>
                    <hr>
                    <p>Total transactions for the month <?php echo $date = date('F');?></p>
                </div>
                <div class="stats-box box-gray box">
                    <h2 id="trns_all"></h2>
                    <hr>
                    <p>Overall total transactions</p>
                </div>
                <div class="stats-box box-red box">
                    <h2 id="bmi_current"></h2>
                    <span class="bmi_info"></span>
                    
                    <hr class="light">
                    <p>Current BMI</p>
                </div>
            </div>
            <br>
            
            <div class="box">
                <?php
                    require_once 'datatable/transaction/index.php'; 
                ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $.ajax({
            url:"datatable/profile/onload.php",
            method:"POST",
            data:{id:'<?php echo $_SESSION['id'];?>'},
            dataType:"JSON",
            success:function(data)
            {
                $('#trns_total').text(data.trns_total);
                $('#trns_all').text(data.trns_all);
                $('#bmi_current').text(data.bmi_current);
                $('.bmi_info').text(data.bmi_info);
            }
         }); 
    });
</script>