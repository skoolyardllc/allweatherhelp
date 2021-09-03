<?php   
require_once 'header.php';
require_once 'navbar.php';

$sql = "select count(id) as jobs from post_task";
if($result = $conn->query($sql))
{
	if($result->num_rows)
	{
		$jobs = $result->fetch_assoc();
	}
}
else{
	echo $conn->error;
}

$sql = "select count(id) as contractor from users where type = 3";
if($result = $conn->query($sql))
{
	if($result->num_rows)
	{
		$cons = $result->fetch_assoc();
	}
}
else
{
	echo $conn->error;
}

$sql = "select count(id) as emp from users where type = 2";
if($result = $conn->query($sql))
{
	if($result->num_rows)
	{
		$emps = $result->fetch_assoc();
	}
}
else
{
	echo $conn->error;
}

$sql = "select * from task_category";
if($result = $conn->query($sql))
{
	while($row = $result->fetch_assoc())
	{
		
		$cato[] = $row;
	}
	// print_r($cato);
}
else
{
	echo $conn->error;
}
$aajkadin = date("Y-m-d");

$forcont = '';
$bache = '';
$link = 'javascript:;';
$sql = "select *, post_task.id as taskId from post_task,task_category where post_task.end_date > '$aajkadin' and post_task.t_catagory=task_category.id";
switch($TYPE)
{
	case 2:
		$forcont = 'show';
		$bache = 'none';
		$link = 'search_task';
		$sql = "select *, post_task.id as taskId from post_task,task_category where post_task.end_date > '$aajkadin' and post_task.t_catagory=task_category.id and post_task.cat_type=1";
		break;

	case 3:
		$forcont = 'show';
		$bache = 'none';
		$link = 'search_task';
		$sql = "select *, post_task.id as taskId from post_task,task_category where post_task.end_date > '$aajkadin' and post_task.t_catagory=task_category.id and post_task.cat_type=1";
		break;

	case 5:
		$forcont = 'none';
		$bache = 'show';
		$link = '#';
		break;
}

if($result = $conn->query($sql))
{
    
    while($row=$result->fetch_assoc())
    {
        $work[] = $row;
    }
    
    
}
else
{
	echo $conn->error;
}

$sql = "select u.*, up.* from users u , user_profile up where u.id = up.u_id and (u.type = 3 or u.type=2)";
if($result = $conn->query($sql))
{
    // echo "hello";
    while($row=$result->fetch_assoc())
    {
        $thekedar[] = $row;
        
    }
    // print_r($thekedar);
    
}
else
{
	echo $conn->error;
}
?>
<!-- Wrapper -->
<div id="wrapper">

<!-- Intro Banner
================================================== -->
<!-- add class "disable-gradient" to enable consistent background overlay -->
<div class="intro-banner" data-background-image="images/bg.jpg">
	<div class="container">
		
		<!-- Intro Headline -->
		<div class="row">
			<div class="col-md-12">
				<div class="banner-headline">
					<h3>
						<strong>Hire experts or be hired for any job, any time.</strong>
						<br>
						<span>Thousands of small businesses use <strong class="color">AWH</strong> to turn their ideas into reality.</span>
					</h3>
				</div>
			</div>
		</div>
		
		<!-- Search Bar -->
		<div class="row">
			<div class="col-md-12">
				<div class="intro-banner-search-form margin-top-95">

					<!-- Search Field -->
					<!-- <div class="intro-search-field with-autocomplete">
						<label for="autocomplete-input" class="field-title ripple-effect">Where?</label>
						<div class="input-with-icon">
							<input id="" type="text" placeholder="Online Job">
							<i class="icon-material-outline-location-on"></i>
						</div>
					</div> -->

					<!-- Search Field -->
					<!-- <div class="intro-search-field">
						<label for ="intro-keywords" class="field-title ripple-effect">What job you want?</label>
						<input id="intro-keywords" type="text" placeholder="Job Title or Keywords">
					</div> -->

					<!-- Button -->
					<!-- <div class="intro-search-button">
						<button class="button ripple-effect" onclick="window.location.href='jobs-list-layout-full-page-map.html'">Search</button>
					</div> -->
				</div>
			</div>
		</div>

		<!-- Stats -->
		<div class="row">
			<div class="col-md-12">
				<ul class="intro-stats margin-top-45 hide-under-992px">
					<li>
						<strong class="counter"><?=$jobs['jobs']?></strong>
						<span>Tasks Posted</span>
					</li>
					<li>
						<strong class="counter"><?=$cons['contractor']?></strong>
						<span>Contractors</span>
					</li>
					<li>
						<strong class="counter"><?=$emps['emp']?></strong>
						<span>Business / LLC</span>
					</li>
				</ul>
			</div>
		</div>

	</div>
</div>


<!-- Content
================================================== -->
<!-- Category Boxes -->
<div class="section margin-top-65">
	<div class="container">
		<div class="row">
			<div class="col-xl-12">

				<div class="section-headline centered margin-bottom-15">
					<h3> Job Categories</h3>
				</div>

				<!-- Category Boxes Container -->
				<div class="categories-container">
					<div class="row">
					
					<?php
						if(isset($cato))
						{
							foreach($cato as $cforcat)
							{
								$paragraph = '';
								switch($cforcat['type'])
								{
									case 1:
										$paragraph = 'Open For all Users!!';
										break;

									case 2:
										$paragraph = 'Open for only Business / LLC!';
										break;
								}
								$categoryName = $conn->real_escape_string($cforcat['id']);
								// switch($TYPE)
								// {
								// 	case 2:
								// 		$link = "search_task?category=$categoryName";
								// 		break;

								// 	case 3:
								// 		$link = "search_task?category=$categoryName";
								// 		break;
								// }
								$link = "javascript:;";
								if($TYPE == 3 && $cforcat['type'] == 1) 
								{
									$link = "search_task?category=$categoryName";
								}
								if($TYPE == 2 )
								{
									$link = "search_task?category=$categoryName";
								}
					?>
					<!-- Category Box -->
							<div class="col-lg-3 caty">	
								<a href="<?=$link?>" class="category-box">
									<div class="category-box-icon" >
										<img src="<?=$cforcat['icon']?>"/>
									</div>
									<!-- <div class="category-box-counter">612</div> -->
									<div class="category-box-content">
										<h3 style="text-decoration:none !important"><?=$cforcat['category']?></h3>
										
										<p><?=$paragraph?></p>
									</div>
								</a>
							</div>
					<?php
							}
						}								
					?>		

					</div>

				</div>

			</div>
		</div>
	</div>
</div>
<!-- Category Boxes / End -->


<!-- Features Jobs -->
<div class="section gray margin-top-45 padding-top-65 padding-bottom-75" style="display:<?=$forcont?>">
	<div class="container">
		<div class="row">
			<div class="col-xl-12">
				
				<!-- Section Headline -->
				<div class="section-headline margin-top-0 margin-bottom-35">
					<h3>Featured Jobs</h3>
					<a href="search_task" class="headline-link">Browse All Jobs</a>
				</div>
				
				<!-- Jobs Container -->
				<div class="listings-container compact-list-layout margin-top-35">
					
					<!-- Job Listing -->
					<?php
                        if(isset($work))
                        {
                            foreach($work as $w)
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
					<a href="bid_task?token=<?=$w['taskId']?>" class="job-listing with-apply-button">

						<!-- Job Listing Details -->
						<div class="job-listing-details">

							<!-- Logo -->
							<!-- <div class="job-listing-company-logo">
								<img src="images/company-logo-01.png" alt="">
							</div> -->

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

							<!-- Apply Button -->
							<span class="list-apply-button ripple-effect">Apply Now</span>
						</div>
					</a>	
					<?php
							}
						}
					
					?>


					

				</div>
				<!-- Jobs Container / End -->

			</div>
		</div>
	</div>
</div>
<!-- Featured Jobs / End -->


<!-- Features Cities -->

<!-- Features Cities / End -->


<!-- Highest Rated Freelancers -->
<div class="section gray padding-top-65 padding-bottom-70 full-width-carousel-fix" style="display:<?=$bache?>">
	<div class="container">
		<div class="row">

			<div class="col-xl-12">
				<!-- Section Headline -->
				<div class="section-headline margin-top-0 margin-bottom-25">
					<h3>Some Workers</h3>
					<a href="freelancer" class="headline-link">Browse All </a>
				</div>
			</div>

			<div class="col-xl-12">
				<div class="default-slick-carousel freelancers-container freelancers-grid-layout">
			<?php
				if(isset($thekedar))
                    {
                        foreach($thekedar as $tk)
                        {
							$id = $tk['u_id'];
							$sql = "SELECT CAST(AVG(rating) AS DECIMAL(10,1)) as hell FROM ratings where u_id = $id";
							if($resu = $conn->query($sql))
							{
							    if($resu->num_rows)
							    {
							        $row = $resu->fetch_assoc();
							        $hell = $row; 
							    }
							}
							else
							{
								echo $conn->error;
							}
                            $bday = '';
                            if($tk['type'] == 2)
                            {
                                $bday = 'Business / LLC';
                            }
                            else
                            {
                                $bday = 'Contractor';
                            }
                            if($tk['f_name'] != NULL)
                            {
								$nationality = $tk['nationality'];
                                $country_code = strtolower($nationality);
								
				?>
					<!--Freelancer -->
					<div class="freelancer">

						<!-- Overview -->
						<div class="freelancer-overview">
							<div class="freelancer-overview-inner">
								
								<!-- Bookmark Icon -->
								<!-- <span class="bookmark-icon"></span> -->
								
								<!-- Avatar -->
								<div class="freelancer-avatar">
									<div class="verified-badge"></div>
									<a href="profile?token=<?=$tk['u_id']?>"><img src="<?=$tk['avtar']?>" alt="" height="90rem"></a>
								</div>

								<!-- Name -->
								<div class="freelancer-name">
									<h4><a href="profile?token=<?=$tk['u_id']?>"><?=$tk['f_name']?> <?=$tk['l_name']?> <img class="flag" src="http://api.hostip.info/images/flags/<?= $country_code ?>.gif" alt="" title="" data-tippy-placement="top"></a></h4>
									<span><?=$tk['tagline']?></span>
									<br>
                                    <strong><?=$bday?></strong>
									<?php
										if($hell['hell'] == 0)
										{
											?>
												<p><i class="bi bi-star-fill" style="color:gold"></i> No Ratings</p>
											<?php
										}
										else
										{
									?>
										<div class="freelancer-rating">
											<div class="star-rating" data-rating="<?=$hell['hell']?>"></div>
										</div>
									<?php
									
										}
									?>
								</div>

								<!-- Rating -->
								
							</div>
						</div>
						
						<!-- Details -->
						<div class="freelancer-details">
							<!-- <div class="freelancer-details-list">
								<ul>
									<li>Location <strong><i class="icon-material-outline-location-on"></i> </strong></li>
									<li>Rate <strong>$60 / hr</strong></li>
									<li>Job Success <strong>95%</strong></li>
								</ul>
							</div> -->
							<a href="profile?token=<?=$tk['u_id']?>" class="button button-sliding-icon ripple-effect">View Profile <i class="icon-material-outline-arrow-right-alt"></i></a>
						</div>
					</div>
					<!-- Freelancer / End -->
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
<!-- Highest Rated Freelancers / End-->


<!-- Membership Plans -->
<!-- <div class="section padding-top-60 padding-bottom-75">
	<div class="container">
		<div class="row">

			<div class="col-xl-12">
				<!-- Section Headline -->
				<!-- <div class="section-headline centered margin-top-0 margin-bottom-35">
					<h3>Membership Plans</h3>
				</div>
			</div>


			<div class="col-xl-12"> -->

				<!-- Billing Cycle  -->
				<!-- <div class="billing-cycle-radios margin-bottom-70">
					<div class="radio billed-monthly-radio">
						<input id="radio-5" name="radio-payment-type" type="radio" checked>
						<label for="radio-5"><span class="radio-label"></span> Billed Monthly</label>
					</div>

					<div class="radio billed-yearly-radio">
						<input id="radio-6" name="radio-payment-type" type="radio">
						<label for="radio-6"><span class="radio-label"></span> Billed Yearly <span class="small-label">Save 10%</span></label>
					</div>
				</div> -->

				<!-- Pricing Plans Container -->
				<!-- <div class="pricing-plans-container"> -->

					<!-- Plan -->
					<!-- <div class="pricing-plan">
						<h3>Basic Plan</h3>
						<p class="margin-top-10">One time fee for one listing or task highlighted in search results.</p>
						<div class="pricing-plan-label billed-monthly-label"><strong>$19</strong>/ monthly</div>
						<div class="pricing-plan-label billed-yearly-label"><strong>$205</strong>/ yearly</div>
						<div class="pricing-plan-features">
							<strong>Features of Basic Plan</strong>
							<ul>
								<li>1 Listing</li>
								<li>30 Days Visibility</li>
								<li>Highlighted in Search Results</li>
							</ul>
						</div>
						<a href="pages-checkout-page.html" class="button full-width margin-top-20">Buy Now</a>
					</div> -->

					<!-- Plan -->
					<!-- <div class="pricing-plan recommended">
						<div class="recommended-badge">Recommended</div>
						<h3>Standard Plan</h3>
						<p class="margin-top-10">One time fee for one listing or task highlighted in search results.</p>
						<div class="pricing-plan-label billed-monthly-label"><strong>$49</strong>/ monthly</div>
						<div class="pricing-plan-label billed-yearly-label"><strong>$529</strong>/ yearly</div>
						<div class="pricing-plan-features">
							<strong>Features of Standard Plan</strong>
							<ul>
								<li>5 Listings</li>
								<li>60 Days Visibility</li>
								<li>Highlighted in Search Results</li>
							</ul>
						</div>
						<a href="pages-checkout-page.html" class="button full-width margin-top-20">Buy Now</a>
					</div> -->

					<!-- Plan -->
					<!-- <div class="pricing-plan">
						<h3>Extended Plan</h3>
						<p class="margin-top-10">One time fee for one listing or task highlighted in search results.</p>
						<div class="pricing-plan-label billed-monthly-label"><strong>$99</strong>/ monthly</div>
						<div class="pricing-plan-label billed-yearly-label"><strong>$1069</strong>/ yearly</div>
						<div class="pricing-plan-features">
							<strong>Features of Extended Plan</strong>
							<ul>
								<li>Unlimited Listings Listing</li>
								<li>90 Days Visibility</li>
								<li>Highlighted in Search Results</li>
							</ul>
						</div>
						<a href="pages-checkout-page.html" class="button full-width margin-top-20">Buy Now</a>
					</div>
				</div>

			</div>

		</div>
	</div>
</div> -->
<!-- Membership Plans / End-->

<?php
	require_once 'js-links.php';
    require_once 'footer.php';
?>