<?php
    require_once 'header.php';
    require_once 'navbar.php';


    $sql = "SELECT at.*,up.f_name,up.l_name,up.u_id as user,up.avtar,pt.t_name,pt.id as task_id,pt.e_id as emp_id,at.id as main_id from accepted_task at,user_profile up,post_task pt where  up.u_id=at.c_id and at.t_id=pt.id and (at.statu=0 or at.statu=2) and at.adm_id='$USER_ID'";
    $note = '';
    $review_emp = 'none';
    switch ($TYPE)
    {
        case 2:
           $sql = "SELECT at.*,up.f_name,up.l_name,up.u_id as user,up.avtar,pt.t_name,pt.id as task_id,pt.e_id as emp_id,at.id as main_id from accepted_task at,user_profile up,post_task pt where up.u_id=at.adm_id and at.t_id = pt.id and at.c_id='$USER_ID' and at.emp_status is NULL ";
            $note = 'none';
            $review_emp = 'show';
           break;
        case 3:
            $sql = "SELECT at.*,up.f_name,up.l_name,up.u_id as user,up.avtar,pt.t_name,pt.id as task_id,pt.e_id as emp_id,at.id as main_id from accepted_task at,user_profile up,post_task pt where up.u_id=at.adm_id and at.t_id = pt.id and at.c_id='$USER_ID' and at.emp_status is NULL";
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
                $mil[] = $row;
               
            }
        }
    }
    else 
    {
        echo $conn->error;
    }
    $userg='';
    switch ($TYPE)
    {
        case 2:
            $userg = 'Contractor';
            break;
        case 3:
            $userg = 'Employer';
    }

    if(isset($_POST['completed']))
    {
        
        $main_id=$_POST['main_id'];

        //  $sql="INSERT INTO milestones(task_id,cus_id,emp_id,mil_title,mil_desc,due_date,mil_status,pay_status) values ($task_id,$cus_id,$review_emp_id,'$title','$desc','$due',$stat,0)";
        $sqll = "update accepted_task set statu=2 where id=$main_id";
        if ( $result = $conn->query($sqll)) 
        {
            $done = "Task marked Completed";
        }
        else{
            echo $conn->error;
        }

    }

    if(isset($_POST['review_do']))
        {
            $c_id = $_POST['cid'];
            $revi = $_POST['message2'];
            $job = $_POST['radio0'];
            $recommend = $_POST['radio3'];
            $time = $_POST['radio2'];
            $budget = $_POST['radio'];
            $rating = $_POST['rating'];
            $t_id = $_POST['tid'];
            $sql = "update accepted_task set review='$revi',job_success='$job',recomendation='$recommend',
            on_time='$time',on_budget='$budget',ratings='$rating',statu=1
            where c_id=$c_id and t_id=$t_id";
            $sqll = "insert into ratings (u_id,t_id,rating) values($c_id,$t_id,$rating)";
            if ($conn->query($sql) && $conn->query($sqll)) 
            {
                $done = "Your review is recorded successfully!";
            }
            else
            {
                echo $conn->error;
            }
        }

        if(isset($_POST['employer_review']))
        {
            $rating = $_POST['ratings'];
            $u_id = $user_data['u_id'];
            $c_id = $_POST['employer'];
            $t_id = $_POST['task_id'];
            $comm = $_POST['comm'];
            $speci = $_POST['speci'];
            $payment =$_POST['payment'];
            $profess = $_POST['profess'];
            $revie = $_POST['reviews'];
            $id=$_POST['employerkiid'];
            $sql = "insert into employer_reviews(t_id,c_id,speci,comm,payment,profess,ratings,review,u_id)
             values('$t_id','$c_id','$speci','$comm','$payment','$profess','$rating','$revie','$u_id')";
             $up  = "update accepted_task set emp_status = 1 where id='$id' ";
            //  echo $up; 
            if ($conn->query($sql) && $conn->query($up)) 
            {
                $done = "Your review is recorded successfully!";
            }else
            {
                $error = $conn->error;
            }
        }
?>
<div id="wrapper">




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
				<h3><i class="bi bi-flag"></i> Milestone</h3>

				<!-- Breadcrumbs -->
				<nav id="breadcrumbs" class="dark">
					<ul>
						<li><a href="index">Home</a></li>
						<li><a href="dashboard">Dashboard</a></li>
						<li>Milestone</li>
					</ul>
				</nav>
                
			</div>
	
            <div class="row">
                <div class="col-xl-12">
                    <?php
                        if(isset($done))
                        {
                            ?>
                                <div class="alert alert-primary" id="123456">
                                    <?=$done?>
                                    <span class="float-right" style="cursor:pointer" onclick="remove(123456)">x</span>
                                </div>

                            <?php
                        }
                    ?>
                </div>
            </div>
			<!-- Row -->
			<div class="row">

				<!-- Dashboard Box -->
				<div class="col-xl-12" >
                        <div class="dashboard-box margin-top-0">
                            <div class="dashboard-box-header" style="margin:20px;display:flex;flex:1;justify-content:flex-end">
                                
                                <p class="d-flex-justify-content-center">* Note : Click on mark completed to see the work by the client and enable review button!
                                   
                                </p>
                            </div>
                        </div>
                        <!-- <br> -->
					
                        <?php
                            if(isset($mil))
                            {
                                $i=1;
                                foreach($mil as $m)
                                {
                                    $complete = 'show';
                                    $abc = $m['task_id'];
                                    $sql = "select * from completed where task_id='$abc' and user_id='$USER_ID'";
                                    switch($TYPE)
                                    {
                                        case 5:
                                            $sql = "select * from completed where task_id='$abc'";
                                            break;
                                    }
                                    if($result=$conn->query($sql))
                                    {
                                        if($result->num_rows>0)
                                        {
                                            $comp = $result->fetch_assoc();
                                            $complete = 'none';

                                        }
                                        // print_r($comp);
                                        // echo $USER_ID;
                                    }
                                    else{
                                        echo $conn->error;
                                    }
                        ?>
                    <div class="dashboard-box margin-top-0">

						<!-- Headline -->
						<div class="headline">
                            <div class="row">
                                <div class="col-lg-2 col-md-2">
                                    <div class="freelancer-overview manage-candidates">
                                        <div class="freelancer-overview-inner">

                                            <!-- Avatar -->
                                            <div class="freelancer-avatar">
                                                <div class="verified-badge"></div>
                                                <a href="#"><img src="<?=$m['avtar']?>" alt=""></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5 col-md-5">
                                    <div class="freelancer-name">

                                        <h4><a href="#">
                                        <?=$m['f_name']?> <?=$m['l_name']?>
                                        </a></h4>
                                        <input type="hidden"  value="<?=$m['task_id']?>"/>
                                        <p>Project : <?=$m['t_name']?></p>
                                        
                                        <!-- Details -->
                                        <span class="freelancer-detail-item"> <?php echo date('g:i A');?> <?php   echo date("D");?></span>
                                        
                                    </div>
                                </div>
                                
                                <div class="col-lg-5 col-md-5">
                                
                                    <?php
                                        if($m['statu'] == 2)
                                        {
                                            ?>
                                                <a href=".<?=$m['task_id']?>1244" style="display:<?=$note?>" class="popup-with-zoom-anim button gray ripple-effect margin-top-5 margin-bottom-10">Review</a>
                                            <?php
                                        }
                                        else if($m['statu'] == 0)
                                        {
                                            ?>
                                                <a href=".<?=$m['task_id']?><?=$i?>" style="display:<?=$note?>" class="popup-with-zoom-anim button gray ripple-effect margin-top-5 margin-bottom-10">Mark Completed</a>
                                            <?php
                                        }
                                        else{
                                            ?>
                                            <p style="display:<?=$note?>">
                                                Already Reviewed
                                            </p>
                                            <?php
                                        }

                                        if($m['emp_status'] == NULL )
                                        { echo $m['emp_status'] ;
                                            ?>
                                                <a href=".<?=$m['task_id']?>8077122" style="display:<?=$review_emp?>" class="popup-with-zoom-anim button gray ripple-effect margin-top-5 margin-bottom-10">Review</a>
                                            <?php
                                        }

                                        switch($TYPE)
                                        {
                                            case 2:
                                                
                                                ?>
                                                    <a href=".<?=$m['task_id']?>8449" id="mark<?=$m['task_id']?>" style="display:<?=$complete?>" class="popup-with-zoom-anim button gray ripple-effect margin-top-5 margin-bottom-10">Mark Completed</a>
                                                <?php
                                                break;

                                            
                                            case 3:
                                                ?>
                                                    <a href=".<?=$m['task_id']?>8449" id="mark<?=$m['task_id']?>" style="display:<?=$complete?>" class="popup-with-zoom-anim button gray ripple-effect margin-top-5 margin-bottom-10">Mark Completed</a>
                                                <?php
                                                break;
                                        }
                                       
                                    ?>
                                                    <div id="small-dialog-1" class="zoom-anim-dialog mfp-hide dialog-with-tabs <?=$m['task_id']?>8449">

                                                        
                                                                <!--Tabs -->
                                                                <div class="sign-in-form">

                                                                    <ul class="popup-tabs-nav">
                                                                        <li><a href="#tab1">Mark Completed</a></li>
                                                                    </ul>

                                                                    <div class="popup-tabs-container">

                                                                        <!-- Tab -->
                                                                        <div class="popup-tab-content" id="tab">
                                                                            
                                                                            <!-- Welcome Text -->
                                                                            <div class="welcome-text">
                                                                                
                                                                               
                                                                                <form method="post">
                                                                                    <label>Completed Work Description</label>
                                                                                    <textarea class="form-control with-border" id="desc<?=$m['task_id']?>" name="desci" rows="2" placeholder="Work Description"></textarea>
                                                                                    <div class="uploadButton margin-top-30">
                                                                                        <input class="uploadButton-input" type="file" accept="image/*, application/pdf" id="upload" required multiple/>
                                                                                        <label class="uploadButton-button ripple-effect" for="upload">Upload Files</label>
                                                                                        <span class="uploadButton-file-name">Image or document that might be helpful in Justifying your work!</span>
                                                                                    </div>
                                                                                    <div id="file_image">
                                                                                    </div>
                                                                                </form>
                                                                                <!-- <div id="uploadDiv">
                                                                                </div> -->
                                                                                <div class="bid-acceptance margin-top-15">
                                                                                    <p id="bid_price">Once marked completed you wont be able to undo</p>

                                                                                    
                                                                                </div>
                                                                            </div>

                                                                            <form id="terms" method="post">
                                                                                <div class="radio">
                                                                                    <input id="termsncon" name="radio" type="radio" required>
                                                                                    <label for="termsncon"><span class="radio-label"></span>  I have read and agree to the Terms and Conditions</label>
                                                                                    <input type="hidden" id="main_id" name="main_id" value="<?=$m['main_id']?>">
                                                                                    
                                                                                </div>
                                                                                
                                                                            </form>

                                                                            <!-- Button -->
                                                                            <button name="completed" class="margin-top-15 button full-width button-sliding-icon ripple-effect" type="button" onclick="uploads(<?=$m['task_id']?>)" form="terms">Accept <i class="icon-material-outline-arrow-right-alt"></i></button>
                                                                            <br>
                                                                                <small class="d-flex justify-content-center">* Attachment is Required</small>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                        </div>
                                                        
                                                
                                    <!-- <button class="button gray ripple-effect">Mark Completed</button> -->

                                &nbsp;
                                                        <div id="small-dialog-4" class="zoom-anim-dialog mfp-hide dialog-with-tabs <?=$m['task_id']?><?=$i?>">

                                                        
                                                                <!--Tabs -->
                                                                <div class="sign-in-form">

                                                                    <ul class="popup-tabs-nav">
                                                                        <li><a href="#tab1">Mark Completed</a></li>
                                                                    </ul>

                                                                    <div class="popup-tabs-container">

                                                                        <!-- Tab -->
                                                                        <div class="popup-tab-content" id="tab">
                                                                            
                                                                            <!-- Welcome Text -->
                                                                            <div class="welcome-text">
                                                                            <?php
                                                                                if(isset($comp))
                                                                                {

                                                                            ?>
                                                                                <p>Work Description : <?=$comp['description']?></p>
                                                                                <a href="uploads/<?=$comp['img1']?>">
                                                                                    <img width="180px" height="150px" style="padding-right: 10px;padding-bottom-10px" src='uploads/<?=$comp['img1']?>'>
                                                                                </a>
                                                                            <?php
                                                                                }
                                                                            ?>
                                                                                <div class="bid-acceptance margin-top-15">
                                                                                    <p id="bid_price">Once marked completed you wont be able to undo</p>
                                                                                    
                                                                                </div>
                                                                            </div>

                                                                            <form id="terms" method="post">
                                                                                <div class="radio">
                                                                                    <input id="radio-1" name="radio" type="radio" required>
                                                                                    <label for="radio-1"><span class="radio-label"></span>  I have read and agree to the Terms and Conditions</label>
                                                                                    <input type="hidden" id="main_id" name="main_id" value="<?=$m['main_id']?>">
                                                                                    
                                                                                </div>
                                                                            </form>

                                                                            <!-- Button -->
                                                                            <button name="completed" class="margin-top-15 button full-width button-sliding-icon ripple-effect" type="submit" form="terms">Accept <i class="icon-material-outline-arrow-right-alt"></i></button>
                                                                        
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                        </div>
                                                        
                                                        <div id="small-dialog-2" class="zoom-anim-dialog mfp-hide dialog-with-tabs <?=$m['task_id']?>1244">

                                                            <!--Tabs -->
                                                            <div class="sign-in-form">

                                                                <ul class="popup-tabs-nav">
                                                                </ul>

                                                                <div class="popup-tabs-container">

                                                                    <!-- Tab -->
                                                                    <div class="popup-tab-content" id="tab2">
                                                                        
                                                                        <!-- Welcome Text -->
                                                                        <div class="welcome-text">
                                                                            <h3>Leave a Review</h3>
                                                                            <span>Rate <a href="#"><?=$m['f_name']?> <?=$m['l_name']?></a> for <?=$m['t_name']?> </span>
                                                                        </div>
                                                                            
                                                                        <!-- Form -->
                                                                        <form method="post" id="leave-review-form">
                                                                            <div class="feedback-yes-no">
                                                                                <strong>Was the job successful?</strong>
                                                                                <div class="radio">
                                                                                    <input id="radio-5" name="radio0" type="radio" value="1" required>
                                                                                    <label for="radio-5"><span class="radio-label"></span> Yes</label>
                                                                                </div>

                                                                                <div class="radio">
                                                                                    <input id="radio-6" name="radio0" type="radio" value="0" required>
                                                                                    <label for="radio-6"><span class="radio-label"></span> No</label>
                                                                                </div>
                                                                            </div>

                                                                            <div class="feedback-yes-no">
                                                                                <input type="hidden" name="cid" value="<?=$m['c_id']?>">
                                                                                <input type="hidden" name="tid" value="<?=$m['t_id']?>">
                                                                                <strong>Was this delivered on budget?</strong>
                                                                                <div class="radio">
                                                                                    <input id="radio-1" name="radio" type="radio" value="1" required>
                                                                                    <label for="radio-1"><span class="radio-label"></span> Yes</label>
                                                                                </div>

                                                                                <div class="radio">
                                                                                    <input id="radio-2" name="radio" type="radio" value="0" required>
                                                                                    <label for="radio-2"><span class="radio-label"></span> No</label>
                                                                                </div>
                                                                            </div>

                                                                            <div class="feedback-yes-no">
                                                                                <strong>Was this delivered on time?</strong>
                                                                                <div class="radio">
                                                                                    <input id="radio-3" name="radio2" type="radio" value="1" required>
                                                                                    <label for="radio-3"><span class="radio-label"></span> Yes</label>
                                                                                </div>

                                                                                <div class="radio">
                                                                                    <input id="radio-4" name="radio2" type="radio" value="0" required>
                                                                                    <label for="radio-4"><span class="radio-label"></span> No</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="feedback-yes-no">
                                                                                <strong>Will you recommend?</strong>
                                                                                <div class="radio">
                                                                                    <input id="radio-7" name="radio3" type="radio" value="1" required>
                                                                                    <label for="radio-7"><span class="radio-label"></span> Yes</label>
                                                                                </div>

                                                                                <div class="radio">
                                                                                    <input id="radio-8" name="radio3" type="radio" value="0" required>
                                                                                    <label for="radio-8"><span class="radio-label"></span> No</label>
                                                                                </div>
                                                                            </div>

                                                                            <div class="feedback-yes-no">
                                                                                <strong>Your Rating</strong>
                                                                                <div class="leave-rating">
                                                                                    <input type="radio" name="rating" id="rating-radio-5" value="5" required>
                                                                                    <label for="rating-radio-5" class="icon-material-outline-star"></label>
                                                                                    <input type="radio" name="rating" id="rating-radio-4" value="4" required>
                                                                                    <label for="rating-radio-4" class="icon-material-outline-star"></label>
                                                                                    <input type="radio" name="rating" id="rating-radio-3" value="3" required>
                                                                                    <label for="rating-radio-3" class="icon-material-outline-star"></label>
                                                                                    <input type="radio" name="rating" id="rating-radio-2" value="2" required>
                                                                                    <label for="rating-radio-2" class="icon-material-outline-star"></label>
                                                                                    <input type="radio" name="rating" id="rating-radio-1" value="1" required>
                                                                                    <label for="rating-radio-1" class="icon-material-outline-star"></label>
                                                                                    
                                                                                    
                                                                                </div><div class="clearfix"></div>
                                                                            </div>

                                                                            <textarea class="with-border" placeholder="Comment" name="message2" id="message2" cols="7" required></textarea>

                                                                        </form>
                                                                        
                                                                        <!-- Button -->
                                                                        <button class="button full-width button-sliding-icon ripple-effect" type="submit" form="leave-review-form" name="review_do">Leave a Review <i class="icon-material-outline-arrow-right-alt"></i></button>

                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div id="small-dialog-3" class="zoom-anim-dialog mfp-hide dialog-with-tabs <?=$m['task_id']?>8077122">
                                                            
                                                            <!--Tabs -->
                                                            <div class="sign-in-form">

                                                                <ul class="popup-tabs-nav">
                                                                </ul>

                                                                <div class="popup-tabs-container">

                                                                    <!-- Tab -->
                                                                    <div class="popup-tab-content" id="tab2">
                                                                        
                                                                        <!-- Welcome Text -->
                                                                        <div class="welcome-text">
                                                                            <h3>Leave a Review</h3>
                                                                            <span>Rate <a href="single-company-profile?token=<?=$m['user']?>"><?=$m['f_name']?> <?=$m['l_name']?></a> For <?=$m['t_name']?> </span>
                                                                        </div>
                                                                            
                                                                        <!-- Form -->
                                                                        <form method="post" id="leave-review-form">
                                                                            
                                                                            <div class="feedback-yes-no">
                                                                                <input type="hidden" name="employer" value="<?=$m['user']?>">
                                                                                <input type="hidden" name="task_id" value="<?=$m['task_id']?>">
                                                                                <input type="hidden" name="employerkiid" value="<?=$m['main_id']?>">
                                                                                  <strong>Clarity in Specifications : (out of 5)</strong>
                                                                                <div class="radio">
                                                                                    <input id="radio-1" name="speci" type="radio" value="5" required>
                                                                                    <label for="radio-1"><span class="radio-label"></span> 5</label>
                                                                                </div>

                                                                                <div class="radio">
                                                                                    <input id="radio-2" name="speci" type="radio" value="4" required>
                                                                                    <label for="radio-2"><span class="radio-label"></span>4</label>
                                                                                </div>

                                                                                <div class="radio">
                                                                                    <input id="radio-3" name="speci" type="radio" value="3" required>
                                                                                    <label for="radio-3"><span class="radio-label"></span>3</label>
                                                                                </div>

                                                                                <div class="radio">
                                                                                    <input id="radio-4" name="speci" type="radio" value="2" required>
                                                                                    <label for="radio-4"><span class="radio-label"></span>2</label>
                                                                                </div>
                                                                                <div class="radio">
                                                                                    <input id="radio-5" name="speci" type="radio" value="1" required>
                                                                                    <label for="radio-5"><span class="radio-label"></span>1</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="feedback-yes-no">
                                                                                <strong>Communication : (out of 5)</strong>
                                                                                <div class="radio">
                                                                                    <input id="radio-6" name="comm" type="radio" value="5" required>
                                                                                    <label for="radio-6"><span class="radio-label"></span> 5</label>
                                                                                </div>

                                                                                <div class="radio">
                                                                                    <input id="radio-7" name="comm" type="radio" value="4" required>
                                                                                    <label for="radio-7"><span class="radio-label"></span>4</label>
                                                                                </div>

                                                                                <div class="radio">
                                                                                    <input id="radio-8" name="comm" type="radio" value="3" required>
                                                                                    <label for="radio-8"><span class="radio-label"></span>3</label>
                                                                                </div>

                                                                                <div class="radio">
                                                                                    <input id="radio-9" name="comm" type="radio" value="2" required>
                                                                                    <label for="radio-9"><span class="radio-label"></span>2</label>
                                                                                </div>
                                                                                <div class="radio">
                                                                                    <input id="radio-10" name="comm" type="radio" value="1" required>
                                                                                    <label for="radio-10"><span class="radio-label"></span>1</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="feedback-yes-no">
                                                                                <strong>Payment Promptness : (out of 5)</strong>
                                                                                <div class="radio">
                                                                                    <input id="radio-11" name="payment" type="radio" value="5" required>
                                                                                    <label for="radio-11"><span class="radio-label"></span> 5</label>
                                                                                </div>

                                                                                <div class="radio">
                                                                                    <input id="radio-12" name="payment" type="radio" value="4" required>
                                                                                    <label for="radio-12"><span class="radio-label"></span>4</label>
                                                                                </div>

                                                                                <div class="radio">
                                                                                    <input id="radio-13" name="payment" type="radio" value="3" required>
                                                                                    <label for="radio-13"><span class="radio-label"></span>3</label>
                                                                                </div>

                                                                                <div class="radio">
                                                                                    <input id="radio-14" name="payment" type="radio" value="2" required>
                                                                                    <label for="radio-14"><span class="radio-label"></span>2</label>
                                                                                </div>
                                                                                <div class="radio">
                                                                                    <input id="radio-15" name="payment" type="radio" value="1" required>
                                                                                    <label for="radio-15"><span class="radio-label"></span>1</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="feedback-yes-no">
                                                                                <strong>Professionalism : (out of 5)</strong>
                                                                                <div class="radio">
                                                                                    <input id="radio-16" name="profess" type="radio" value="5" required>
                                                                                    <label for="radio-16"><span class="radio-label"></span> 5</label>
                                                                                </div>

                                                                                <div class="radio">
                                                                                    <input id="radio-17" name="profess" type="radio" value="4" required>
                                                                                    <label for="radio-17"><span class="radio-label"></span>4</label>
                                                                                </div>

                                                                                <div class="radio">
                                                                                    <input id="radio-18" name="profess" type="radio" value="3" required>
                                                                                    <label for="radio-18"><span class="radio-label"></span>3</label>
                                                                                </div>

                                                                                <div class="radio">
                                                                                    <input id="radio-19" name="profess" type="radio" value="2" required>
                                                                                    <label for="radio-19"><span class="radio-label"></span>2</label>
                                                                                </div>
                                                                                <div class="radio">
                                                                                    <input id="radio-20" name="profess" type="radio" value="1" required>
                                                                                    <label for="radio-20"><span class="radio-label"></span>1</label>
                                                                                </div>
                                                                            </div>
                                                                            

                                                                            <div class="feedback-yes-no">
                                                                                <strong>Your Rating</strong>
                                                                                <div class="leave-rating">
                                                                                    <input type="radio" name="ratings" id="rating-radio-5" value="5" required>
                                                                                    <label for="rating-radio-5" class="icon-material-outline-star"></label>
                                                                                    <input type="radio" name="ratings" id="rating-radio-4" value="4" required>
                                                                                    <label for="rating-radio-4" class="icon-material-outline-star"></label>
                                                                                    <input type="radio" name="ratings" id="rating-radio-3" value="3" required>
                                                                                    <label for="rating-radio-3" class="icon-material-outline-star"></label>
                                                                                    <input type="radio" name="ratings" id="rating-radio-2" value="2" required>
                                                                                    <label for="rating-radio-2" class="icon-material-outline-star"></label>
                                                                                    <input type="radio" name="ratings" id="rating-radio-1" value="1" required>
                                                                                    <label for="rating-radio-1" class="icon-material-outline-star"></label>
                                                                                    
                                                                                    
                                                                                </div><div class="clearfix"></div>
                                                                            </div>

                                                                            <textarea class="with-border" placeholder="Comment/Review" name="reviews" id="message2" cols="7" required></textarea>

                                                                        </form>
                                                                        
                                                                        <!-- Button -->
                                                                        <button class="button full-width button-sliding-icon ripple-effect" type="submit" form="leave-review-form" name="employer_review">Leave a Review <i class="icon-material-outline-arrow-right-alt"></i></button>

                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>

                                </div>
                                
                                </div>
                            </div>
                        </div>
			        </div>
                    <?php
                                $i++;
                                }
                            }
                            else
                            {
                                ?>
                                    <div class="alert alert-primary">
                                        No Milestone are in queue at this moment!!!!!
                                    </div>
                                <?php
                            }
                    ?>
							
						</div>
					</div>

					<!-- Pagination -->
					<div class="clearfix"></div>
					
					<div class="clearfix"></div>
					<!-- Pagination / End -->

				</div>

				<!-- Dashboard Box -->
			


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






<?php
require_once 'js-links.php';
?>
<script>
    function remove(id)
    {
        $("#"+id).remove();
    }

	$("#dashboard").removeClass('active');
	$("#bookmarks").removeClass('active');
	$("#reviews").removeClass('active');
	$("#jobs").removeClass('active');
	$("#tasks").removeClass('active');
	$("#settings").removeClass('active');
	$("#milestone").removeClass('active');
	$("#milestone").addClass('active');

    var counter=0;
    var globalEventVar = 'aforapple';
    $(function(){
        $('.uploadButton-input').change(function(e)
        {
            globalEventVar = e;
           
        })
    })

    function uploads(id)
    {

        if(document.getElementById("termsncon").checked == true)
        {
            var a = globalEventVar;
            // var image = 'none';
            var des = $("#desc"+id).val();
            console.log(des);
            if(a != 'aforapple' && des != '')
            {
                var formData = new FormData();
                formData.append('images',a.target.files[0]);
                formData.append('updateFile','true');
                formData.append('des',des);
                formData.append('id',id);
                formData.append('user',<?=$USER_ID?>);
                var modal = id+8449;
                $.ajax({

                    url:'mil_ajax.php',
                    type:'post',
                    processData:false,
                    contentType: false,
                    data:formData, 
                    success:function(data){
                        var obj = JSON.parse(data);
                        if(obj.msg.trim()!='err'){
                        var inhtml = `
                                        <div id="fileId${counter}">
                                            <input name="inputed_files[]" type="hidden" value="${obj.msg}"/>
                                            <img width="180px" height="150px" style="padding-right: 10px;padding-bottom-10px;" src='uploads/${obj.msg}'>
                                            <button type="button" class="btn btn-danger" onclick="deleteFile('fileId${counter}','${obj.msg}')"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                        </div>`;
                                    // $('#uploadDiv').append(inhtml); 
                                    counter++;
                                    $("#mark"+id).hide();
                                    var image = obj.msg;
                                    $('#small-dialog-1').hide();
                        }
                        else if(obj.msg.trim()=='desc')
                        {
                            alert("Please Enter description!");
                        }
                    },
                    error:function(data){
                        
                    }
                })
            }
            else 
            {
                alert("Please Fill all the detials!");
            }
        }
        else
        {
            alert("Please Agree to the terms and conditons!")
        }
        
    }

    function deleteFile(id,filename) {
        $.ajax({
                url:'mil_ajax.php',
                type:'post',
                data:{
                    deleteFile:true,
                    filename:filename
                }, 
                success:function(data){
                    var obj = JSON.parse(data);
                        if(obj.msg.trim()=="deleted")
                        {
                            $('#'+id).remove();
                            $("#upload").val('');
                        }
                    }     
                ,
                error:function(data){}
            })

    }
</script>