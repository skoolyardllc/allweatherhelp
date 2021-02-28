<?php
	$sql="select up.f_name,up.l_name,up.status,u.type from user_profile up, users u where u.id = up.u_id and u.id = '$USER_ID'";
	if($result = $conn->query($sql))
	{
		if($result->num_rows)
		{
			$row = $result->fetch_assoc();
			$user_data=$row;
		}
	}
?>
<!-- Header Container
================================================== -->
<header id="header-container" class="fullwidth">

    <!-- Header -->
    <div id="header">
        <div class="container">

            <!-- Left Side Content -->
            <div class="left-side">

                <!-- Logo -->
                <div id="logo">
                    <a href="#"><img src="images/cyberflow-logo-2.png" alt=""><h6 style="padding-left:50px;margin-top:0px">AWH</h6></a>
                </div>

                <!-- Main Navigation -->
                <nav id="navigation">
                    <ul id="responsive">

                        <li><a href="#" class="current">Home</a>
                            <ul class="dropdown-nav">
                                <li><a href="index-2.html">Home 1</a></li>
                                <li><a href="index-3.html">Home 2</a></li>
                                <li><a href="index-4.html">Home 3</a></li>
                            </ul>
                        </li>


                        <?php  
								switch($TYPE){
									case 2:
									?>
                        <li><a href="#">For Employers</a>
                            <ul class="dropdown-nav">
                                <li><a href="#">Find a Freelancer</a>
                                    <ul class="dropdown-nav">
                                        <li><a href="freelancers-grid-layout-full-page.html">Full Page Grid</a></li>
                                        <li><a href="freelancers-grid-layout.html">Grid Layout</a></li>
                                        <li><a href="freelancers-list-layout-1.html">List Layout 1</a></li>
                                        <li><a href="freelancers-list-layout-2.html">List Layout 2</a></li>
                                    </ul>
                                </li>
                                <li><a href="single-freelancer-profile.html">Freelancer Profile</a></li>
                                <li><a href="dashboard-post-a-job.html">Post a Job</a></li>
                                <li><a href="dashboard-post-a-task.html">Post a Task</a></li>
                            </ul>
                        </li>

                        <?php
									break;
									case 3:
										?>
                        <li><a href="#">Find Work</a>
                            <ul class="dropdown-nav">
                                <li><a href="#">Browse Jobs</a>
                                    <ul class="dropdown-nav">
                                        <li><a href="jobs-list-layout-full-page-map.html">Full Page List + Map</a></li>
                                        <li><a href="jobs-grid-layout-full-page-map.html">Full Page Grid + Map</a></li>
                                        <li><a href="jobs-grid-layout-full-page.html">Full Page Grid</a></li>
                                        <li><a href="jobs-list-layout-1.html">List Layout 1</a></li>
                                        <li><a href="jobs-list-layout-2.html">List Layout 2</a></li>
                                        <li><a href="jobs-grid-layout.html">Grid Layout</a></li>
                                    </ul>
                                </li>
                                <li><a href="#">Browse Tasks</a>
                                    <ul class="dropdown-nav">
                                        <li><a href="search_task.php">Find Tasks</a></li>
                                        <li><a href="tasks-list-layout-2.html">List Layout 2</a></li>
                                        <li><a href="tasks-grid-layout.html">Grid Layout</a></li>
                                        <li><a href="tasks-grid-layout-full-page.html">Full Page Grid</a></li>
                                    </ul>
                                </li>
                                <li><a href="browse-companies.html">Browse Companies</a></li>
                                <li><a href="single-job-page.html">Job Page</a></li>
                                <li><a href="single-task-page.html">Task Page</a></li>
                                <li><a href="single-company-profile.html">Company Profile</a></li>
                            </ul>
                        </li>
                        <?php
										break;
								}
                        
						if(user_auth()) {
							?>
                        <li><a href="#">Dashboard</a>
                            <ul class="dropdown-nav">
                                <li><a href="dashboard.html">Dashboard</a></li>
                                <li><a href="dashboard-messages.html">Messages</a></li>
                                <li><a href="dashboard-bookmarks.html">Bookmarks</a></li>
                                <li><a href="dashboard-reviews.html">Reviews</a></li>
                                <li><a href="dashboard-manage-jobs.html">Jobs</a>
                                    <ul class="dropdown-nav">
                                        <li><a href="dashboard-manage-jobs.html">Manage Jobs</a></li>
                                        <li><a href="dashboard-manage-candidates.html">Manage Candidates</a></li>
                                        <li><a href="dashboard-post-a-job.html">Post a Job</a></li>
                                    </ul>
                                </li>
                                <li><a href="dashboard-manage-tasks.html">Tasks</a>
                                    <ul class="dropdown-nav">
                                        <li><a href="dashboard-manage-tasks.html">Manage Tasks</a></li>
                                        <li><a href="dashboard-manage-bidders.html">Manage Bidders</a></li>
                                        <li><a href="dashboard-my-active-bids.html">My Active Bids</a></li>
                                        <li><a href="dashboard-post-a-task.html">Post a Task</a></li>
                                    </ul>
                                </li>
                                <li><a href="editProfile.php">Settings</a></li>
                            </ul>
                        </li>
                        <?php
						}
						?>

                    </ul>
                </nav>
                <div class="clearfix"></div>
                <!-- Main Navigation / End -->

            </div>
            <!-- Left Side Content / End -->


            <?php
				if(user_auth()){
				?>
            <!-- Right Side Content / End -->
            <div class="right-side">

                <!--  User Notifications -->
                <div class="header-widget hide-on-mobile">

                    <!-- Notifications -->
                    <div class="header-notifications">

                        <!-- Trigger -->
                        <div class="header-notifications-trigger">
                            <a href="#"><i class="icon-feather-bell"></i><span>4</span></a>
                        </div>

                        <!-- Dropdown -->
                        <div class="header-notifications-dropdown">

                            <div class="header-notifications-headline">
                                <h4>Notifications</h4>
                                <button class="mark-as-read ripple-effect-dark" title="Mark all as read"
                                    data-tippy-placement="left">
                                    <i class="icon-feather-check-square"></i>
                                </button>
                            </div>

                            <div class="header-notifications-content">
                                <div class="header-notifications-scroll" data-simplebar>
                                    <ul>
                                        <!-- Notification -->
                                        <li class="notifications-not-read">
                                            <a href="dashboard-manage-candidates.html">
                                                <span class="notification-icon"><i
                                                        class="icon-material-outline-group"></i></span>
                                                <span class="notification-text">
                                                    <strong>Michael Shannah</strong> applied for a job <span
                                                        class="color">Full Stack Software Engineer</span>
                                                </span>
                                            </a>
                                        </li>

                                        <!-- Notification -->
                                        <li>
                                            <a href="dashboard-manage-bidders.html">
                                                <span class="notification-icon"><i
                                                        class=" icon-material-outline-gavel"></i></span>
                                                <span class="notification-text">
                                                    <strong>Gilbert Allanis</strong> placed a bid on your <span
                                                        class="color">iOS App Development</span> project
                                                </span>
                                            </a>
                                        </li>

                                        <!-- Notification -->
                                        <li>
                                            <a href="dashboard-manage-jobs.html">
                                                <span class="notification-icon"><i
                                                        class="icon-material-outline-autorenew"></i></span>
                                                <span class="notification-text">
                                                    Your job listing <span class="color">Full Stack PHP Developer</span>
                                                    is expiring.
                                                </span>
                                            </a>
                                        </li>

                                        <!-- Notification -->
                                        <li>
                                            <a href="dashboard-manage-candidates.html">
                                                <span class="notification-icon"><i
                                                        class="icon-material-outline-group"></i></span>
                                                <span class="notification-text">
                                                    <strong>Sindy Forrest</strong> applied for a job <span
                                                        class="color">Full Stack Software Engineer</span>
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>

                    </div>

                    <!-- Messages -->
                    <div class="header-notifications">
                        <div class="header-notifications-trigger">
                            <a href="#"><i class="icon-feather-mail"></i><span>3</span></a>
                        </div>

                        <!-- Dropdown -->
                        <div class="header-notifications-dropdown">

                            <div class="header-notifications-headline">
                                <h4>Messages</h4>
                                <button class="mark-as-read ripple-effect-dark" title="Mark all as read"
                                    data-tippy-placement="left">
                                    <i class="icon-feather-check-square"></i>
                                </button>
                            </div>

                            <div class="header-notifications-content">
                                <div class="header-notifications-scroll" data-simplebar>
                                    <ul>
                                        <!-- Notification -->
                                        <li class="notifications-not-read">
                                            <a href="dashboard-messages.html">
                                                <span class="notification-avatar status-online"><img
                                                        src="images/user-avatar-small-03.jpg" alt=""></span>
                                                <div class="notification-text">
                                                    <strong>David Peterson</strong>
                                                    <p class="notification-msg-text">Thanks for reaching out. I'm quite
                                                        busy right now on many...</p>
                                                    <span class="color">4 hours ago</span>
                                                </div>
                                            </a>
                                        </li>

                                        <!-- Notification -->
                                        <li class="notifications-not-read">
                                            <a href="dashboard-messages.html">
                                                <span class="notification-avatar status-offline"><img
                                                        src="images/user-avatar-small-02.jpg" alt=""></span>
                                                <div class="notification-text">
                                                    <strong>Sindy Forest</strong>
                                                    <p class="notification-msg-text">Hi Tom! Hate to break it to you,
                                                        but I'm actually on vacation until...</p>
                                                    <span class="color">Yesterday</span>
                                                </div>
                                            </a>
                                        </li>

                                        <!-- Notification -->
                                        <li class="notifications-not-read">
                                            <a href="dashboard-messages.html">
                                                <span class="notification-avatar status-online"><img
                                                        src="images/user-avatar-placeholder.png" alt=""></span>
                                                <div class="notification-text">
                                                    <strong>Marcin Kowalski</strong>
                                                    <p class="notification-msg-text">I received payment. Thanks for
                                                        cooperation!</p>
                                                    <span class="color">Yesterday</span>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <a href="dashboard-messages.html"
                                class="header-notifications-button ripple-effect button-sliding-icon">View All
                                Messages<i class="icon-material-outline-arrow-right-alt"></i></a>
                        </div>
                    </div>

                </div>
                <!--  User Notifications / End -->

                <!-- User Menu -->
                <div class="header-widget">

                    <!-- Messages -->
                    <div class="header-notifications user-menu">
                        <div class="header-notifications-trigger">
                            <a href="#">
                                <div class="user-avatar status-online"><img src="images/user-avatar-small-01.jpg"
                                        alt=""></div>
                            </a>
                        </div>

                        <!-- Dropdown -->
                        <div class="header-notifications-dropdown">

                            <!-- User Status -->
                            <div class="user-status">
                                <?php
											if($user_data['type'] ==2){
												$type ='EMPLOYER';
											}
											elseif($user_data['type'] ==3){
												$type ='CONTRACTOR';
											}
											?>
                                <!-- User Name / Avatar -->
                                <div class="user-details">
                                    <div class="user-avatar status-online"><img src="images/user-avatar-small-01.jpg"
                                            alt=""></div>
                                    <div class="user-name">
                                        <?=$user_data['f_name']?> <?=$user_data['l_name']?> <span><?=$type?></span>
                                    </div>
                                </div>

                                <?php
											$online='';
											$invisible=''; 
											switch ($user_data['status']){
												case 1:
													$online="current-status";
													break;
												case 2:
													$invisible = "current-status";
													break;
											}?>
                                <!-- User Status Switcher -->
                                <div class="status-switch" id="snackbar-user-status">
                                    <label class="user-online <?=$online?>" onclick="status_online(1)">Online</label>
                                    <label class="user-invisible <?=$invisible?>"
                                        onclick="status_invisible(2)">Invisible</label>
                                    <!-- Status Indicator -->
                                    <span class="status-indicator" aria-hidden="true"></span>
                                </div>
                            </div>

                            <ul class="user-menu-small-nav">
                                <li><a href="dashboard.html"><i class="icon-material-outline-dashboard"></i>
                                        Dashboard</a></li>
                                <li><a href="editProfile.php"><i class="icon-material-outline-settings"></i>
                                        Settings</a></li>
                                <li><a href="logout.php"><i class="icon-material-outline-power-settings-new"></i>
                                        Logout</a></li>
                            </ul>

                        </div>
                    </div>

                </div>
                <!-- User Menu / End -->

                <!-- Mobile Navigation Button -->
                <span class="mmenu-trigger">
                    <button class="hamburger hamburger--collapse" type="button">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </span>

            </div>
            <!-- Right Side Content / End -->
            <?php
				}

			?>

        </div>
    </div>
    </div>
    <!-- Header / End -->

</header>
<div class="clearfix"></div>
<!-- Header Container / End -->