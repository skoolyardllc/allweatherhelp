<?php 



	require_once 'header.php';

	require_once 'navbar.php';



	$user_id = $USER_ID;

		

	$useragent=$_SERVER['HTTP_USER_AGENT'];



	if(!preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))

		header('Location: ./milestone_transaction4emp');

	

	$sql = "SELECT count(mt.id) as noOfRows FROM milestones_transaction mt, user_profile up WHERE mt.contractor_id = '{$user_id}' and up.u_id = mt.customer_id  ";

	// echo $sql;	

	if($res = $conn->query($sql))

		{

			// echo $sql;

			$noofresults = $res->fetch_assoc();

		}

		else

		{

			echo $conn->error;

		}

		$noofresults['noOfRows'];

		$results_per_page = 25;  

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

	



	$query = "SELECT mt.id, mt.customer_id, mt.transaction_id, mt.transaction_detail, mt.amount, mt.status, mt.timestamp, up.f_name, up.l_name,up.avtar FROM milestones_transaction mt, user_profile up WHERE mt.contractor_id = '{$user_id}' and up.u_id = mt.customer_id ORDER BY mt.id DESC limit $page_first_result , $results_per_page";

	$result4show_transaction = $conn->query($query);

	if ($result4show_transaction->num_rows > 0) 

	{

		while($row = $result4show_transaction->fetch_assoc())

		{

			$phonedetails[] = $row;		

		}

	}



	



 ?>

<style>

	.viewonphone{display:none}

	.viewonlaptop{display:initial}

	@media only screen and (max-width: 600px) {

		.viewonphone{display:initial}

		.viewonlaptop{display:none}

		.arrows{display:none}

		#transactionsonlaptop{display:none}

		#transactionsonphone{display:initial}

	}

</style>



<div id="wrapper">

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

			<h3><i class="fas fa-balance-scale-right"></i>Transactions</h3>



			<!-- Breadcrumbs -->

			<nav id="breadcrumbs" class="dark">

				<ul>

					<li><a href="index">Home</a></li>

					<li><a href="dashboard">Dashboard</a></li>

					<li>Transactions</li>

				</ul>

			</nav>

			

		</div>

 		<div class="container">





 			<div class="mt-5 pt-5" style="padding-top:0 !important; margin-top:0 !important;">

			 <div class="card-deck">

					<div class="fun-fact" data-fun-fact-color="#36bd78" >

                        <div class="fun-fact-text">

                            <span>Total Earnings ($)</span>

                            <h3 class="total_amount">0</h3>

                        </div>

                        <div class="fun-fact-icon"><i class="fas fa-dollar-sign"></i></div>

                    </div>

					<div class="fun-fact" data-fun-fact-color="#b81b7f" >

                        <div class="fun-fact-text">

                            <span>Today's Earnings ($)</span>

                            <h3 class="total_today">0</h3>

                        </div>

                        <div class="fun-fact-icon"><i class="bi bi-credit-card"></i></div>

                    </div>

					<div class="fun-fact" data-fun-fact-color="#c91b1f" >

                        <div class="fun-fact-text">

                            <span>Total Withdraw ($)</span>

                            <h3 id="total_withdraw">0</h3>

                        </div>

                        <div class="fun-fact-icon"><i class="fas fa-money-bill-wave"></i></div>

                    </div>

					<div class="fun-fact" data-fun-fact-color="#36bd78" >

                        <div class="fun-fact-text">

                            <span>Today's Withdraw ($)</span>

                            <h3 id="withdraw_today">0</h3>

                        </div>

                        <div class="fun-fact-icon"><i class="fas fa-money-check"></i></div>

                    </div>

					<div class="fun-fact" data-fun-fact-color="#36bd78" >

                        <div class="fun-fact-text">

                            <span>Your Wallet ($)</span>

                            <h3 id="withdraw_today"><?=$wallet?></h3>

							<a href=".paymentdialog "  class="popup-with-zoom-anim button ripple-effect margin-top-5 margin-bottom-10">Withdrawn Money</a>

                        </div>

                        <div class="fun-fact-icon"><i class="fas fa-dollar-sign"></i></div>

                    </div>

					

 				</div>

 				<!-- <div class="card-deck">

 				  <div class="card bg-primary">

 				    <div class="card-body">

 				      <h2 class="card-title">Total Earnings</h2>

 				      <h3 class="total_amount"></h3>

 				    </div>

 				  </div>

 				  <div class="card bg-info">

 				    <div class="card-body">

 				      <h4 class="card-title">Today's Earning</h4>

 				      <h3 class="total_today"></h3>

 				    </div>

 				  </div> -->

 				  <!-- <div class="card">

 				    <div class="card-body">

 				      <h4 class="card-title">Card title</h4>

 				      <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This card has even longer content than the first to show that equal height action.</p>

 				    </div>

 				  </div> -->

 				</div>

 			</div>



			<div class="row" style="margin-bottom:40px" id="transactionsonphone">

			 	<div class="section-headline border-top margin-top-45 padding-top-45 margin-bottom-30">

 					<h4>Transaction Details</h4>



 				</div>

				 <div class="col-lg-12 col-md-12" style='flex:1;display:flex;justify-content:center;width:100%' >

					<div class=" ">

						<ul style="list-style:none;padding-left:0" >

						<?php

							foreach($phonedetails as $phone)

							{	

								$id = $phone['id'];

								$payment_ref = $phone['transaction_id'];

								$customer_id = $phone['customer_id'];

								$description = $phone['transaction_detail'];

								$user = $phone['f_name']." ".$phone['l_name'];

								$amount = $phone['amount'];

								$status = $phone['status'];

								$timestamp = $phone['timestamp'];

								$timestamp = date('M d Y', strtotime($phone['timestamp']));

								

								if($status == 0){

									$status = "Money Credited";

								} else {

									$status = "Money withdrawal";

								}

				

								

								$onclickphone = "viewonphone(`$payment_ref`,`$user`,`$description`,`$timestamp`,`$amount`,`$status`,`$id`)";

						

						

						?>

								<li>

								<div class='card transactionsdetails' style='width:78vw;margin-bottom:10px' onclick="{$('#morinfo<?=$id?>').click()}">

										<div class='card-body '>

											<div class='row'>

												<div class="col-lg-2" style='width:20%'>

													<div class="header-notifications-trigger">

														<a href="#">

															<div class="user-avatar"><img src="<?=$phone['avtar']?>"

																	alt="" style="  height:50px;width:50px"></div>

														</a>

													</div>

												</div>	

												<div class='col-lg-7' style='width:60%;color:grey'><h6 style='margin-bottom:1.5px;color:darkslategray'><?=$user?></h6><p style='margin-bottom:0'>  <?=$timestamp?></p></div>

												<div class='col-lg-3' style='width:20%;padding-left:0;'><span class='badge badge-success' style='margin-top:10px'>$ <?=$amount?></span></div>

											</div>

											<!-- <div class="row">

												<p style='margin-bottom:0'> Date : <?=$timestamp?></p>

											</div> -->

										</div>

										<div class='card-footer' style='display:none'>

											<a href='#small-dialog-1' id='morinfo<?=$id?>' onclick="<?=$onclickphone?>" class='btn btn-outline-primary btn-block popup-with-zoom-anim button margin-top-5 margin-bottom-10' >More Info</a>

										</div>

									</div>

								</li>

						<?php

							}	

						?>

							<center id="loader" style="margin-top:20px">

								<div class="spinner-border text-primary" role="status">

									<span class="sr-only">Loading...</span>

								</div>

							</center>

							

						</ul>

					</div>

				</div>

			</div>



		</div>

						<div class="row" style="margin-left:10px">

							<div class="col-md-12">

								<!-- Pagination -->

								<div class="pagination-container margin-top-40 margin-bottom-60">

									<nav class="pagination">

										<ul>

										<?php

											for($page = 1; $page<= $number_of_page; $page++) 

											{  

												$active = "";

												if(isset($_GET['page']) && $page == $_GET['page'] )

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

													<li><a href="transaction4emp?page=<?=$page?>" class="<?=$active?> ripple-effect"><?=$page?></a></li>

												<?php

											

											}  

										

										?>

											<!-- <li class="pagination-arrow"><a href="#" class="ripple-effect"><i class="icon-material-outline-keyboard-arrow-left"></i></a></li>

											<li><a href="#" class="ripple-effect">1</a></li>

											<li><a href="#" class="current-page ripple-effect">2</a></li>

											<li><a href="#" class="ripple-effect">3</a></li>

											<li><a href="#" class="ripple-effect">4</a></li>

											<li class="pagination-arrow"><a href="#" class="ripple-effect"><i class="icon-material-outline-keyboard-arrow-right"></i></a></li> -->

										</ul>

									</nav>

								</div>

							</div>

						</div>

		</div>

</div>

</div>

<div id="small-dialog-1" class="zoom-anim-dialog mfp-hide dialog-with-tabs 8449129">



                                                        

		<!--Tabs -->

		<div class="sign-in-form">



			



			<div class="popup-tabs-container">

			<h4 style="margin-top: 15px; margin-left: 40px;">Transaction Details</h4>

				<!-- Tab -->

				<div class="popup-tab-content" id="tab">

					

					<!-- Welcome Text -->

					<div class="" id="transactiondetails" style="display:none;">



						<!-- Headline -->

						<div class="content with-padding padding-bottom-0">



							<div class="row">

									<label >Payment Id : </label>

									<input type='text' class='form-control' value='' id="payid" disabled>

									<label >Amount : </label>

									<input type='text' class='form-control' value='' id="amount" disabled>

									<label >Payment Reference : </label>

									<input type='text' class='form-control' value='' id="payment_ref" disabled>

									<label >Description : </label>

									<input type='text' class='form-control' value='' id="description" disabled>

									<label >By : </label>

									<input type='text' class='form-control' value='' id="user" disabled>

									<label >Status : </label>

									<input type='text' class='form-control' value='' id="status" disabled>

									<label >Date : </label>

									<input type='text' class='form-control' value='' id="date" disabled>

									

							</div>



						</div>



					</div>

				</div>



			</div>

		</div>

</div>





<div id="small-dialog" class="zoom-anim-dialog mfp-hide dialog-with-tabs paymentdialog">



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



<?php

    require_once 'js-links.php';

?>



<script>



	$("#dashboard").removeClass('active');

	$("#bookmarks").removeClass('active');

	$("#reviews").removeClass('active');

	$("#jobs").removeClass('active');

	$("#tasks").removeClass('active');

	$("#settings").removeClass('active');

    $("#transaction").removeClass('active');

	$("#milestone").removeClass('active');

	$("#transaction").addClass('active');

	//alert('hi there');

	$(document).ready(function(event) {

					 

		$.get('milestone_show_transaction4emp.php?user_id=<?= $USER_ID ?>', function(response) {

			

			$("#loader").remove();

			$('.total_amount').html(response.total_amount);

			$('.total_today').html(response.total_today);

			$('#total_withdraw').html(response.withdraw_total);

			// console.log()

			$('#withdraw_today').html(response.withdraw_today);

		}, "JSON");

	

})/*read end*/



function viewonphone(payment_ref,user,description,time,amount,status,id)

{

	$("#transactiondetails").show();

	$("#payid").val(id);

	$("#payment_ref").val(payment_ref);

	$("#user").val(user);

	$("#description").val(description);

	$("#date").val(time);

	$("#amount").val("$"+amount);

	$("#status").val(status);

}



</script>