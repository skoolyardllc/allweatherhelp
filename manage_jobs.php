<?php
    require_once 'header.php';
    require_once 'navbar.php';

    $sql = "SELECT * FROM post_job where e_id='$USER_ID'";
    if($result =$conn->query($sql))
    {
        if($result->num_rows)
        {
            while($row=$result->fetch_assoc())
            {
                $jobDetails[] = $row;
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
            require_once 'left-navbar.php'
        ?>
        <!-- Dashboard Content
        ================================================== -->
        <div class="dashboard-content-container" data-simplebar>
            <div class="dashboard-content-inner" >
                
                <!-- Dashboard Headline -->
                    <div class="dashboard-headline">
                        <h3>Manage Jobs</h3>

                        <!-- Breadcrumbs -->
                        <nav id="breadcrumbs" class="dark">
                            <ul>
                                <li><a href="index">Home</a></li>
                                <li><a href="dashboard">Dashboard</a></li>
                                <li>Manage Jobs</li>
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
                                <h3><i class="icon-material-outline-business-center"></i> My Job Listings</h3>
                            </div>

                            <div class="content">
                                <ul class="dashboard-box-list">
                                <?php
                                foreach($jobDetails as $jobDetail)
                                {
                                ?>
                                    <li>
                                        <!-- Job Listing -->
                                        <div class="job-listing">

                                            <!-- Job Listing Details -->
                                            <div class="job-listing-details">
                                                <!-- Logo -->
                                                <!-- <a href="#" class="job-listing-company-logo">
                                                    <img src="images/company-logo-05.png" alt="">
                                                </a> -->

                                                <?php
                                                    $status='';
                                                    $state=$jobDetail['status'];
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
                                                    <h3 class="job-listing-title"><a href="#"><?=$jobDetail['j_title']?></a> <span class="dashboard-status-button <?=$color?>"><?=$status?></span></h3>

                                                    <!-- Job Listing Footer -->
                                                    <div class="job-listing-footer">
                                                        <ul>
                                                            <?php
                                                                $postedOn =$jobDetail['time_stamp'];
                                                                $postedOn = date( "d F, Y", strtotime($postedOn));
                                                                $end_date =$jobDetail['end_date'];
                                                                $end_date = date( "d F, Y", strtotime($end_date));
                                                            ?>
                                                            <li><i class="icon-material-outline-date-range"></i> Posted on <?=$postedOn?></li>
                                                            <li><i class="icon-material-outline-date-range"></i> Expiring on <?=$end_date?></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Buttons -->
                                        <div class="buttons-to-right always-visible">
                                            <a href="dashboard-manage-candidates.html" class="button ripple-effect"><i class="icon-material-outline-supervisor-account"></i> Manage Candidates <span class="button-info">0</span></a>
                                            <a href="#" class="button gray ripple-effect ico" title="Edit" data-tippy-placement="top"><i class="icon-feather-edit"></i></a>
                                            <a href="#" class="button gray ripple-effect ico" title="Remove" data-tippy-placement="top"><i class="icon-feather-trash-2"></i></a>
                                        </div>
                                    </li>
                                <?php
                                }
                                ?>
                                    <li>
                                        <!-- Job Listing -->
                                        <div class="job-listing">

                                            <!-- Job Listing Details -->
                                            <div class="job-listing-details">

                                                <!-- Details -->
                                                <div class="job-listing-description">
                                                    <h3 class="job-listing-title"><a href="#">Full Stack PHP Developer</a> <span class="dashboard-status-button yellow">Expiring</span></h3>

                                                    <!-- Job Listing Footer -->
                                                    <div class="job-listing-footer">
                                                        <ul>
                                                            <li><i class="icon-material-outline-date-range"></i> Posted on 28 June, 2019</li>
                                                            <li><i class="icon-material-outline-date-range"></i> Expiring on 28 July, 2019</li>
                                                        </ul>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <!-- Buttons -->
                                        <div class="buttons-to-right always-visible">
                                            <a href="dashboard-manage-candidates.html" class="button ripple-effect"><i class="icon-material-outline-supervisor-account"></i> Manage Candidates <span class="button-info">3</span></a>
                                            <a href="#" class="button gray ripple-effect ico" title="Edit" data-tippy-placement="top"><i class="icon-feather-edit"></i></a>
                                            <a href="#" class="button gray ripple-effect ico" title="Remove" data-tippy-placement="top"><i class="icon-feather-trash-2"></i></a>
                                        </div>
                                    </li>

                                    <li>
                                        <!-- Job Listing -->
                                        <div class="job-listing">

                                            <!-- Job Listing Details -->
                                            <div class="job-listing-details">

                                                <!-- Details -->
                                                <div class="job-listing-description">
                                                    <h3 class="job-listing-title"><a href="#">Node.js Developer</a> <span class="dashboard-status-button red">Expired</span></h3>

                                                    <!-- Job Listing Footer -->
                                                    <div class="job-listing-footer">
                                                        <ul>
                                                            <li><i class="icon-material-outline-date-range"></i> Posted on 16 May, 2019</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Buttons -->
                                        <div class="buttons-to-right always-visible">
                                            <a href="dashboard-manage-candidates.html" class="button ripple-effect"><i class="icon-material-outline-supervisor-account"></i> Manage Candidates <span class="button-info">7</span></a>
                                            <a href="#" class="button dark ripple-effect"><i class="icon-feather-rotate-ccw"></i> Refresh</a>
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
                    <!-- <ul class="footer-social-links">
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
                    </ul> -->
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

<script>
    $("#dashboard").removeClass('active');
	$("#bookmarks").removeClass('active');
	$("#reviews").removeClass('active');
	$("#jobs").removeClass('active');
	$("#tasks").removeClass('active');
	$("#settings").removeClass('active');
	$("#milestone").removeClass('active');
	$("#jobs").addClass('active');

</script>