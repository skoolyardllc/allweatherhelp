<?php
require_once 'header.php';

if (isset($_GET['token']) and !empty($_GET['token'])) 
{
    $t_id = $conn->real_escape_string($_GET['token']);

    if (isset($_POST['placeBid'])) {
        $time_type = $conn->real_escape_string($_POST['time_type']);
        $time_no = $conn->real_escape_string($_POST['time_no']);
        $description = $conn->real_escape_string($_POST['description']);
        $bid_expected = $_POST['bid_expected'];
        $sql="select e_id from post_task where id='$t_id'";
        if ($res = $conn->query($sql)) 
        {
            if ($res->num_rows) 
            {
                $row1 = $res->fetch_assoc();
                    $for_id = $row1['e_id'];
                    $done = "Your bid has been submitted successfully";
            }
        }

        $sql = "insert into bidding (t_id,c_id,time_no,time_type,description,stat) values('$t_id','$USER_ID','$time_no','$time_type','$description',0)";
        if ($conn->query($sql)) 
        {
            $insertId = $conn->insert_id;
            $sql = "update bidding set bid_expected='$bid_expected' where id='$insertId'";
            if ($conn->query($sql)) 
            {
                $sql2="insert into notifications(msg, link, for_id, status,task) values('You have a new bid', 'manage_bidder.php?token=$t_id', '$for_id', 1,'$t_id')";
                if ($conn->query($sql2)) 
                {
                    $resMember=true;
                }
                else
                {
                    $error = $conn->error;
                }
            } 
            else 
            {
                $error = $conn->error;
            }
        }
    }

    
    $sql="select * from bookmarks where u_id='$USER_ID' and t_id='$t_id'";
    if ($res = $conn->query($sql)) 
    {
        if ($res->num_rows) 
        {
            $row1 = $res->fetch_assoc();
                $bmark[] = $row1;
        }
    }
    if(isset($_POST['editBid']))
    {
        $time_type = $conn->real_escape_string($_POST['time_type']);
        $time_no = $conn->real_escape_string($_POST['time_no']);
        $description = $conn->real_escape_string($_POST['description']);
        $bid_expected = $_POST['bid_expected'];
        $sql = "update bidding set time_no = '$time_no' , time_type = '$time_type', description = '$description' where c_id='$USER_ID' and t_id='$t_id'";
        if($result = $conn->query($sql))
        {
            $done = "Your Bid is updated Successfully";
        }
        else
        {
            echo $conn->error;
        }
    }




    $sql = "select pt.*,up.* from post_task pt,user_profile up where pt.id='$t_id' and up.u_id=pt.e_id";
    if ($result = $conn->query($sql)) {
        if ($result->num_rows) {
            $row = $result->fetch_assoc();
            $taskDetails = $row;
        }
    }

    $rate = $taskDetails['u_id'];
    $sql="SELECT CAST(AVG(ratings) AS DECIMAL(10,1)) as rates FROM employer_reviews where c_id='$rate'";
    if ($result = $conn->query($sql)) {
        if ($result->num_rows) {
            $row = $result->fetch_assoc();
            $emp_rate = $row;
            // print_r($emp_rate);
        }
    }


    $sql = "select * from skill_tasks where t_id='$t_id'";
    if ($result = $conn->query($sql)) {
        if ($result->num_rows) {
            while ($row = $result->fetch_assoc()) {
                $skills[] = $row;
            }
        }
    }
    // print_r($skills);

    $sql = "SELECT * from bidding where t_id='$t_id' and c_id='$USER_ID' and stat=0";
    if($result = $conn->query($sql))
    {
        if($result->num_rows)
        {
            $row = $result->fetch_assoc();
            $existing=$row;
            
        }
        // print_r($existing);
    }
    else
    {
        echo $conn->error;
    }

    $sql = "select up.*,r.* from user_profile up,post_task pt,ratings r  where pt.id='$t_id' and pt.e_id=up.u_id and pt.e_id=r.u_id";
    if ($result = $conn->query($sql)) {
        if ($result->num_rows) {
            $row = $result->fetch_assoc();
            $employerDetails = $row;
        }
    }

    $sql="select * from uploaded_documents where t_id='$t_id'";
    if ($result = $conn->query($sql)) {
        if ($result->num_rows) {
            while($row = $result->fetch_assoc())
            {
                $attachments[] = $row;
            }
        }
    }

    // to calculate the rating of employer
   $sql = "select r.* from post_task pt,ratings r where pt.id='$t_id' and pt.e_id=r.u_id";
    if($result =$conn->query($sql))
    {
        if($result->num_rows)
        {
            while($row=$result->fetch_assoc()){
                $employerRatings[] = $row;
            }
        } 
    }

    $sql = "select up.u_id,up.f_name,up.l_name,up.avtar,up.nationality,up.hourly_rate,b.t_id,b.c_id,b.bid_expected,b.description,b.time_no,b.time_type from bidding b , user_profile up where b.t_id='$t_id' and b.c_id=up.u_id ";
    if ($result = $conn->query($sql)) {
        if ($result->num_rows) {
            while ($row = $result->fetch_assoc()) {
                $bidders[$row['u_id']] = $row;
                $sql = "select * from ratings where u_id=" . $row['u_id'];
                if ($res = $conn->query($sql)) {
                    if ($res->num_rows) {
                        while ($row1 = $res->fetch_assoc()) {
                            $bidders[$row["u_id"]]["ratings"][] = $row1;
                        }
                    }
                }
            }
        }
    }


}
?>
<style>
    .biddescription{padding-left:0 !important;padding-right:0 !important}
</style>
<!-- Wrapper -->
<div id="wrapper">

    <?php
    require_once 'navbar.php';
    ?>
    <div class="clearfix"></div>
    <!-- Header Container / End -->


    <!-- Titlebar
    ================================================== -->
    <div class="single-page-header" data-background-image="images/single-task.jpg">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="single-page-header-inner">
                        <div class="left-side">
                            <div class="header-image"><a
                                    href="single-company-profile?token=<?=$taskDetails['e_id']?>"><img
                                        src="<?= $taskDetails['avtar'] ?>" alt=""></a></div>
                            <div class="header-details">
                                <h3><?= $taskDetails['t_name'] ?></h3>
                                <h5>About the Employer</h5>
                                <ul>
                                    <?php
                                    $nationality = $taskDetails['nationality'];
                                    $country_code = strtolower($nationality);
                                    ?>
                                    <li><a href="single-company-profile?token=<?=$taskDetails['e_id']?>"><i
                                                class="icon-material-outline-business"></i>
                                            <?= $taskDetails['f_name'] . ' ' . $taskDetails['l_name'] ?></a></li>
                                    <li>
                                        <?php
                                            $totalRatings=0;
                                            $i=1;
                                            foreach($employerRatings as $rating)
                                            {
                                                $totalRatings = $totalRatings + $rating['rating'];
                                                $i++;
                                            }
                                            
                                            $finalRatings=$totalRatings/$i;
                                            if($emp_rate['rates'] == 0 )
                                            {
                                                ?>
                                                   <i class="bi bi-star-fill" style="color:gold"></i> No ratings
                                                <?php
                                            }
                                            else
                                            {
                                                ?>
                                                    <div class="star-rating" data-rating="<?=$emp_rate['rates']?>"></div>
                                                <?php
                                            }
                                        ?>
                                        
                                        
                                    </li>
                                    <li><img class="flag"
                                            src="http://api.hostip.info/images/flags/<?= $country_code ?>.gif" alt=""
                                            title="<?= $taskDetails['nationality'] ?>" alt=""
                                            data-tippy-placement="top" /><?= $taskDetails['nationality'] ?></li>
                                    <li>
                                        <?php
                                        if ($taskDetails['status'] == 2) {
                                        ?>
                                        <div class="verified-badge-with-title">Verified</div>
                                        <?php
                                        } else if ($taskDetails['status'] == 1) {
                                        ?>
                                        <div class="verified-badge-with-title">Verified</div>
                                        <?php
                                        }
                                        ?>

                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="right-side">
                            <div class="salary-box">
                                <?php
                                $pay_type = '';
                                $type = $taskDetails['pay_type'];
                                switch ($type) {
                                    case 1:
                                        $pay_type = "Fixed price";
                                        break;
                                    case 2:
                                        $pay_type = "Hourly rate";
                                        break;
                                }
                                ?>
                                <div class="salary-type">Project Budget</div>
                                <div class="salary-amount">$<?= $taskDetails['min_salary'] ?> -
                                    $<?= $taskDetails['max_salary'] ?> </div>( <?= $pay_type ?> )
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
        <?php
        if (isset($bidded)) {
        ?>
        <div class="alert alert-success" role="alert">
            You has successfully bidded for this task !!!
        </div>
        <?php
        }
        if(isset($done))
        {
            ?>
                <div class="alert alert-success" role="alert">
                    <?=$done?>
                </div>
            <?php
        }
        
        ?>

        <div class="row">

            <!-- Content -->
            <div class="col-xl-7 col-lg-7 content-right-offset">

                <!-- Description -->
                <div class="single-page-section">
                    <h3 class="margin-bottom-25">Project Description</h3>
                    <p><?= $taskDetails['t_description'] ?></p>
                </div>

                <!-- Atachments -->
                <div class="single-page-section">
                    <h3>Attachments</h3>
                    <div class="attachments-container">
                    <?php
                        if(isset($attachments)) 
                        {
                            $counter=0;
                            foreach($attachments as $file)
                            {

                                $ext=pathinfo($file['document'],PATHINFO_EXTENSION);
                                if(strtolower($ext)=="pdf")
                                {
                                    
                                ?>
                                <div class="col-md-6" id="file<?=$counter?>">
                                    <div class="col-md-4">
                                        <a href="uploads/<?=$file['document']?>"  target="_blank"><img src="images/PDF.svg" width="100px" height="100px"/></a>            
                                    </div>
                                </div>
                                <?php
                                }
                                else
                                {
                                ?>
                                <div class="col-md-6" id="file<?=$counter?>">
                                    <div class="col-md-4">
                                        <a href="uploads/<?=$file['document']?>" target="_blank"><img src="uploads/<?=$file['document']?>" width="100px" height="100px"/></a>
                                    </div>
                                </div>
                                <?php
                                }
                            }
                        }
                    ?>

                                                

                    </div>
                </div>

                <!-- Skills -->
                <div class="single-page-section">
                    <h3>Skills Required</h3>
                    <div class="task-tags">
                        <?php
                        foreach ($skills as $skill) {
                        ?>
                        <span><?= $skill['skills'] ?></span>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="clearfix"></div>

                <!-- Freelancers Bidding -->
                <div class="boxed-list margin-bottom-60">
                    <div class="boxed-list-headline">
                        <h3><i class="icon-material-outline-group"></i>Bidding</h3>
                    </div>
                    <ul class="boxed-list-ul">
                        <?php
                        $id = $taskDetails['e_id'];
                        if (isset($bidders))
                        {
                        foreach ($bidders as $bidder) {
                            if ($bidder['c_id'] != $id) {
                        ?>
                        <li>
                            <div class="bid">
                                <!-- Avatar -->
                                <div class="bids-avatar">
                                    <div class="freelancer-avatar">
                                        <div class="verified-badge"></div>
                                        <a href="profile?token=<?= $bidder['c_id'] ?>"><img
                                                src="<?= $bidder['avtar'] ?>" alt=""></a>
                                    </div>
                                </div>

                                <!-- Content -->
                                <div class="bids-content">
                                    <!-- Name -->
                                    <div class="freelancer-name">
                                        <?php
                                                $nationality = $bidder['nationality'];
                                                $country_code = strtolower($nationality);

                                                $totalRatings=0;
                                                $i=0;
                                                foreach($bidder['ratings'] as $rating)
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
                                        <h4><a href="profile?token=<?= $bidder['c_id'] ?>"><?= $bidder['f_name'] ?>
                                                <?= $bidder['l_name'] ?> <img class="flag"
                                                    src="http://api.hostip.info/images/flags/<?= $country_code ?>.gif"
                                                    alt="" title="<?= $employerDetails['nationality'] ?>" alt=""
                                                    data-tippy-placement="top"></a></h4>
                                                    <p><?=$bidder['description']?></p>
                                        <?php
                                            if(isset($showrating)){
                                                ?>
                                                <div class="star-rating" data-rating="<?=$finalRatings?>"></div>
                                                <?php
                                            }            
                                            else{
                                                ?>
                                                <span class="not-rated"><i class="bi bi-star-fill" style="color:gold"></i>No Ratings</span>
                                                <?php
                                            }
                                        ?>
                                    </div>
                                </div>

                                <!-- Bid -->
                                <div class="bids-bid">
                                    <div class="bid-rate">
                                        <?php
                                                $time_type = '';
                                                $type = $bidder['time_type'];
                                                switch ($type) {
                                                    case 1:
                                                        $time_type = "Hours";
                                                        break;
                                                    case 2:
                                                        $time_type = "Days";
                                                        break;
                                                }
                                                ?>
                                        <div class="rate">$<?= $bidder['bid_expected'] ?></div>
                                        <span>in <?= $bidder['time_no'] ?> <?= $time_type ?></span>
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
                                <div class="alert alert-primary">
                                    No Bidders Found for this task!!
                                </div>
                            <?php
                        }    
                        ?>
                    </ul>
                </div>

            </div>


            <!-- Sidebar -->
            <!-- <form method="post"> -->
            <div class="col-xl-5 col-lg-5">
                <div class="sidebar-container">
                <?php
                    $date = date('Y-m-d H:i:s');
                    $presentTime = new DateTime($date);
                    $end_date = new DateTime($taskDetails['end_date']);
                    $interval = $end_date->diff($presentTime);
                    ?>
                    
                    
                        <?php
                        if(date("Y-m-d") < $taskDetails['end_date'])
                        {
                        ?> 
                            <div class="countdown green margin-bottom-35"><?php echo $interval->format('%d days %H hours %i minutes')?> left </div>
                        <?php
                        }
                        else if(date("Y-m-d") > $taskDetails['end_date'])
                        {
                        ?>
                            <div class="countdown green margin-bottom-35">Closed <?php echo $interval->format('%d days %H hours %i minutes')?> ago</div>
                        <?php
                        }
                        ?>

                    <div class="sidebar-widget">
                        <div class="bidding-widget">
                            <div class="bidding-headline">
                                <h3>Bid on this task!</h3>
                            </div>
                            <form method="post">
                                <div class="bidding-inner">

                                    <!-- Headline -->
                                    <span class="bidding-detail">Set your <strong>minimal rate</strong></span>

                                    <!-- Price Slider -->
                                    <!-- <div class="bidding-value">$<span id="biddingVal"></span></div>
                                        <input class="bidding-slider"   type="text" name="bid_expected"
                                            data-slider-handle="custom" data-slider-currency="$" data-slider-min="10"
                                            data-slider-max="1000" data-slider-value="auto" data-slider-step="50"
                                            data-slider-tooltip="hide" />
                                            <div class="qtyButtons with-border"> -->
                                    <div class="bidding-field">
                                        <!-- Quantity Buttons -->
                                        <div class="qtyButtons with-border">
                                            <div class="qtyDec"></div>
                                            <?php
                                                if(!isset($existing))
                                                {
                                                    ?>
                                                         <input type="text" name="bid_expected" id="bid_expected" placeholder="eg. 3"
                                                        value="0">
                                                    <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                        <input type="text" name="bid_expected" id="bid_expected" placeholder="eg. 3"
                                                        value="<?=$existing['bid_expected']?>">
                                                    <?php
                                                }
                                            ?>
                                            
                                            <!-- <input type="hidden" id="etime_no" name="etime_no" class="form-control"> -->
                                            <div class="qtyInc"></div>
                                        </div>
                                    </div>


                                    <!-- onchange="change_bidding_amount(value)" -->
                                    <!-- Headline -->
                                    <span class="bidding-detail margin-top-30">Set your <strong>estimated task time</strong></span>

                                    <!-- Fields -->
                                    <div class="bidding-fields">
                                        <div class="bidding-field">
                                            <!-- Quantity Buttons -->
                                            <div class="qtyButtons">
                                                <div class="qtyDec"></div>
                                                <?php
                                                if(!isset($existing))
                                                {
                                                    ?>
                                                        <input name="time_no" type="text" placeholder="eg. 2" name="qtyInput" value="0">            
                                                    <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                        <input name="time_no" type="text" placeholder="eg. 2" name="qtyInput" value="<?=$existing['time_no']?>">            
                                                    <?php
                                                }
                                                ?>
                                                <div class="qtyInc"></div>
                                            </div>
                                        </div>
                                        <div class="bidding-field">
                                        <?php
                                            if(isset($existing))
                                            {
                                                $ghanta = '';
                                                $minutes = '';
                                                $yoyo = $existing['time_type'];
                                                if($yoyo == 1)
                                                {
                                                    $ghanta = 'checked';
                                                }
                                                else if($yoyo == 2)
                                                {
                                                    $din = 'checked';
                                                }
                                                // echo $ghanta;
                                                // echo $din;
                                                ?>
                                                    <select class="selectpicker default yoyo" name="time_type">
                                                    <option value="2" <?= $din ?>>Days</option>
                                                        <option value="1" <?= $ghanta ?>>Hours</option>
                                                        
                                                    </select>
                                                <?php
                                            }
                                            else
                                            {

                                                $time_type_days = '';
                                                $time_type_hours = '';
                                                $type = $bidder['time_type'];
                                                switch ($type) {
                                                    case 1:
                                                        $time_type_hours = "checked";
                                                        break;
                                                    case 2:
                                                        $time_type_days = "checked";
                                                        break;
                                                }
                                            
                                        ?>
                                            <select class="selectpicker default" name="time_type">
                                                <option value="1" <?= $time_type_hours ?>>Hours</option>
                                                <option value="2" <?= $time_type_hours ?>>Days</option>
                                            </select>
                                            <?php
                                                }
                                            ?>
                                        </div>

                                        <div class="col-xl-12 margin-top-30 biddescription">
                                            <div class="submit-field">
                                                <h5>Write your bid</h5>
                                                <textarea name="description" cols="30" rows="8"
                                                    class="with-border"><?= $profile['intro'] ?><?=$existing['description']?></textarea>
                                            </div>
                                        </div>

                                    </div>

                                    <!-- Button -->
                                        <?php
                                        if(date("Y-m-d") > $taskDetails['end_date'])
                                        {
                                        ?>
                                            <div class="countdown green margin-bottom-35">Closed <?php echo $interval->format('%d days %H hours %i minutes')?> ago</div>
                                        <?php
                                        }
                                        

                                        else if(isset($existing))
                                        {
                                            ?>
                                                <button name="editBid" id="snackbar-place-bid"
                                                    class="button ripple-effect move-on-hover full-width margin-top-30">
                                                    <span>
                                                        Edit Your Bid
                                                    </span>
                                                </button>
                                            <?php
                                        }
                                        else{
                                            ?>
                                             <button name="placeBid" id="snackbar-place-bid"
                                                class="button ripple-effect move-on-hover full-width margin-top-30"><span>Place
                                                    a
                                                    Bid</span></button>
                                            
                                            <?php
                                        }
                                    ?>
                                   

                                </div>
                            </form>
                            
                        </div>
                    </div>

                    <!-- Sidebar Widget -->
                    <div class="sidebar-widget">
                        <h3>Bookmark or Share</h3>

                        <!-- Bookmark Button -->
                        
                           <?php
                           if(isset($bmark))
                           {
                           ?>
                            <button onclick="change_bookmark(<?=$taskDetails['id']?>)"
                            class="bookmark-button margin-bottom-25">
                                <span class="bookmark-icon"></span>
                                <span class="bookmark-text">Bookmarked</span>
                                <span class="bookmarked-text">Bookmark</span>
                                
                            </button>
                            <?php
                           }
                           else
                           {
                            ?>
                               <button onclick="change_bookmark(<?= $taskDetails['id']?>)"
                            class="bookmark-button margin-bottom-25">
                                <span class="bookmark-icon"></span>
                                <span class="bookmark-text">Bookmark</span>
                                <span class="bookmarked-text">Bookmarked</span>
                                
                            </button>
                            <?php
                           }
                           ?>
                            
                            
                        

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
                                    <li><a id='facebook' href="https://www.facebook.com/sharer/sharer?u="
                                            target="_blank" data-button-color="#3b5998" title="Share on Facebook"
                                            data-tippy-placement="top"><i class="icon-brand-facebook-f"></i></a></li>
                                    <li><a href="#" data-button-color="#1da1f2" title="Share on Twitter"
                                            data-tippy-placement="top"><i class="icon-brand-twitter"></i></a></li>
                                    <li><a href="#" data-button-color="#dd4b39" title="Share on Google Plus"
                                            data-tippy-placement="top"><i class="icon-brand-google-plus-g"></i></a></li>
                                    <li><a href="#" data-button-color="#0077b5" title="Share on LinkedIn"
                                            data-tippy-placement="top"><i class="icon-brand-linkedin-in"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- </form> -->

        </div>
    </div>


    <!-- Spacer -->
    <div class="margin-top-15"></div>
    <!-- Spacer / End-->


</div>
<!-- Wrapper / End -->


<!-- Sign In Popup
================================================== -->
<div id="sign-in-dialog" class="zoom-anim-dialog mfp-hide dialog-with-tabs">

    <!--Tabs -->
    <div class="sign-in-form">

        <ul class="popup-tabs-nav">
            <li><a href="#login">Log In</a></li>
            <li><a href="#register">Register</a></li>
        </ul>

        <div class="popup-tabs-container">

            <!-- Login -->
            <div class="popup-tab-content" id="login">

                <!-- Welcome Text -->
                <div class="welcome-text">
                    <h3>We're glad to see you again!</h3>
                    <span>Don't have an account? <a href="#" class="register-tab">Sign Up!</a></span>
                </div>

                <!-- Form -->
                <form method="post" id="login-form">
                    <div class="input-with-icon-left">
                        <i class="icon-material-baseline-mail-outline"></i>
                        <input type="text" class="input-text with-border" name="emailaddress" id="emailaddress"
                            placeholder="Email Address" required />
                    </div>

                    <div class="input-with-icon-left">
                        <i class="icon-material-outline-lock"></i>
                        <input type="password" class="input-text with-border" name="password" id="password"
                            placeholder="Password" required />
                    </div>
                    <a href="#" class="forgot-password">Forgot Password?</a>
                </form>

                <!-- Button -->
                <button class="button full-width button-sliding-icon ripple-effect" type="submit" form="login-form">Log
                    In <i class="icon-material-outline-arrow-right-alt"></i></button>

                <!-- Social Login -->
                <div class="social-login-separator"><span>or</span></div>
                <div class="social-login-buttons">
                    <button class="facebook-login ripple-effect"><i class="icon-brand-facebook-f"></i> Log In via
                        Facebook</button>
                    <button class="google-login ripple-effect"><i class="icon-brand-google-plus-g"></i> Log In via

                        Google+</button>
                </div>

            </div>

            <!-- Register -->
            <div class="popup-tab-content" id="register">

                <!-- Welcome Text -->
                <div class="welcome-text">
                    <h3>Let's create your account!</h3>
                </div>

                <!-- Account Type -->
                <div class="account-type">
                    <div>
                        <input type="radio" name="account-type-radio" id="freelancer-radio" class="account-type-radio"
                            checked />
                        <label for="freelancer-radio" class="ripple-effect-dark"><i
                                class="icon-material-outline-account-circle"></i> Freelancer</label>
                    </div>

                    <div>
                        <input type="radio" name="account-type-radio" id="employer-radio" class="account-type-radio" />
                        <label for="employer-radio" class="ripple-effect-dark"><i
                                class="icon-material-outline-business-center"></i> Employer</label>
                    </div>
                </div>

                <!-- Form -->
                <form method="post" id="register-account-form">
                    <div class="input-with-icon-left">
                        <i class="icon-material-baseline-mail-outline"></i>
                        <input type="text" class="input-text with-border" name="emailaddress-register"
                            id="emailaddress-register" placeholder="Email Address" required />
                    </div>

                    <div class="input-with-icon-left" title="Should be at least 8 characters long"
                        data-tippy-placement="bottom">
                        <i class="icon-material-outline-lock"></i>
                        <input type="password" class="input-text with-border" name="password-register"
                            id="password-register" placeholder="Password" required />
                    </div>

                    <div class="input-with-icon-left">
                        <i class="icon-material-outline-lock"></i>
                        <input type="password" class="input-text with-border" name="password-repeat-register"
                            id="password-repeat-register" placeholder="Repeat Password" required />
                    </div>
                </form>

                <!-- Button -->
                <button class="margin-top-10 button full-width button-sliding-icon ripple-effect" type="submit"
                    form="register-account-form">Register <i class="icon-material-outline-arrow-right-alt"></i></button>

                <!-- Social Login -->
                <div class="social-login-separator"><span>or</span></div>
                <div class="social-login-buttons">
                    <button class="facebook-login ripple-effect"><i class="icon-brand-facebook-f"></i> Register via
                        Facebook</button>
                    <button class="google-login ripple-effect"><i class="icon-brand-google-plus-g"></i> Register via
                        Google+</button>
                </div>

            </div>

        </div>
    </div>
</div>
<!-- Sign In Popup / End -->






<?php
require_once 'js-links.php';
require_once 'footer.php';
?>

<script>
// function change_bidding_amount(amount) {
//     $.ajax({
//         url: "bid_task_ajax.php",
//         type: "post",
//         data: {
//             userId: '<?= $USER_ID ?>',
//             changeBidding_amount: true,
//             amount: amount,
//         },
//         success: function(data) {
//             console.log(data);
//         },
//         error: function(data) {
//             console.log("galti");
//         }
//     })
// }

function change_bookmark(t_id) {
    console.log(t_id)
    $.ajax({
        url: "bid_task_ajax.php",
        type: "post",
        data: {
            userId: '<?= $USER_ID ?>',
            change_bookmark: true,
            task_id: t_id,
        },
        success: function(data) {
            console.log(data);
        },
        error: function(data) {
            console.log("galti");
        }
    })
}

$(function() {
    var x = window.location.href;
    var link = document.getElementById("facebook"); // store the element

    var curHref = link.getAttribute('href'); // get its current href value
    link.setAttribute('href', curHref + x);
})
</script>