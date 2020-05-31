<div class="content-container">
    <div class="submenu-left">
        <h3>Equipments</h3>       
        <hr>
        
        <h4>Select category:</h4>
        <ul class="list-nav">
        	<a href="index.php?mod=equipment&sub=all"> <li <?php echo $active = ($sub == 'class' || $sub == '') ? 'class="active"' : '' ;?>> All</li></a>
            <a href="index.php?mod=equipment&sub=avail"> <li <?php echo $active = ($sub == 'class' || $sub == '') ? 'class="active"' : '' ;?>> Available</li></a>
            <a href="index.php?mod=equipment&sub=repair"> <li <?php echo $active = ($sub == 'membership') ? 'class="active"' : '' ;?>>Under Repair</li></a>
            <a href="index.php?mod=equipment&sub=dispose"><li <?php echo $active = ($sub == 'promos') ? 'class="active"' : '' ;?>>Disposed</li></a>
          
        </ul>
    </div>

    <div class="managesvcs-content">
        <?php
            switch($sub){
            	case 'all':
                    require_once 'datatable/equipment_all/index.php';
                break;
                case 'avail':
                    require_once 'datatable/equipment_avail/index.php';
                break;
                case 'repair':
                    require_once 'datatable/equipment_repair/index.php';
                break;
                case 'dispose':
                    require_once 'datatable/equipment_dispose/index.php';;
                break;
                default:
                    require_once 'datatable/equipment_all/index.php';
                break;	
            }
        ?>
    </div>
</div>
 