<?php



require_once 'header.php';

require_once 'navbar.php';



$sql = "SELECT count(at.id) as noOfRows from accepted_task at,user_profile up,post_task pt where up.u_id=at.adm_id and at.t_id = pt.id and at.c_id='$USER_ID' and at.emp_status is NULL order by at.id desc";

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





switch ($TYPE)

{

    case 2:

       $sql = "SELECT at.*,up.f_name,up.l_name,up.u_id as user,up.avtar,pt.t_name,pt.id as task_id,pt.e_id as emp_id,at.id as main_id from accepted_task at,user_profile up,post_task pt where up.u_id=at.adm_id and at.t_id = pt.id and at.c_id='$USER_ID' and at.emp_status is NULL order by at.id desc limit $page_first_result , $results_per_page";

        $note = 'none';

        $review_emp = 'show';

       break;

    case 3:

        $sql = "SELECT at.*,up.f_name,up.l_name,up.u_id as user,up.avtar,pt.t_name,pt.id as task_id,pt.e_id as emp_id,at.id as main_id from accepted_task at,user_profile up,post_task pt where up.u_id=at.adm_id and at.t_id = pt.id and at.c_id='$USER_ID' and at.emp_status is NULL order by at.id desc limit $page_first_result , $results_per_page";

        $note = 'none';

        $review_emp = 'show';

        break;

}





// echo $sql;

if ($result = $conn->query($sql)) {

    // echo "jaa";

    if ($result->num_rows) {

        // echo "ccvjkasdvckasd";

        while ($row = $result->fetch_assoc()) {

            $thekedar[] = $row;

           

        }

    }

}

else 

{

    echo $conn->error;

}



?>



<div id="wrapper">





<!-- Header Container

================================================== -->

   

    <!-- Header Container / End -->



    <!-- Spacer -->

    <div class="margin-top-90"></div>

    <!-- Spacer / End-->



    <!-- Page Content

    ================================================== -->

    <div class="container">

        <div class="row">

            <div class="col-xl-1 col-lg-3">

                <div class="sidebar-container">



                    <?php

                        // require_once 'left-navbar.php';

                    

                    ?>

                    <div class="clearfix"></div>



                </div>

            </div>

            <div class="col-xl-11 col-lg-8 content-left-offset">



                <h3 class="page-title">Your Active Tasks</h3>



                

                

                <!-- Freelancers List Container -->

                <div class="freelancers-container freelancers-list-layout compact-list margin-top-35">

                    

                <?php

                    if(isset($thekedar))

                    {

                        foreach($thekedar as $tk)

                        {

                            

                            

                            if($tk['f_name'] != NULL)

                            {

                ?>

                    <!--Freelancer -->

                    <div class="freelancer">



                        <!-- Overview -->

                        <div class="freelancer-overview">

                            <div class="freelancer-overview-inner">

                                

                                <!-- Bookmark Icon -->

                                <span class="bookmark-icon"></span>

                                

                                <!-- Avatar -->

                                <div class="freelancer-avatar">

                                    <div class="verified-badge"></div>

                                    <a href="single-company-profile?token=<?=$tk['user']?>"><img src="<?=$tk['avtar']?>" alt=""></a>

                                </div>



                                <!-- Name -->

                                <div class="freelancer-name">

                                    <h4 style="margin-bottom:2px"><a href="bid_task?token=<?=$tk['t_id']?>"><?=$tk['t_name']?></a></h4>

                                    

                                        <input type="hidden"  value="<?=$m['task_id']?>"/>

                                        <a href="single-company-profile?token=<?=$tk['user']?>"><p><?=$tk['f_name']?> <?=$tk['l_name']?></p></a>

                                        

                                        <!-- Details -->

                                        <span class="freelancer-detail-item"> <?php echo date('d M');?> <?php   echo date("D");?></span>

                                        

                                   



                                </div>

                            </div>

                        </div>

                        

                        <!-- Details -->

                        <div class="freelancer-details">

                            <div class="freelancer-details-list">

                                <ul>

                                    <!-- <li>Location <strong><i class="icon-material-outline-location-on"></i><?=$tk['address']?></strong></li> -->

                                    <!-- <li>Rate <strong>$60 / hr</strong></li> -->

                                    <!-- <li>Job Success <strong>95%</strong></li> -->

                                </ul>

                            </div>

                            <a href="milestone?token=<?=$tk['t_id']?>" class="button button-sliding-icon ripple-effect">View <i class="icon-material-outline-arrow-right-alt"></i></a>

                        </div>

                    </div>

                    <!-- Freelancer / End -->

                    <?php

                            }

                        }

                    }

                                

                    ?>



        

                </div>

                <!-- Freelancers Container / End -->





                <!-- Pagination -->

                <div class="clearfix"></div>

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

                                        if(isset($_GET['page']) &&  $page == $_GET['page'] )

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

                                            <li><a href="active_task?page=<?=$page?>" class="<?=$active?> ripple-effect"><?=$page?></a></li>

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

                <!-- Pagination / End -->



            </div>

        </div>

    </div>





    <!-- Footer

    ================================================== -->

  <?php

    require_once 'js-links.php';

    require_once 'footer.php';

  ?>

    <!-- Footer / End -->



</div>