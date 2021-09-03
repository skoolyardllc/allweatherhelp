<?php
    require_once 'header.php';

    if(isset($_GET['token']))
    {
        $id=$_GET['token'];
        $sql = "select up.* , u.type from user_profile up ,users u where up.u_id = u.id and up.u_id=$id";
        if ($result = $conn->query($sql)) {
            if ($result->num_rows) {
                $row = $result->fetch_assoc();
                $taskDetails = $row;
            }
        }
        if($taskDetails['type'] == 2)
        {
            $sql = "SELECT * from insurance where u_id = $id";
            if($result = $conn->query($sql))
            {
                if($result->num_rows > 0)
                {
                    $row = $result->fetch_assoc();
                    $insurance = $row;
                }
            }
        }
        $sql="select * from bookmarks where u_id='$USER_ID' and f_id='$id'";
        if ($res = $conn->query($sql)) 
        {
            if ($res->num_rows) 
            {
                $row1 = $res->fetch_assoc();
                    $bmark = $row1;
            }
        }
        $sql = "select *, post_task.id as taskId from post_task,task_category where post_task.e_id=$id and post_task.t_catagory=task_category.id order by post_task.id desc limit 5";
        if ($result = $conn->query($sql)) {
            if ($result->num_rows) {
                while ($row = $result->fetch_assoc()) {
                    $works[] = $row;
                }
                // print_r($works);
            }
        }

        $sql = "select e.* , p.id , p.t_name from employer_reviews e , post_task p where c_id=$id and e.t_id = p.id order by e.id desc limit 5 ";
        if ($result = $conn->query($sql)) {
            if ($result->num_rows) {
                while ($row = $result->fetch_assoc()) {
                    $reviewsss[] = $row;
                }
            }
        }
        else
        {
            $error =  $conn->error;
        }
        $sql="SELECT CAST(AVG(ratings) AS DECIMAL(10,1)) as rates FROM employer_reviews where c_id='$id'";
        if ($result = $conn->query($sql)) {
            if ($result->num_rows) 
            {
                $row = $result->fetch_assoc();
                $emp_rate = $row;
            }
        }

    }

?>

<div id="wrapper">

    <?php
    require_once 'navbar.php';
    ?>
    <div class="clearfix"></div>
    <div class="single-page-header" data-background-image="images/single-company.jpg">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="single-page-header-inner">
                        <div class="left-side">
                            <div class="header-image"><img src="<?= $taskDetails['avtar'] ?>" alt=""></div>
                            <?php
                                $nationality = $taskDetails['nationality'];
                                $country_code = strtolower($nationality);
                            ?>
                            <div class="header-details">
                                <h3><?= $taskDetails['f_name'] ?> <?= $taskDetails['l_name'] ?><span><?= $taskDetails['tagline'] ?></span></h3>
                                <ul>
                                    <li>
                                    <?php

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
                                    <li><img class="flag" src="http://api.hostip.info/images/flags/<?= $country_code ?>.gif" alt="" title="<?= $taskDetails['nationality'] ?>" alt="" data-tippy-placement="top" /><?= $taskDetails['nationality'] ?></li>
                                    <li><div class="verified-badge-with-title">Verified</div></li>
                                </ul>
                            </div>
                        </div>
                        <div class="right-side">
                            <!-- Breadcrumbs -->
                            <nav id="breadcrumbs" class="white">
                                <!-- <ul>
                                    <li><a href="#">Home</a></li>
                                    <li><a href="#">Browse Companies</a></li>
                                    <li>Acodia</li>
                                </ul> -->
                            </nav>
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

                <div class="single-page-section">
                    <h3 class="margin-bottom-25">About Company</h3>
                    <p><?=$taskDetails['intro']?></p>
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
                        <h3><i class="icon-material-outline-business-center"></i> Open Positions</h3>
                    </div>

                    <div class="listings-container compact-list-layout">

                    <?php
                        if(isset($works))
                        {
                            foreach($works as $w)
                            {
                                $date = strtotime($w['time_stamp']);
                                $date1=date_create(date("Y-m-d",$date));
                                $date2=date_create(date("Y-m-d"));
                                $abcd=date_diff($date1,$date2);
                                $time=$abcd->format("%a");
                                
                            //    echo $time;
                                
                               
                            //    echo $date;
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
                        
                        <!-- Job Listing -->
                        <a href="bid_task?token=<?=$w['taskId']?>" class="job-listing">

                            <!-- Job Listing Details -->
                            <div class="job-listing-details">

                                <!-- Details -->
                                <div class="job-listing-description">
                                    <h5  class="job-listing-title"><?=$w['t_name']?></h5>
                                    <h3 style="color:black">Category : <?= $w['category'] ?></h3>
                                    

                                    <!-- Job Listing Footer -->
                                    <div class="job-listing-footer">
                                        <ul>
                                            <li><i class="icon-material-outline-location-on"></i> <?=$w['location']?></li>
                                            <li><i class="icon-material-outline-access-time"></i> <?=$happy?></li>
                                        </ul>
                                    </div>
                                </div>

                            </div>

                            <!-- Bookmark -->
                            <span class="bookmark-icon"></span>
                        </a>
                    <?php
                            }
                        }
                        else
                        {
                            ?>
                            <br>
                            <div class="alert alert-danger">
                                No Open Positions Found!!
                            </div>
                            <?php
                        }
                    ?>

                       	
                    </div>

                </div>
                <!-- Boxed List / End -->

                <!-- Boxed List -->
                <div class="boxed-list margin-bottom-60">
                    <div class="boxed-list-headline">
                        <h3><i class="icon-material-outline-thumb-up"></i> Work History and Feedback</h3>
                    </div>
                    <ul class="boxed-list-ul">
                        <?php
                            if(isset($reviewsss))
                            {
                            foreach($reviewsss as $task){
                                ?>
                                    <li>
                                        <div class="boxed-list-item">
                                            <!-- Content -->
                                            <div class="item-content">
                                                <h4><?=$task['t_name']?><span>Rated as Employer</span></h4>
                                                <div class="item-details margin-top-10">
                                                    <div class="star-rating" data-rating="<?=$task['ratings']?>"></div>
                                                    <?php
                                                        $timestamp = strtotime($task['time_stamp']);
                                                        $date = date('M Y', $timestamp);
                                                    ?>

                                                    <div class="detail-item"><i class="icon-material-outline-date-range"></i><?=$date?></div>
                                                </div>
                                                <div class="item-description">
                                                    <p> Clarity in Specifications : <?=$task['speci']?>/5</p>
                                                    <p> Communication : <?=$task['comm']?>/5</p>
                                                    <p> Payment Promptness : <?=$task['payment']?>/5</p>
                                                    <p> Professionalism : <?=$task['profess']?>/5</p>
                                                    <p><?=$task['review']?></p>

                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                <?php
                            }
                        }else
                        {
                            ?>
                            <br>
                            <div class="alert alert-primary">
                                No Records Found!!
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

                    <!-- Location -->
                    <!-- <div class="sidebar-widget">
                        <h3>Location</h3>
                        <div id="single-job-map-container">
                            <div id="singleListingMap" data-latitude="52.520007" data-longitude="13.404954" data-map-icon="im im-icon-Hamburger"></div>
                            <a href="#" id="streetView">Street View</a>
                        </div>
                    </div> -->

                    <!-- Widget -->
                    <!-- <div class="sidebar-widget">
                        <h3>Social Profiles</h3>
                        <div class="freelancer-socials margin-top-25">
                            <ul>
                                <li><a href="#" title="Dribbble" data-tippy-placement="top"><i class="icon-brand-dribbble"></i></a></li>
                                <li><a href="#" title="Twitter" data-tippy-placement="top"><i class="icon-brand-twitter"></i></a></li>
                                <li><a href="#" title="Behance" data-tippy-placement="top"><i class="icon-brand-behance"></i></a></li>
                                <li><a href="#" title="GitHub" data-tippy-placement="top"><i class="icon-brand-github"></i></a></li>
                            
                            </ul>
                        </div>
                    </div> -->

                    <!-- Sidebar Widget -->
                    <div class="sidebar-widget">
                        <h3>Bookmark or Share</h3>

                        <!-- Bookmark Button -->
                        <?php
                           if(isset($bmark))
                           {
                           ?>
                            <button onclick="change_bookmark()"
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
                               <button onclick="change_bookmark()"
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
                            <button class="copy-url-button ripple-effect" data-clipboard-target="#copy-url" title="Copy to Clipboard" data-tippy-placement="top"><i class="icon-material-outline-file-copy"></i></button>
                        </div>

                        <!-- Share Buttons -->
                        <div class="share-buttons margin-top-25">
                            <div class="share-buttons-trigger"><i class="icon-feather-share-2"></i></div>
                            <div class="share-buttons-content">
                                <span>Interesting? <strong>Share It!</strong></span>
                                <ul class="share-buttons-icons">
                                    <li><a href="#" data-button-color="#3b5998" title="Share on Facebook" data-tippy-placement="top"><i class="icon-brand-facebook-f"></i></a></li>
                                    <li><a href="#" data-button-color="#1da1f2" title="Share on Twitter" data-tippy-placement="top"><i class="icon-brand-twitter"></i></a></li>
                                    <li><a href="#" data-button-color="#dd4b39" title="Share on Google Plus" data-tippy-placement="top"><i class="icon-brand-google-plus-g"></i></a></li>
                                    <li><a href="#" data-button-color="#0077b5" title="Share on LinkedIn" data-tippy-placement="top"><i class="icon-brand-linkedin-in"></i></a></li>
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
</div>

<?php
require_once 'js-links.php';
require_once 'footer.php';
?>

<script>
    function change_bookmark() {
    $.ajax({
        url: "bid_task_ajax.php",
        type: "post",
        data: {
            userId: '<?= $USER_ID ?>',
            change_bookmark_user: true,
            f_id: <?=$id?>,
        },
        success: function(data) {
            console.log(data);
        },
        error: function(data) {
            console.log("galti");
        }
    })
}
</script>