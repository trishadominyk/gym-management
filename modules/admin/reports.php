<div class="content-container">
    <div class="submenu-left">
        <h3>Reports</h3>       
        <hr>
        
        <h4>Select Report Type:</h4>
        <ul class="list-nav">
        	<a href="index.php?mod=report&sub=membership"> <li <?php echo $active = ($sub == 'class' || $sub == '') ? 'class="active"' : '' ;?>>Membership</li></a>
            <a href="index.php?mod=report&sub=financial"> <li <?php echo $active = ($sub == 'membership') ? 'class="active"' : '' ;?>>Sales</li></a>
            <a href="index.php?mod=report&sub=equipment"><li <?php echo $active = ($sub == 'promos') ? 'class="active"' : '' ;?>>Equipment</li></a>
             <a href="index.php?mod=report&sub=logstaff"><li <?php echo $active = ($sub == 'promos') ? 'class="active"' : '' ;?>>Staff Logs</li></a>
            <a href="index.php?mod=report&sub=logstud"><li <?php echo $active = ($sub == 'promos') ? 'class="active"' : '' ;?>>Client Logs</li></a>
             <a href="index.php?mod=report&sub=booking"><li <?php echo $active = ($sub == 'promos') ? 'class="active"' : '' ;?>>Event Booking</li></a>
 
          
        </ul>
    </div>

    <div class="managesvcs-content">
        <?php
            switch($sub){
            	case 'membership':
                    require_once 'report/membership.php';
                break;
                case 'financial':
                    require_once 'report/sales.php';
                break;
                case 'equipment':
                    require_once 'report/equipment.php';
                break;
                case 'logstaff':
                    require_once 'report/stafflog.php';
                break;
                 case 'logstud':
                    require_once 'report/studlog.php';
                break;
                case 'booking':
                    require_once 'report/booking.php';
                break;
                default:
                    require_once 'reports.php';
                break;	
            }
        ?>
    </div>
</div>
 