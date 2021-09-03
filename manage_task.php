<?php

    require_once 'header.php';

    require_once 'navbar.php';



    $sql = "SELECT count(id) as noOfRows FROM post_task where e_id='$USER_ID' order by id desc";

    if($res = $conn->query($sql))

    {

        $noofresults = $res->fetch_assoc();

    }

    else

    {

        $error =  $conn->query($sql);

    }

    $noofresults['noOfRows'];

    $results_per_page = 10;  

    $number_of_page = ceil ($noofresults['noOfRows'] / $results_per_page);

    if(isset($_GET['page'])&& !empty($_GET['page']))

    {

        $page = $_GET['page'];

    }

    else

    {

        $page = 1;

    }

    $page_first_result = ($page-1) * $results_per_page;



    if(isset($_POST['remove']))

    {

        $id = $_POST['remove'];

        $sql = "delete from post_task where id=$id";

        if($conn->query($sql))

        {

            $done="Your Post is deleted sucessfully!!";

        }

        else

        {

            $error =  $conn->error;

        }

    }



    $sql = "SELECT * FROM post_task where e_id='$USER_ID' order by id desc limit $page_first_result , $results_per_page";

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

    else

    {

        $error = $conn->error;

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

                            <li><a href="index">Home</a></li>

                            <li><a href="dashboard">Dashboard</a></li>

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

                                <h3><i class="icon-material-outline-assignment"></i> My Tasks<i style="justify-content:flex-end;display:flex;flex:1;font-size:1rem"><a href="post_task">Post a Task</a></i></h3>

                            </div>

                            <?php

                                if(isset($done))

                                {

                                    ?>

                                        <div class="alert alert-success">

                                            <?=$done?>

                                        </div>

                                    <?php

                                }

                            ?>



                            <div class="content">

                                <ul class="dashboard-box-list">

                                    <?php

                                    if(isset($taskDetails))

                                    {

                                    foreach($taskDetails as $taskDetail)

                                    {

                                        $tId = $taskDetail['id'];

                                        $sql = "Select Count(id) as bids from bidding where t_id='$tId'";

                                        if($result = $conn->query($sql))

                                        {

                                            $bidders = $result->fetch_assoc();



                                        }

                                        $sql = "select * from accepted_task where t_id='$tId'";

                                        if($result = $conn->query($sql))

                                        {

                                            if($result->num_rows>0)

                                            {

                                                $milestone = "show";

                                                $manage = 'none';

                                               

                                            }

                                            else

                                            {

                                                $milestone = "none";

                                                $manage = 'show';

                                            }

                                        }

                                        else

                                        {

                                            echo $conn->error;

                                        }

                                    ?>

                                        <li>

                                            <!-- Job Listing -->

                                            <div class="job-listing width-adjustment">



                                                <!-- Job Listing Details -->

                                                <div class="job-listing-details">

                                                <?php

                                                    if(date("Y-m-d") > $taskDetail['end_date'] && $taskDetail['status']!=4 && $taskDetail['status']==3)

                                                    {

                                                        $status="Completed";

                                                        $color ="yellow";

                                                    }

                                                    else if(date("Y-m-d")< $taskDetail['end_date'] && $taskDetail['status']!=4 && $taskDetail['status']==2)

                                                    {

                                                        $status="Ongoing";

                                                        $color ="green";

                                                    }

                                                    else if($taskDetail['status']==1 && date("Y-m-d")< $taskDetail['end_date'])

                                                    {

                                                        $status="Open for Biding";

                                                        $color ="green";

                                                    }

                                                    else if($taskDetail['status']==4)

                                                    {

                                                        $status="Blocked by Admin";

                                                        $color ="red";

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

                                                                if(date("Y-m-d") < $taskDetail['end_date'])

                                                                {

                                                            ?>

                                                                <li><i class="icon-material-outline-access-time"></i><?php echo $interval->format('%d days %H hours %i minutes')?> left</li>

                                                            <?php

                                                                }

                                                                else if(date("Y-m-d") > $taskDetail['end_date'])

                                                                {

                                                            ?>

                                                                    <li><i class="icon-material-outline-access-time"></i>Closed <?php echo $interval->format('%d days %H hours %i minutes')?> ago</li>

                                                            <?php

                                                                }

                                                            ?>

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

                                                <li><strong><?=$bidders['bids']?></strong><span>Bids</span></li>

                                                <!-- <li><strong>$22</strong><span>Avg. Bid</span></li> -->

                                                <li><strong>$<?=$taskDetail['min_salary']?> - $<?=$taskDetail['max_salary']?></strong><span><?=$pay_type?></span></li>

                                            </ul>



                                            <!-- Buttons -->

                                            <div class="buttons-to-right always-visible">

                                                

                                                <a href="milestone?token=<?=$taskDetail['id']?>" style="margin-top:10px;display:<?=$milestone?>" class="button ripple-effect"><i class="icon-material-outline-supervisor-account"></i> See Milestone </a>

                                                <a href="manage_bidder.php?token=<?=$taskDetail['id']?>" style="margin-top:10px;display:<?=$manage?>" class="button ripple-effect"><i class="icon-material-outline-supervisor-account"></i> Manage Bidders <span class="button-info"><?=$bidders['bids']?></span></a>

                                                <a href="post_task_edit.php?token=<?=$taskDetail['id']?>" class="button gray ripple-effect icon" style="display:<?=$manage?>" title="Edit" data-tippy-placement="top"><i class="icon-feather-edit"></i></a>

                                                <a href=".<?=$taskDetail['id']?>" value="<?=$taskDetail['id']?>" style="margin-top:0;display:<?=$manage?>" class="popup-with-zoom-anim button ripple-effect button gray ripple-effect ico" title="Remove" data-tippy-placement="top"><i class="icon-feather-trash-2"></i></a>

                                            

                                            </div>



                                                            <div id="small-dialog-1" class="zoom-anim-dialog mfp-hide dialog-with-tabs <?=$taskDetail['id']?> ">



                                                                <!--Tabs -->

                                                                <div class="sign-in-form">



                                                                    <ul class="popup-tabs-nav">

                                                                        <li><a href="#tab1">Delete Bid</a></li>

                                                                    </ul>



                                                                    <div class="popup-tabs-container">



                                                                        <!-- Tab -->

                                                                        <div class="popup-tab-content" id="tab">

                                                                            

                                                                            <!-- Welcome Text -->

                                                                            <div class="welcome-text">

                                                                                <h3 id="name">Once deleted you wont be able to undo !</h3>

                                                                                

                                                                            </div>



                                                                            <form id="terms" method="post">

                                                                                <div class="radio">

                                                                                    <input id="radio-1" name="radio" type="radio" required>

                                                                                    <label for="radio-1"><span class="radio-label"></span>  I have read and agree to the Terms and Conditions</label>

                                                                                    </div>

                                                                            </form>



                                                                            <!-- Button -->

                                                                            <button name="remove" value="<?=$taskDetail['id']?>" class="margin-top-15 button full-width button-sliding-icon ripple-effect" type="submit" form="terms">Accept <i class="icon-material-outline-arrow-right-alt"></i></button>

                                                                        

                                                                        </div>



                                                                    </div>

                                                                </div>

                                                            </div>

                                        </li>

                                        <?php

                                        }

                                    }

                                    else

                                    {

                                        ?>

                                            <div class="alert alert-primary">

                                                No Task found To manage!!

                                            </div>

                                        <?php

                                    }

                                    ?>



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

                    <div class="row">

                        <div class="col-md-12">

                            <!-- Pagination -->

                            <div class="pagination-container margin-top-40 margin-bottom-60">

                                <nav class="pagination">

                                    <ul>

                                    <?php

                                        for($page = 1; $page<= $number_of_page; $page++) 

                                        {  

                                            $active = "";

                                            if(isset($_GET['page']) && $page == $_GET['page'] )

                                            {

                                                $active = "current-page";

                                            }

                                            else if(!isset($_GET['page']) && $page == 1)

                                            {

                                                $active = "current-page";

                                            }

                                            else

                                            {

                                                $active = "";

                                            }

                                            ?>

                                                <li><a href="manage_task?page=<?=$page?>" class="<?=$active?> ripple-effect"><?=$page?></a></li>

                                            <?php

                                        

                                        }  

                                    

                                    ?>

                                        <!-- <li class="pagination-arrow"><a href="#" class="ripple-effect"><i class="icon-material-outline-keyboard-arrow-left"></i></a></li>

                                        <li><a href="#" class="ripple-effect">1</a></li>

                                        <li><a href="#" class="current-page ripple-effect">2</a></li>

                                        <li><a href="#" class="ripple-effect">3</a></li>

                                        <li><a href="#" class="ripple-effect">4</a></li>

                                        <li class="pagination-arrow"><a href="#" class="ripple-effect"><i class="icon-material-outline-keyboard-arrow-right"></i></a></li> -->

                                    </ul>

                                </nav>

                            </div>

                        </div>

                    </div>

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

	$("#tasks").addClass('active');



</script>





