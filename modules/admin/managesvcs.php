<div class="content-container">
    <div class="submenu-left">
        <h3>Services</h3>


        <hr>

        <h4>Select a Service:</h4>
        <ul class="list-nav">
            <a href="index.php?mod=managesvcs&sub=class"> <li <?php echo $active = ($sub == 'class' || $sub == '') ? 'class="active"' : '' ;?>> Class Types</li></a>
            <a href="index.php?mod=managesvcs&sub=membership"> <li <?php echo $active = ($sub == 'membership') ? 'class="active"' : '' ;?>>Membership Types</li></a>
            <a href="index.php?mod=managesvcs&sub=prm"><li <?php echo $active = ($sub == 'promos') ? 'class="active"' : '' ;?>>Promos</li></a>
        </ul>
    </div>

    <div class="managesvcs-content">
        <?php
            switch($sub){
                case 'membership':
                    require_once 'datatable/membership/index.php';
                break;
                case 'prm':
                    require_once 'datatable/promo/index.php';
                break;
        
                default:
                    require_once 'datatable/class/index.php';
                break;
            }
        ?>
    </div>
</div>
