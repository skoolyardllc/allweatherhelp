<!-- Footer

================================================== -->

<div id="footer">

	

	<!-- Footer Top Section -->

	<div class="footer-top-section">

		<div class="container">

			<div class="row">

				<div class="col-xl-12">



					<!-- Footer Rows Container -->

					<div class="footer-rows-container">

						

						<!-- Left Side -->

						<div class="footer-rows-left">

							<div class="footer-row" style="margin-bottom:80px">

								<div style="height:100px;margin-bottom:-50px">

									<img src="images/cyberflow-logo-1.png"  alt="" style="height:20vh" >

								</div>

							</div>

						</div>

						

						<!-- Right Side -->

						<div class="footer-rows-right">



							<!-- Social Icons -->

							<div class="footer-row">

								<div class="footer-row-inner">

									<ul class="footer-social-links">

										<li>

											<a href="#" title="Facebook" data-tippy-placement="bottom" data-tippy-theme="light">

												<i class="icon-brand-facebook-f"></i>

											</a>

										</li>

										<li>

											<a href="#" title="Twitter" data-tippy-placement="bottom" data-tippy-theme="light">

												<i class="icon-brand-twitter"></i>

											</a>

										</li>

										<li>

											<a href="#" title="Google Plus" data-tippy-placement="bottom" data-tippy-theme="light">

												<i class="icon-brand-google-plus-g"></i>

											</a>

										</li>

										<li>

											<a href="#" title="LinkedIn" data-tippy-placement="bottom" data-tippy-theme="light">

												<i class="icon-brand-linkedin-in"></i>

											</a>

										</li>

									</ul>

									<div class="clearfix"></div>

								</div>

							</div>

							

							<!-- Language Switcher -->

							<!-- <div class="footer-row">

								<div class="footer-row-inner">

									<select class="selectpicker language-switcher" data-selected-text-format="count" data-size="5">

										<option selected>English</option>

										<option>Français</option>

										<option>Español</option>

										<option>Deutsch</option>

									</select>

								</div>

							</div> -->

						</div>



					</div>

					<!-- Footer Rows Container / End -->

				</div>

			</div>

		</div>

	</div>

	<!-- Footer Top Section / End -->



	<!-- Footer Middle Section -->

	<div class="footer-middle-section" style="margin-top:20px">

		<div class="container" >

			<div class="row" >



				<?php
				if(isset($_SESSION['user_signed_in']))

				{

					switch($TYPE)

					{

						case 2:

							?>

								<div class="col-xl-3 col-lg-3 col-md-3">

									<div class="footer-links">

									

										<h3>For Business / LLC</h3>

										<ul>

											<li><a href="search_task"><span>Browse Tasks</span></a></li>

											<li><a href="active_task_bids"><span>Active Bids</span></a></li>

											<li><a href="active_task"><span>Active Tasks</span></a></li>

											<li><a href="bookmark"><span>My Bookmarks</span></a></li>

										</ul>

									</div>

								</div>

							<?php

							break;



						case 3:

							?>

								<div class="col-xl-3 col-lg-3 col-md-3">

									<div class="footer-links">

									

										<h3>For Contractor</h3>

										<ul>

											<li><a href="search_task"><span>Browse Tasks</span></a></li>

											<li><a href="active_task_bids"><span>Active Bids</span></a></li>

											<li><a href="active_task"><span>Active Tasks</span></a></li>

											<li><a href="bookmark"><span>My Bookmarks</span></a></li>	

										</ul>

									</div>

								</div>

							<?php

							break;



						case 5:

							?>

								<div class="col-xl-3 col-lg-3 col-md-3">

									<div class="footer-links">

									

										<h3>For Customer</h3>

										<ul>

											<li><a href="post_task"><span>Post Task</span></a></li>

											<li><a href="manage_task"><span>Manage Task</span></a></li>

											<li><a href="see"><span>Reviews</span></a></li>

											<li><a href="bookmarks"><span>My Bookmarks</span></a></li>

										</ul>

									</div>

								</div>

							<?php

							break;



					}

				}

				?>

				

				<div class="col-xl-3 col-lg-3 col-md-3">

					<div class="footer-links">

						<h3>Helpful Links</h3>

						<ul>

							<li><a href="home"><span>Home</span></a></li>

							<li><a href="#"><span>Contact</span></a></li>

							<li><a href="#"><span>Privacy Policy</span></a></li>

							<li><a href="#"><span>Terms of Use</span></a></li>

						</ul>

					</div>

				</div>



				 

				<div class="col-xl-2 col-lg-2 col-md-3">

					<div class="footer-links">

						<h3>Account</h3>

						<ul>

						<?php

						if(isset($_SESSION['user_signed_in']))

						{

						?>

							<li><a href="logout"><span>Log Out</span></a></li>

							<li><a href="editProfile"><span>My Account</span></a></li>

						<?php

						}

						else

						{

						?>

							<li><a href="login.php"><span>Log In</span></a></li>



						<?php

						}

						?>

							

						</ul>

					</div>

				</div>



				 

				<div class="col-xl-4 col-lg-4 col-md-12">

					<h3><i class="icon-feather-mail"></i> Sign Up For a Newsletter</h3>

					<p>Weekly breaking news, analysis and cutting edge advices on job searching.</p>

					<form action="#" method="get" class="newsletter">

						<input type="text" name="fname" placeholder="Enter your email address">

						<button type="submit"><i class="icon-feather-arrow-right"></i></button>

					</form>

				</div>

			</div>

		</div>

	</div>

	<!-- Footer Middle Section / End -->

	

	<!-- Footer Copyrights -->

	<div class="footer-bottom-section">

		<div class="container">

			<div class="row">

			</div>

		</div>

	</div>

	<!-- Footer Copyrights / End -->



</div>

<!-- Footer / End -->



</div>

<!-- Wrapper / End -->







</body>


</html>