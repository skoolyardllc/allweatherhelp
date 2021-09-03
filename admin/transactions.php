<?php

	

	require_once 'header_new.php';



	

	$sql = "SELECT mp.*,up.f_name,up.l_name FROM milestones_payment mp,user_profile up where mp.user_id=up.u_id ORDER BY id DESC";

    $status = "All";

    $app = "";

    $block = "";

	

// echo $sql;

	if($resu = $conn->query($sql))

	{

		$noofRows = $resu->num_rows;
		$results_per_page = 25;  
		$number_of_page = ceil ($noofRows  / $results_per_page);
		if(isset($_GET['page'])&& !empty($_GET['page']))
		{
			$page = $_GET['page'];
		}
		else
		{
			$page = 1;
		}
		$page_first_result = ($page-1) * $results_per_page;
		
		$sql .= " limit $page_first_result , $results_per_page";
		$result = $conn->query($sql);
		if($result->num_rows)

		{

			while($row = $result->fetch_assoc())

			{

				$cus[] = $row;

			}

		}

	}

	else

	{

		echo $conn->error; 

	}

// print_r($cus);



?>



<body>

	<!-- wrapper -->

	<div class="wrapper">

		<!--sidebar-wrapper-->

		<?php

			require_once 'sidebar.php';

			require_once 'navbar.php';

		?>

		<!--end sidebar-wrapper-->

		<!--header-->

	

		<!--end header-->

		<!--page-wrapper-->

		<div class="page-wrapper">

			<!--page-content-wrapper-->

			<div class="page-content-wrapper">

				<div class="page-content">

					<!--breadcrumb-->

					<div class="page-breadcrumb d-none d-md-flex align-items-center mb-3">

						<div class="breadcrumb-title pr-3">Transactions</div>

						<div class="pl-3">

							<nav aria-label="breadcrumb">

								<ol class="breadcrumb mb-0 p-0">

									<li class="breadcrumb-item"><a href="dashboard"><i class='bx bx-home-alt'></i></a>

									</li>

									<li class="breadcrumb-item active" aria-current="page">Transactions</li>

								</ol>

							</nav>

						</div>

						

					</div>

					<!--end breadcrumb-->

					<?php

						if(isset($updated))

						{

							?>

								<div class="alert alert-primary alert-dismissible fade show" role="alert">

									Your Profile Updated Successfully!

									<button type="button" class="close" data-dismiss="alert" aria-label="Close">	<span aria-hidden="true">&times;</span>

									</button>

								</div>

							<?php

						}

						else if(isset($error))

						{

							?>

								<div class="alert alert-danger alert-dismissible fade show" role="alert">

									Error occured while Updating ypur profile!

									<button type="button" class="close" data-dismiss="alert" aria-label="Close">	<span aria-hidden="true">&times;</span>

									</button>

								</div>

							<?php

						}

					

					?>

					<div class="user-profile-page">

						<div class="card radius-15">

							<div class="card-body">

                                            <div class="row">

                                                <div class="col-lg-10">

                                                    <h5><?=$status?> Transactions</h5>

                                                </div>

                                            </div>

									<div class="row">

                                            



										<div class="col-8 col-lg-8" style="overflow-y: scroll;height:100vh">

                                            

                                            

                                            <hr/>

                                            <?php

                                                if(isset($cus))

                                                {

                                            ?>

                                            <div class="table-responsive">

                                                <table class="table table-striped table-bordered mb-0" id="example2">

                                                    <thead class="thead-primary" style="background-color:#673ab7;border-radius:10px">

                                                        <tr style="color:white">

                                                            <th scope="col" style="color:white">#</th>

                                                            <th scope="col" style="color:white">By</th>

                                                            <th scope="col" style="color:white">Date</th>

                                                            <th scope="col" style="color:white">Amount</th>

                                                            <th scope="col" style="width:10vw;color:white">View</th>

                                                        </tr>

                                                    </thead>

													<tbody >

														<?php

														

															$i=1;												



															foreach($cus as $p)

															{

																$d=strtotime($p['timestamp']);

                                                                 $timestamp = date("M d Y", $d);

                                                                //  $onclicklaptop = "viewonlaptop(`$payment_ref`,`$user`,`$description`,`$timestamp`,`$amount`,`$status`,`$id`,`$project_id`)";

																$c_id=$p['contractor_id'];

                                                                $sql = "SELECT up.f_name,up.l_name from user_profile up where up.u_id = '$c_id'";

                                                                if($result = $conn->query($sql))

                                                                {

                                                                    if($result->num_rows)

                                                                    {

                                                                        $contractor = $result->fetch_assoc();

                                                                    }

                                                                }

                                                                ?>

																	<tr>

																		<th scope="row"><?=$i?></th>

																		<td><?=$p['f_name']?> <?=$p['l_name']?></td>

																		<td><?=$timestamp?></td>

                                                                        <td>$ <?=$p['amount']?></td>

																		<td>

																			<!-- <button class="btn btn-outline-primary" onclick="dekho(<?=$p['id']?>,<?=$i?>)" data-toggle="modal" data-target="#modal-reject" type="button" ><i class="bi bi-eye"></i> View</button> -->

																			<button class="btn btn-outline-primary" onclick="viewonlaptop(`<?=$p['payment_ref']?>`,`<?=$p['f_name']?> <?=$p['l_name']?>`,`<?=$p['description']?>`,`<?=$timestamp?>`,`<?=$p['amount']?>`,`<?=$p['status']?>`,`<?=$p['id']?>`,`<?=$p['project_id']?>`,`<?=$contractor['f_name']?> <?=$contractor['l_name']?>`)" type="button" style="border:0"><i class="bi bi-eye"></i>View</button>

                                                                        </td>

																	</tr>

																<?php

                                                                $i++;

															}

														

															

														?>

													</tbody>

                                                </table>

                                            </div>

                                            <?php

                                                        }

                                                        else

															{

																?>

																	<tr>

																		<div class="alert alert-danger">

																			No Transaction Found!

																		</div>

																	</tr>

											

																<?php

															}

                                        ?>

                                        </div>

                                        <div class="col-4 col-lg-4" >

                                        <div class="card shadow-none border mb-0 radius-15" id="transactiondetails" style="display:initial;">

                                            <div class='card-body'>

                                        <!-- Headline -->

                                            <div class="headline">

                                                <div class="row">

                                                    <div class="col-lg-11">

                                                        <h4><i class="bi bi-cash"></i> Transaction Details</h4>

                                                    </div>

                                                    <!-- <div class="col-lg-1">

                                                        <h5><i class="bi bi-x" style="align-items:flex-end;font-size:40px;cursor:pointer" onclick="{$('#transactiondetails').hide()}"></i></h5>

                                                    </div>	 -->

                                                </div>

                                            </div>



                                            <div class="" style="width:20vw">



                                                <div class="row" >

                                                    <div class="form-row" style="margin-top:10px">

                                                        <div class="form-group col-md-12">

                                                            <label >Payment Id : </label>

                                                            <input type='text' class='form-control' id='payid' disabled>

                                                        </div>

                                                        <div class="form-group col-md-12">

                                                            <label >Amount : </label>

                                                            <input type='text' class='form-control' id='amount' disabled>

                                                        </div>

                                                        <div class="form-group col-md-12">

                                                            <label >Payment Reference : </label>

                                                            <input type='text' class='form-control' id='payment_ref' disabled>

                                                        </div>

                                                        <div class="form-group col-md-12">

                                                            <label >Description : </label>

                                                            <input type='text' class='form-control' id='description' disabled>

                                                        </div>

                                                        <div class="form-group col-md-12">

                                                            <label >Date : </label>

                                                            <input type='text' class='form-control' value='' id="date" disabled>

                                                        </div>

                                                        <div class="form-group col-md-12">

                                                            <label >By : </label>

                                                            <input type='text' class='form-control' id='user' disabled> 

                                                        </div>

                                                        <div class="form-group col-md-12">

                                                            <label >To : </label>

                                                            <input type='text' class='form-control' id='contractor' disabled> 

                                                        </div>

                                                    </div>

                                                        <a href='#' id="viewMilestone" style="margin-bottom:20px"><i class='bi bi-eye'></i> View Post</a>

                                                </div>



                                            </div>

                                            </div>

                                        </div>

                                        </div>



									</div>

							</div>

						</div>
						<nav aria-label="Page navigation">
						<ul class="pagination pagination-lg round-pagination">
						<?php
							for($page = 1; $page<= $number_of_page; $page++) 
							{  
								$active = "";
								if(isset($_GET['page']) && $page == $_GET['page'] )
								{
									$active = "active";
								}
								else if(!isset($_GET['page']) && $page == 1)
								{
									$active = "active";
								}
								else
								{
									$active = "";
								}
								if(isset($_GET['token']))
								{
									$t = $_GET['token'];
									$href = "transactions?token=$t&page=$page";	
								}
								else
								{
									$href = "transactions?page=$page";
								}
								?>
									<li class="page-item <?=$active?>"><a class="page-link" href="<?=$href?>"><?=$page?></a>
									</li>
								<?php
							
							}  
						
						?>
							
						</ul>
					</nav>
					</div>

											

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

			<p class="mb-0">All Weather Help @<?=date("Y")?> | Developed By : <a href="https://www.cyberflow.in" target="_blank">CyberFlow</a>

			</p>

		</div>

		<!-- end footer -->

	</div>

	<!-- end wrapper -->

	<!--start switcher-->

	

	<!--end switcher-->

	<?php

		require_once 'javascript.php'; 

	?>

</body>

<script>

function viewonlaptop(payment_ref,user,description,time,amount,status,id,project_id,contractor)

{

	$("#transactiondetails").show();

	$("#payid").val(id);

	$("#payment_ref").val(payment_ref);

	$("#user").val(user);

	$("#description").val(description);

	$("#date").val(time);

	$("#amount").val("$"+amount);

    $("#contractor").val(contractor);

	$("#viewMilestone").attr('href',"task?token="+project_id)

	// $(".viewonlaptop").removeClass('btn-primary');

	// $(".viewonlaptop").addClass('btn-outline-primary');

	// $("#viewonlaptop"+id).removeClass('btn-outline-primary');

	// $("#viewonlaptop"+id).addClass('btn-primary');

}

</script>



</html>