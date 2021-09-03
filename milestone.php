<?php
    require_once 'header.php';
    require_once 'navbar.php';

    if(isset($_GET['token']) and !empty($_GET['token']))
    {

        $token = $_GET['token'];

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
            $c_id = $_POST['employersid'];
            $t_id = $token;
            $comm = $_POST['comm'];
            $speci = $_POST['speci'];
            $payment =$_POST['payment'];
            $profess = $_POST['profess'];
            $revie = $_POST['reviews'];
            $id=$_POST['acceptID'];
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


        $sql = "select id,c_id,review,emp_status from accepted_task where t_id = '$token'";
        if($result = $conn->query($sql))
        {
            $c_id = $result->fetch_assoc();
        }
        if(isset($_POST['editkare']))
        {
            $id=$_POST['mil_id'];
            $title =$_POST['title'];
            $desc =$_POST['desc'];
            $due =$_POST['due'];
            $price = $_POST['price'];
            $sql="UPDATE milestones set mil_title='$title',mil_desc='$desc',due_date='$due',price='$price' WHERE id='$id'";
            if($conn->query($sql))
            {
                $done="Milestone updated successfully";
            }
            else{
                echo $conn->error;
            }

        }
        
        if(isset($_POST['createkare']))
        {
            $task = $token; 
            $cus = $USER_ID;
            $emp = $c_id['c_id'];
            $title =$_POST['mil_title'];
            $desc =$_POST['mil_desc'];
            $due =$_POST['due_date'];
            $price = $_POST['mil_price'];
            $sql="insert into milestones(task_id,cus_id,emp_id,mil_title,mil_desc,due_date,price) values($task,$cus,$emp,'$title','$desc','$due','$price')";
            if($conn->query($sql))
            {
                $done="Milestone added successfully";
            }
            else{
                echo $conn->error;
            }

        }

        if(isset($_POST['escrow']))
        {
            $milestoneKiId = $_POST['escrow'];
            $sql = "UPDATE milestones set pay_status = 2 where id = '$milestoneKiId'";
            if($conn->query($sql))
            {
                $done = "Milestone added in Escrow";
            }
            else
            {
                echo $conn->error;
            }
        }
        
        $abled = '';
        $disabled = '';
        $dontshow = '';
        $hide='none';
        switch($TYPE)
        {
            case 3:
                $sqlUserData = "SELECT up.u_id as opp_id , up.f_name,up.l_name,up.avtar,up.nationality from user_profile up , post_task pt where  pt.e_id = up.u_id and pt.id = '$token' ";
                $sql = "SELECT mt.*,up.f_name,up.l_name,up.avtar from milestones mt,user_profile up where mt.emp_id=$USER_ID and mt.cus_id=up.u_id and mt.task_id = '$token'";
                $abled = 'disabled';
                $disabled = 'disabled';
                $dontshow = 'none';
                $hide='show';
                break;


            case 5:
                $sqlUserData = "SELECT up.u_id as opp_id , up.f_name,up.l_name,up.avtar,up.nationality from user_profile up , accepted_task ated where  ated.c_id = up.u_id and ated.t_id = '$token'";
                // $sql = "SELECT mt.* from milestones mt where mt.emp_id=$USER_ID and  mt.task_id='$token'";
                $sql = "SELECT mt.*,up.f_name,up.l_name,up.avtar from milestones mt,user_profile up where mt.cus_id=$USER_ID and mt.emp_id=up.u_id and mt.task_id = '$token'";


                break;

            case 2:
                $sqlUserData = "SELECT up.u_id as opp_id , up.f_name,up.l_name,up.avtar,up.nationality from user_profile up , post_task pt where  pt.e_id = up.u_id and pt.id = '$token' ";
                $sql = "SELECT mt.*,up.f_name,up.l_name,up.avtar from milestones mt,user_profile up where mt.emp_id=$USER_ID and mt.cus_id=up.u_id and mt.task_id = '$token'";
                $abled = 'disabled';
                $disabled = 'disabled';
                $dontshow = 'none';
                $hide='show';
                break;

        }
        // echo $sql;
        $budget = 0;
        $escrow = 0;
        $paid = 0;
        $remaining = 0;
        $total = 0;
        if ($result = $conn->query($sql)) {
            // echo "happy";
            if ($result->num_rows) {
                // echo "ccvjkasdvckasd";
                while ($row = $result->fetch_assoc()) {
                    $miles[] = $row;
                    $budget = $budget + $row['price'] ;
                    if($row['pay_status'] == 1)
                    {
                        $paid = $paid+$row['price'];
                    }
                    if($row['pay_status'] == 2)
                    {
                        $escrow = $escrow + $row['price'] ;
                    }

                
                }
            }
            $total = $paid + $escrow;
            $remaining = $budget - $paid;
        }
        else
        {
            echo $conn->error;
        }

        $abc = "SELECT mt.* from milestones mt where mt.emp_id=$USER_ID and  mt.task_id='$token' limit 1";
        if ($result = $conn->query($abc)) {
            // echo "happy";
            if ($result->num_rows) {
                // echo "ccvjkasdvckasd";
               
                    $ids = $result->fetch_assoc();
                
               
            }

        }
        else
        {
            echo $conn->error;
        }

        $sql="select * from uploaded_documents where t_id='$token'";
        if ($result = $conn->query($sql)) {
            if ($result->num_rows) {
                while($row = $result->fetch_assoc())
                {
                    $attachments[] = $row;
                }
            }
        }
        
        $query = "select * from post_task where id='$token'";
        if ($result = $conn->query($query))
        {
            
            if ($result->num_rows)
            {
                    $task =  $result->fetch_assoc();
                    // print_r($details);
            }

        }
        else
        {
            echo $conn->error;
        }
        if ($result = $conn->query($sqlUserData))
        {
            
            if ($result->num_rows)
            {
                    $details[] =  $result->fetch_assoc();
                    // print_r($details);
            }

        }
        else
        {
            echo $conn->error;
        }    
        $sql = "select * from milestone where task_id='$token' order by id asc limit 1";
        if ($result = $conn->query($sqlUserData))
        {
            
            if ($result->num_rows)
            {
                    $start[] =  $result->fetch_assoc();
                    // print_r($details);
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
    }
    // print_r($miles);
    

    
?>


<div id="wrapper">

<style>
@media screen and (max-width: 600px) {
    .paynowbutton{width:50%}

}
</style>

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
				<h3><i class="bi bi-flag"></i> Milestone For <?=$task['t_name']?></h3>

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
				<div class="col-xl-12">

                <?php
                
                    
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
                                                <a href="#"><img src="<?=$details[0]['avtar']?>" alt=""></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5 col-md-5">
                                    <div class="freelancer-name">

                                        <h4><a href="#">
                                            <?=$details[0]['f_name']?>  <?=$details[0]['l_name']?></a>&nbsp;
                                            <?php
                                                $nationality = $details[0]['nationality'];
                                                $country_code = strtolower($nationality);
                                            ?>
                                                <img class="flag" src="http://api.hostip.info/images/flags/<?=$country_code?>.gif" alt="" title="<?=$biddingDetail['nationality']?>" data-tippy-placement="top"/>                                     </h4>
                                        
                                        <!-- Details -->
                                        <span class="freelancer-detail-item"><?php  echo date("M d");?></span>
                                        

                                        
                                    </div>
                                </div>
                                <div class="col-lg-5 col-md-5">
                                
                                <!-- <button class="button gray ripple-effect-dark" style="display:<?=$dontshow?>"> Bonus</button> -->
                                &nbsp;
                                <!-- <button class="button gray ripple-effect-dark" type="submit" >Cancel Contract</button> -->
                                </div>
                            </div>
                        </div>

						<div class="content">
                        <div class="tabs">
                            <div class="tabs-header" >
                                <ul>
                                    <li class="active"><a href="#tab-1" data-tab-id="1" class="ahref">Milestone & Payments</a></li>
                                    <!-- <li class=""><a href="#tab-2" data-tab-id="2" class="ahref">Messages & Files</a></li> -->
                                    <li class=""><a href="#tab-3" data-tab-id="3" class="ahref">Terms & Settings</a></li>
                                    <li class=""><a href="#tab-4" data-tab-id="4" class="ahref">Feedback</a></li>
                                </ul>
                                <div class="tab-hover"></div>
                                <nav class="tabs-nav">
                                    <span class="tab-prev"><i class="icon-material-outline-keyboard-arrow-left"></i></span>
                                    <span class="tab-next"><i class="icon-material-outline-keyboard-arrow-right"></i></span>
                                </nav>
                            </div>
                            <!-- Tab Content -->
                            <div class="tabs-content">
                                <div class="tab active " data-tab-id="1">
                                    
                                    <div class="row">
                                        <div class="col-lg-2 col-md-2" style="padding-left:10px;padding-right:10px;margin-top:10px">
                                            <h6>Budget</h6>
                                            
                                            <p id="budget">$ <?=$budget?></p>
                                        </div>
                                        <div class="col-lg-2 col-md-2" style="padding-left:10px;padding-right:20px;margin-top:10px">
                                            <h6>In Escrow</h6>
                                            
                                            <p id="escrow">$ <?=$escrow?></p>
                                        </div>
                                        <div class="col-lg-3 col-md-3" style="padding-left:10px;padding-right:20px;margin-top:10px">
                                            <h6>Milestones Paid</h6>
                                            
                                            <p id="paid">$ <?=$paid?></p>
                                        </div>
                                        <div class="col-lg-2 col-md-2" style="padding-left:10px;padding-right:50px;margin-top:10px">
                                            <h6>Remaining</h6>
                                            
                                            <p id="remaining">$ <?=$remaining?></p>
                                        </div>
                                        <div class="col-lg-3 col-md-3" style="padding-left:10px;padding-right:10px;margin-top:10px">
                                            <h6>Total Payments <i href="#" class="bi bi-patch-question-fill" style="color:blue;"></i></h6>
                                            
                                            <p id="total">$ <?=$total?></p>
                                        </div>
                                    </div>
                                
                                    <div class="row" style="margin-top:40px">
                                        <div class="col-lg-9 col-md-9">
                                            <h3>Remaining Milestone</h3>
                                        </div>
                                        <div class="col-lg-3 col-md-3">
                                            <a href="#small-dialog"   class="popup-with-zoom-anim button ripple-effect button gray ripple-effect-dark" style="display:<?=$dontshow?>">Add Milestones</a>
                                        </div>
                                    </div>

                                    <?php
                                         if(isset($miles))
                                         {
                                            /*print_r($miles);*/
                                             
                                             $i=1;
                                             $bud=0;
                                             foreach($miles as $mi)
                                             {
                                                $unactive = 'none';
                                                $active='none';

                                                $abc = $mi['complete'];
                                                switch($TYPE)
                                                {
                                                    case 5:
                                                        $sql = "select * from completed where id='$abc'";
                                                        break;
                                                }
                                                if($result=$conn->query($sql))
                                                {
                                                    if($result->num_rows>0)
                                                    {
                                                        $comp = $result->fetch_assoc();
                                                        $complete = 'none';
                                                        $review_emp = 'show';

                                                    }
                                                    // print_r($comp);
                                                    // echo $USER_ID;
                                                }
                                                else{
                                                    echo $conn->error;
                                                }
                                                // switch($mi['pay_status'])
                                                // {
                                                //     case 0:
                                                //         $unactive= 'show';
                                                //         $active = 'show';
                                                //         break;
                                                    
                                                //     case 1:
                                                //        $unactive= 'none';
                                                //         $active = 'none';
                                                //         break;

                                                // }
                                                 switch($mi['mil_status'])
                                                 {
                                                     case 0:
                                                         $unactive= 'show';
                                                         $active='none';
                                                         break;
                                                     
                                                     case 1:
                                                         $active = 'show';
                                                         $unactive = 'none';
                                                         break;

                                                    case 2:
                                                        $active = 'none';
                                                        $unactive = 'none';
                                                        break;
                 
                                                     
                                                 }
                                                


                                                 $disp='';
                                                 $display='';
                                                 $showEscrow = "none";
                                                 $pay = '(unpaid)';
                                                 if($mi['pay_status'] == 1 || $TYPE == 3)
                                                 {
                                                     $display='none';
                                                 }
                                                 if($mi['pay_status'] == 1)
                                                 {
                                                    $pay = '(paid)';
                                                    $hide='none';
                                                 }
                                                 if($mi['pay_status'] == 2)
                                                 {
                                                    $pay = '(in Escrow)';
                                                 }
                                                 if($mi['pay_status'] != 2)
                                                 {
                                                     $showEscrow = "initial";
                                                 }
                                                 
                                                $bud = $bud + $mi['price'];
                                                $budget = $bud;
                                               
                                    
                                    ?>
                                    <div class="row" style="margin-top:40px" onload="show(<?=$mi['pay_status']?>,<?=$i?>,<?=$mi['id']?>)">
                                        
                                        <div class="col-lg-8 col-md-8" style="padding-left:30px">
                                            
                                            <p><?=$i?> &nbsp;<b><?=$mi['mil_title']?></b> &nbsp;
                                                 &emsp;&emsp;
                                                
                                                <button class="btn btn-outline-danger aforapple" id="80777<?=$i?>" onclick="activity(80777<?=$i?>,1222<?=$i?>,<?=$mi['id']?>)"
                                                 style="display:<?=$unactive?>" <?=$abled?>>Unactive</button>
                                                
                                                <button class="btn btn-outline-primary aforapple" id="1222<?=$i?>" onclick="activity(1222<?=$i?>,80777<?=$i?>,<?=$mi['id']?>)"
                                                 style="display:<?=$active?>" <?=$disabled?>>Active</button>
                                                 
                                                 <input type="hidden" value="<?=$mi['mil_status']?>" id="mil_status<?=$mi['id']?>" /> 
                                            </p>
                                            <p style="margin-left:15px"><?=$mi['mil_desc']?></p>
                                            <div class="row" style="padding-bottom:20px;">
                                                <div class="col-lg-5 col-md-5">
                                                    
                                                    <input type="hidden" value="<?=$mi['pay_status']?>" id="pay_status<?=$mi['id']?>" /> 
                                                    <p>&emsp;$<?=$mi['price'] ?>  <?=$pay?></p>
                                                </div>
                                                <div class="col-lg-7 col-md-7">
                                                    <p>&emsp;Due <?php  echo date_format(date_create($mi['due_date']),"M d");?></p>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-8">
                                                        <?php
                                                            if($mi['complete'] != 0 && $TYPE == 5)
                                                            {
                                                                ?>
                                                                    <a href=".<?=$mi['id']?><?=$i?>" id="mark<?=$i?>" style="display:" class="popup-with-zoom-anim button gray ripple-effect margin-top-5 margin-bottom-10">View Work</a>
                                                                <?php
                                                            }
                                                        ?>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            
                                        </div>
                                        
                                        <div class="col-lg-3 col-md-3">
                                                <input type="hidden" name="pay_stat" value="<?=$mi['pay_status']?>" />
                                            <div class="row">
                                                <div class="col-lg-7 paynowbutton">
                                                <?php
                                                    if($mi['pay_status'] == 1 && $TYPE == 5)
                                                    {
                                                        ?>
                                                            Already paid
                                                        <?php
                                                    }
                                                    else if($TYPE == 5)
                                                    {
                                                        ?>
                                                        <!-- paymentdialog -->
                                                    
                                                            <a href=".paymentdialog" id="payment<?=$mi['id']?>" onclick="setmilestonevalues('<?=$mi['id']?>','<?= $mi['emp_id']?>', '<?= $mi['cus_id'] ?>', '<?= $mi['mil_title'] ?>', '<?= $mi['price']?>', '<?= $mi['task_id'] ?>')"  class="popup-with-zoom-anim button ripple-effect margin-top-5 margin-bottom-10">Pay Now</a>
                                                        <?php
                                                    }
                                                ?>
                                                </div>
                                                
                                                <?php
                                                    if($mi['complete'] == 0 && $TYPE != 5)
                                                    {
                                                        ?>
                                                            <a href=".<?=$i?>8449" id="mark<?=$i?>" style="display:" class="popup-with-zoom-anim button gray ripple-effect margin-top-5 margin-bottom-10">Mark Completed</a>
                                                        <?php
                                                    }
                                                ?>
                                                <div class="col-lg-5 paynowbutton" style="margin-top:3px">
                                                <a href="#small-dialog-2"  style="display:<?=$display?>"  onclick="edit(<?=$mi['id']?>,'<?=$mi['mil_title']?>','<?=$mi['mil_desc']?>','<?=$mi['due_date']?>',<?=$mi['price']?>)" class="popup-with-zoom-anim button ripple-effect button gray ripple-effect-dark" disabled>Edit</a>
                                                    
                                                </div>
                                            </div>
                                            <form method="post">
                                                <button class="button ripple-effect button gray ripple-effect-dark"  type="submit" name="escrow" value="<?=$mi['id']?>" title="Mark in Escrow"
                                                    data-tippy-placement="left" style="display:<?=$showEscrow?>">
                                                    <i class="icon-feather-check-square"></i> Escrow
                                                </button>
                                            </form>
                                        </div>
                                       
                                    </div>
                                                        <div id="small-dialog-1" class="zoom-anim-dialog mfp-hide dialog-with-tabs <?=$i?>8449">

                                                        
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
                                                                                    <textarea class="form-control with-border" id="desc<?=$i?>" name="desci" rows="2" placeholder="Work Description"></textarea>
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
                                                                                    <input type="hidden" id="main_id<?=$i?>" name="main_id<?=$i?>" value="<?=$mi['id']?>">
                                                                                    
                                                                                </div>
                                                                                
                                                                            </form>

                                                                            <!-- Button -->
                                                                            <button name="completed" class="margin-top-15 button full-width button-sliding-icon ripple-effect" type="button" onclick="uploads(<?=$i?>)" form="terms">Accept <i class="icon-material-outline-arrow-right-alt"></i></button>
                                                                            <br>
                                                                                <small class="d-flex justify-content-center">* Attachment is Required</small>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                        </div>
                                                        <div id="small-dialog-1" class="zoom-anim-dialog mfp-hide dialog-with-tabs <?=$mi['id']?><?=$i?>">

                                                        
                                                                <!--Tabs -->
                                                                <div class="sign-in-form">

                                                                    <ul class="popup-tabs-nav">
                                                                        <li><a href="#tab1">View Work</a></li>
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
                                                                                <p><?=$comp['description']?></p>
                                                                                <?php
                                                                                $ext=pathinfo($comp['img1'],PATHINFO_EXTENSION);
                                                                                                                                                              
                                                                                if(strtolower($ext)=="pdf")
                                                                                {
                                                                                    
                                                                                ?>
                                                                                   
                                                                                        <a href="uploads/<?=$comp['img1']?>" style="width:100px;height:100px" target="_blank"><img src="images/PDF.svg" width="100px" height="100px"/></a>            
                                                                                   
                                                                                <?php
                                                                                }
                                                                                else
                                                                                {
                                                                                ?>
                                                                                    <a href="uploads/<?=$comp['img1']?>">
                                                                                        <img width="180px" height="150px" style="padding-right: 10px;padding-bottom-10px" src='uploads/<?=$comp['img1']?>'>
                                                                                    </a>
                                                                                <?php
                                                                                }
                                                                                ?>
                                                                               
                                                                                <?php
                                                                                    if($comp['img2'] != 0)
                                                                                    {
                                                                                        $ext2=pathinfo($comp['img2'],PATHINFO_EXTENSION);  
                                                                                        if(strtolower($ext2)=="pdf")
                                                                                        {
                                                                                            ?>                
                                                                                                <br><br>
                                                                                                <a href="uploads/<?=$comp['img2']?>" style="width:100px;height:100px" target="_blank"><img src="images/PDF.svg" width="100px" height="100px"/></a>            
                                                                                            <?php
                                                                                        }
                                                                                        else
                                                                                        {
                                                                                            ?>
                                                                                            <br><br>
                                                                                            <a href="uploads/<?=$comp['img2']?>">
                                                                                                <img width="180px" height="150px" style="padding-right: 10px;padding-bottom-10px" src='uploads/<?=$comp['img2']?>'>
                                                                                            </a>
                                                                                        <?php
                                                                                        }
                                                                                       
                                                                                    }
                                                                                ?>
                                                                                
                                                                            <?php
                                                                                }
                                                                            ?>
                                                                                <!-- <div class="bid-acceptance margin-top-15">
                                                                                    <p id="bid_price">Once marked completed you wont be able to undo</p>
                                                                                    
                                                                                </div> -->
                                                                            </div>

                                                                            <!-- <form id="terms" method="post">
                                                                                <div class="radio">
                                                                                    <input id="radio-1" name="radio" type="radio" required>
                                                                                    <label for="radio-1"><span class="radio-label"></span>  I have read and agree to the Terms and Conditions</label>
                                                                                    <input type="hidden" id="main_id" name="main_id" value="<?=$m['main_id']?>">
                                                                                    
                                                                                </div>
                                                                            </form>

                                                                            <button name="completed" class="margin-top-15 button full-width button-sliding-icon ripple-effect" type="submit" form="terms">Accept <i class="icon-material-outline-arrow-right-alt"></i></button> -->
                                                                        
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                        </div>
                                                        
                                    <?php
                                            $i++;
                                            }
                                        }
                                    ?>
                                    <div id="small-dialog-2" class="zoom-anim-dialog mfp-hide dialog-with-tabs ">

                                        <!--Tabs -->
                                        <div class="sign-in-form">



                                            <div class="popup-tabs-container">

                                                <!-- Tab -->
                                                <div class="popup-tab-content" id="tab2">
                                                    
                                                    <!-- Welcome Text -->
                                                    <div class="welcome-text">
                                                        <h3>  Edit Milestone </h3>
                                                        
                                                    </div>
                                                        
                                                    <!-- Form -->
                                                    <form method="post" id="leave-review-form">
                                                        <input type="hidden" name="mil_id" id="mil_id" value=""/>                                                                        
                                                                                                                                

                                                        <div class="feedback-yes-no">
                                                            <strong>Milestone Title</strong>
                                                    
                                                            <input  name="title" id="title" class="with-border" value="" placeholder="Title"  type="text" required>
                                                        </div>

                                                        
                                                        <div class="feedback-yes-no">
                                                            <strong>Milestone Description</strong>
                                                    
                                                            <textarea class="with-border" id="desc" placeholder="Description"  name="desc" id="message2" cols="1"  required></textarea>
                                                        </div>
                                                        

                                                        <div class="feedback-yes-no">
                                                            <strong>Due Date</strong>
                                                                        
                                                            <input id="due"  class="with-border"  value="" name="due" type="date" required>
                                                        </div>
                                                        <div class="feedback-yes-no">
                                                            <strong>Price</strong>
                                                            <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">$</span>
                                                            </div>
                                                            <input type="text" id="price" class="form-control with-border" value="" name="price" aria-label="Amount (to the nearest dollar)">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">.00</span>
                                                            </div>
                                                            </div>
                                                        </div>


                                                    </form>

                                                    
                                                    <!-- Button -->
                                                    <button class="button button-sliding-icon ripple-effect" type="submit" name="editkare" form="leave-review-form">Edit <i class="icon-material-outline-arrow-right-alt"></i></button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-top:40px;">
                                        <div class="col-lg-12 col-md-12">
                                            <p><i class="bi bi-lightbulb-fill"></i> Do hardwork and complete all the milestones on time for full payment!</p> 
                                        </div>
                                    </div>
                        
                                </div>
                                
                                
                                <div class="tab " data-tab-id="2">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4">
                                            <div class="sidebar-widget">
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
                                                               
                                                                    <div class="col-md-4">
                                                                        <!-- <a href="uploads/<?=$file['document']?>"  target="_blank"><img src="images/PDF.svg" width="100px" height="100px"/></a>             -->
                                                                        <a href="uploads/<?=$file['document']?>" target="_blank" class="attachment-box ripple-effect"><span>Attachment</span><i>PDF</i></a>
                                                                    </div>
                                                               
                                                                <?php
                                                                }
                                                                else
                                                                {
                                                                ?>
                                                               
                                                                    <div class="col-md-4">
                                                                        <a href="uploads/<?=$file['document']?>" target="_blank"><img src="uploads/<?=$file['document']?>" width="100px" height="100px"/></a>
                                                                    </div>
                                                                
                                                                <?php
                                                                }
                                                            }
                                                        }
                                                    ?>

                                                   
                                                    <!-- <a href="#" class="attachment-box ripple-effect"><span>Contract</span><i>DOCX</i></a> -->
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-lg-8 col-md-8">
                                            <div class="message-content">

                                                <div class="messages-headline">
                                                    <h4>Vansh Patpatia</h4>
                                                    <a href="#" class="message-action"><i class="icon-feather-trash-2"></i> Delete Conversation</a>
                                                </div>

                                                <!-- Message Content Inner -->
                                                    <div class="message-content-inner">
                                                        
                                                        <!-- Time Sign -->
                                                        <div class="message-time-sign">
                                                            <span>Yesterday</span>
                                                        </div>

                                                        <div class="message-bubble me">
                                                            <div class="message-bubble-inner">
                                                                <div class="message-avatar"><img src="uploads/1615971240_bajrangbali.jpg" alt="" /></div>
                                                                <div class="message-text"><p>Hi Vansh, I just wanted to let you know that project is finished and I'm waiting for your approval.</p></div>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                        </div>

                                                        <div class="message-bubble">
                                                            <div class="message-bubble-inner">
                                                                <div class="message-avatar"><img src="uploads/111.jpeg" alt="" /></div>
                                                                <div class="message-text"><p>Hi Pancham! Hate to break it to you, but I'm actually on vacation 🌴 until Sunday so I can't check it now. 😎</p></div>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                        </div>

                                                        <div class="message-bubble me">
                                                            <div class="message-bubble-inner">
                                                                <div class="message-avatar"><img src="uploads/1615971240_bajrangbali.jpg" alt="" /></div>
                                                                <div class="message-text"><p>Ok, no problem. But don't forget about last payment. 🙂</p></div>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                        </div>

                                                    
                                                </div>
                                                <!-- Message Content Inner / End -->

                                                <!-- Reply Area -->
                                                <div class="message-reply">
                                                    
                                                    <textarea cols="1" rows="1" placeholder="Your Message" data-autoresize></textarea>
                                                    <a href="#" style="margin-top:10px;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-paperclip" viewBox="0 0 16 16">
                                                        <path d="M4.5 3a2.5 2.5 0 0 1 5 0v9a1.5 1.5 0 0 1-3 0V5a.5.5 0 0 1 1 0v7a.5.5 0 0 0 1 0V3a1.5 1.5 0 1 0-3 0v9a2.5 2.5 0 0 0 5 0V5a.5.5 0 0 1 1 0v7a3.5 3.5 0 1 1-7 0V3z"/>
                                                    </svg>    
                                                    </a> 
                                                    &nbsp;
                                                    <button class="button ripple-effect">Send</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
					
                    
                                    <div class="tab" data-tab-id="3">
                                        <div class="row">
                                            <div class="col-xl-8 col-md-8">
                                                <div class="row">
                                                    <div class="col-xl-12 col-md-12">
                                                        <h4>Contact Info</h4>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-6 col-md-6">
                                                        <br>
                                                        <h6>Start Date</h6>
                                                    </div>
                                                    <div class="col-xl-6 col-md-6">
                                                        <br>
                                                        <p><?php  echo date_format(date_create($start['time_stamp']),"d M Y");?></p>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-top:15px">
                                                    
                                                    <div class="col-xl-6 col-md-6">
                                                        <br>
                                                        <h6>Location</h6>
                                                    </div>
                                                    <div class="col-xl-6 col-md-6">
                                                        <br>
                                                        <p><?=$task['location']?></p>
                                                    </div>
                                                    
                                                </div>
                                                <div class="row" style="margin-top:15px;margin-bottom:40px">
                                                    <div class="col-xl-6 col-md-6">
                                                        <br>
                                                        <h6>Contract ID</h6>
                                                    </div>
                                                    <div class="col-xl-6 col-md-6">
                                                        <br>
                                                        <p>206084497</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4" style="margin-top:20px;padding-right:10px;">
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12">
                                                        <h4>Description of Work</h4>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12" style="padding-right:h6;">
                                                        <p><?=$task['t_description']?></p>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-top:40px"> 
                                                    <div class="col-lg-12 col-md-12" style="padding-right:50px;">
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
                                                               
                                                                    <div class="col-md-8">
                                                                        <!-- <a href="uploads/<?=$file['document']?>"  target="_blank"><img src="images/PDF.svg" width="100px" height="100px"/></a>             -->
                                                                        <a href="uploads/<?=$file['document']?>" target="_blank" class="attachment-box ripple-effect"><span>Attachment</span><i>PDF</i></a>
                                                                    </div>
                                                               
                                                                <?php
                                                                }
                                                                else
                                                                {
                                                                ?>
                                                               
                                                                    <div class="col-md-6">
                                                                        <a href="uploads/<?=$file['document']?>" target="_blank"><img src="uploads/<?=$file['document']?>" width="100px" height="100px"/></a>
                                                                    </div>
                                                                
                                                                <?php
                                                                }
                                                            }
                                                        }
                                                    ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>

                                    
                                    <?php
                                        $feedback = 0;
                                        $count = 0;
                                        if(isset($miles))
                                        {
                                            foreach($miles as $a)
                                            {
                                                $count ++;
                                                if($a['pay_status'] == 1)
                                                {
                                                    $feedback++;
                                                }
                                            }
                                        }
                                    
                                    ?>
                                    <div class="tab  " data-tab-id="4">
                                        <div class="row" style="margin-top:40px;margin-bottom:40px;">
                                            <div class="col-lg-4 col-md-4"></div>
                                            <div class="col-lg-4 col-md-4" style="display:flex;flex:1;align-items:center;justify-content:center;">
                                                <center>
                                                    <img src="uploads/review.jpg" style="border-radius: 50%; height:200px; width:250px; margin-bottom:30px;">
                                                    <?php
                                                        if($feedback != $count )
                                                        {
                                                            ?>
                                                                <h5 >
                                                                    The Contract is not eligible for feedback
                                                                </h5>
                                                                <br>
                                                                <p>
                                                                    You can request Feedback on active contracts once all the payments are completed. The feedback will appear on your profile, and can impact 
                                                                    on you job-success score.
                                                                </p>
                                                            <?php
                                                        }
                                                        else if($feedback == $count)
                                                        {
                                                            ?>
                                                                 <h5 >
                                                                    The Contract is eligible for feedback
                                                                </h5>
                                                                <br>
                                                                <p>
                                                                   The Feedback is now enabled and you can share your work experience.
                                                                   This will be publicly posted with your name!
                                                                </p>
                                                            <?php
                                                        }
                                                    ?>
                                                   
                                                    <br>
                                                    
                                                    <br><br>
                                                    <?php
                                                        if($feedback == $count && $TYPE !=5 &&  $c_id['emp_status']=="")
                                                        {
                                                            ?>
                                                                <a href=".emp<?=$TYPE?>" class="popup-with-zoom-anim button ripple-effect margin-top-5 margin-bottom-10" disabled><i class="icon-material-outline-thumb-up"></i>Leave a Review</a>
                                                            <?php
                                                        }    
                                                        else if($feedback == $count && $TYPE ==5 && $c_id['review']=="")
                                                        {
                                                            ?>
                                                                <a href=".cus<?=$TYPE?>" class="popup-with-zoom-anim button ripple-effect margin-top-5 margin-bottom-10" disabled><i class="icon-material-outline-thumb-up"></i>Leave a Review</a>
                                                            <?php
                                                        }   
                                                        else
                                                        {
                                                            ?>
                                                                Already Reviewed!
                                                            <?php
                                                        } 

                                                    ?>
                                                        <div id="small-dialog-2" class="zoom-anim-dialog mfp-hide dialog-with-tabs emp<?=$TYPE?>">

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
            <span>Rate <?=$details[0]['f_name']?>  <?=$details[0]['l_name']?> For <?=$task['t_name']?> </span>
        </div>
            
        <!-- Form -->
        <form method="post" id="leave-review-form">
            
            <div class="feedback-yes-no">
                <input type="hidden" name="employersid" value="<?=$details[0]['opp_id']?>">
                <input type="hidden" name="task_id_for_employer" value="<?=$token?>">
                <input type="hidden" name="acceptID" value="<?=$c_id['id']?>">
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
</div>  </div>
                                                        <div id="small-dialog-2" class="zoom-anim-dialog mfp-hide dialog-with-tabs cus<?=$TYPE?>">
                                                            <div class="sign-in-form">

                                                                <!-- <ul class="popup-tabs-nav">
                                                                </ul> -->

                                                                <div class="popup-tabs-container">

                                                                    <!-- Tab -->
                                                                    <div class="popup-tab-content" id="tab2">
                                                                        
                                                                        <!-- Welcome Text -->
                                                                        
                                                                        <div class="welcome-text">
                                                                            <h3>Leave a Review</h3>
                                                                            <span>Rate <?=$details[0]['f_name']?>  <?=$details[0]['l_name']?> For <?=$task['t_name']?> </span>
                                                                        </div>
                                                                            
                                                                        <!-- Form -->
                                                                        <form method="post" id="leave-review-form-2">
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
                                                                                <input type="hidden" name="cid" value="<?=$c_id['c_id']?>">
                                                                                <input type="hidden" name="tid" value="<?=$token?>">
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
                                                                            <button class="button full-width button-sliding-icon ripple-effect" type="submit" name="review_do">Leave a Review <i class="icon-material-outline-arrow-right-alt"></i></button>

                                                                        </form>
                                                                        
                                                                        <!-- Button -->

                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                </center>
                                            </div>
                                            <div class="col-lg-4 col-md-4"></div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
							
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

                <div id="small-dialog" class="zoom-anim-dialog mfp-hide dialog-with-tabs ">

                    <!--Tabs -->
                    <div class="sign-in-form">



                        <div class="popup-tabs-container">

                            <!-- Tab -->
                            <div class="popup-tab-content" id="tab2">
                                
                                <!-- Welcome Text -->
                                <div class="welcome-text">
                                    <h3>Add Milestone</h3>
                                    
                                </div>
                                    
                                <!-- Form -->
                                <form method="post" id="leave-review-form">
                                    <input type="hidden" name="taskId"  value="<?=$ids['task_id']?>" />    
                                    <input type="hidden" name="cusId"  value="<?=$ids['cus_id']?>"/>                                                                        
                                    <input type="hidden" name="empId"  value="<?=$ids['emp_id']?>"/>    
                                    <div class="feedback-yes-no">
                                        <strong>Milestone Title</strong>
                                
                                        <input  name="mil_title" id="title" class="with-border" value="" placeholder="Title"  type="text" required>
                                    </div>

                                    
                                    <div class="feedback-yes-no">
                                        <strong>Milestone Description</strong>
                                
                                        <textarea class="with-border" id="desc" placeholder="Description"  name="mil_desc" id="message2" cols="1" style="height:50%;" required></textarea>
                                    </div>
                                    

                                    <div class="feedback-yes-no">
                                        <strong>Due Date</strong>
                                                    
                                        <input name="due_date"  class="with-border"  value="" name="due" type="date" required>
                                    </div>
                                    <div class="feedback-yes-no">
                                        <strong>Price</strong>
                                        <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">$</span>
                                        </div>
                                        <input type="text" id="price" class="form-control with-border" value="" name="mil_price" aria-label="Amount (to the nearest dollar)" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text">.00</span>
                                        </div>
                                        </div>
                                    </div>


                                </form>

                                
                                <!-- Button -->
                                <button class="button button-sliding-icon ripple-effect" type="submit" name="createkare" form="leave-review-form">Create <i class="icon-material-outline-arrow-right-alt"></i></button>
                            </div>

                        </div>
                    </div>
                </div>

			<!-- Footer -->
			<div class="dashboard-footer-spacer"></div>
			<div class="small-footer margin-top-15">
				<div class="small-footer-copyrights">
				</div>
				<ul class="footer-social-links">
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
				</ul>
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



<!-- Modal -->
<!-- <div class="modal" id="exampleModalCentered" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenteredLabel">Milestone Payment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#exampleModalCentered').hide()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">


        <div class="notification error closeable" id="paymentErrors">
            <p class="paymentErrors"></p>
            <a class="close" href="#"></a>
        </div>
    
      <form action="milestone_payment.php" method="POST" role="form" id="milestone_payment">
      <input type="hidden" name="id" id="milestone_id">
      <input type="hidden" name="title" id="milestone_title">
      <input type="hidden" name="customer_id" id="milestone_customer_id">
      <input type="hidden" name="emp_id" id="milestone_emp_id">
      <input type="hidden" name="amount" id="milestone_amount">
      <input type="hidden" name="task_id" id="milestone_task_id">

	<div class="form-group">
		<input type="text" class="form-control" id="CardNumber" placeholder="Card Number" required="">
	</div>

    <div class="row">
    <div class="col-6">
    <div class="form-gruop">
         <label for="">Expiry Month</label>
        <input type="text" class="form-control" id="ExpiryMonth" placeholder="Expiry Month" required="">
    </div>

    </div>
    
    <div class="col-6">
    
    <div class="form-gruop">
         <label for="">Expiry Year</label> 
        <input type="text" class="form-control" id="ExpiryYear" placeholder="Expiry Year" required="">
    </div>

    </div>
    
    
    </div>

    <div class="form-gruop">
        <label for="">CVV</label> 
        <input type="text" class="form-control" id="CVV" placeholder="CVV Number" required="">
    </div>

    
    

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

        <button type="button" class="btn btn-primary" id="payment">Pay $<span id="milestone_amount"></span>

        </button>


      </div>
      </form>
    </div>
  </div>
</div> -->
<div id="small-dialog-4" class="zoom-anim-dialog mfp-hide dialog-with-tabs paymentdialog modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="overflow:hidden">

                    <!--Tabs -->
    <div class="sign-in-form">



        <div class="popup-tabs-container">

            <!-- Tab -->
            <div class="popup-tab-content" id="tab2" style="padding-bottom:0">
                
                <!-- Welcome Text -->
                <div class="welcome-text">
                     <h5 class="modal-title" id="exampleModalCenteredLabel">Milestone Payment</h5>
                    
                </div>
                    
                <div class="notification error closeable" id="paymentErrors">
                    <p class="paymentErrors"></p>
                    <a class="close" href="#"></a>
                </div>
                <!-- Form -->
                <div>
                    <div class="notification success closeable modal-body" style="display:none">
                        
                    </div>
                </div>
                <form action="milestone_payment.php" method="POST" role="form" id="milestone_payment">
                    <input type="hidden" name="id" id="milestone_id">
                    <input type="hidden" name="title" id="milestone_title">
                    <input type="hidden" name="customer_id" id="milestone_customer_id">
                    <input type="hidden" name="emp_id" id="milestone_emp_id">
                    <input type="hidden" name="amount" id="milestone_amount">
                    <input type="hidden" name="task_id" id="milestone_task_id">

                    <div class="form-group">
                        <label for="">Card Number</label>
                        <input type="text" class="form-control" id="CardNumber" placeholder="Card Number" required="">
                    </div>

                    <div class="row">
                    <div class="col-6">
                    <div class="form-gruop">
                        <label for="">Expiry Month</label>
                        <input type="text" class="form-control" id="ExpiryMonth" placeholder="Expiry Month" required="">
                    </div>

                    </div>
                    
                    <div class="col-6">
                    
                    <div class="form-gruop">
                        <label for="">Expiry Year</label>
                        <input type="text" class="form-control" id="ExpiryYear" placeholder="Expiry Year" required="">
                    </div>

                    </div>
                    
                    
                    </div>

                    <div class="form-gruop">
                        <label for="">CVV</label>
                        <input type="text" class="form-control" id="CVV" placeholder="CVV Number" required="">
                    </div>

    
    

                    </div>

                        <button type="button" class="button button-sliding-icon ripple-effect" id="payment">Pay $<span id="milestone_amount"> <i class="icon-material-outline-arrow-right-alt"></i></span>

                        </button>

                    </form>

                
                <!-- Button -->
                <!-- <button class="button button-sliding-icon ripple-effect" type="submit" name="createkare" form="leave-review-form">Create <i class="icon-material-outline-arrow-right-alt"></i></button> -->
            </div>

        </div>
    </div>
<!-- </div> -->




<?php
require_once 'js-links.php';
?>

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<script>
    function remove(id)
    {
        $("#"+id).remove();
    }
    // $('.paymentdialog').modal({
    //     backdrop: 'static',
    //     keyboard: false,
    //     show:false,
    // })
    $(document).ready(function(){
        // $("#small-dialog-4").modal({
        //     show:true,
        //     backdrop:'static'
        // });
        // $("#small-dialog-4").modal({
        //     show:true,
        //     backdrop:'static'
        // });
    });
	$("#dashboard").removeClass('active');
	$("#bookmarks").removeClass('active');
	$("#reviews").removeClass('active');
	$("#jobs").removeClass('active');
	$("#tasks").removeClass('active');
	$("#settings").removeClass('active');
    $("#transaction").removeClass('active');
	$("#milestone").removeClass('active');
	$("#tasks").addClass('active');

    function activity(id_un,id_ac,id)
    {
        
        var status = $("#mil_status"+id).val();
        var stat;
        if(status == '0')
        {
            stat = 1;
        }
        else if(status == '1')
        {
            stat = 0;
        }

        $.ajax({
            url:"mil_ajax.php",
            type:"post",
            data:{
                change:true,
                id:id,
                status:stat
            },
            success: function(data){
                console.log(data);
				if(data.trim()=="updated"){
					Snackbar.show({
					text: 'Status of Milestone changed successfully !!',
					pos: 'bottom-center',
					showAction: false,
					actionText: "Dismiss",
					duration: 3000,
					textColor: '#fff',
					backgroundColor: '#383838'
                    
				});
                $("#"+id_un).hide();
                $("#"+id_ac).show(); 
				}
            },
            error: function(data) {
                console.log("galti");
            }
        });


    }
    // onclick="edit(<?=$mi['id']?>,'<?=$mi['mil_title']?>','<?=$mi['mil_desc']?>','<?=$mi['due_date']?>',<?=$mi['price']?>)"
    var globalEventVar = 'aforapple';
    var counter=0;
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
            var t_id = <?=$token?>;
            var main_id = $("#main_id"+id).val();
            // var image = 'none';
            var des = $("#desc"+id).val();
            // console.log(des);
            if(a != 'aforapple' && des != '')
            {
                var formData = new FormData();
                formData.append('images',a.target.files[0]);
                formData.append('updateFile','true');
                formData.append('des',des);
                formData.append('id',t_id);
                formData.append('user',<?=$USER_ID?>);
                formData.append('main_id',main_id);
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
                                    // $('.'+id+'8449').remove();
                                    $(".mfp-close").click();
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

    function edit(id,title,desc,due,price)
    {
        $("#mil_id").val(id);
        $("#title").val(title);
        $("#desc").val(desc);
        $("#due").val(due);
        $("#price").val(price);
    }

    function show(stat,counter,id)
    {
        if(stat == 1)
        {
            $("#80777"+counter).remove();
            $("#1222"+counter).remove();
            $(".aforapple").hide();
        }
    }


    function setmilestonevalues(id, emp_id, cust_id, title, amount, task_id){
        
        $('.popup-with-zoom-anim').magnificPopup({
            type: 'inline',
            fixedContentPos: false,
            // fixedBgPos: true,
            overflowY: 'hidden',
            closeBtnInside: true,
            closeOnBgClick: false,
            preloader: false,
            midClick: true,
            removalDelay: 300,
            mainClass: 'my-mfp-zoom-in'
        });
        $("#milestone_id").val(id)
        $("#milestone_customer_id").val(cust_id);
        $("#milestone_emp_id").val(emp_id);
        $("#milestone_amount").val(amount);
        $("#milestone_task_id").val(task_id);
        $("#milestone_title").val(title);
        $("h5.modal-title").html(title);
        $("span#milestone_amount").html(amount);
        $("#paymentErrors").hide();
        $(".modal").show();
            // $(".mfp-ready").modal({
            //     show:true,
            //     backdrop:'static',
            //     keyboard: false,
            //     });
            //     $(".mfp-ready").attr('disabled',true)
    }



// set your stripe publishable key
Stripe.setPublishableKey('pk_test_51ImyzVSEHoT1T6uL8zjq5RsKnx1XcCWPxmViB1AViNCKkCJv7NtEMQWgvMAvWE4ukjNeKr60qEyWyVCjAxHJds9z00gjIkCcr2');

    $('#payment').click(function(event){
        //alert("Form alert");
        $('#payment').attr("disabled", "disabled");
        //event.preventDefaults()
        $('#payment').html(`<span class='need2hide spinner-border spinner-border-sm' role='status' aria-hidden='true'></span>
        <span>Please Wait</span>`);

        Stripe.createToken({
            number: $('#CardNumber').val(),
            cvc: $('#cvv').val(),
            exp_month: $('#ExpiryMonth').val(),
            exp_year: $('#ExpiryYear').val()
        }, handleStripeResponse); 
        return false;
    });
       
    

    // handle the response from stripe
function handleStripeResponse(status, response) {
	console.log(JSON.stringify(response));
    if (response.error) {
        $('#payment').removeAttr("disabled");
        $('#payment').html(`Try Again`);
        //alert(response.error.message);
        $(".paymentErrors").html(response.error.message);
        $("#paymentErrors").fadeIn();
        $('.notification').css("opacity", 1);
    } else {
		var milestone_payment = $("#milestone_payment");
        //get stripe token id from response
        var stripeToken = response['id'];
        //set the token into the form hidden input to make payment
        milestone_payment.append("<input type='hidden' name='stripeToken' value='" + stripeToken + "' />");
		//milestone_payment.get(0).submit();
            payment_ajax();
    }
}


 function payment_ajax(){
    $.ajax({
        url: 'milestone_payment.php',
        method: 'POST',
        dataType : "JSON",
        data : $('#milestone_payment').serialize()
    })
    .done(function(response){
        if(response.success){
            //alert(response.message);
            $("form").hide();
            $(".modal-body").show();
            $(".modal-body").html(response.message);
            $('#payment').hide();

        } else {
            alert(response.message);
        }
    }).fail(function(error){
        console
        alert("Unable to process Your payment please contact admin");
    })

 }

</script>