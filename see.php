<?php

    require_once 'header.php';

    require_once 'navbar.php';



    $user = '';

    

    $sql = "select count((at.id)) as noOfRows from accepted_task at,post_task pt,ratings r where at.c_id='$USER_ID' and at.t_id=pt.id  and r.u_id=at.c_id and r.t_id=pt.id";

    if($TYPE == 5)

    {

        $sql = "select count(e.id) as noOfRows from employer_reviews e , post_task p where c_id=$USER_ID and e.t_id = p.id ";

    }



    // echo $sql ;

    if($res = $conn->query($sql))

    {

        $noofresults = $res->fetch_assoc();

    }

    else

    {

        $error =  $conn->query($sql);

    }

    $noofresults['noOfRows'];

    $results_per_page = 10;  

    $number_of_page = ceil ($noofresults['noOfRows'] / $results_per_page);

    if(isset($_GET['page'])&& !empty($_GET['page']))

    {

        $page = $_GET['page'];

    }

    else

    {

        $page = 1;

    }

    $page_first_result = ($page-1) * $results_per_page;







    switch($TYPE){

        //Employer/Business

        case 5:

            

            $sql = "select e.* , p.id , p.t_name from employer_reviews e , post_task p where c_id=$USER_ID and e.t_id = p.id order by e.id desc limit $page_first_result , $results_per_page";

            if ($result = $conn->query($sql)) {

                if ($result->num_rows) {

                    while ($row = $result->fetch_assoc()) {

                        $reviewsss[] = $row;

                    }

                }

            }

            

            break;

        

        //Contractor

        case 2:

            $sql = "select distinct at.* ,pt.*,r.* from accepted_task at,post_task pt,ratings r where at.c_id='$USER_ID' and at.t_id=pt.id  and r.u_id=at.c_id and r.t_id=pt.id order by at.id desc limit $page_first_result , $results_per_page";

            if($result =$conn->query($sql))

            {   

                if($result->num_rows)

                {

                    $count=0;

                    while($row=$result->fetch_assoc()){

                        $taskCompleted[] = $row;

                        $count++;

                    }

                }

            }

            break;

        case 3:

            $sql = "select distinct at.* ,pt.*,r.* from accepted_task at,post_task pt,ratings r where at.c_id='$USER_ID' and at.t_id=pt.id  and r.u_id=at.c_id and r.t_id=pt.id order by at.id desc limit $page_first_result , $results_per_page";

            if($result =$conn->query($sql))

            {   

                if($result->num_rows)

                {

                    $count=0;

                    while($row=$result->fetch_assoc()){

                        $taskCompleted[] = $row;

                        $count++;

                    }

                }

            }

            break;

        

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

                        <div class="boxed-list margin-bottom-60">

                    <div class="boxed-list-headline">

                        <h3><i class="icon-material-outline-thumb-up"></i> Your reviews</h3>

                    </div>

                    <ul class="boxed-list-ul">

                        <?php

                            if (isset($reviewsss))

                            {

                                foreach($reviewsss as $task){

                                ?>

                                    <li>

                                        <div class="boxed-list-item">

                                            <!-- Content -->

                                            <div class="item-content">

                                                <h4><?=$task['t_name']?><span>Rated as Employer</span></h4>

                                                <div class="item-details margin-top-10">

                                                    <div class="star-rating" data-rating="<?=$task['ratings']?>"></div>

                                                    <?php

                                                        $timestamp = strtotime($task['time_stamp']);

                                                        $date = date('M Y', $timestamp);

                                                    ?>



                                                    <div class="detail-item"><i class="icon-material-outline-date-range"></i><?=$date?></div>

                                                </div>

                                                <div class="item-description">

                                                    <p> Clarity in Specifications : <?=$task['speci']?>/5</p>

                                                    <p> Communication : <?=$task['comm']?>/5</p>

                                                    <p> Payment Promptness : <?=$task['payment']?>/5</p>

                                                    <p> Professionalism : <?=$task['profess']?>/5</p>

                                                    <p> Comment : <?=$task['review']?></p>



                                                </div>

                                            </div>

                                        </div>

                                    </li>

                                <?php

                                }

                            

                        ?>

                        

                    </ul>

                    <?php

                        }

                        else

                        {

                    ?>

                    <ul class="boxed-list-ul">

                        <?php

                            foreach($taskCompleted as $task){

                                if($task['review'] != '')

                                {

                                    $job='No';

                                    $recommend='No';

                                    $time='No';

                                    $budget='No';

                                    if($task['recomendation'] == 1)

                                    {

                                        $recommend = 'Yes';

                                    }

                                    if($task['on_time'] == 1)

                                    {

                                        $time = 'Yes';

                                    }

                                    if($task['on_budget'] == 1)

                                    {

                                        $budget = 'Yes';

                                    }

                                ?>

                        <li>

                            <div class="boxed-list-item">

                                <!-- Content -->

                                <div class="item-content">

                                    <h4><?=$task['t_name']?><span>Rated as Freelancer</span></h4>

                                    <div class="item-details margin-top-10">

                                        <div class="star-rating" data-rating="<?=$task['rating']?>"></div>

                                        <?php

                                                        $timestamp = strtotime($task['time_stamp']);

                                                        $date = date('M Y', $timestamp);

                                                    ?>

                                        <div class="detail-item"><i

                                                class="icon-material-outline-date-range"></i><?=$date?></div>

                                    </div>

                                    <div class="item-description">

                                        <p>

                                        <?php

                                        if($task['job_success'] == 1)

                                        { 

                                        ?>

                                            <i class="fa fa-check" style="color: green;" aria-hidden="true"></i> Job Success

                                        <?php

                                        }

                                        else if($task['job_success'] == 0)

                                        {

                                        ?>

                                            <i class="fa fa-times" style="color: red;" aria-hidden="true"></i>&nbspJob Success

                                        <?php

                                        }

                                        ?>

                                        </p>

                                        <p>

                                        <?php

                                        if($task['on_time'] == 1)

                                        { 

                                        ?>

                                            <i class="fa fa-check" style="color: green;" aria-hidden="true"></i> On Time

                                        <?php

                                        }

                                        else if($task['on_time'] == 0)

                                        {

                                        ?>

                                            <i class="fa fa-times" style="color: red;" aria-hidden="true"></i>&nbspOn Time

                                        <?php

                                        }

                                        ?>

                                        </p>

                                        

                                        <p>

                                        <?php

                                        if($task['on_budget'] == 1)

                                        { 

                                        ?>

                                            <i class="fa fa-check" style="color: green;" aria-hidden="true"></i>On Budget

                                        <?php

                                        }

                                        else if($task['on_budget'] == 0)

                                        {

                                        ?>

                                            <i class="fa fa-times" style="color: red;" aria-hidden="true"></i>&nbspOn Budget

                                        <?php

                                        }

                                        ?>

                                        </p>

                                        <p>

                                        <?php

                                        if($task['recomendation'] == 1)

                                        { 

                                        ?>

                                            <i class="fa fa-check" style="color: green;" aria-hidden="true"></i> Recommendations

                                        <?php

                                        }

                                        else if($task['recomendation'] == 0)

                                        {

                                        ?>

                                            <i class="fa fa-times" style="color: red;" aria-hidden="true"></i> &nbspRecommendations

                                        <?php

                                        }

                                        ?>

                                        </p><br>

                                        <label>Review :</label><br>

                                        <textarea name="review" style="color:black; resize: none;" id="review" readonly><?=$task['review']?></textarea>

                                    </div>

                                </div>

                            </div>

                        </li>

                        <?php

                                }

                            }

                        }

                        ?>



                    </ul>

					</div>

                </div>

                </div>



					<!-- Pagination -->

					<div class="clearfix"></div>

					<div class="pagination-container margin-top-40 margin-bottom-0">

						<nav class="pagination">

							<ul>

                                <?php

                                    for($page = 1; $page<= $number_of_page; $page++) 

                                    {  

                                        $active = "";

                                        if(isset($_GET['page']) &&  $page == $_GET['page'] )

                                        {

                                            $active = "current-page";

                                        }

                                        else if(!isset($_GET['page']) && $page == 1)

                                        {

                                            $active = "current-page";

                                        }

                                        else

                                        {

                                            $active = "";

                                        }

                                        ?>

                                            <li><a href="see?page=<?=$page?>" class="<?=$active?> ripple-effect"><?=$page?></a></li>

                                        <?php

                                    

                                    }  

                                

                                ?>

								<!-- <li><a href="#" class="ripple-effect current-page">1</a></li>

								<li><a href="#" class="ripple-effect">2</a></li>

								<li><a href="#" class="ripple-effect">3</a></li>

								<li class="pagination-arrow"><a href="#" class="ripple-effect"><i class="icon-material-outline-keyboard-arrow-right"></i></a></li> -->

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

	$("#reviews").addClass('active');



</script>