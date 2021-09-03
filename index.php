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
					?>
					<!-- Category Box -->
							<div class="col-lg-3 caty">	
								<a href="#" class="category-box">
									<div class="category-box-icon">
										<img src="<?=$cforcat['icon']?>"/>
									</div>
									<!-- <div class="category-box-counter">612</div> -->
									<div class="category-box-content">
										<h3><?=$cforcat['category']?></h3>
										
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

<br><br>
<?php
    require_once 'js-links.php';
    require_once 'footer.php';

?>