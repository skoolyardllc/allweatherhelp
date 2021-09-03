<?php

	

	require_once 'header_new.php';



	

	$sql = "select pt.*,up.f_name,up.l_name from post_task pt,user_profile up  where up.u_id=pt.e_id order by pt.id desc";

    $status = "All";

    $app = "";

    $block = "";

    $aaj = date("Y-m-d");

	if(isset($_GET['token']) && !empty($_GET['token']))

    {

        $token = $_GET['token'];

        switch($token)

        {

            case 1:

				$sql = "select pt.*,up.f_name,up.l_name from post_task pt,user_profile up  where pt.end_date < '$aaj' and up.u_id=pt.e_id order by pt.id desc";

				$status = "Completed";

                $app = "none";

                break;



            case 2:

                $sql = "select pt.*,up.f_name,up.l_name from post_task pt,user_profile up  where pt.end_date > '$aaj' and up.u_id=pt.e_id order by pt.id desc";

				$status = "Ongoing";

                $block = "none";

                break;



		}

    }



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
		// echo $sql;
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

						<div class="breadcrumb-title pr-3">Tasks</div>

						<div class="pl-3">

							<nav aria-label="breadcrumb">

								<ol class="breadcrumb mb-0 p-0">

									<li class="breadcrumb-item"><a href="dashboard"><i class='bx bx-home-alt'></i></a>

									</li>

									<li class="breadcrumb-item active" aria-current="page">Tasks</li>

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

                                        

										<div class="col-12 col-lg-12">

                                            <div class="row">

                                                <div class="col-lg-10">

                                                    <h5><?=$status?> Tasks</h5>

                                                </div>

                                            </div>

                                            

                                            <hr/>

                                            <?php

                                                if(isset($cus))

                                                {

                                            ?>

                                            <div class="table-responsive">

                                                <table class="table table-striped table-bordered mb-0" id="example2">

                                                    <thead class="thead-dark">

                                                        <tr>

                                                            <th scope="col">S No.</th>

                                                            <th scope="col">Task Name</th>

                                                            <th scope="col">Posted By</th>

                                                            <th scope="col" style="width:10vw">Action</th>

                                                        </tr>

                                                    </thead>

													<tbody>

														<?php

														

															$i=1;												



															foreach($cus as $p)

															{

																

																switch($p['status'])

																{

																	case 1: //approved

																		$app = "none";

																		break;

																	case 2: //blocked

																		$block = "none";

																		break;

																}

																

																?>

																	<tr>

																		<th scope="row"><?=$i?></th>

																		<td><?=$p['t_name']?></td>

																		<td><?=$p['f_name']?> <?=$p['l_name']?></td>

																		<td>

																			<!-- <button class="btn btn-outline-primary" onclick="dekho(<?=$p['id']?>,<?=$i?>)" data-toggle="modal" data-target="#modal-reject" type="button" ><i class="bi bi-eye"></i> View</button> -->

																			<a href="task?token=<?=$p['id']?>" class="btn btn-outline-primary" style="border:0"  type="button" ><i class="bi bi-eye"></i>View</a>

                                                                           

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

																			No Tasks Found!

																		</div>

																	</tr>

											

																<?php

															}

											?>

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
									$href = "alltasks?token=$t&page=$page";	
								}
								else
								{
									$href = "alltasks?page=$page";
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

	



function approve(id,counter)

{

	$.ajax(

            {

                url:"status.php",

                type:"post",

                data:{ approve:true,

                        id:id,



                     },

                dataType: "html" ,    

                success : function(data)

                {

                    if(data.trim()=="ok")

                    {

						$("#approve"+id).hide();

						$("#block"+id).show();

                    }

                   

                },

                error:

                function(err){}

            })

}



function block(id,counter)

{

	// console.log("heelo");

	$.ajax(

            {

                url:"status.php",

                type:"post",

                data:{ block:true,

                        id:id,



                     },

                dataType: "html",

                success : function(data)

                {

                    if(data.trim()=="ok")

                    {

						$("#block"+id).hide();

						$("#approve"+id).show();

                    }

                   

                },

                error:

                function(err){}

            })

}

</script>



</html>