<?php

    require_once "lib/core.php";
    if(isset($_SESSION['user_signed_in']))
    {
        $sql="select up.u_id,up.f_name,up.l_name,up.status,up.avtar,u.type from user_profile up, users u where u.id = up.u_id and u.id = '$USER_ID'";

        if($result = $conn->query($sql))

        {

            if($result->num_rows)

            {

                $row = $result->fetch_assoc();

                $user_data=$row;

            }

        }

        $USER_ID = $user_data['u_id'];

        $sql = "SELECT m.* from message m where for_id='$USER_ID' ";

        if($result = $conn->query($sql))
        {
           if($result->num_rows > 0)
            {
                while($row = $result->fetch_assoc())    
                {
                    $messages[]=$row;
                }

            }

        }
        else
        {
            $error =  $conn->error;
        }

        $sql = "SELECT count(m.id) as mssg  from message m where for_id='$USER_ID' ";
        if($result = $conn->query($sql))
        {
            if($result->num_rows > 0)
            {
                $mssg=$result->fetch_assoc();
            }

        }

        else

        {

            $error =  $conn->error;

        }

        $sql = "SELECT n.*,pt.t_name from notifications n,post_task pt where n.for_id = '$USER_ID' and n.task=pt.id and n.status=1 order by n.id desc limit 10";

        if($result = $conn->query($sql))

        {

            if($result->num_rows > 0)

            {



                while($row = $result->fetch_assoc())    

                {

                    $notifications[]=$row;

                }

            }

        }

        else

        {

            $error =  $conn->error;

        }

        $sql = "SELECT COUNT(id) as noti from notifications where for_id = '$USER_ID' ";

        if($result = $conn->query($sql))

        {

            if($result->num_rows > 0)

            {

                    $noti=$result->fetch_assoc();

            }

        }

        else

        {

            $error =  $conn->error;

        }

    }
	
    // print_r($notificatons);

?>

<!-- Header Container

================================================== -->

<style>

    

</style>

<header id="header-container" class="fullwidth">



    <!-- Header -->

    <div id="header">

        <div class="container" style="padding-right:0">

                 

            <!-- Left Side Content -->

            <div class="left-side">



                <!-- Logo -->

                <?php

                    if(isset($_SESSION['user_signed_in']))

                    {

                        $href="home";

                    }

                    else

                    {

                        $href="index";

                    }

                ?>

                <span class="mmenu-trigger" style="float:left !important;margin-left:0;margin-right:10px; background-color: inherit;" id="threebars">

                    <button class="hamburger hamburger--collapse" type="button">

                        <span class="hamburger-box">

                            <span class="hamburger-inner"></span>

                        </span>

                    </button>

                </span>

                <div id="logo" >

                    <a href="<?=$href?>"><img src="images/cyberflow-logo-1.png" alt=""></a>

                </div>



                <!-- Main Navigation -->

                <nav id="navigation">

                    <ul id="responsive">



                        <li style="margin:2.5px;"><a href="<?=$href?>" class="current">Home</a>

                            

                        </li>





                        <?php  
                            if(isset($_SESSION['user_signed_in']))
                            {
								switch($TYPE){

									case 2:

									?>

                        



                        <?php

                            break;

                            case 3:

                        ?>

                        <li><a href="#">Find Work</a>

                            <ul class="dropdown-nav">

                                <!-- <li><a href="#">Browse Jobs</a>

                                    <ul class="dropdown-nav">

                                        <li><a href="jobs-list-layout-full-page-map.html">Full Page List + Map</a></li>

                                        <li><a href="jobs-grid-layout-full-page-map.html">Full Page Grid + Map</a></li>

                                        <li><a href="jobs-grid-layout-full-page.html">Full Page Grid</a></li>

                                        <li><a href="jobs-list-layout-1.html">List Layout 1</a></li>

                                        <li><a href="jobs-list-layout-2.html">List Layout 2</a></li>

                                        <li><a href="jobs-grid-layout.html">Grid Layout</a></li>

                                    </ul>

                                </li> -->

                                <li><a href="search_task">Browse Tasks</a>

                                   <!-- <ul class="dropdown-nav">

                                    </ul>-->

                                </li>

                                <li><a href="active_task_bids">My Active Bids</a></li>

                                <!-- <li><a href="browse-companies.html">Browse Companies</a></li>

                                <li><a href="single-job-page.html">Job Page</a></li>

                                <li><a href="single-task-page.html">Task Page</a></li>

                                <li><a href="single-company-profile.html">Company Profile</a></li> -->

                            </ul>

                        </li>

                        <?php

										break;

                                    case 5:

                                        ?>

                                            <li class="active"><a href="#">For Customer</a>

                                                <ul class="dropdown-nav">

                                                    <li><a href="freelancer">Find a Worker</a>

                                                        

                                                    </li>

                                                    

                                                    <li><a href="post_task.php">Post a Task</a></li>

                                                </ul>

                                            </li>

                                        <?php

								}

                            }

						if(isset($_SESSION['user_signed_in'])) 

                        {

                                            





							?>

                        <li><a href="dashboard">Dashboard</a>

                            <ul class="dropdown-nav">

                                <li><a href="dashboard">Dashboard</a></li>

                                <li><a href="bookmark">Bookmarks</a></li>

                                <li><a href="see">See Your Reviews </a>

                                </li>



                                <?php  

								switch($TYPE){

									case 2:

									?>

                                    

                                    <li><a href="dashboard-manage-tasks.html">Tasks</a>

                                        <ul class="dropdown-nav">

                                            <li><a href="active_task_bids">My Active Bids</a></li>

                                            <li><a href="search_task">Find a Task</a></li>

                                            <li><a href="active_task">My active Tasks</a></li>

                                        </ul>

                                    </li>

                                    <li class="milestone"><a href="milestone_transaction4emp">Transaction</a></li>

                                    <li><a href="#">Settings</a>

                                        <ul class="dropdown-nav">

                                            <li><a href="editProfile">Edit Profile</a></li>

                                            <li><a href="banking_details">Banking Details</a></li>

                                            <li><a href="adm">Administration Details</a></li>

                                        </ul>

                                    </li>

                                    <?php

                                        break;

                                        case 3:

                                    ?>

                                    

                                    <li><a href="dashboard-manage-tasks.html">Tasks</a>

                                        <ul class="dropdown-nav">

                                            <li><a href="active_task_bids">My Active Bids</a></li>

                                            <li><a href="search_task">Find a Task</a></li>

                                            <li><a href="active_task">My active Tasks</a></li>

                                        </ul>

                                    </li>

                                    <li class="milestone"><a href="milestone_transaction4emp">Transaction</a></li>

                                    <li><a href="#">Settings</a>

                                        <ul class="dropdown-nav">

                                            <li><a href="editProfile">Edit Profile</a></li>

                                            <li><a href="banking_details">Banking Details</a></li>

                                        </ul>

                                    </li>

                                    <?php

                                            break;



                                        case 5;

                                            ?>

                                                <li><a href="dashboard-manage-tasks.html">Tasks</a>

                                                    <ul class="dropdown-nav">

                                                        <li><a href="manage_task">Manage Tasks</a></li>

                                                        <!-- <li><a href="active_task_bids">My Active Bids</a></li> -->

                                                        <li><a href="post_task">Post a Task</a></li>

                                                    </ul>

                                                </li>

                                                <li class="milestone"><a href="milestone_transaction">Transaction</a></li>

                                                <li><a href="#">Settings</a>

                                                <ul class="dropdown-nav">

                                                    <li><a href="editProfile">Edit Profile</a></li>

                                                    <li><a href="banking_details">Banking Details</a></li>

                                                </ul>

                                            </li>

                                            <?php

                                    }

                                    ?>

                                    

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

				if(isset($_SESSION['user_id'])){

				?>

            <!-- Right Side Content / End -->

            <div class="right-side">



                <!--  User Notifications -->

                <div class="header-widget hide-on-mobile ">



                    <!-- Notifications -->

                    <div class="header-notifications">



                        <!-- Trigger -->

                        <div class="header-notifications-trigger">

                            <a href="#"><i class="icon-feather-bell"></i><span><?=$noti['noti']?></span></a>

                        </div>



                        <!-- Dropdown -->

                        <div class="header-notifications-dropdown">



                            <div class="header-notifications-headline">

                                <h4>Notifications</h4>

                                <!-- <button class="mark-as-read ripple-effect-dark" title="Mark all as read"

                                    data-tippy-placement="left">

                                    <i class="icon-feather-check-square"></i>

                                </button> -->

                            </div>



                            <div class="header-notifications-content">

                                <div class="header-notifications-scroll" data-simplebar>

                                    <ul>

                                    <?php

                                        if(isset($messagessss))

                                        {

                                            foreach($messages as $m)

                                            {

                                                ?>

                                                    <li class="notifications-not-read">

                                                        <a href="">

                                                            <span class="notification-icon"><i

                                                                    class="icon-material-outline-group"></i></span>

                                                            <span class="notification-text">

                                                                <strong>Michael Shannah</strong> applied for a job <span

                                                                    class="color">Full Stack Software Engineer</span>

                                                            </span>

                                                        </a>

                                                    </li>

                                                <?php

                                            }

                                        }

                                    

                                    ?>

                                        <!-- Notification -->

                                        

                                    <?php

                                        if(isset($notifications))

                                        {

                                            foreach($notifications as $n)

                                            {

                                                $date = strtotime($n['time_stamp']);

                                                $date1=date_create(date("Y-m-d",$date));

                                                $date2=date_create(date("Y-m-d"));

                                                $abcd=date_diff($date1,$date2);

                                                $time=$abcd->format("%a");

                                                if($time == 0)

                                                {

                                                    $happy = 'Today';

                                                }

                                                else if($time < 1 && $time >10)

                                                {

                                                    $happy = date('d M Y ', $date);

                                                }

                                                else

                                                {

                                                    $happy = $time.' days ago';

                                                }

                                                

                                                ?>

                                                    <li class="notifications-not-read" id="notifications<?=$n['id']?>">

                                                        <a href="<?=$n['link']?>">

                                                        <span class="notification-icon"><i

                                                            class=" icon-material-outline-gavel"></i></span>

                                                            <span class="notification-text">

                                                                <strong><?=$n['t_name']?> !</strong> <br><span

                                                                    class="color"><?=$n['msg'];?></span>

                                                                    <span><?=$happy?></span>

                                                            </span>

                                                            

                                                        </a>

                                                            <button class="mark-as-read ripple-effect-dark" style="margin-right: 11px; margin-top: -45px;" onclick="markread(<?=$n['id']?>)" title="Mark  as read"

                                                                data-tippy-placement="left">

                                                                <i class="icon-feather-check-square"></i>

                                                            </button>

                                                    </li>

                                                <?php

                                            }

                                        }

                                        

                                    ?>

                                        <!-- Notification -->

                                        <!-- <li>

                                            <a href="dashboard-manage-bidders.html">

                                                <span class="notification-icon"><i

                                                        class=" icon-material-outline-gavel"></i></span>

                                                <span class="notification-text">

                                                    <strong>Gilbert Allanis</strong> placed a bid on your <span

                                                        class="color">iOS App Development</span> project

                                                </span>

                                            </a>

                                        </li>



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



                                        <li>

                                            <a href="dashboard-manage-candidates.html">

                                                <span class="notification-icon"><i

                                                        class="icon-material-outline-group"></i></span>

                                                <span class="notification-text">

                                                    <strong>Sindy Forrest</strong> applied for a job <span

                                                        class="color">Full Stack Software Engineer</span>

                                                </span>

                                            </a>

                                        </li> -->

                                    </ul>

                                </div>

                            </div>



                        </div>



                    </div>



                </div>

                <!--  User Notifications / End -->



                <!-- User Menu -->

                <div class="header-widget photoonphone" >



                    <!-- Messages -->

                    <div class="header-notifications user-menu" >

                        <div class="header-notifications-trigger">

                            <a href="#">

                                <div class="user-avatar status-online"><img src="<?=$user_data['avtar']?>"

                                        alt="" style="  height:50px;width:50px"></div>

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

                                            elseif($user_data['type'] ==5){

												$type ='CUSTOMER';

											}

											?>

                                <!-- User Name / Avatar -->

                                <div class="user-details">

                                    <div class="user-avatar status-online"><img src="<?=$user_data['avtar']?>"

                                            alt="" style="height:3.7rem; width:3.7rem"></div>

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

                                    <label class="user-online <?=$online?>" onclick="status_online(1)" >Online</label>

                                    <label class="user-invisible <?=$invisible?>"

                                        onclick="status_invisible(2)" >Invisible</label>

                                    <!-- Status Indicator -->

                                    <span class="status-indicator" aria-hidden="true"></span>

                                </div>

                            </div>



                            <ul class="user-menu-small-nav">

                                <li><a href="dashboard"><i class="icon-material-outline-dashboard"></i>

                                        Dashboard</a></li>

                                <li><a href="editProfile"><i class="icon-material-outline-settings"></i>

                                        Settings</a></li>

                                <li><a href="logout"><i class="icon-material-outline-power-settings-new"></i>

                                        Logout</a></li>

                            </ul>



                        </div>

                    </div>



                </div>

                <!-- User Menu / End -->



                <!-- Mobile Navigation Button -->

                <!-- <span class="mmenu-trigger" style="display:none !important">

                    <button class="hamburger hamburger--collapse" type="button">

                        <span class="hamburger-box">

                            <span class="hamburger-inner"></span>

                        </span>

                    </button>

                </span> -->



                <?php

				}

                else{

                    ?>

                     <div class="right-side" >

                        <a href="login.php" class=" button  ripple-effect-dark" style="margin-top:1rem">Login!</a>

                    </div>

                    <?php

                }

			?>

            </div>

            <!-- Right Side Content / End -->

            



        </div>

    </div>

    <!-- Header / End -->



</header>

<div class="clearfix"></div>

<!-- Header Container / End -->

<script>

    function markread(id)

    {

        $.ajax({

        url: "notification.php",

        type: "post",

        data: {

            read :true,

            id:id

        },

        success: function(data) {

            console.log(data);

            if(data.trim()=='read'){

                $("#notifications"+id).remove();

                Snackbar.show({

					text: 'Your notification has been marked as read !!',

					pos: 'bottom-center',

					showAction: false,

					actionText: "Dismiss",

					duration: 3000,

					textColor: '#fff',

					backgroundColor: '#383838'

				}); 

            }

        },

        error: function(data) {

            console.log("galti");

        }

    })

    }

</script>