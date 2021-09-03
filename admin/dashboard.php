<?php

	require_once 'header_new.php';



	if(!isset($_SESSION['user_signed_in']))

	{

		header("location:login");		

	}



    $sql = "SELECT count(id) as customer from users where type='5'";

    if($result = $conn->query($sql))

    {

        if($result->num_rows > 0)

        {

            $customer = $result->fetch_assoc();

        }

    }

    $sql = "SELECT count(id) as business from users where type='2'";

    if($result = $conn->query($sql))

    {

        if($result->num_rows > 0)

        {

            $business = $result->fetch_assoc();

        }

    }

    $sql = "SELECT count(id) as contractor from users where type='3'";

    if($result = $conn->query($sql))

    {

        if($result->num_rows > 0)

        {

            $contractor = $result->fetch_assoc();

        }

    }

    $sql = "SELECT count(id) as task from post_task";

    if($result = $conn->query($sql))

    {

        if($result->num_rows > 0)

        {

            $task = $result->fetch_assoc();

        }

    }

    $sql = "SELECT count(distinct(milestone_id)) as payment from milestones_payment";

    if($result = $conn->query($sql))

    {

        if($result->num_rows > 0)

        {

            $payment = $result->fetch_assoc();

        }

    }

    $sql = "SELECT count(id) as review from accepted_task where review!=''";

    if($result = $conn->query($sql))

    {

        if($result->num_rows > 0)

        {

            $review = $result->fetch_assoc();

        }

    }

    $sql = "SELECT count(id) as emp from employer_reviews";

    if($result = $conn->query($sql))

    {

        if($result->num_rows > 0)

        {

            $emp = $result->fetch_assoc();

        }

    }

?>



<body>

	<!-- wrapper -->

	<div class="wrapper">

		<?php

			require_once 'sidebar.php';

			require_once 'navbar.php';

		?>



		<!--page-wrapper-->

		<div class="page-wrapper">

			<!--page-content-wrapper-->

			<div class="page-content-wrapper">

				<div class="page-content">

				<div class="row">

						<div class="col-12 col-lg-12 col-xl-6">

							<div class="card-deck flex-column flex-lg-row">

								<div class="card radius-15 bg-info">

									<a href="customer">

										<div class="card-body text-center">

											<div class="widgets-icons mx-auto rounded-circle bg-white"><i class='lni lni-user'></i>

											</div>

											<h4 class="mb-0 font-weight-bold mt-3 text-white"><?=$customer['customer']?></h4>

											<p class="mb-0 text-white">Customers</p>

										</div>

									</a>

								</div>

								<div class="card radius-15 bg-wall">

									<a href="business">

										<div class="card-body text-center">

											<div class="widgets-icons mx-auto bg-white rounded-circle"><i class='bx bx-group'></i>

											</div>

											<h4 class="mb-0 font-weight-bold mt-3 text-white"><?=$business['business']?></h4>

											<p class="mb-0 text-white">Business / LLC</p>

										</div>

									</a>	

								</div>

								<div class="card radius-15 bg-rose">

									<a href="contractor">

										<div class="card-body text-center">

											<div class="widgets-icons mx-auto bg-white rounded-circle"><i class='lni lni-users'></i>

											</div>

											<h4 class="mb-0 font-weight-bold mt-3 text-white"><?=$contractor['contractor']?></h4>

											<p class="mb-0 text-white">Contractors</p>

										</div>

									</a>

								</div>

								

							</div>

							

						</div>

						<div class="col-12 col-lg-12 col-xl-6">

							<div class="card-deck flex-column flex-lg-row" style="height:100%">

								<div class="card radius-15 bg-danger">


                                    <a href="alltasks" >
										<div class="card-body text-center">

											<div class="widgets-icons mx-auto rounded-circle bg-white"><i class='lni lni-unlink'></i>

											</div>

											<h4 class="mb-0 font-weight-bold mt-3 text-white"><?=$task['task']?></h4>

											<p class="mb-0 text-white">Tasks</p>

										</div>
									</a>

								</div>

								<div class="card radius-15 bg-primary">
                                    <a href="transactions">
										<div class="card-body text-center">

											<div class="widgets-icons mx-auto bg-white rounded-circle"><i class="lni lni-dollar"></i>

											</div>

											<h4 class="mb-0 font-weight-bold mt-3 text-white"><?=$payment['payment']?></h4>

											<p class="mb-0 text-white">Transactions</p>

										</div>
                                    </a>
								</div>

								<div class="card radius-15 bg-success">			

										<div class="card-body text-center">

											<div class="widgets-icons mx-auto bg-white rounded-circle"><i class='bx bx-cloud-download'></i>

											</div>

											<h4 class="mb-0 font-weight-bold mt-3 text-white"><?=$review['review'] + $emp['emp']?></h4>

											<p class="mb-0 text-white">Reviews</p>

										</div>

								</div>

							</div>

						</div>

					</div>

					<div class="row">

						<div class="col-12 col-lg-12 mx-auto">
							<div class="card radius-15">
								<div class="card-body">
									<div class="card-title">
										<h4 class="mb-0">Transactions</h4>
									</div>
									<hr/>
									<div class="chart-container1">
										<canvas id="chart1"></canvas>
									</div>
								</div>
							</div>
							<div class="card radius-15">
								<div class="card-body">
									<div class="card-title">
										<h4 class="mb-0">Tasks Posted</h4>
									</div>
									<hr/>
									<div class="chart-container1">
										<canvas id="taskChart"></canvas>
									</div>
								</div>
							</div>
						</div>

					</div>

					

					

					<!--end row-->

					



				</div>

			</div>

			<!--end page-content-wrapper-->

		</div>

		<!--end page-wrapper-->

		<!--start overlay-->

		<div class="overlay toggle-btn-mobile"></div>

		<!--end overlay-->

		<!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>

		<!--End Back To Top Button-->

		<!--footer -->

		<div class="footer">

			<p class="mb-0">All Weather Help @<?=date("Y")?>| Developed By : <a href="https://www.cyberflow.in" target="_blank">CyberFlow</a>

			</p>

		</div>

		<!-- end footer -->

	</div>

	<!-- end wrapper -->



	<!--end switcher-->

	

</body>

<?php

	require_once 'javascript.php';

?>

</html>
<script>
	$(document).ready(function(){
		$.get('dashboard_ajax.php?transaction_graph=true',function(response)
		{
			console.log(response);
			if(response.msg=="ok")
			{
    			var ctx = document.getElementById('chart1').getContext('2d');
    
    			var myChart = new Chart(ctx, {
    
    				type: 'line',
    
    				data: {
    
    					labels: ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL' , 'AUG' , 'SEPT' , 'OCT' , 'NOV' , 'DEC'],
    
    					datasets: [{
    
    						label: 'Transactions',
    
    						data: response.amount_new,
    
    						backgroundColor: "transparent",
    
    						borderColor: "#673ab7",
    
    						pointRadius: "0",
    
    						borderWidth: 4
    
    					}]
    
    				},
    
    				options: {
    
    					maintainAspectRatio: false,
    
    					legend: {
    
    						display: true,
    
    						labels: {
    
    							fontColor: '#585757',
    
    							boxWidth: 40
    
    						}
    
    					},
    
    					tooltips: {
    
    						enabled: true
    
    					},
    
    					scales: {
    
    						xAxes: [{
    
    							ticks: {
    
    								beginAtZero: true,
    
    								fontColor: '#585757'
    
    							},
    
    							gridLines: {
    
    								display: true,
    
    								color: "rgba(0, 0, 0, 0.07)"
    
    							},
    
    						}],
    
    						yAxes: [{
    
    							ticks: {
    
    								beginAtZero: true,
    
    								fontColor: '#585757'
    
    							},
    
    							gridLines: {
    
    								display: true,
    
    								color: "rgba(0, 0, 0, 0.07)"
    
    							},
    
    						}]
    
    					}
    
    				}
    
    			});
			}
			    
		},"JSON")
	})
	$.get('dashboard_ajax.php?tasks_graph=true',function(response){
	    console.log(response);
	    
	    if(response.msg=="ok")
	    {
    	    var ctx = document.getElementById('taskChart').getContext('2d');
    
    		var myChart = new Chart(ctx, {
    
    				type: 'line',
    
    				data: {
    
    					labels: ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL' , 'AUG' , 'SEPT' , 'OCT' , 'NOV' , 'DEC'],
    
    					datasets: [{
    
    						label: 'Tasks Posted',
    
    						data: response.amount_new,
    
    						backgroundColor: "transparent",
    
    						borderColor: "#673ab7",
    
    						pointRadius: "0",
    
    						borderWidth: 4
    
    					}]
    
    				},
    
    				options: {
    
    					maintainAspectRatio: false,
    
    					legend: {
    
    						display: true,
    
    						labels: {
    
    							fontColor: '#585757',
    
    							boxWidth: 40
    
    						}
    
    					},
    
    					tooltips: {
    
    						enabled: true
    
    					},
    
    					scales: {
    
    						xAxes: [{
    
    							ticks: {
    
    								beginAtZero: true,
    
    								fontColor: '#585757'
    
    							},
    
    							gridLines: {
    
    								display: true,
    
    								color: "rgba(0, 0, 0, 0.07)"
    
    							},
    
    						}],
    
    						yAxes: [{
    
    							ticks: {
    
    								beginAtZero: true,
    
    								fontColor: '#585757'
    
    							},
    
    							gridLines: {
    
    								display: true,
    
    								color: "rgba(0, 0, 0, 0.07)"
    
    							},
    
    						}]
    
    					}
    
    				}
    
    			});
	    }
	},"JSON")

</script>