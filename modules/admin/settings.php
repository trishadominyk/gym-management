<div class="content-container">
    <div class="submenu-left">
        <h3>Settings</h3>       
        <hr>
        <h4>Select category:</h4>
        <ul class="list-nav">
        	<a href="index.php?mod=settings&sub=client"> <li <?php echo $active = ($sub == 'class' || $sub == '') ? 'class="active"' : '' ;?>> Client Management</li></a>
        	<a href="index.php?mod=settings&sub=staff"> <li <?php echo $active = ($sub == 'class' || $sub == '') ? 'class="active"' : '' ;?>> Staff Management</li></a>
            <a href="index.php?mod=settings&sub=coach"> <li <?php echo $active = ($sub == 'class' || $sub == '') ? 'class="active"' : '' ;?>> Coach Management</li></a>
            <a href="index.php?mod=settings&sub=class"> <li <?php echo $active = ($sub == 'membership') ? 'class="active"' : '' ;?>>Class Management</li></a>
            <a href="index.php?mod=settings&sub=eqpcat"><li <?php echo $active = ($sub == 'promos') ? 'class="active"' : '' ;?>> Equipment Categories</li></a>
          
        </ul>
    </div>

    <div class="managesvcs-content">`
        <?php
            switch($sub){
            	case 'staff':
                    require_once 'datatable/staff/index.php';
                break;
                case 'coach':
                    require_once 'datatable/coach/index.php';
                break;
                 case 'class':
                    require_once 'datatable/class_settings/index.php';
                break;
                case 'eqpcat':
                    require_once 'datatable/equipmentcat_settings/index.php';
                break;
                default:
                    require_once 'datatable/client/index.php';
                break;	
            }
        ?>
    </div>
</div>
 