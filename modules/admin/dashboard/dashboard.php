<?php
	include 'function.php';
?>
<div class="content-container admin-dashboard-container">
    <div id="overviewcont">
        <div id="statboxone">
            <div id="bookingctrcont" class="box-red">
                <div class="cntnumB">
                    <?php
                        $countcurrmembers = count_muaythai_active();
                        echo $countcurrmembers;
                     ?>
                </div>
                <div class="cntnumextensionB">
                          enrolled in Muay Thai.
                </div>
            </div>

            <div id="bookingctrcont" class="box-black">
                <div class="cntnumB">
                    <?php $countcurrbox = count_boxing_active();
                           echo $countcurrbox;
                     ?>
                </div>
                <div class="cntnumextensionB">
                        enrolled in Boxing.
                </div>
            </div>

            <div id="bookingctrcont" class="box-dark">
                <div class="cntnumB">
                    <?php $countcurrjj = count_jj_active();
                        echo $countcurrjj;
                    ?>
                </div>
                <div class="cntnumextensionB">
                    enrolled in Jiu Jitsu.
                </div>
            </div>

            <div id="memberctrcont" class="box-gray">
                <div class="cntnum">
                    <?php
                        $countcurrmembers = count_current_members();
                        echo $countcurrmembers;
                     ?>
                </div>
                <div class="cntnumextension">
                        active member(s).
                </div>
            </div>

            <div id="memberctrcont" class="box-gray">
                <div class="cntnum">
                    <?php
                        $countcurrmembers = count_expired_members();
                        echo $countcurrmembers;
                     ?>
                </div>
                <div class="cntnumextension">
                        expired membership.
                </div>
            </div>

            <div id="memberctrcont" class="box-gray">
                <div class="cntnum">
                    <?php
                        $countcurrmembers = count_events();
                        echo $countcurrmembers;
                    ?>
                </div>
                <div class="cntnumextension">
                    event(s)
                </div>
            </div>
        </div>

        <div class="dashleft">
            <div class="dashheader box-red svg-middle"><?php echo file_get_contents('../../svg/ic_statistics.svg');?>&nbsp;Statistics</div>

            <div id="chartonecont" class="box">
                <?php require_once 'dashboard_chart/peak_days_chart.php';?>
            </div>


            <div id="charttwocont" class="box">
               <?php require_once 'dashboard_chart/peak_hours_chart.php';?>
            </div>

            <div id="chartthreecont" class="box">
                <?php require_once 'dashboard_chart/peak_month_chart.php';?>
            </div>

            <div id="class-sales" class="class_sales box">
                <?php require_once 'dashboard_chart/curryear_classsales_chart.php';?>
            </div>

            <div class="sales_total box">
				<table class="table table-border" style="margin-bottom: 10px; margin-top: 10px;">
				    <thead>
				        <tr>
				            <th>Total Sales</th>
				        </tr>
                    </thead>
				    <tbody>
				        <tr>
				            <td>
				                <span style="margin-bottom:0;">Today</span>
								
                                <h4>Php
								    <?php
								        $daily = count_daily_sales();
								        echo number_format($daily,2);
								    ?>
								</h4>
				            </td>
                        </tr>

                        <tr>
                            <td>
                                <span style="margin-bottom:0;">For Year <?php echo date('Y');?></span>
                                
                                <h4>Php
								    <?php
								        $total_sales = count_total_sales();
								
                                        echo number_format($total_sales,2);
								    ?>
								</h4>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <span style="margin-bottom:0;">For <?php echo date('F Y');?></span>
                                <h4>Php
								    <?php
								        $month_sales = count_monthly_sales();
                                        
                                        echo number_format($month_sales,2);
								    ?>
                                </h4>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="dashright">
					<div id="announcementcont" class="box">
							<?php require_once 'datatable/announcement/index.php';?>
					</div>





            <div id="calendarFinal" class="dashboard_calendar">
                <?php require_once 'datatable/booking/index.php';?>
            </div>
        </div>
    </div>
</div>
