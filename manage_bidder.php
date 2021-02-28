<?php
    require_once 'header.php';
    require_once 'navbar.php';


	if(isset($_POST['delete_bid']))
	{
		 $id=$conn->real_escape_string($_POST['delete_bid']);
		
		 echo $sql="delete from bidding where id=$id";
		if($conn->query($sql))
		{
			$deLBid=true;   
		}
		else
		{
			$errorPost=$conn->error;
		}
	}
	
	if(isset($_POST['accepted_bid']))
	{
		$c_id=$conn->real_escape_string($_POST['c_id']);
		$t_id=$conn->real_escape_string($_POST['t_id']);
		$b_id=$conn->real_escape_string($_POST['b_id']);
		
		$sql="insert into accepted_task (c_id,t_id,b_id) values('$c_id','$t_id','$b_id')";
		if($conn->query($sql))
		{
			$accBid=true;   
		}
		else
		{
			$errorPost=$conn->error;
		}
	}




	if(isset($_GET['token']) and !empty($_GET['token']))
    {
        $t_id=$conn->real_escape_string($_GET['token']);
        $sql = "SELECT b.bid_expected,b.time_no,b.time_type,b.c_id,b.id as bid_id,r.*,u.*,up.* FROM bidding b,users u,user_profile up,ratings r where b.t_id='$t_id' and b.c_id=up.u_id and up.u_id=u.id and r.u_id=u.id";
		if($result =$conn->query($sql))
		{
			if($result->num_rows)
			{
				while($row=$result->fetch_assoc())
				{
					$biddingDetails[] = $row;
					$no=1;
					$no=$no+1;
				}
			}
		}

		$sql="select * from post_task where e_id='$USER_ID' and id='$t_id'";
		if($result =$conn->query($sql))
		{
			if($result->num_rows)
			{
				$row=$result->fetch_assoc();
				$employerDetails = $row;
				
			}
		}
    }

?>

<div id="wrapper">


	<div class="clearfix"></div>
	<!-- Header Container / End -->


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
						<h3>Manage Bidders</h3>
						<span class="margin-top-7">Bids for <a href="#"><?=$employerDetails['t_name']?></a></span>

						<!-- Breadcrumbs -->
						<nav id="breadcrumbs" class="dark">
							<ul>
								<li><a href="#">Home</a></li>
								<li><a href="#">Dashboard</a></li>
								<li>Manage Bidders</li>
							</ul>
						</nav>
					</div>
			
					<?php
					if(isset($deLBid)){
						?>
							<div class="alert alert-warning" role="alert">
								The Bid you selected is deleted !!!!
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
									<h3><i class="icon-material-outline-supervisor-account"></i> <?=$no?> Bidders</h3>
									<div class="sort-by">
										<select class="selectpicker hide-tick">
											<option>Highest First</option>
											<option>Lowest First</option>
											<option>Fastest First</option>
										</select>
									</div>
								</div>

								<div class="content">
									<ul class="dashboard-box-list">
									<?php
										$counter=0;
										foreach($biddingDetails as $biddingDetail)
										{
											$counter++;
											
										?>
											<li>
												<form method="post">
												<!-- Overview -->
													<div class="freelancer-overview manage-candidates">
														<div class="freelancer-overview-inner">

															<!-- Avatar -->
															<div class="freelancer-avatar">
																<div class="verified-badge"></div>
																<a href="#"><img src="images/user-avatar-big-02.jpg" alt=""></a>
															</div>

															<!-- Name -->
															<div class="freelancer-name">
																<?php
																	$nationality = $biddingDetail['nationality'];
																	$country_code = strtolower($nationality);
																?>
																<h4><a href="#"><?=$biddingDetail['f_name']?> <?=$biddingDetail['l_name']?><img class="flag" src="http://api.hostip.info/images/flags/<?=$country_code?>.gif" alt="" title="<?=$biddingDetail['nationality']?>" data-tippy-placement="top"/></a></h4>
																<input type="hidden" id="contractor_name<?=$counter?>" value="<?=$biddingDetail['f_name']?> <?=$biddingDetail['l_name']?>">
																<input type="hidden" id="contractor_id<?=$counter?>" value="<?=$biddingDetail['c_id']?>">
																<input type="hidden" id="bid_id<?=$counter?>" value="<?=$biddingDetail['bid_id']?>">
																<input type="hidden" id="contractor_bid<?=$counter?>" value="<?=$biddingDetail['bid_expected']?>">
																<!-- Details -->
																<span class="freelancer-detail-item"><a href="#"><i class="icon-feather-mail"></i><?=$biddingDetail['email']?></a></span>
																<span class="freelancer-detail-item"><i class="icon-feather-phone"></i><?=$biddingDetail['mobile']?></span>

																<!-- Rating -->
																<div class="freelancer-rating">
																	<div class="star-rating" data-rating="<?=$biddingDetail['rating']?>"></div>
																	<!-- <span class="company-not-rated">Minimum of 3 votes required</span> -->
																</div>
																<?php
																	$time_type = $biddingDetail['time_type'];
																	$t_type='';
																	switch ($time_type){
																		case 1:
																			$t_type = 'hours';
																			break;
																		case 2:
																			$t_type = 'days';
																			break;
																	}
																?>
																<!-- Bid Details -->
																<ul class="dashboard-task-info bid-info">
																	<li><strong>$<?=$biddingDetail['bid_expected']?></strong><span>Fixed Price</span></li>
																	<li><strong><?=$biddingDetail['time_no']?> <?=$t_type?></strong><span>Delivery Time</span></li>
																</ul>

																<!-- Buttons -->
																
																
																	<div class="buttons-to-right always-visible margin-top-25 margin-bottom-0">
																		<button type="button" name="accept_bid" onclick="setValues(<?=$counter?>)" value="<?=$biddingDetail['bid_id']?>" class="button ripple-effect"><i class="icon-material-outline-check"></i> Accept Offer</button>
																		<a href="#small-dialog-1" style="visibility:hidden" id="popUp_link<?=$counter?>" class="popup-with-zoom-anim button ripple-effect"><i class="icon-material-outline-check"></i> Accept Offer</a>
																		<!-- <a href="#small-dialog-2" class="popup-with-zoom-anim button dark ripple-effect"><i class="icon-feather-mail"></i> Send Message</a> -->
																		<button name="delete_bid" type="submit" value="<?=$biddingDetail['bid_id']?>" class="button gray ripple-effect ico" title="Remove Bid" data-tippy-placement="top"><i class="icon-feather-trash-2"></i></button>
																		

																	</div>
																
															</div>
														</div>
													</div>
												</form>
											</li>
										<?php
										}
										?>
									</ul>
								</div>
							</div>
						</div>

					</div>
					<!-- Row / End -->

					<!-- Footer -->
					<div class="dashboard-footer-spacer"></div>
					<div class="small-footer margin-top-15">
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


	<!-- Bid Acceptance Popup
	================================================== -->
	<div id="small-dialog-1" class="zoom-anim-dialog mfp-hide dialog-with-tabs">

		<!--Tabs -->
		<div class="sign-in-form">

			<ul class="popup-tabs-nav">
				<li><a href="#tab1">Accept Offer</a></li>
			</ul>

			<div class="popup-tabs-container">

				<!-- Tab -->
				<div class="popup-tab-content" id="tab">
					
					<!-- Welcome Text -->
					<div class="welcome-text">
						<h3 id="name">Accept Offer From David</h3>
						<div class="bid-acceptance margin-top-15">
							<p id="bid_price">$3200</p>
						</div>
					</div>

					<form id="terms" method="post">
						<div class="radio">
							<input id="radio-1" name="radio" type="radio" required>
							<label for="radio-1"><span class="radio-label"></span>  I have read and agree to the Terms and Conditions</label>
							<input type="hidden" id="c_id" name="c_id">
							<input type="hidden" id="b_id" name="b_id">
							<input type="hidden" id="t_id" name="t_id" value="<?=$t_id?>">
						</div>
					</form>

					<!-- Button -->
					<button name="accepted_bid" class="margin-top-15 button full-width button-sliding-icon ripple-effect" type="submit" form="terms">Accept <i class="icon-material-outline-arrow-right-alt"></i></button>
				
				</div>

			</div>
		</div>
	</div>
	<!-- Bid Acceptance Popup / End -->


	<!-- Send Direct Message Popup
	================================================== -->
	<div id="small-dialog-2" class="zoom-anim-dialog mfp-hide dialog-with-tabs">

		<!--Tabs -->
		<div class="sign-in-form">

			<ul class="popup-tabs-nav">
				<li><a href="#tab2">Send Message</a></li>
			</ul>

			<div class="popup-tabs-container">

				<!-- Tab -->
				<div class="popup-tab-content" id="tab2">
					
					<!-- Welcome Text -->
					<div class="welcome-text">
						<h3>Direct Message To David</h3>
					</div>
						
					<!-- Form -->
					<form method="post" id="send-pm">
						<textarea name="textarea" cols="10" placeholder="Message" class="with-border" required></textarea>
					</form>
					
					<!-- Button -->
					<button class="button full-width button-sliding-icon ripple-effect" type="submit" form="send-pm">Send <i class="icon-material-outline-arrow-right-alt"></i></button>

				</div>

			</div>
		</div>
	</div>
<!-- Send Direct Message Popup / End -->

<?php
    require_once 'js-links.php';
?>


<script>

	function setValues(counter){
		var contractor_name = $("#contractor_name"+counter).val();
		var contractor_id = $("#contractor_id"+counter).val();
		var contractor_bid = $("#contractor_bid"+counter).val();
		var bid_id = $("#bid_id"+counter).val();
		$("#c_id").val(contractor_id);
		$("#b_id").val(bid_id);

		$('#name').html(`Accept Offer From ${contractor_name}`);
		$('#bid_price').html(`$${contractor_bid}`);
		$('#popUp_link'+counter).click();
	}

	

</script>
