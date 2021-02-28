<?php
    require_once 'header.php';
    require_once 'navbar.php';

    $sql = "SELECT * FROM post_task where e_id='$USER_ID'";
    if($result =$conn->query($sql))
    {
        if($result->num_rows)
        {
            while($row=$result->fetch_assoc())
            {
                $taskDetails[] = $row;
            }
        }
    }

?>

<div id="wrapper">


    <div class="clearfix"></div>
    <!-- Header Container / End -->


    <!-- Dashboard Container -->
    <div class="dashboard-container">

        <?php
            require_once 'left-navbar.php';
        ?>


        <!-- Dashboard Content
        ================================================== -->
        <div class="dashboard-content-container" data-simplebar>
            <div class="dashboard-content-inner" >
                
                <!-- Dashboard Headline -->
                <div class="dashboard-headline">
                    <h3>Manage Tasks</h3>

                    <!-- Breadcrumbs -->
                    <nav id="breadcrumbs" class="dark">
                        <ul>
                            <li><a href="#">Home</a></li>
                            <li><a href="#">Dashboard</a></li>
                            <li>Manage Tasks</li>
                        </ul>
                    </nav>
                </div>
        
                <!-- Row -->
                <div class="row">

                    <!-- Dashboard Box -->
                    <div class="col-xl-12">
                        <div class="dashboard-box margin-top-0">

                            <!-- Headline -->
                            <div class="headline">
                                <h3><i class="icon-material-outline-assignment"></i> My Tasks</h3>
                            </div>

                            <div class="content">
                                <ul class="dashboard-box-list">
                                    <?php
                                    foreach($taskDetails as $taskDetail)
                                    {
                                    ?>
                                        <li>
                                            <!-- Job Listing -->
                                            <div class="job-listing width-adjustment">

                                                <!-- Job Listing Details -->
                                                <div class="job-listing-details">
                                                <?php
                                                    $status='';
                                                    $state=$taskDetail['status'];
                                                    switch ($state){
                                                        case 1:
                                                            $status="Open for Bidding";
                                                            $color ="green";
                                                            break;
                                                        case 2:
                                                            $status="Ongoing";
                                                            $color ="green";
                                                            break;
                                                        case 3:
                                                            $status="Completed";
                                                            $color ="yellow";
                                                            break;
                                                        case 4:
                                                            $status="Blocked by admin";
                                                            $color ="red";
                                                            break;
                                                    }
                                                ?>
                                                    <!-- Details -->
                                                    <div class="job-listing-description">
                                                        <h3 class="job-listing-title"><a href="#"><?=$taskDetail['t_name']?></a> <span class="dashboard-status-button <?=$color?>"><?=$status?></span></h3>

                                                        <!-- Job Listing Footer -->
                                                        <div class="job-listing-footer">
                                                            <ul>
                                                            <?php
                                                                $date = date('Y-m-d H:i:s');
                                                                $presentTime = new DateTime($date);
                                                                $end_date =new DateTime($taskDetail['end_date']);
                                                                $interval = $presentTime->diff($end_date);
                                                            ?>
                                                                <li><i class="icon-material-outline-access-time"></i><?php echo $interval->format('%d days %H hours %i minutes')?> left</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <?php
                                                $pay_type='';
                                                switch ($taskDetail['pay_type']){
                                                    case 1:
                                                        $pay_type='Fixed Price';
                                                        break;
                                                    case 2:
                                                        $pay_type='Hourly Rate';
                                                }
                                            ?>
                                            <!-- Task Details -->
                                            <ul class="dashboard-task-info">
                                                <li><strong>3</strong><span>Bids</span></li>
                                                <li><strong>$22</strong><span>Avg. Bid</span></li>
                                                <li><strong>$<?=$taskDetail['min_salary']?> - $<?=$taskDetail['max_salary']?></strong><span><?=$pay_type?></span></li>
                                            </ul>

                                            <!-- Buttons -->
                                            <div class="buttons-to-right always-visible">
                                                <a href="manage_bidder.php?token=<?=$taskDetail['id']?>" class="button ripple-effect"><i class="icon-material-outline-supervisor-account"></i> Manage Bidders <span class="button-info">3</span></a>
                                                <a href="#" class="button gray ripple-effect ico" title="Edit" data-tippy-placement="top"><i class="icon-feather-edit"></i></a>
                                                <a href="#" class="button gray ripple-effect ico" title="Remove" data-tippy-placement="top"><i class="icon-feather-trash-2"></i></a>
                                            </div>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                    <li>
                                        <!-- Job Listing -->
                                        <div class="job-listing width-adjustment">

                                            <!-- Job Listing Details -->
                                            <div class="job-listing-details">

                                                <!-- Details -->
                                                <div class="job-listing-description">
                                                    <h3 class="job-listing-title"><a href="#">Food Delivery Mobile Application</a></h3>

                                                    <!-- Job Listing Footer -->
                                                    <div class="job-listing-footer">
                                                        <ul>
                                                            <li><i class="icon-material-outline-access-time"></i> 6 days, 23 hours left</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Task Details -->
                                        <ul class="dashboard-task-info">
                                            <li><strong>3</strong><span>Bids</span></li>
                                            <li><strong>$3,200</strong><span>Avg. Bid</span></li>
                                            <li><strong>$2,500 - $4,500</strong><span>Fixed Price</span></li>
                                        </ul>

                                        <!-- Buttons -->
                                        <div class="buttons-to-right always-visible">
                                            <a href="dashboard-manage-bidders.html" class="button ripple-effect"><i class="icon-material-outline-supervisor-account"></i> Manage Bidders <span class="button-info">3</span></a>
                                            <a href="#" class="button gray ripple-effect ico" title="Edit" data-tippy-placement="top"><i class="icon-feather-edit"></i></a>
                                            <a href="#" class="button gray ripple-effect ico" title="Remove" data-tippy-placement="top"><i class="icon-feather-trash-2"></i></a>
                                        </div>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- Row / End -->

                <!-- Footer -->
                <div class="dashboard-footer-spacer"></div>
                <div class="small-footer margin-top-15">
                    <ul class="footer-social-links">
                        <li>
                            <a href="#" title="Facebook" data-tippy-placement="top">
                                <i class="icon-brand-facebook-f"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#" title="Twitter" data-tippy-placement="top">
                                <i class="icon-brand-twitter"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#" title="Google Plus" data-tippy-placement="top">
                                <i class="icon-brand-google-plus-g"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#" title="LinkedIn" data-tippy-placement="top">
                                <i class="icon-brand-linkedin-in"></i>
                            </a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <!-- Footer / End -->

            </div>
        </div>
        <!-- Dashboard Content / End -->

    </div>
    <!-- Dashboard Container / End -->

</div>
<!-- Wrapper / End -->

<?php
    require_once 'js-links.php';
?>


