<?php

    require_once 'header.php';

    require_once 'navbar.php';



    if(isset($_POST['delete_bookmarkTask']))

    { 

        $id=$conn->real_escape_string($_POST['delete_bookmarkTask']);

        

        $sql="delete from bookmarks where id=$id";

        

        if($conn->query($sql))

        {

            $deleteBookmark="Your bookmarked post is deleted";   

        }

        else

        {

            $errorPost=$conn->error;

        }

    }



    if(isset($_POST['delete_bookmarkLancer']))

    { 

        $id=$conn->real_escape_string($_POST['delete_bookmarkLancer']);

        

        $sql="delete from bookmarks where id=$id";

        

        if($conn->query($sql))

        {

            $deleteBookmark="Your bookmarked Freelancer is deleted";   

        }

        else

        {

            $errorPost=$conn->error;

        }

    }



    $sql="SELECT pt.*,up.f_name,up.l_name,up.avtar, pt.t_name, pt.t_catagory, pt.location,pt.pay_type, b.id as bookmark_id from post_task pt, bookmarks b, user_profile up where b.u_id='$USER_ID' and b.t_id=pt.id and pt.e_id=up.u_id";

    if($result=$conn->query($sql)){

        if($result->num_rows){

            while($row=$result->fetch_assoc())

            {

                $bookmark_posts[]=$row;

            }

        }

    }



    $sql="SELECT up.u_id,up.avtar,up.f_name,up.l_name,up.nationality, b.id as bookmark_id from bookmarks b, user_profile up where b.u_id='$USER_ID' and b.f_id=up.u_id";

    if($result=$conn->query($sql)){

        if ($result->num_rows) {

            while ($row = $result->fetch_assoc()) {

                $bookmark_freelancers[$row["u_id"]] = $row;

                $sql = "select * from skills where u_id=" . $row["u_id"];

                if ($res = $conn->query($sql)) {

                    if ($res->num_rows) {

                        while ($row1 = $res->fetch_assoc()) {

                            $bookmark_freelancers[$row["u_id"]]["skills"][] = $row1;

                        }

                    }

                }





                // to show the ratings

                $sql = "select * from ratings where u_id=" . $row["u_id"];

                if ($res = $conn->query($sql)) {

                    if ($res->num_rows) {

                        while ($row2 = $res->fetch_assoc()) {

                            $bookmark_freelancers[$row["u_id"]]["ratings"][] = $row2;

                        }

                    }

                }

            }

        }

    }

?>





<!-- Wrapper -->

<div id="wrapper">





    <div class="clearfix"></div>



    <!-- Dashboard Container -->

    <div class="dashboard-container">



        <!-- Header Container / End -->

        <?php

            require_once 'left-navbar.php';

        ?>





        <!-- Dashboard Content

        ================================================== -->

        <div class="dashboard-content-container" data-simplebar>

            <div class="dashboard-content-inner">



                <!-- Dashboard Headline -->

                <div class="dashboard-headline">

                    <h3>Bookmarks</h3>



                    <!-- Breadcrumbs -->

                    <nav id="breadcrumbs" class="dark">

                        <ul>

                            <li><a href="index">Home</a></li>

                            <li><a href="dashboard">Dashboard</a></li>

                            <li>Bookmarks</li>

                        </ul>

                    </nav>

                </div>



                <?php

			if(isset($deleteBookmark)){

				?>

                <div class="alert alert-success" role="alert">

                    <?=$deleteBookmark?>

                </div>

                <?php

			}

			?>



                <!-- Row -->

                <div class="row">



                    <!-- Dashboard Box -->

                    <div class="col-xl-12">

                        <div class="dashboard-box margin-top-0">



                            <!-- Headline -->

                            <div class="headline">

                                <h3><i class="icon-material-outline-business-center"></i> Bookmarked Tasks</h3>

                            </div>



                            <div class="content">

                                <ul class="dashboard-box-list">

                                    <?php
                                    if(isset($bookmark_posts))
                                    {
                                        foreach ($bookmark_posts as $bookmark_post){

                                            ?>

                                    <li>

                                        <!-- Job Listing -->

                                        <div class="job-listing">



                                            <!-- Job Listing Details -->

                                            <div class="job-listing-details">



                                                <!-- Logo -->

                                                <a href="#" class="job-listing-company-logo">

                                                    <img src="<?=$bookmark_post['avtar']?>" alt="">

                                                </a>



                                                <!-- Details -->

                                                <div class="job-listing-description">

                                                    <h3 class="job-listing-title"><a

                                                            href="#"><?=$bookmark_post['t_name']?></a></h3>



                                                    <?php

                                                                $time_type='';

                                                                $type=$bookmark_post['pay_type']; 

                                                                switch ($type){

                                                                    case 1:

                                                                        $time_type="Fixed Price";

                                                                        break;

                                                                    case 2:

                                                                        $time_type = "Hourly Rate";

                                                                        break;

                                                                }

                                                                $date = date('Y-m-d H:i:s');

                                                                $presentTime = new DateTime($date);

                                                                $postedTime =new DateTime($bookmark_post['time_stamp']);

                                                                $interval = $postedTime->diff($presentTime);



                                                                $month=$interval->format('%m month');

                                                                if($month != 0){

                                                                    $time_ago=$interval->format('%m month %d days');

                                                                }

                                                                else{

                                                                    $time_ago=$interval->format('%d days');

                                                                }

                                                                

                                                            ?>

                                                    <!-- Job Listing Footer -->

                                                    <div class="job-listing-footer">

                                                        <ul>

                                                            <li><i class="icon-material-outline-business"></i>

                                                                <?=$bookmark_post['t_catagory']?></li>

                                                            <li><i class="icon-material-outline-location-on"></i>

                                                                <?=$bookmark_post['location']?></li>

                                                            <li><i class="icon-material-outline-business-center"></i>

                                                                <?=$time_type?></li>

                                                            <li><i

                                                                    class="icon-material-outline-access-time"></i><?=$time_ago?>

                                                                ago</li>

                                                        </ul>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                        <!-- Buttons -->

                                        <div class="buttons-to-right">

                                            <form method="post">

                                                <button type="submit" name="delete_bookmarkTask"

                                                    value="<?=$bookmark_post['bookmark_id']?>"

                                                    class="button red ripple-effect ico" title="Remove"

                                                    data-tippy-placement="left"><i

                                                        class="icon-feather-trash-2"></i></button>

                                            </form>

                                        </div>

                                    </li>

                                    <?php    

                                        }
                                    }
                                    else
                                    {
                                        ?>
                                            <div class="alert alert-primary">
                                                No Bookmarks Found!
                                            </div>
                                        <?php
                                    }

                                        ?>

                                </ul>

                            </div>

                        </div>

                    </div>



                    <?php

                        if ($TYPE == 2){

                        ?>

                    <!-- Dashboard Box -->

                    <div class="col-xl-12">

                        <div class="dashboard-box">

                            <!-- Headline -->

                            <div class="headline">

                                <h3><i class="icon-material-outline-face"></i> Bookmarked Freelancers</h3>

                            </div>



                            <?php

                                foreach($bookmark_freelancers as $bookmark_freelancer){

                            ?>

                            <div class="content">

                                <ul class="dashboard-box-list">

                                    <li>

                                        <!-- Overview -->

                                        <div class="freelancer-overview">

                                            <div class="freelancer-overview-inner">



                                                <!-- Avatar -->

                                                <div class="freelancer-avatar">

                                                    <div class="verified-badge"></div>

                                                    <a href="profile?token=<?=$bookmark_freelancer['u_id']?>"><img src=<?=$bookmark_freelancer['avtar']?> alt=""></a>

                                                </div>



                                                <!-- Name -->

                                                <div class="freelancer-name">

                                                <?php

                                                    $nationality = $bookmark_freelancer['nationality'];

                                                    $country_code = strtolower($nationality);

                                                ?>

                                                    <h4><a href="#"><?=$bookmark_freelancer['f_name']?>

                                                            <?=$bookmark_freelancer['l_name']?> <img class="flag"

                                                                src="http://api.hostip.info/images/flags/<?=$country_code?>.gif" alt="" title="<?=$bookmark_freelancer['nationality']?>"

                                                                data-tippy-placement="top"></a></h4>

                                                                    <?php

                                                                    foreach($bookmark_freelancer['skills'] as $skill){

                                                                        ?>

                                                                        <span>+ <?=$skill['skill']?></span>

                                                                    <?php

                                                                    }

                                                                    ?>



                                                    <!-- Rating -->

                                                    <?php

                                                        $totalRatings=0;

                                                        $i=0;

                                                        foreach($bookmark_freelancer['ratings'] as $rating)

                                                        {

                                                            $totalRatings = $totalRatings + $rating['rating'];

                                                            $i++;

                                                        }

                                                        $finalRatings=$totalRatings/$i;

                                                        if($i==1){

                                                            $finalRatings=0;

                                                        }

                                                    ?>

                                                    

                                                    <div class="freelancer-rating">

                                                        <div class="star-rating" data-rating="<?=$finalRatings?>"></div>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>



                                        <!-- Buttons -->

                                        <div class="buttons-to-right">

                                            <form method="post">

                                                <button type="submit" name="delete_bookmarkLancer"

                                                    value="<?=$bookmark_freelancer['bookmark_id']?>"

                                                    class="button red ripple-effect ico" title="Remove"

                                                    data-tippy-placement="left"><i

                                                        class="icon-feather-trash-2"></i></button>

                                            </form>

                                        </div>

                                    </li>

                                </ul>

                            </div>

                            <?php  

                                        }

                                        ?>

                        </div>

                    </div>

                    <?php

                                }

                    ?>





                </div>

                <!-- Row / End -->



                <!-- Footer -->

                <div class="dashboard-footer-spacer"></div>

                <div class="small-footer margin-top-15">

                    <div class="small-footer-copyrights">

                    </div>

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





<!-- Apply for a job popup

================================================== -->

<div id="small-dialog" class="zoom-anim-dialog mfp-hide dialog-with-tabs">



    <!--Tabs -->

    <div class="sign-in-form">



        <ul class="popup-tabs-nav">

            <li><a href="#tab">Add Note</a></li>

        </ul>



        <div class="popup-tabs-container">



            <!-- Tab -->

            <div class="popup-tab-content" id="tab">



                <!-- Welcome Text -->

                <div class="welcome-text">

                    <h3>Do Not Forget 😎</h3>

                </div>



                <!-- Form -->

                <form method="post" id="add-note">



                    <select class="selectpicker with-border default margin-bottom-20" data-size="7" title="Priority">

                        <option>Low Priority</option>

                        <option>Medium Priority</option>

                        <option>High Priority</option>

                    </select>



                    <textarea name="textarea" cols="10" placeholder="Note" class="with-border"></textarea>



                </form>



                <!-- Button -->

                <button class="button full-width button-sliding-icon ripple-effect" type="submit" form="add-note">Add

                    Note <i class="icon-material-outline-arrow-right-alt"></i></button>



            </div>



        </div>

    </div>

</div>

<!-- Apply for a job popup / End -->





<?php

    require_once 'js-links.php';

?>



</body>



<!-- Mirrored from www.vasterad.com/themes/AWH/dashboard-bookmarks.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 10 Feb 2021 18:39:02 GMT -->



</html>

<script>

    $("#dashboard").removeClass('active');

	$("#bookmarks").removeClass('active');

	$("#reviews").removeClass('active');

	$("#jobs").removeClass('active');

	$("#tasks").removeClass('active');

	$("#settings").removeClass('active');

	$("#milestone").removeClass('active');

	$("#bookmarks").addClass('active');



</script>