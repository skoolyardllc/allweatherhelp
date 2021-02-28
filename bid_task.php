<?php
    require_once 'header.php';

    if(isset($_GET['token']) and !empty($_GET['token']))
    {
        $t_id=$conn->real_escape_string($_GET['token']);

        if(isset($_POST['placeBid'])){
            $time_type = $conn->real_escape_string($_POST['time_type']);
            $time_no = $conn->real_escape_string($_POST['time_no']);
            $description = $conn->real_escape_string($_POST['description']);
            $bid_expected = $_POST['bid_expected'];
    
            $sql = "insert into bidding (t_id,c_id,time_no,time_type,description) values('$t_id','$USER_ID','$time_no','$time_type','$description')";
            if($conn->query($sql))
            {
                $insertId = $conn->insert_id;
                $sql = "update bidding set bid_expected='$bid_expected' where id='$insertId'"; 
                if($conn->query($sql))
                {
                    $bidded =true;
                } 
                else{
                    $error =$conn->error;
                }
            }
        }




        $sql = "select * from post_task where id='$t_id'";
        if($result =$conn->query($sql))
        {
            if($result->num_rows)
            {
                $row=$result->fetch_assoc();
                $taskDetails = $row;
            } 
        }

        $sql = "select * from skill_tasks where t_id='$t_id'";
        if($result =$conn->query($sql))
        {
            if($result->num_rows)
            {
                while($row=$result->fetch_assoc()){
                    $skills[] = $row;
                }
            } 
        }

        $sql = "select up.*,r.* from user_profile up,post_task pt,ratings r  where pt.id='$t_id' and pt.e_id=up.u_id and pt.e_id=r.u_id";
        if($result =$conn->query($sql))
        {
            if($result->num_rows)
            {
                $row=$result->fetch_assoc();
                $employerDetails = $row;
            } 
        }

        // $sql = "select * from ratings where t_id='$t_id'";
        // if($result =$conn->query($sql))
        // {
        //     if($result->num_rows)
        //     {
        //         while($row=$result->fetch_assoc()){
        //             $ratings[] = $row;
        //         }
        //     } 
        // }

        $sql = "select up.*,b.* from bidding b , user_profile up where b.t_id='$t_id' and b.c_id=up.u_id ";
        if($result =$conn->query($sql))
        {
            if($result->num_rows)
            {
                while($row=$result->fetch_assoc()){
                    $bidders[$row["id"]] = $row;
                    $sql = "select * from skill_tasks where t_id=".$row["id"];
                    if($res =$conn->query($sql))
                    {
                        if($res->num_rows)
                        {
                            while($row1=$res->fetch_assoc())
                            {
                                $taskDetails[$row["id"]]["skills"][] = $row1;
                            }
                        }
                    }
                }
            } 
        }


    }

?>

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
                            <div class="header-image"><a href="single-company-profile.html"><img
                                        src="images/browse-companies-02.png" alt=""></a></div>
                            <div class="header-details">
                                <h3><?=$taskDetails['t_name']?></h3>
                                <h5>About the Employer</h5>
                                <ul>
                                    <?php
                                    echo $nationality = $employerDetails['nationality'];
                                    $country_code = strtolower($nationality);
                                ?>
                                    <li><a href="single-company-profile.html"><i
                                                class="icon-material-outline-business"></i> Acue</a></li>
                                    <li>
                                        <div class="star-rating" data-rating="<?=$employerDetails['rating']?>"></div>
                                    </li>
                                    <li><img class="flag"
                                            src="http://api.hostip.info/images/flags/<?=$country_code?>.gif" alt=""
                                            title="<?=$employerDetails['nationality']?>" alt=""
                                            data-tippy-placement="top" /><?=$employerDetails['nationality']?></li>
                                    <li>
                                        <div class="verified-badge-with-title">Verified</div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="right-side">
                            <div class="salary-box">
                                <?php
                                $pay_type='';
                                $type = $taskDetails['pay_type'];
                                switch ($type){
                                    case 1:
                                        $pay_type="Fixed price";
                                        break;
                                    case 2:
                                        $pay_type = "Hourly rate";
                                        break;
                                }
                            ?>
                                <div class="salary-type">Project Budget</div>
                                <div class="salary-amount">$<?=$taskDetails['min_salary']?> -
                                    $<?=$taskDetails['max_salary']?> </div>( <?=$pay_type?> )
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
        if(isset($bidded)){
            ?>
                <div class="alert alert-success" role="alert">
                    You has successfully bidded for this task !!!
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
                    <p><?=$taskDetails['t_description']?></p>
                </div>

                <!-- Atachments -->
                <div class="single-page-section">
                    <h3>Attachments</h3>
                    <div class="attachments-container">
                        <a href="#" class="attachment-box ripple-effect"><span>Project Brief</span><i>PDF</i></a>
                    </div>
                </div>

                <!-- Skills -->
                <div class="single-page-section">
                    <h3>Skills Required</h3>
                    <div class="task-tags">
                        <?php
                            foreach ($skills as $skill){
                                ?>
                        <span><?=$skill['skills']?></span>
                        <?php
                            }
                            ?>
                    </div>
                </div>
                <div class="clearfix"></div>

                <!-- Freelancers Bidding -->
                <div class="boxed-list margin-bottom-60">
                    <div class="boxed-list-headline">
                        <h3><i class="icon-material-outline-group"></i> Freelancers Bidding</h3>
                    </div>
                    <ul class="boxed-list-ul">
                        <?php
                        $id = $taskDetails['e_id'];
                        foreach($bidders as $bidder){
                            if($bidder['c_id'] != $id){
                        ?>
                        <li>
                            <div class="bid">
                                <!-- Avatar -->
                                <div class="bids-avatar">
                                    <div class="freelancer-avatar">
                                        <div class="verified-badge"></div>
                                        <a href="single-freelancer-profile.html"><img
                                                src="images/user-avatar-big-01.jpg" alt=""></a>
                                    </div>
                                </div>

                                <!-- Content -->
                                <div class="bids-content">
                                    <!-- Name -->
                                    <div class="freelancer-name">
                                        <?php
                                                $nationality = $bidder['nationality'];
                                                $country_code = strtolower($nationality);
                                            ?>
                                        <h4><a href="single-freelancer-profile.html"><?=$bidder['f_name']?>
                                                <?=$bidder['l_name']?> <img class="flag"
                                                    src="http://api.hostip.info/images/flags/<?=$country_code?>.gif"
                                                    alt="" title="<?=$employerDetails['nationality']?>" alt=""
                                                    data-tippy-placement="top"></a></h4>
                                        <div class="star-rating" data-rating="<?=$bidder['bid_expected']?>"></div>
                                        <!-- <span class="not-rated">Minimum of 3 votes required</span> -->
                                    </div>
                                </div>

                                <!-- Bid -->
                                <div class="bids-bid">
                                    <div class="bid-rate">
                                        <?php
                                                $time_type='';
                                                $type = $bidder['time_type'];
                                                switch ($type){
                                                    case 1:
                                                        $time_type="Hours";
                                                        break;
                                                    case 2:
                                                        $time_type = "Days";
                                                        break;
                                                }
                                            ?>
                                        <div class="rate">$<?=$bidder['bid_expected']?></div>
                                        <span>in <?=$bidder['time_no']?> <?=$time_type?></span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <?php
                            }
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
                            $end_date =new DateTime($taskDetails['end_date']);
                            $interval = $end_date->diff($presentTime);
                        ?>
                    <div class="countdown green margin-bottom-35">
                        <?php echo $interval->format('%d days %H hours %i minutes')?> left</div>

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
                                    <div class="bidding-value">$<span id="biddingVal"></span></div>
                                    <input class="bidding-slider" type="text" name="bid_expected"
                                        data-slider-handle="custom" data-slider-currency="$" data-slider-min="10"
                                        data-slider-max="1000" data-slider-value="auto" data-slider-step="50"
                                        data-slider-tooltip="hide" />
                                    <!-- onchange="change_bidding_amount(value)" -->
                                    <!-- Headline -->
                                    <span class="bidding-detail margin-top-30">Set your <strong>delivery
                                            time</strong></span>

                                    <!-- Fields -->
                                    <div class="bidding-fields">
                                        <div class="bidding-field">
                                            <!-- Quantity Buttons -->
                                            <div class="qtyButtons">
                                                <div class="qtyDec"></div>
                                                <input name="time_no" type="text" placeholder="eg. 2" name="qtyInput">
                                                <div class="qtyInc"></div>
                                            </div>
                                        </div>
                                        <div class="bidding-field">
                                            <?php
                                                    $time_type_days ='';
                                                    $time_type_hours=''; 
                                                    $type = $bidder['time_type'];
                                                    switch ($TYPE){
                                                        case 1:
                                                            $time_type_hours="checked";
                                                            break;
                                                        case 2:
                                                            $time_type_days = "checked";
                                                            break;
                                                    }
                                                ?>
                                            <select class="selectpicker default" name="time_type">
                                                <option value="1" <?=$time_type_hours?>>Hours</option>
                                                <option value="2" <?=$time_type_hours?>>Days</option>
                                            </select>
                                        </div>

                                        <div class="col-xl-12 margin-top-30">
                                            <div class="submit-field">
                                                <h5>Write your bid</h5>
                                                <textarea name="description" cols="30" rows="8"
                                                    class="with-border"><?=$profile['intro']?></textarea>
                                            </div>
                                        </div>

                                    </div>

                                    <!-- Button -->
                                    <button name="placeBid" id="snackbar-place-bid"
                                        class="button ripple-effect move-on-hover full-width margin-top-30"><span>Place a
                                            Bid</span></button>

                                </div>
                            </form>
                            <div class="bidding-signup">Don't have an account? <a href="signup.php"
                                    class="register-tab sign-in popup-with-zoom-anim">Sign Up</a></div>
                        </div>
                    </div>

                    <!-- Sidebar Widget -->
                    <div class="sidebar-widget">
                        <h3>Bookmark or Share</h3>

                        <!-- Bookmark Button -->
                        <button class="bookmark-button margin-bottom-25">
                            <span class="bookmark-icon"></span>
                            <span class="bookmark-text">Bookmark</span>
                            <span class="bookmarked-text">Bookmarked</span>
                        </button>

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
                                    <li><a id='facebook' href="https://www.facebook.com/sharer/sharer.php?u=" target="_blank" data-button-color="#3b5998" title="Share on Facebook"
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
function change_bidding_amount(amount) {
    $.ajax({
        url: "bid_task_ajax.php",
        type: "post",
        data: {
            userId: '<?=$USER_ID?>',
            changeBidding_amount: true,
            amount: amount,
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