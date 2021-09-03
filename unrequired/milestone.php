<?php
    require_once 'header.php';
    require_once 'navbar.php';

    if(isset($_GET['token']) and !empty($_GET['token']))
    {
        $token = $_GET['token'];
        $abled = '';
        $disabled = '';
        $dontshow = '';
        $hide='none';
        switch($TYPE)
        {
            case 2:
                $sqlUserData = "SELECT up.f_name,up.l_name,up.avtar,up.nationality from user_profile up , accepted_task ated where  ated.c_id = up.u_id and ated.t_id = '$token' and ated.statu=2";
                $sql = "SELECT mt.* from milestones mt where mt.emp_id=$USER_ID and  mt.task_id='$token'";

                break;

            case 3:
                $sqlUserData = "SELECT up.f_name,up.l_name,up.avtar,up.nationality from user_profile up , accepted_task ated where  ated.c_id = up.u_id and ated.t_id = '$token' and ated.statu=2";
                $sql = "SELECT mt.* from milestones mt where mt.emp_id=$USER_ID and  mt.task_id='$token'";

                break;

            case 5:
                $sqlUserData = "SELECT up.f_name,up.l_name,up.avtar,up.nationality from user_profile up , post_task pt where  pt.e_id = up.u_id and pt.id = '$token' ";
                $sql = "SELECT mt.*,up.f_name,up.l_name,up.avtar from milestones mt,user_profile up where mt.cus_id=$USER_ID and mt.emp_id=up.u_id";
                $abled = 'disabled';
                $disabled = 'disabled';
                $dontshow = 'none';
                $hide='show';
                break;

        }
        echo $sql;
        if ($result = $conn->query($sql)) {
            // echo "happy";
            if ($result->num_rows) {
                // echo "ccvjkasdvckasd";
                while ($row = $result->fetch_assoc()) {
                    $miles[] = $row;
                
                }
            }

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
                while ($row = $result->fetch_assoc()) {
                    $ids = $row;
                
                }
            }

        }
        else
        {
            echo $conn->error;
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
    $budget = 0;
    $escrow = 0;
    $paid = 0;
    $remaining = 0;
    $total = 0;

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
        $task = $_POST['taskId'];
        $cus = $_POST['cusId'];
        $emp = $_POST['empId'];
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
                                
                                <button class="button gray ripple-effect-dark" style="display:<?=$dontshow?>"> Bonus</button>
                                &nbsp;
                                <button class="button gray ripple-effect-dark" type="submit" >Cancel Contract</button>
                                </div>
                            </div>
                        </div>

						<div class="content">
                        <div class="tabs">
                            <div class="tabs-header" >
                                <ul>
                                    <li class="active"><a href="#tab-1" data-tab-id="1" class="ahref">Milestone & Payments</a></li>
                                    <li class=""><a href="#tab-2" data-tab-id="2" class="ahref">Messages & Files</a></li>
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
                                            
                                            <p id="budget"><?=$budget?></p>
                                        </div>
                                        <div class="col-lg-2 col-md-2" style="padding-left:10px;padding-right:20px;margin-top:10px">
                                            <h6>In Escrow</h6>
                                            
                                            <p id="escrow"><?=$escrow?></p>
                                        </div>
                                        <div class="col-lg-3 col-md-3" style="padding-left:10px;padding-right:20px;margin-top:10px">
                                            <h6>Milestones Paid</h6>
                                            
                                            <p id="paid"><?=$paid?></p>
                                        </div>
                                        <div class="col-lg-2 col-md-2" style="padding-left:10px;padding-right:50px;margin-top:10px">
                                            <h6>Remaining</h6>
                                            
                                            <p id="remaining"><?=$remaining?></p>
                                        </div>
                                        <div class="col-lg-3 col-md-3" style="padding-left:10px;padding-right:10px;margin-top:10px">
                                            <h6>Total Payments <i href="#" class="bi bi-patch-question-fill" style="color:blue;"></i></h6>
                                            
                                            <p id="total"><?=$total?></p>
                                        </div>
                                    </div>
                                
                                    <div class="row" style="margin-top:40px">
                                        <div class="col-lg-9 col-md-9">
                                            <h3>Remaining Milestone</h3>
                                        </div>
                                        <div class="col-lg-3 col-md-3">
                                            <a href="#small-dialog-1"   class="popup-with-zoom-anim button ripple-effect button gray ripple-effect-dark" style="display:<?=$dontshow?>">Add Milestones</a>
                                        </div>
                                    </div>

                                    <?php
                                         if(isset($miles))
                                         {
                                             
                                             $i=1;
                                             $bud=0;
                                             foreach($miles as $mi)
                                             {
                                                $unactive = 'none';
                                                $active='none';
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
                                                 
                                                $bud = $bud + $mi['price'];
                                                $budget = $bud;
                                               
                                    
                                    ?>
                                    <div class="row" style="margin-top:40px" onload="show(<?=$mi['pay_status']?>,<?=$i?>,<?=$mi['id']?>)">
                                        
                                        <div class="col-lg-8 col-md-8" style="padding-left:30px">
                                            
                                            <p><?=$i?> &nbsp;<b><?=$mi['mil_title']?></b> &emsp;&emsp;
                                                
                                                <button class="btn btn-outline-danger aforapple" id="80777<?=$i?>" onclick="activity(80777<?=$i?>,1222<?=$i?>,<?=$mi['id']?>)"
                                                 style="display:<?=$unactive?>" <?=$abled?>>Unactive</button>
                                                
                                                <button class="btn btn-outline-primary aforapple" id="1222<?=$i?>" onclick="activity(1222<?=$i?>,80777<?=$i?>,<?=$mi['id']?>)"
                                                 style="display:<?=$active?>" <?=$disabled?>>Active</button>
                                                 
                                                 <input type="hidden" value="<?=$mi['mil_status']?>" id="mil_status<?=$mi['id']?>" /> 
                                            </p>
                                            <label for="description" style="margin-left:15px">Description : </label>
                                            <p style="margin-left:15px"><?=$mi['mil_desc']?></p>
                                            <div class="row" style="padding-bottom:20px;">
                                                <div class="col-lg-5 col-md-5">
                                                    
                                                    <input type="hidden" value="<?=$mi['pay_status']?>" id="pay_status<?=$mi['id']?>" /> 
                                                    <p>&emsp;$<?=$mi['price'] ?>  <?=$pay?></p>
                                                </div>
                                                <div class="col-lg-7 col-md-7">
                                                    <p>&emsp;Due <?php  echo date_format(date_create($mi['due_date']),"M d");?></p>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        
                                        <div class="col-lg-3 col-md-3">
                                                <input type="hidden" name="pay_stat" value="<?=$mi['pay_status']?>" />
                                                
                                            &emsp;&emsp;<a href="#" class="button  ripple-effect-dark"  style="display:<?=$display?>" >Pay Now</a>
                                                        <button class="btn btn-outline-success" name="completed" style="display:<?=$hide?>" onclick="completion(<?=$mi['id']?>)">Mark Completed</button>
                                            &nbsp;   <a href="#small-dialog-2"  style="display:<?=$display?>"  onclick="edit(<?=$mi['id']?>,'<?=$mi['mil_title']?>','<?=$mi['mil_desc']?>','<?=$mi['due_date']?>',<?=$mi['price']?>)" class="popup-with-zoom-anim button ripple-effect button gray ripple-effect-dark" disabled>Edit</a>
                                                                    
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
                                                    
                                                            <textarea class="with-border" id="desc" placeholder="Description"  name="desc" id="message2" cols="1" style="height:50%;" required></textarea>
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

                                    <div class="row" style="margin-top:40px">
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
                                                    <a href="#" class="attachment-box ripple-effect"><span>Cover Letter</span><i>PDF</i></a>
                                                    <a href="#" class="attachment-box ripple-effect"><span>Contract</span><i>DOCX</i></a>
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
                                                        <p> <a href="#"><i class="bi bi-layers"></i> View Offer</a></p>
                                                        <p> <a href="#"><i class="bi bi-layers"></i> View Origial Job Posting</a></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>

                                    
                                    <div class="tab  " data-tab-id="4">
                                        <div class="row" style="margin-top:40px;margin-bottom:40px;">
                                            <div class="col-lg-4 col-md-4"></div>
                                            <div class="col-lg-4 col-md-4" style="display:flex;flex:1;align-items:center;justify-content:center;">
                                                <center>
                                                    <img src="uploads/review.jpg" style="border-radius: 50%; height:200px; width:250px; margin-bottom:30px;">
                                                    <h5 >
                                                        The Contract is not eligible for feedback
                                                    </h5>
                                                    <br>
                                                    <p>
                                                        You can request Feedbackonn active contracts with payments beginning 30 days after the contract started. The feedback will appear on your profile, and doesnot impact on you job-success score
                                                    </p>
                                                    <br><br>
                                                    <a href=".abcd" class="popup-with-zoom-anim button ripple-effect margin-top-5 margin-bottom-10" disabled><i class="icon-material-outline-thumb-up"></i>Leave a Review</a>
                                                        <div id="small-dialog-2" class="zoom-anim-dialog mfp-hide dialog-with-tabs abcd">

                                                                <!--Tabs -->
                                                                <div class="sign-in-form">

                                                                    <!-- <ul class="popup-tabs-nav">
                                                                    </ul> -->

                                                                    <div class="popup-tabs-container">

                                                                        <!-- Tab -->
                                                                        <div class="popup-tab-content" id="tab2">
                                                                            
                                                                            <!-- Welcome Text -->
                                                                            <div class="welcome-text">
                                                                                <h3>Leave a Review</h3>
                                                                                <span>Rate <a href="profile?token=<?=$re['u_id']?>"><?=$re['f_name']?> <?=$re['l_name']?></a> for <?=$re['t_name']?> </span>
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
                                                                                    <input type="hidden" name="cid" value="<?=$re['c_id']?>">
                                                                                    <input type="hidden" name="tid" value="<?=$re['t_id']?>">
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

                <div id="small-dialog-1" class="zoom-anim-dialog mfp-hide dialog-with-tabs ">

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
                                        <input type="text" id="price" class="form-control with-border" value="" name="mil_price" aria-label="Amount (to the nearest dollar)">
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
            url:"unrequired_mil_ajax.php",
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
</script>