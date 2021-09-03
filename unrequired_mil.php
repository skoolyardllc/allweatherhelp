<?php
    require_once 'header.php';
    require_once 'navbar.php';


    $sql = "SELECT at.*,up.f_name,up.l_name,up.u_id as user,up.avtar,pt.t_name,pt.id as task_id,pt.e_id as emp_id,at.id as main_id from accepted_task at,user_profile up,post_task pt where at.statu=0 and up.u_id=at.c_id and at.t_id=pt.id ";
    if ($result = $conn->query($sql)) {
        if ($result->num_rows) {
            // echo "ccvjkasdvckasd";
            while ($row = $result->fetch_assoc()) {
                $mil[] = $row;
               
            }
        }
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

    if(isset($_POST['createkare']))
    {
        $cus_id = $_POST['cus_id'];
        $task_id = $_POST['task_id'];
        $emp_id = $_POST['emp_id'];
        $title = $_POST['title'];
        $desc = $_POST['desc'];
        $due = $_POST['due'];
        $stat = $_POST['rad'];
        $main_id=$_POST['main_id'];

         $sql="INSERT INTO milestones(task_id,cus_id,emp_id,mil_title,mil_desc,due_date,mil_status,pay_status) values ($task_id,$cus_id,$emp_id,'$title','$desc','$due',$stat,0)";
        $sqll = "update accepted_task set statu=2 where id=$main_id";
        if ($result = $conn->query($sql) && $result = $conn->query($sqll)) 
        {
            $done = "Milestone created successfully";
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
				<div class="col-xl-12" >
					
                        <?php
                            if(isset($mil))
                            {
                                $i=1;
                                foreach($mil as $m)
                                {
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
                                
                                <button class="button gray ripple-effect">Mark Completed</button>
                                
                                <!-- <a href=".<?=$m['task_id']?><?=$i?>" class="popup-with-zoom-anim button gray ripple-effect margin-top-5 margin-bottom-10">Create Milestone</a> -->
                                &nbsp;
                                                        <div id="small-dialog-2" class="zoom-anim-dialog mfp-hide dialog-with-tabs <?=$m['task_id']?><?=$i?>">

                                                            <!--Tabs -->
                                                            <div class="sign-in-form">

                                                               

                                                                <div class="popup-tabs-container">

                                                                    <!-- Tab -->
                                                                    <div class="popup-tab-content" id="tab2">
                                                                        
                                                                        <!-- Welcome Text -->
                                                                        <div class="welcome-text">
                                                                            <h3>  Create a Milestone For <?=$m['t_name']?> </h3>
                                                                            
                                                                            <p><?=$userg?> : <?=$m['f_name']?> <?=$m['l_name']?> </p>
                                                                        </div>
                                                                            
                                                                        <!-- Form -->
                                                                        <form method="post" id="leave-review-form">
                                                                            <input type="hidden" name="task_id" value="<?=$m['task_id']?>"/>                                                                        
                                                                            <input type="hidden" name="cus_id" value="<?=$m['user']?>"/>
                                                                            <input type="hidden" name="emp_id" value="<?=$m['emp_id']?>"/>                                                                         
                                                                            <input type="hidden" name="main_id" value="<?=$m['main_id']?>"/>                                                                         

                                                                            <div class="feedback-yes-no">
                                                                                <strong>Milestone Title</strong>
                                                                        
                                                                                <input id="" name="title" class="with-border" placeholder="Title" name="title" type="text" required>
                                                                            </div>

                                                                            
                                                                            <div class="feedback-yes-no">
                                                                                <strong>Milestone Description</strong>
                                                                        
                                                                                <textarea class="with-border" placeholder="Description" name="desc" id="message2" cols="1" style="height:50%;" required></textarea>
                                                                            </div>
                                                                            <div class="feedback-yes-no">
                                                                                <strong>Milestone Status</strong>
                                                                                <div class="radio">
                                                                                    <input id="radio-5" name="rad" type="radio" value="1" required>
                                                                                    <label for="radio-5"><span class="radio-label"></span> Active</label>
                                                                                </div>

                                                                                <div class="radio">
                                                                                    <input id="radio-6" name="rad" type="radio" value="0" required>
                                                                                    <label for="radio-6"><span class="radio-label"></span> Inactive</label>
                                                                                </div>
                                                                            </div>

                                                                            <div class="feedback-yes-no">
                                                                                <strong>Due Date</strong>
                                                                                            
                                                                                <input id=""  class="with-border" placeholder="Title" name="due" type="date" required>
                                                                            </div>

                                                                        </form>

                                                                        
                                                                        <!-- Button -->
                                                                        <button class="button button-sliding-icon ripple-effect" type="submit" name="createkare" form="leave-review-form">Create <i class="icon-material-outline-arrow-right-alt"></i></button>
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

</script>