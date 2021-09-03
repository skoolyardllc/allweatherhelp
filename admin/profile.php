<?php

	

	require_once 'header_new.php';



	if(isset($_GET['token'])&&!empty($_GET['token']))

    {

        $id = $_GET['token'];

        $sql = "SELECT u.id as user,u.email,u.stat,u.type,up.* from users u,user_profile up where u.id = up.u_id and u.id='$id'";

        if($result = $conn->query($sql))

        {

            if($result->num_rows > 0)

            {

                $detail = $result->fetch_assoc();

            }

        }

        

        $sql = "SELECT * FROM bank where u_id='$id'";

        if($result = $conn->query($sql))

            {

                if($result->num_rows > 0)

                {

                    $bank = $result->fetch_assoc();

                }

            }

            else

            {

                $error2 = $conn->error;

            }

            $account = "none";

            $card = "none";

            $username = "none";

            $hide = "";

            switch($bank['method'])

            {

                case 'Account':

                    $account = "initial";

                    break;

                case 'Card':

                    $card = "initial";

                    break;

                case 'Cashapp':

                    $username = "initial";

                    break; 

                case 'PayPal':

                    $username = "initial";

                    break;

                default:

                    $notmentioned = "Banking Details Not Found";

                    $hide = "none";

            }

        $ins = "none";

        switch($detail['type'])

        {

            case 5:

                $para = "<i class='lni lni-user'></i> Customer";

                $post = "SELECT *,id as post_id from post_task where e_id='$id'";

                $acctype = "Customer";

                break;

            case 2:

                $para = "<i class='bx bx-group'></i> Business / LLC";

                $ins = "initial";

                $acctype = "Business / LLC";

                $sql = "SELECT * from insurance where u_id='$id'";

                if($result = $conn->query($sql))

                {

                    if($result->num_rows > 0)

                    {

                        $insurance = $result->fetch_assoc();

                    }

                }

                $sql = "SELECT * from adm where u_id='$id' and adm=00";

                if($result = $conn->query($sql))

                {

                    if($result->num_rows > 0)

                    {

                        $manager = $result->fetch_assoc();

                    }

                }

                $sql = "SELECT * from adm where u_id='$id' and adm=01";

                if($result = $conn->query($sql))

                {

                    if($result->num_rows > 0)

                    {

                        $assistant = $result->fetch_assoc();

                    }

                }

                $post = "SELECT pt.*,pt.id as post_id from accepted_task at , post_task pt where at.c_id = '$id' and at.t_id = pt.id";

                break;

            case 3:

                $para = "<i class='lni lni-users'></i> Contractor";

                $acctype = "Contractor";

                $post = "SELECT pt.*,pt.id as post_id from accepted_task at , post_task pt where at.c_id = '$id' and at.t_id = pt.id";

                break;

        }

        switch($detail['stat'])

        {

            case 0:

                $button = "<button type='button' class='btn btn-danger'> <span class='badge badge-danger'><i class='fadeIn animated bx bx-block'></i></span> Blocked</button>";

                break;

            case 1:

                $button = "<button type='button' class='btn btn-success'> <span class='badge badge-success'><i class='bi bi-check'></i></span> Approved</button>";

                break;

        

        }

        // echo $post;

        if($result =$conn->query($post))

        {

            if($result->num_rows > 0)

            {

                while($row = $result->fetch_assoc())

                {

                    $posts[] = $row;

                }

            }

        }

        else

        {

            echo $conn->error;

        }

        // print_r($posts);

    } 



?>

<style>

    .postsdata:hover { background:#b3d1ff}

</style>

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

						<div class="breadcrumb-title pr-3">User Profile</div>

						<div class="pl-3">

							<nav aria-label="breadcrumb">

								<ol class="breadcrumb mb-0 p-0">

									<li class="breadcrumb-item"><a href="dashboard"><i class='bx bx-home-alt'></i></a>

									</li>

									<li class="breadcrumb-item " aria-current="page"><?=$acctype?></li>

                                    <li class="breadcrumb-item active" aria-current="page">User Profile</li>

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

						<div class="">

							<div class="card-body">

                                <div class="card radius-15" style="padding-left:10px;padding-top:10px">

							<div class="card-body">

								<div class="row"  style="margin-bottom:20px">

									<div class="col-12 col-lg-7 ">

										<div class="d-md-flex align-items-center">

											<div class="mb-md-0 mb-3">

												<img src="../<?=$detail['avtar']?>" class="rounded-circle shadow" width="130" height="130" alt="" />

											</div>

											<div class="ml-md-4 flex-grow-1">

												<div class="d-flex align-items-center mb-1">

													<h4 class="mb-0"><?=$detail['f_name']?> <?=$detail['l_name']?></h4>

												</div>

												<p class="text-primary"><?=$para?></p>

											</div>

										</div>

									</div>

									<div class="col-12 col-lg-5">

										<table class="table table-sm table-borderless mt-md-0 mt-3">

                                            <?=$button?>   

										</table>

                                    </div>

								</div>

								<!--end row-->

								<ul class="nav nav-pills">

                                    <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#Edit-Profile"><span class="p-tab-name">Profile</span><i class='bx bx-message-edit font-24 d-sm-none'></i></a>

									</li>

									<li class="nav-item"> <a class="nav-link " data-toggle="tab" href="#Experience"><span class="p-tab-name">Bank Details</span><i class='bx bx-donate-blood font-24 d-sm-none'></i></a>

									</li>

									<li class="nav-item" style="display:<?=$ins?>"> <a class="nav-link" id="profile-tab" data-toggle="tab" href="#Biography"><span class="p-tab-name">Insurance Details</span><i class='bx bxs-user-rectangle font-24 d-sm-none'></i></a>

									</li>

                                    <li class="nav-item" style="display:<?=$ins?>"> <a class="nav-link" data-toggle="tab" href="#adm"><span class="p-tab-name">Administration Details</span><i class='bx bxs-user-rectangle font-24 d-sm-none'></i></a>

									</li>

                                    <li class="nav-item" > <a class="nav-link" data-toggle="tab" href="#posts"><span class="p-tab-name">Posts</span><i class='bx bxs-user-rectangle font-24 d-sm-none'></i></a>

									</li>

									

								</ul>

								<div class="tab-content mt-3">

									<div class="tab-pane fade" id="Experience">

										<div class="card shadow-none border mb-0 radius-15">

											<div class="card-body">

												<div class="d-sm-flex align-items-center mb-3">

													<h4 class="mb-0">Banking Details</h4>

												</div>

												<div class="row">

                                                        <div class="col-xl-12">

                                                            <?php

                                                                if(isset($notmentioned) && !empty($notmentioned))

                                                                {

                                                                    ?>

                                                                        <p><?=$notmentioned?></p>

                                                                    <?php

                                                                }

                                                            ?>

                                                            <div class="form-row" style="display:<?=$hide?>">

                                                                <div class="form-group col-md-6">

                                                                    <label>Method</label>

                                                                    <input type="text" class="form-control" value="<?=$bank['method']?>"  name="f_name" disabled/>

                                                                </div>

                                                                <div class="form-group col-md-6" style="display:<?=$username?>">

                                                                    <label>Username</label>

                                                                    <input type="text" class="form-control" value="<?=$bank['username']?>" name="l_name" disabled/>

                                                                </div>

                                                            </div>

                                                            <div class="form-row" style="display:<?=$account?>">

                                                                <div class="form-group col-md-6">

                                                                    <label>Account Number</label>

                                                                    <input type="text" class="form-control" value="<?=$bank['acc_no']?>"  name="email" disabled/>

                                                                </div>

                                                                <div class="form-group col-md-6">

                                                                    <label>Routing Number</label>

                                                                    <input type="text" class="form-control" value="<?=$bank['routing_no']?>" name="phone" disabled/>

                                                                </div>

                                                            </div>

                                                            <div class="form-row" style="display:<?=$card?>">

                                                                <div class="form-group col-md-6">

                                                                    <label>Card Number</label>

                                                                    <input type="text" class="form-control" value="<?=$bank['card_no']?>"  name="email" disabled/>

                                                                </div>

                                                                <div class="form-group col-md-6">

                                                                    <label>Name On Card</label>

                                                                    <input type="text" class="form-control" value="<?=$bank['name_card']?>" name="phone" disabled/>

                                                                </div>

                                                            </div>

                                                        </div>



                                                                                              

                                                </div>

											</div>

										</div>

									</div>

									<div class="tab-pane fade" id="Biography">

                                    <?php

                                        if(isset($insurance))

                                        {

                                            ?>

										<div class="row">

											<div class="col-lg-4">

												<div class="card shadow-none border mb-0">

													<div class="card-body">

														<h5 class="mb-3">Insurance Document</h5>

                                                       

                                                             

                                                        <a href="../uploads/<?= $insurance['document']?>" target="_blank"><img src="../images/PDF.svg" height="100" width="100"/></a>

												    </div>

                                                </div>

											</div>

											<div class="col-lg-8">

												<div class="card shadow-none border mb-0 radius-15">

													<div class="card-body" style="padding-top:10px;padding-bottom:3px">

                                                        <div class="row">

                                                            <div class="col-12 col-lg-12">

                                                                <div class="form-row" >

                                                                    <div class="form-group col-md-12">

                                                                        <label>Name of Insurance Company</label>

                                                                        <input type="text" class="form-control" value="<?=$insurance['in_company']?>"  name="f_name" disabled/>

                                                                    </div>

                                                                    <div class="form-group col-md-12">

                                                                        <label>Policy Number</label>

                                                                        <input type="text" class="form-control" value="<?=$insurance['policy_no']?>" name="l_name" disabled/>

                                                                    </div>

                                                                </div>

                                                            </div>

                                                        </div>

													</div>

												</div>

											</div>

										</div>

                                        <?php

                                        }

                                        ?>

									</div>

                                    <div class="tab-pane fade" id="adm">

										<div class="row">

											<div class="col-lg-6">

                                                <div class="card shadow-none border mb-0 radius-10">

                                                    <div class="card-body" style="padding-top:10px;padding-bottom:3px">

                                                        <div class="row">

                                                            <div class="col-12 col-lg-12">

                                                                <h4>Manager</h4>

                                                                <div class="form-row" >

                                                                    <div class="form-group col-md-12">

                                                                        <label>Name</label>

                                                                        <input type="text" class="form-control" value="<?=$manager['fir_name']?> <?=$manager['las_name']?>"  name="f_name" disabled/>

                                                                    </div>

                                                                    <div class="form-group col-md-12">

                                                                        <label>Email Address</label>

                                                                        <input type="text" class="form-control" value="<?=$manager['email']?>" name="l_name" disabled/>

                                                                    </div>

                                                                    <div class="form-group col-md-12">

                                                                        <label>Username</label>

                                                                        <input type="text" class="form-control" value="<?=$manager['username']?>"  name="f_name" disabled/>

                                                                    </div>

                                                                    <div class="form-group col-md-12">

                                                                        <label>Phone Number</label>

                                                                        <input type="text" class="form-control" value="<?=$manager['ph_no']?>" name="l_name" disabled/>

                                                                    </div>

                                                                </div>

                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>

											</div>

											<div class="col-lg-6">

												<div class="card shadow-none border mb-0 radius-10">

													<div class="card-body" style="padding-top:10px;padding-bottom:3px">

                                                        <div class="row">

                                                            <div class="col-12 col-lg-12">

                                                                <h4>Assistant Manager</h4>

                                                                <div class="form-row" >

                                                                    <div class="form-group col-md-12">

                                                                        <label>Name</label>

                                                                        <input type="text" class="form-control" value="<?=$assistant['fir_name']?> <?=$assistant['las_name']?>"  name="f_name" disabled/>

                                                                    </div>

                                                                    <div class="form-group col-md-12">

                                                                        <label>Email Address</label>

                                                                        <input type="text" class="form-control" value="<?=$assistant['email']?>" name="l_name" disabled/>

                                                                    </div>

                                                                    <div class="form-group col-md-12">

                                                                        <label>Username</label>

                                                                        <input type="text" class="form-control" value="<?=$assistant['username']?>"  name="f_name" disabled/>

                                                                    </div>

                                                                    <div class="form-group col-md-12">

                                                                        <label>Phone Number</label>

                                                                        <input type="text" class="form-control" value="<?=$assistant['ph_no']?>" name="l_name" disabled/>

                                                                    </div>

                                                                </div>

                                                            </div>

                                                        </div>

													</div>

												</div>

											</div>

										</div>

									</div>

									<div class="tab-pane fade show active" id="Edit-Profile">

										<div class="card shadow-none border mb-0 radius-15">

											<div class="card-body">

												<div class="form-body">

													<div class="row">

														<div class="col-12 col-lg-12">

                                                        <div class="form-row" >

                                                            <div class="form-group col-md-6">

                                                                <label>First Name</label>

                                                                <input type="text" class="form-control" value="<?=$detail['f_name']?>"  name="f_name" disabled/>

                                                            </div>

                                                            <div class="form-group col-md-6">

                                                                <label>Last Name</label>

                                                                <input type="text" class="form-control" value="<?=$detail['l_name']?>" name="l_name" disabled/>

                                                            </div>

                                                        </div>

                                                        <div class="form-row">

                                                            <div class="form-group col-md-6">

                                                                <label>Email</label>

                                                                <input type="text" class="form-control" value="<?=$detail['email']?>"  name="email" disabled/>

                                                            </div>

                                                            <div class="form-group col-md-6">

                                                                <label>Phone Number</label>

                                                                <input type="text" class="form-control" value="<?=$detail['mobile']?>" name="phone" disabled/>

                                                            </div>

                                                        </div>

                                                        <div class="form-row" >

                                                           

                                                            <div class="form-group col-md-6">

                                                                <label>Nationality</label>

                                                                <input type="text" class="form-control" value="<?=$detail['nationality']?>" name="nationality" disabled/>

                                                            </div>

                                                        

                                                            <div class="form-group col-md-6">

                                                                <label>Tagline</label>

                                                                <input type="text" class="form-control" value="<?=$detail['tagline']?>"  name="tagline" disabled/>

                                                            </div>

                                                        </div>

                                                        

                                                        <div class="form-row" >

                                                            <div class="form-group col-md-12">

                                                                <label>Address</label>

                                                                <textarea rows="3" class="form-control" value=""  name="address" disabled><?=$detail['address']?></textarea>

                                                            </div>

                                                        

                                                        </div>

                                                        <div class="form-row" >

                                                            <div class="form-group col-md-12">

                                                                <label>Introduction</label>

                                                                <textarea rows="3" class="form-control" value=""  name="intro" disabled><?=$detail['intro']?></textarea>

                                                            </div>

                                                        </div>

                                                        

                                                        

											

														</div>

													

													</div>

												</div>

											</div>

										</div>

									</div>

                                    <div class="tab-pane fade" id="posts">

                                        <?php

                                            if(isset($posts))

                                            {

                                                $i = 0;

                                                $color = ['youtube','facebook','dribbble','twitter','tumblr','linkedin','youtube','linkedin','dribbble','tumblr','facebook'];

                                                $ico = ['lni-star-empty','lni-slack','lni-pallet','lni-paperclip','lni-sketch','lni-surf-board','lni-bitbucket','lni-500px'];

                                        ?>

                                        <div class="row">

                                            <div class="col-lg-3"></div>

                                        <div class="col-lg-6">

                                            <div class="dashboard-social-list" style="height:74vh">

                                                <ul class="list-group list-group-flush">

                                                <?php

                                                    foreach($posts as $b)

                                                    {

                                                        

                                                        // echo $color[$i];

                                                        // echo $b['time_stamp'];

                                                        $d=strtotime($b['time_stamp']);

                                                        $tim = date("M d Y H:m", $d);

                                                        $e=strtotime($b['end_date']);

                                                        $due = date("M d Y ", $e);

                                                        $pay_status = "";

                                                        $status = "";

                                                       



                                                ?>

                                                <a href="task?token=<?=$b['id']?>" >

                                                    <li class="list-group-item d-flex align-items-center postsdata" style="cursor:pointer" >

                                                        <div class="media align-items-center">

                                                        <div class="widgets-social bg-<?=$color[$i]?> rounded-circle text-white"><i class="lni <?=$ico[$i]?>"></i>

                                                        </div>

                                                            <div class="media-body ml-2" style="margin-top:20px">

                                                                <h6 class="mb-0"><?=$b['t_name']?></h6>

                                                                <p><?=$tim?></p>

                                                            </div>

                                                        </div>

                                                        <div class="ml-auto"><span class="badge badge-success" style="font-size:15px">$<?=$b['min_salary']?> - <?=$b['max_salary']?></span></div>

                                                    </li>

                                                </a>

                                                <?php

                                                        $i++;

                                                        if($i>8)

                                                        {

                                                            $i = 0;

                                                        }

                                                    }

                                                ?>

                                                </ul>

                                            </div>

                                        </div>

                                       

                                        </div>

                                        <?php

                                            }

                                            else

                                            {

                                                ?>

                                                    <p style="margin:10px">No Posts Found</p>

                                                <?php

                                            }

                                        ?>

                                    </div>

								</div>

							</div>

						</div>

					</div>

								</form>

							</div>

						</div>

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

			<p class="mb-0">All Weather Help @<?=date("Y");?> | Developed By : <a href="https://www.cyberflow.in" target="_blank">CyberFlow</a>

			</p>

		</div>

		<!-- end footer -->

	<!-- </div> -->

	<!-- end wrapper -->

	<!--start switcher-->

	

	<!--end switcher-->

	<?php

		require_once 'javascript.php'; 

	?>

</body>





</html>