<?php

    require_once 'header.php';

    require_once 'navbar.php';



    if(isset($_GET['token']) and !empty($_GET['token']))

    {

        $t_id=$conn->real_escape_string($_GET['token']);

        $sql = "select b.*,up.*,u.type from bidding b , user_profile up,users u where u.id=up.u_id and b.c_id='$t_id' and up.u_id=b.c_id";

        if($result =$conn->query($sql))

        {

            if($result->num_rows)

            {

                $row=$result->fetch_assoc();

                $bidderDetails = $row;

            } 

        }
        else
        {
            $error =  $conn->error;
        }
        $sql = "select up.*,u.type from user_profile up,users u where u.id=up.u_id and up.u_id='$t_id' ";
        if($result =$conn->query($sql))
        {
            if($result->num_rows)
            {
                $row=$result->fetch_assoc();
                $userDetails = $row;
            } 
        }

        // print_r($bidderDetails);

        if($userDetails['type'] == 2)

        {

            $sql = "SELECT * from insurance where u_id = $t_id";

            if($result = $conn->query($sql))

            {

                if($result->num_rows > 0)

                {

                    $row = $result->fetch_assoc();

                    $insurance = $row;

                }

            }

            else

            {

                echo $conn->error;

            }

        }



        $sql = "select r.* from ratings r where r.u_id='$t_id'";

        if($result =$conn->query($sql))

        {   

            if($result->num_rows)

            {

                while($row=$result->fetch_assoc()){

                    $ratings[] = $row;

                }

            } 

        }



        $sql = "select s.* from skills s where s.u_id='$t_id'";

        if($result =$conn->query($sql))

        {   

            if($result->num_rows)

            {

                while($row=$result->fetch_assoc()){

                    $skills[] = $row;

                }

            } 

        }


        $count=0;
        $sql = "select distinct at.* ,pt.*,r.* from accepted_task at,post_task pt,ratings r where at.c_id='$t_id' and at.t_id=pt.id  and r.u_id=at.c_id and r.t_id=pt.id";

        if($result =$conn->query($sql))

        {   

            if($result->num_rows)

            {

                $count=0;

                while($row=$result->fetch_assoc()){

                    $taskCompleted[] = $row;

                    $count++;

                }

            }

        }

        // echo $count;

        

        // to calculate the percentage



        $sql = "select count(id) as count from accepted_task where job_success='1' and c_id='$t_id' ";

        if($result =$conn->query($sql))

        {

            if($result->num_rows)

            {

                $row=$result->fetch_assoc();

                $job_success_no=$row['count'];

                if($count==0)

                {

                    $job_success_per=0;

                }

                else

                {

                    $job_success_per = ($job_success_no/$count)*100;

                }

            }

        }



        $sql = "select count(id) as count from accepted_task where recomendation='1' and c_id='$t_id' ";

        if($result =$conn->query($sql))

        {

            if($result->num_rows)

            {

                $row=$result->fetch_assoc();

                $recomendation_no=$row['count'];

                if($count==0)

                {

                    $recomendation_per=0;

                }

                else

                {

                    $recomendation_per = ($recomendation_no/$count)*100;

                }

            }

        }



        $sql = "select count(id) as count from accepted_task where on_time='1' and c_id='$t_id' ";

        if($result =$conn->query($sql))

        {

            if($result->num_rows)

            {

                $row=$result->fetch_assoc();

                $on_time_no=$row['count'];

                if($count==0)

                {

                    $on_time_per=0;

                }

                else

                {

                    $on_time_per = ($on_time_no/$count)*100;

                }

            }

        }



        $sql = "select count(id) as count from accepted_task where on_budget='1' and c_id='$t_id' ";

        if($result =$conn->query($sql))

        {

            if($result->num_rows)

            {

                $row=$result->fetch_assoc();

                $on_budget_no=$row['count'];

                if($count==0)

                {

                    $on_budget_per =0;

                }

                else

                {

                    $on_budget_per = ($on_budget_no/$count)*100;

                }

            }

        }

        





    }





    

?>

<!-- Wrapper -->

<div id="wrapper">



    <div class="clearfix"></div>

    <!-- Header Container / End -->







    <!-- Titlebar

    ================================================== -->

    <div class="single-page-header freelancer-header" data-background-image="images/single-freelancer.jpg">

        <div class="container">

            <div class="row">

                <div class="col-md-12">

                    <div class="single-page-header-inner">

                        <div class="left-side">

                            <div class="header-image freelancer-avatar"><img src="<?=$userDetails['avtar']?>" alt="">

                            </div>

                            <div class="header-details">



                                <h3><?=$userDetails['f_name']?> <?=$userDetails['l_name']?>

                                    <span>

                                        <?php 

                                        if(isset($skills))
                                        {
                                        foreach($skills as $skill){

                                            ?>

                                        + <?=$skill['skill']?>

                                        <?php

                                            }
                                        }

                                        ?></span>

                                </h3>



                                <ul>

                                    <li>

                                        <?php

                                            $totalRatings=0;

                                            $i=0;

                                            foreach($ratings as $rating)

                                            {

                                                $totalRatings = $totalRatings + $rating['rating'];

                                                $i++;

                                            }

                                            if($i==0){

                                                $finalRatings=0;

                                            }

                                            else{

                                                $finalRatings=$totalRatings/$i;

                                                $showrating='true';

                                            }

                                        ?>

                                        <?php

                                            if(isset($showrating)){

                                                ?>

                                                <div class="star-rating" data-rating="<?=$finalRatings?>"></div>

                                                <?php

                                            }            

                                            else{

                                                ?>



                                                <span class="not-rated"><i style="color: gold" class="fa fa-star" aria-hidden="true"></i>No ratings</span>

                                                <?php

                                            }

                                        ?>

                                    </li>

                                    <?php

                                        $nationality = $userDetails['nationality'];

                                        $country_code = strtolower($nationality);

                                    ?>

                                    <li><img class="flag"

                                            src="http://api.hostip.info/images/flags/<?=$country_code?>.gif" alt=""

                                            title="<?=$userDetails['nationality']?>"></li>

                                    <li>

                                        <div class="verified-badge-with-title">Verified</div>

                                    </li>

                                </ul>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>





    <!-- Page Content

================================================== -->

    <div class="container">

        <div class="row">



            <!-- Content -->

            <div class="col-xl-8 col-lg-8 content-right-offset">



                <!-- Page Content -->

                <div class="single-page-section">

                    <h3 class="margin-bottom-25">About Me</h3>

                    <?=$userDetails['intro']?>

                </div>

                <?php

                    if(isset($insurance))

                    {

                        ?>

                            <div class="single-page-section">

                                <h3 class="margin-bottom-25">Insurance Details</h3>

                                <p><?=$insurance['in_company']?></p>

                                <br>

                                <?php

                                    $ext=pathinfo($insurance['document'],PATHINFO_EXTENSION);

                                    if(strtolower($ext)=="pdf")

                                    {

                                        

                                    ?>

                                    <div class="col-md-6" id="file<?=$counter?>">

                                        <div class="col-md-4">

                                            <a href="uploads/<?=$insurance['document']?>"  target="_blank"><img src="./images/PDF.svg" width="100px" height="100px"/></a>            

                                        </div>

                                    </div>

                                    <?php

                                    }

                                    else

                                    {

                                    ?>

                                    <div class="col-md-6" id="insurance<?=$counter?>">

                                        <div class="col-md-4">

                                            <a href="uploads/<?=$insurance['document']?>" target="_blank"><img src="./uploads/<?=$insurance['document']?>" width="100px" height="100px"/></a>

                                        </div>

                                    </div>

                                    <?php

                                    }

                                    

                                ?>

                            </div>

                        <?php

                    }

                

                ?> 

                <!-- Boxed List -->

                <div class="boxed-list margin-bottom-60">

                    <div class="boxed-list-headline">

                        <h3><i class="icon-material-outline-thumb-up"></i> Work History and Feedback</h3>

                    </div>

                    <ul class="boxed-list-ul">

                        <?php

                        if(isset($taskCompleted))

                        {

                            foreach($taskCompleted as $task)

                            {

                                if($task['review'] != '')

                                {

                                ?>

                                    <li>

                                        <div class="boxed-list-item">

                                            <!-- Content -->

                                            <div class="item-content">

                                                <h4><?=$task['t_name']?><span>Rated as Freelancer</span></h4>

                                                <div class="item-details margin-top-10">

                                                    <div class="star-rating" data-rating="<?=$task['rating']?>"></div>

                                                    <?php

                                                                    $timestamp = strtotime($task['time_stamp']);

                                                                    $date = date('M Y', $timestamp);

                                                                ?>

                                                    <div class="detail-item"><i

                                                            class="icon-material-outline-date-range"></i><?=$date?></div>

                                                </div>

                                                <div class="item-description">

                                                    <p><?=$task['review']?></p>

                                                </div>

                                            </div>

                                        </div>

                                    </li>

                        <?php

                                }

                            }

                        }

                        else

                        {

                        ?>

                            <div style="margin-top: 5px;" class="alert alert-danger" role="alert">

                                No Records Found

                            </div>

                        <?php

                        }

                        ?>



                    </ul>



                    <!-- Pagination -->

                    <div class="clearfix"></div>

                    <!-- <div class="pagination-container margin-top-40 margin-bottom-10">

                        <nav class="pagination">

                            <ul>

                                <li><a href="#" class="ripple-effect current-page">1</a></li>

                                <li><a href="#" class="ripple-effect">2</a></li>

                                <li class="pagination-arrow"><a href="#" class="ripple-effect"><i

                                            class="icon-material-outline-keyboard-arrow-right"></i></a></li>

                            </ul>

                        </nav>

                    </div> -->

                    <div class="clearfix"></div>

                    <!-- Pagination / End -->



                </div>

                <!-- Boxed List / End -->



            </div>





            <!-- Sidebar -->

            <div class="col-xl-4 col-lg-4">

                <div class="sidebar-container">



                    <!-- Profile Overview -->

                    <div class="profile-overview">

                        <div class="overview-item"><strong>$<?=$userDetails['hourly_rate']?></strong><span>Hourly

                                Rate</span></div>

                        <div class="overview-item"><strong><?=$count?></strong><span>Jobs Done</span></div>

                    </div>



                    <!-- Button -->

                    <a href="#small-dialog" class="apply-now-button popup-with-zoom-anim margin-bottom-50">Make an Offer

                        <i class="icon-material-outline-arrow-right-alt"></i></a>



                    <!-- Freelancer Indicators -->

                    <div class="sidebar-widget">

                        <div class="freelancer-indicators">



                            <!-- Indicator -->

                            <div class="indicator">

                                <strong><?=$job_success_per?>%</strong>

                                <div class="indicator-bar" data-indicator-percentage="<?=$job_success_per?>"><span></span></div>

                                <span>Job Success</span>

                            </div>



                            <!-- Indicator -->

                            <div class="indicator">

                                <strong><?=$recomendation_per?>%</strong>

                                <div class="indicator-bar" data-indicator-percentage="<?=$recomendation_per?>"><span></span></div>

                                <span>Recommendation</span>

                            </div>



                            <!-- Indicator -->

                            <div class="indicator">

                            <strong><?=$on_time_per?>%</strong>

                                

                                <div class="indicator-bar" data-indicator-percentage="<?=$on_time_per?>"><span></span></div>

                                <span>On Time</span>

                            </div>



                            <!-- Indicator -->

                            <div class="indicator">

                                <strong><?=$on_budget_per?>%</strong>

                                <div class="indicator-bar" data-indicator-percentage="<?=$on_budget_per?>"><span></span></div>

                                <span>On Budget</span>

                            </div>

                        </div>

                    </div>



                    <!-- Widget -->

                    <div class="sidebar-widget">

                        <h3>Skills</h3>

                        <div class="task-tags">

                            <?php 
                            if(isset($skills))
                            {
                                foreach($skills as $skill){

                                    ?>

                            <span><?=$skill['skill']?></span>

                            <?php

                                }
                            }
                            else
                            {
                                ?>
                                    <div class="alert alert-primary">
                                        No skills found
                                    </div>
                                <?php
                            }
                            ?>

                        </div>

                    </div>



                    <!-- Widget -->

                    <!-- <div class="sidebar-widget">

                        <h3>Attachments</h3>

                        <div class="attachments-container">

                            <a href="#" class="attachment-box ripple-effect"><span>Cover Letter</span><i>PDF</i></a>

                            <a href="#" class="attachment-box ripple-effect"><span>Contract</span><i>DOCX</i></a>

                        </div>

                    </div>
 -->


                    <!-- Sidebar Widget -->

                    <div class="sidebar-widget">



                        <?php

                        if ($TYPE == 3){

                            ?>

                            <h3>Bookmark</h3>

                        

                            <!-- Bookmark Button -->

                            <button onclick="change_bookmark(<?=$userDetails['u_id'] ?>)"

                                class="bookmark-button margin-bottom-25">

                                <span class="bookmark-icon"></span>

                                <span class="bookmark-text">Bookmark</span>

                                <span class="bookmarked-text">Bookmarked</span>

                            </button>

                            <?php

                        }

                        ?>



                        <h3>Share</h3>



                        <!-- Copy URL -->

                        <div class="copy-url">

                            <input id="copy-url" type="text" value="" class="with-border">

                            <button class="copy-url-button ripple-effect" data-clipboard-target="#copy-url"

                                title="Copy to Clipboard" data-tippy-placement="top"><i

                                    class="icon-material-outline-file-copy"></i></button>

                        </div>



                        <!-- Share Buttons -->

                        <div class="share-buttons margin-top-25">

                            <div class="share-buttons-trigger"><i class="icon-feather-share-2"></i></div>

                            <div class="share-buttons-content">

                                <span>Interesting? <strong>Share It!</strong></span>

                                <ul class="share-buttons-icons">

                                    <li><a id='facebook' href="https://www.facebook.com/sharer/sharer.php?u="

                                            target="_blank" data-button-color="#3b5998" title="Share on Facebook"

                                            data-tippy-placement="top"><i class="icon-brand-facebook-f"></i></a></li>

                                    <li><a id='twitter' href="https://twitter.com/intent/tweet" target="_blank"

                                            data-button-color="#1da1f2" title="Share on Twitter"

                                            data-tippy-placement="top"><i class="icon-brand-twitter"></i></a></li>

                                    <!-- <li><a id='googlePlus' href="https://plus.google.com/share?url=" data-button-color="#dd4b39" title="Share on Google Plus"

                                            data-tippy-placement="top"><i class="icon-brand-google-plus-g"></i></a></li> -->

                                    <li><a id='linkedin'

                                            href="https://www.linkedin.com/shareArticle?mini=true&url=http://developer.linkedin.com&title=LinkedIn%20Developer%20Network&summary=My%20favorite%20developer%20program&source=LinkedIn"

                                            data-button-color="#0077b5" title="Share on LinkedIn"

                                            data-tippy-placement="top"><i class="icon-brand-linkedin-in"></i></a></li>

                                </ul>

                            </div>

                        </div>

                    </div>



                </div>

            </div>



        </div>

    </div>





    <!-- Spacer -->

    <div class="margin-top-15"></div>

    <!-- Spacer / End-->

    <?php

        require_once 'footer.php';

    ?>

</div>

<!-- Wrapper / End -->





<!-- Make an Offer Popup

================================================== -->

<div id="small-dialog" class="zoom-anim-dialog mfp-hide dialog-with-tabs">



    <!--Tabs -->

    <div class="sign-in-form">



        <ul class="popup-tabs-nav">

            <li><a href="#tab">Make an Offer</a></li>

        </ul>



        <div class="popup-tabs-container">



            <!-- Tab -->

            <div class="popup-tab-content" id="tab">



                <!-- Welcome Text -->

                <div class="welcome-text">

                    <h3>Message for <?=$userDetails['f_name']?> <?=$userDetails['l_name']?></h3>

                </div>



                <!-- Form -->

                <form method="post">



                    



                    <textarea name="textarea" cols="10" id="msg" name="msg" placeholder="Message" class="with-border"></textarea>



                </form>



                <!-- Button -->

                <button class="button margin-top-35 full-width button-sliding-icon ripple-effect" type="button" onclick="addmessage()">Make an

                    Offer <i class="icon-material-outline-arrow-right-alt"></i></button>



            </div>

            <!-- Login -->

            <div class="popup-tab-content" id="loginn">



                <!-- Welcome Text -->

                <div class="welcome-text">

                    <h3>Discuss Your Project With Tom</h3>

                </div>



                <!-- Form -->

                <form method="post" id="make-an-offer-form">



                    <div class="input-with-icon-left">

                        <i class="icon-material-outline-account-circle"></i>

                        <input type="text" class="input-text with-border" name="name2" id="name2"

                            placeholder="First and Last Name" required />

                    </div>



                    <div class="input-with-icon-left">

                        <i class="icon-material-baseline-mail-outline"></i>

                        <input type="text" class="input-text with-border" name="emailaddress2" id="emailaddress2"

                            placeholder="Email Address" required />

                    </div>



                    <textarea name="textarea" cols="10" placeholder="Message" class="with-border"></textarea>



                    <div class="uploadButton margin-top-25">

                        <input class="uploadButton-input" type="file" accept="image/*, application/pdf" id="upload-cv"

                            multiple />

                        <label class="uploadButton-button" for="upload-cv">Add Attachments</label>

                        <span class="uploadButton-file-name">Allowed file types: zip, pdf, png, jpg <br> Max. files

                            size: 50 MB.</span>

                    </div>



                </form>



                <!-- Button -->

                <button class="button full-width button-sliding-icon ripple-effect" type="submit"

                    form="make-an-offer-form">Make an Offer <i class="icon-material-outline-arrow-right-alt"></i>

                </button>



            </div>



        </div>

    </div>

</div>

<!-- Make an Offer Popup / End -->

<?php

    require_once 'js-links.php';

?>



<script>

$(function() {

    var x = window.location.href;

    var link_facebook = document.getElementById("facebook"); // store the element

    var link_twitter = document.getElementById("twitter"); // store the element

    var linkedin = document.getElementById("linkedin"); // store the element



    var curHref = link_facebook.getAttribute('href'); // get its current href value of facebook

    link_facebook.setAttribute('href', curHref + x);



    var curHref = link_twitter.getAttribute('href'); // get its current href value of twitter

    link_twitter.setAttribute('href', curHref + x);



    var curHref = link_linkedin.getAttribute('href'); // get its current href value of linkedin

    link_linkedin.setAttribute('href', curHref + x);



})



function addmessage()

{

    var msg=$("#msg").val()

    console.log(msg)

    $.ajax({

        url: "profile_ajax.php",

        type: "post",

        data: {

            for: <?=$t_id?>,

            addmsg: msg,

            from: <?=$USER_ID?>

        },

        success: function(data) {

            $(".mfp-close").trigger("click");

        },

        error: function(data) {

            console.log("galti");

        }

    })

}



function change_bookmark(u_id) {

    $.ajax({

        url: "profile_ajax.php",

        type: "post",

        data: {

            userId: '<?= $USER_ID ?>',

            change_bookmark: true,

            f_id: u_id,

        },

        success: function(data) {

            console.log(data);

        },

        error: function(data) {

            console.log("galti");

        }

    })

}



    $("#dashboard").removeClass('active');

	$("#bookmarks").removeClass('active');

	$("#reviews").removeClass('active');

	$("#jobs").removeClass('active');

	$("#tasks").removeClass('active');

	$("#settings").removeClass('active');

	$("#milestone").removeClass('active');

	// $("#milestone").addClass('active');



</script>