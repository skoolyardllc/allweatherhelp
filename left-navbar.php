<?php

	

	

	$free='';

	// switch($TYPE)

	// {

	// 	case 2:

	// 		$sql="SELECT count(id) as count from employer_reviews where c_id='$USER_ID'";

	// 		$emp='Freelancer';

	// 		break;



	// 	case 3:

	// 		$sql="SELECT count(id) as count from accepted_task where c_id='$USER_ID'";

	// 		$emp='Employer';

	// 		break;



	// }

	// if($result=$conn->query($sql))

    // {

    //     if($result->num_rows>0)

    //     {

    //         $row=$result->fetch_assoc();

	// 		$userCount=$row['count'];

    //     }

 

    // }







?>





<!-- Navigation -->

<div class="dashboard-nav">

	<div class="dashboard-nav-inner">



		<ul data-submenu-title="Start">

			<li class="active" id="dashboard"><a href="dashboard"><i class="icon-material-outline-dashboard"></i> Dashboard</a></li>

			<li class="" id="bookmarks"><a href="bookmark"><i class="icon-material-outline-star-border"></i> Bookmarks</a></li>

			<li class="" id="reviews"><a href="see"><i class="icon-material-outline-rate-review"></i> Reviews</a></li>

		</ul>

		

		<ul data-submenu-title="Organize and Manage">

			<?php  

			$adm='';

			$bank='';

			$href = "";

			switch($TYPE){

				case 2:

					$adm='show';

					$href = "milestone_transaction4emp";

				?>

						

						<li class="" id="tasks"><a href="#"><i class="icon-material-outline-assignment"></i> Tasks</a>

							<ul>

								<li><a href="search_task">Find Tasks </a></li>

								<li><a href="active_task_bids">My Active Bids </a></li>

							</ul>	

						</li>						

						<li class="" id="tasks"><a href="active_task"><i class="icon-material-outline-assignment"></i>Active Tasks </a></li>



						 <li id="transactions"><a href="milestone_transaction4emp"><i class="fas fa-dollar-sign"></i> Transactions </a></li>

						<!-- <li classs="milestone"><a href="mil"><i class="bi bi-flag"></i>Milestone</a></li> -->

				<?php

					break;

					case 3:

						$adm='none';

						$href = "milestone_transaction4emp";



					?>

						

						<li class="" id="tasks"><a href="#"><i class="icon-material-outline-assignment"></i> Tasks</a>

							<ul>

								<li><a href="search_task">Find Tasks </a></li>

								<li><a href="active_task_bids">My Active Bids </a></li>

							</ul>	

						</li>

						<li class="" id="tasks"><a href="active_task"><i class="icon-material-outline-assignment"></i>Active Tasks </a></li>



						 <li id="transactions"><a href="milestone_transaction4emp"><i class="fas fa-dollar-sign"></i> Transactions </a></li>

						<!-- <li classs="milestone"><a href="mil"><i class="bi bi-flag"></i>Milestone</a></li> -->

					<?php

						break;

						case 5:

							$adm='none';

							$bank='show';

							$href = "milestone_transaction";



					?>

						<li class="" id="tasks"><a href="manage_task"><i class="icon-material-outline-assignment"></i>Manage Tasks </a></li>

						<li class="post_task"><a href="post_task"><i class="bi bi-plus"></i>Post A Task</a></li>



						 <li id="transactions"><a href="<?=$href?>"><i class="fas fa-dollar-sign"></i> Transactions </a></li>

					<?php

							break;

				}

				?>



			

		</ul>



		<ul data-submenu-title="Account">

			<li class="" id="settings">

				<a href="#"><i class="icon-material-outline-settings"></i> Settings</a>

				<ul>

						<li><a href="editProfile">Edit Profile</a></li>

				</ul>	

				<ul style="display:<?=$bank?>">

						<li><a href="banking_details">Banking Details </a></li>

				</ul>

				<ul style="display:<?=$adm?>">

						<li><a href="adm">Administration Details</a></li>

				</ul>	

			</li>

			<li><a href="logout"><i class="icon-material-outline-power-settings-new"></i> Logout</a></li>

		</ul>

		

	</div>

</div>

<!-- Navigation / End -->



<script>

	// $("#dashboard").removeClass('active');

	// $("#bookmarks").removeClass('active');

	// $("#reviews").removeClass('active');

	// $("#jobs").removeClass('active');

	// $("#tasks").removeClass('active');

	// $("#settings").removeClass('active');

	// $("#milestone").removeClass('active');

	// $("#dashboard").addClass('active');

</script>