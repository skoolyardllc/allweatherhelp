<?php
    require_once 'header.php';
    require_once 'navbar.php';

    $user = '';
    switch($TYPE){
        case 2:
            $user="Rate Freelancers";
            $sql="select * from user_profile,accepted_task,post_task where user_profile.u_id = accepted_task.c_id and post_task.id=accepted_task.t_id ";
            if ($result = $conn->query($sql)) 
            {
                if ($result->num_rows) 
                {
                    while ($row = $result->fetch_assoc()) 
                    {
                        $rev[] = $row;
                    }
                }
            }
            
            break;
        
        case 3:
            $user="Rate Employers";

            $sql = "select pt.*,up.u_id,up.f_name,up.l_name from post_task pt,user_profile up where pt.e_id = up.u_id and up.status = 2";
            if ($resu = $conn->query($sql)) 
            {
                if ($resu->num_rows) 
                {
                    
                    while ($row = $resu->fetch_assoc()) 
                    {
                        $row_id = $row['id'];
                        $reviews[$row_id] = $row;
                        
                        $sql="select * from employer_reviews where u_id='$USER_ID' and t_id='$row_id' ";
                        // echo $sql;
                        if ($result = $conn->query($sql)) 
                        {
                            // echo "happy";
                            if ($result->num_rows>0) 
                            {
                                $reviews[$row_id]['reviewed'] = true; 
                                
                            }
                            else{

                            }
                        }
                        else{
                            echo $conn->error;
                        }
                    }
                }
                else{
                    echo $conn->error;
                }
            }
            else{
                echo $conn->error;
            }

            break;
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
            on_time='$time',on_budget='$budget',ratings='$rating'
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
            $sql = "insert into employer_reviews(t_id,c_id,speci,comm,payment,profess,ratings,review,u_id)
             values('$t_id','$c_id','$speci','$comm','$payment','$profess','$rating','$revie','$u_id')";
            if ($conn->query($sql)) 
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
				<h3>Reviews</h3>

				<!-- Breadcrumbs -->
				<nav id="breadcrumbs" class="dark">
					<ul>
						<li><a href="index">Home</a></li>
						<li><a href="dashboard">Dashboard</a></li>
						<li>Reviews</li>
					</ul>
				</nav>
                
			</div>
	
            <div class="row">
                <div class="col-xl-12">
                    <?php
                        if(isset($done))
                        {
                            ?>
                                <div class="alert alert-success" id="123456">
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
					<div class="dashboard-box margin-top-0">

						<!-- Headline -->
						<div class="headline">
							<h3><i class="icon-material-outline-business"></i><?=$user?></h3>
						</div>

						<div class="content">
							<ul class="dashboard-box-list">
                                <?php
                                    if(isset($reviews))
                                    {
                                        $i=1;
                                        foreach($reviews as $r)
                                        {
                                             
                                            

                                        
                                ?>
								<li>
									<div class="boxed-list-item">
										<!-- Content -->
										<div class="item-content">
                                            <input type="hidden" value="" name="">
											<h4><?=$r['t_name']?></h4>
                                            <h6>Company : <?=$r['f_name']?> <?=$r['l_name']?></h6>
                                            
                                            
										</div>
									</div>
                                    <?php
                                        if($r['reviewed'])
                                        {
                                            ?>
                                                Already Reviewed!!
                                            <?php
                                        }
                                        else 
                                        {
                                            ?>
                                                <a href=".<?=$r['u_id']?><?=$i?>" class="popup-with-zoom-anim button ripple-effect margin-top-5 margin-bottom-10"><i class="icon-material-outline-thumb-up"></i>Leave a Review</a>
                                            <?php
                                        }
                                    ?>

                                      
                                      
                                    <div id="small-dialog-2" class="zoom-anim-dialog mfp-hide dialog-with-tabs <?=$r['u_id']?><?=$i?>">
  
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
                                                          <span>Rate <a href="single-company-profile?token=<?=$r['u_id']?>"><?=$r['f_name']?> <?=$r['l_name']?></a> For <?=$r['t_name']?> </span>
                                                      </div>
                                                          
                                                      <!-- Form -->
                                                      <form method="post" id="leave-review-form">
                                                          
                                                        <div class="feedback-yes-no">
                                                            <input type="hidden" name="employer" value="<?=$r['u_id']?>">
                                                            <input type="hidden" name="task_id" value="<?=$r['task_id']?>">
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
                                
                                </li>
                                <?php
                                            $i++;
                                        }
                                    }

                                ?>
                                <?php
                                    if(isset($rev))
                                    {
                                        foreach($rev as $re)
                                        {
                                           


                                        
                                ?>
								<li>
									<div class="boxed-list-item">
										<!-- Content -->
										<div class="item-content">
                                            <h5><a href="profile?token=<?=$re['u_id']?>"><?=$re['f_name']?> <?=$re['l_name']?></a></h5>
                                            <h6>Project : <?=$re['t_name']?></h6>
										</div>
									</div>
                                    <?php
                                        if($re['review'] == '' )
                                        {
                                    ?>
                                            <a href=".<?=$re['u_id']?><?=$re['t_id']?>" class="popup-with-zoom-anim button ripple-effect margin-top-5 margin-bottom-10"><i class="icon-material-outline-thumb-up"></i>Leave a Review</a>
                                    <?php
                                        }
                                        else
                                        {
                                    ?>
                                            Already Reviewed!
                                    <?php
                                        }
                                    ?>
                                    <div id="small-dialog-2" class="zoom-anim-dialog mfp-hide dialog-with-tabs <?=$re['u_id']?><?=$re['t_id']?>">

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
                                                        <span>Rate <a href="profile?token=<?=$re['u_id']?>"><?=$re['f_name']?> <?=$re['l_name']?></a> for <?=$re['t_name']?> </span>
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
                                
                                </li>
                                <?php
                                
                                        }
                                    }

                                ?>
								
								<!-- <li>
									<div class="boxed-list-item">
										<!-- Content -->
										<!--<div class="item-content">
											<h4>Fix Python Selenium Code</h4>
											<div class="item-details margin-top-10">
												<div class="star-rating" data-rating="5.0"></div>
												<div class="detail-item"><i class="icon-material-outline-date-range"></i> May 2019</div>
											</div>
											<div class="item-description">
												<p>Great clarity in specification and communication. I got payment really fast. Really recommend this employer for his professionalism. I will work for him again with pleasure.</p>
											</div>
										</div>
									</div>
									<a href="#small-dialog-1" class="popup-with-zoom-anim button gray ripple-effect margin-top-5 margin-bottom-10"><i class="icon-feather-edit"></i> Edit Review</a>
								</li> -->
								

							</ul>
						</div>
					</div>

					<!-- Pagination -->
					<div class="clearfix"></div>
					<div class="pagination-container margin-top-40 margin-bottom-0">
						<nav class="pagination">
							<ul>
								<li><a href="#" class="ripple-effect current-page">1</a></li>
								<li><a href="#" class="ripple-effect">2</a></li>
								<li><a href="#" class="ripple-effect">3</a></li>
								<li class="pagination-arrow"><a href="#" class="ripple-effect"><i class="icon-material-outline-keyboard-arrow-right"></i></a></li>
							</ul>
						</nav>
					</div>
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

</div>
<!-- Dashboard Container / End -->

</div>
<!-- Wrapper / End -->



<!-- Edit Review Popup
================================================== -->
<div id="small-dialog-1" class="zoom-anim-dialog mfp-hide dialog-with-tabs">

	<!--Tabs -->
	<div class="sign-in-form">

		<ul class="popup-tabs-nav">
		</ul>

		<div class="popup-tabs-container">

			<!-- Tab -->
			<div class="popup-tab-content" id="tab1">
				
				<!-- Welcome Text -->
				<div class="welcome-text">
					<h3>Change Review</h3>
					<span>Rate <a href="#">Herman Ewout</a> for the project <a href="#">WordPress Theme Installation</a> </span>
				</div>
					
				<!-- Form -->
				<form method="post" id="change-review-form">

					<div class="feedback-yes-no">
						<strong>Was this delivered on budget?</strong>
						<div class="radio">
							<input id="radio-rating-1" name="radio" type="radio" checked>
							<label for="radio-rating-1"><span class="radio-label"></span> Yes</label>
						</div>

						<div class="radio">
							<input id="radio-rating-2" name="radio" type="radio">
							<label for="radio-rating-2"><span class="radio-label"></span> No</label>
						</div>
					</div>

					<div class="feedback-yes-no">
						<strong>Was this delivered on time?</strong>
						<div class="radio">
							<input id="radio-rating-3" name="radio2" type="radio" checked>
							<label for="radio-rating-3"><span class="radio-label"></span> Yes</label>
						</div>

						<div class="radio">
							<input id="radio-rating-4" name="radio2" type="radio">
							<label for="radio-rating-4"><span class="radio-label"></span> No</label>
						</div>
					</div>

					<div class="feedback-yes-no">
						<strong>Your Rating</strong>
						<div class="leave-rating">
							<input type="radio" name="rating" id="rating-1" value="5" checked/>
							<label for="rating-1" class="icon-material-outline-star"></label>
							<input type="radio" name="rating" id="rating-2" value="44"/>
							<label for="rating-2" class="icon-material-outline-star"></label>
							<input type="radio" name="rating" id="rating-3" value="3"/>
							<label for="rating-3" class="icon-material-outline-star"></label>
							<input type="radio" name="rating" id="rating-4" value="2"/>
							<label for="rating-4" class="icon-material-outline-star"></label>
							<input type="radio" name="rating" id="rating-5" value="1"/>
							<label for="rating-5" class="icon-material-outline-star"></label>
						</div><div class="clearfix"></div>
					</div>

					<textarea class="with-border" placeholder="Comment" name="message" id="message" cols="7" required>Excellent programmer - helped me fixing small issue.</textarea>

				</form>
				
				<!-- Button -->
				<button class="button full-width button-sliding-icon ripple-effect" type="submit" form="change-review-form">Save Changes <i class="icon-material-outline-arrow-right-alt"></i></button>

			</div>

		</div>
	</div>
</div>
<!-- Edit Review Popup / End -->


<!-- Leave a Review for Freelancer Popup
================================================== -->
<div id="small-dialog-2" class="zoom-anim-dialog mfp-hide dialog-with-tabs">

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
					<span>Rate <a href="#">Peter Valentín</a> for the project <a href="#">Simple Chrome Extension</a> </span>
				</div>
					
				<!-- Form -->
				<form method="post" id="leave-review-form">

					<div class="feedback-yes-no">
						<strong>Was this delivered on budget?</strong>
						<div class="radio">
							<input id="radio-1" name="radio" type="radio" required>
							<label for="radio-1"><span class="radio-label"></span> Yes</label>
						</div>

						<div class="radio">
							<input id="radio-2" name="radio" type="radio" required>
							<label for="radio-2"><span class="radio-label"></span> No</label>
						</div>
					</div>

					<div class="feedback-yes-no">
						<strong>Was this delivered on time?</strong>
						<div class="radio">
							<input id="radio-3" name="radio2" type="radio" required>
							<label for="radio-3"><span class="radio-label"></span> Yes</label>
						</div>

						<div class="radio">
							<input id="radio-4" name="radio2" type="radio" required>
							<label for="radio-4"><span class="radio-label"></span> No</label>
						</div>
					</div>

					<div class="feedback-yes-no">
						<strong>Your Rating</strong>
						<div class="leave-rating">
							<input type="radio" name="rating" id="rating-radio-1" value="1" required>
							<label for="rating-radio-1" class="icon-material-outline-star"></label>
							<input type="radio" name="rating" id="rating-radio-2" value="2" required>
							<label for="rating-radio-2" class="icon-material-outline-star"></label>
							<input type="radio" name="rating" id="rating-radio-3" value="3" required>
							<label for="rating-radio-3" class="icon-material-outline-star"></label>
							<input type="radio" name="rating" id="rating-radio-4" value="4" required>
							<label for="rating-radio-4" class="icon-material-outline-star"></label>
							<input type="radio" name="rating" id="rating-radio-5" value="5" required>
							<label for="rating-radio-5" class="icon-material-outline-star"></label>
						</div><div class="clearfix"></div>
					</div>

					<textarea class="with-border" placeholder="Comment" name="message2" id="message2" cols="7" required></textarea>

				</form>
				
				<!-- Button -->
				<button class="button full-width button-sliding-icon ripple-effect" type="submit" form="leave-review-form">Leave a Review <i class="icon-material-outline-arrow-right-alt"></i></button>

			</div>

		</div>
	</div>
</div>
<!-- Leave a Review Popup / End -->

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
	$("#reviews").addClass('active');

</script>