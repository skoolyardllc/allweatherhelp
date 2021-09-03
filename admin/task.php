v<?php

	

	require_once 'header_new.php';



	if(isset($_GET['token'])&&!empty($_GET['token']))

    {

        $id = $_GET['token'];

        $token = $_GET['token'];

        $sql = "SELECT pt.*,up.f_name,up.l_name,up.avtar,up.mobile from post_task pt, user_profile up where pt.e_id = up.u_id and pt.id='$id'";

        if($result = $conn->query($sql))

        {

            if($result->num_rows > 0)

            {

                $detail = $result->fetch_assoc();

            }

        }

        else

        {

            $error =  $conn->error;

        }

        $caty = $detail['t_catagory'];

        $sql = "SELECT * from task_category where id='$caty'";

        if($result = $conn->query($sql))

        {

            if($result->num_rows > 0)

            {

                $category = $result->fetch_assoc();

            }

        }

        $userid=$detail['e_id'];

        $sql = "SELECT email from users where id = $userid";

        if($result = $conn->query($sql))

        {

            if($result->num_rows > 0)

            {

                $email = $result->fetch_assoc();

            }

        }

        $sql = "SELECT email from users where id = $userid";

        if($result = $conn->query($sql))

        {

            if($result->num_rows > 0)

            {

                $email = $result->fetch_assoc();

            }

        }

        $mile = "none";

        $sql = "SELECT at.c_id,up.f_name,up.l_name,up.avtar,up.mobile from accepted_task at,user_profile up where at.t_id='$token' and at.c_id=up.u_id limit 1";

        if($result = $conn->query($sql))

        {

            if($result->num_rows > 0)

            {

                $accepter = $result->fetch_assoc();

                // print_r($accepter);

                $acc_id = $accepter['c_id'];

                $sql = "SELECT email,type from users where id = '$acc_id'";

                if($result = $conn->query($sql))

                {

                    if($result->num_rows > 0)

                    {

                        $account = $result->fetch_assoc();

                        $mile = "initial";

                        switch($account['type'])

                        {

                            case 3:

                                $name = "Contractor";

                                $para = "<i class='lni lni-users'></i> Contractor";

                                break;

                            

                            case 2:

                                $name = "Business / LLC";

                                $para = "<i class='bx bx-group'></i> Business / LLC";

                                break;

                        }

                    }

                }

            }

        }

        else

        {

            echo $conn->error;

        }



        $sql = "SELECT b.*,up.f_name,up.l_name,up.avtar from bidding b,user_profile up where b.t_id='$token' and b.c_id=up.u_id";

        if ($result = $conn->query($sql)) {

            if ($result->num_rows) {

                while($row = $result->fetch_assoc())

                {

                    $bidders[] = $row;

                }

            }

        }

        // print_r($bidders);

        $sql = "SELECT * from milestones where task_id = '$token'";

        if ($result = $conn->query($sql)) {

            if ($result->num_rows) {

                while($row = $result->fetch_assoc())

                {

                    $milestone[] = $row;

                }

            }

        }

        // print_r($milestone);

        $sql="select * from uploaded_documents where t_id='$token'";

        if ($result = $conn->query($sql)) {

            if ($result->num_rows) {

                while($row = $result->fetch_assoc())

                {

                    $attachments[] = $row;

                }

            }

        }

        // print_r($attachments);

        $d=strtotime($detail['time_stamp']);

        $timestamp = date("M d Y", $d);

        $pay_type = '';

        $type = $detail['pay_type'];

        switch ($type) {

            case 1:

                $pay_type = "Fixed price";

                break;

            case 2:

                $pay_type = "Hourly rate";

                break;

        }

    } 



?>

<style>

    .bi-check-all,.bi-toggle-on{color:darkgreen;font-size:17px}

    .bi-x,.bi-toggle-off{color:red;font-size:17px}

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

						<div class="breadcrumb-title pr-3">Tasks Details</div>

						<div class="pl-3">

							<nav aria-label="breadcrumb">

								<ol class="breadcrumb mb-0 p-0">

									<li class="breadcrumb-item"><a href="dashboard"><i class='bx bx-home-alt'></i></a>

									</li>

									<li class="breadcrumb-item active" aria-current="page">Tasks Details</li>

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

                                <div class="card radius-15">

							<div class="card-body">

								<!-- <div class="row"  style="margin-bottom:20px">

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

								</div> -->

								<!--end row-->

								<ul class="nav nav-pills">

                                    <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#Edit-Profile"><span class="p-tab-name">Task Details</span><i class='bx bx-message-edit font-24 d-sm-none'></i></a>

									</li>

                                    <li class="nav-item" > <a class="nav-link"  data-toggle="tab" href="#doc"><span class="p-tab-name">Task Attachments</span><i class='bx bxs-user-rectangle font-24 d-sm-none'></i></a>

									</li>

									<li class="nav-item"> <a class="nav-link " data-toggle="tab" href="#Experience"><span class="p-tab-name">Posted By</span><i class='bx bx-donate-blood font-24 d-sm-none'></i></a>

									</li>

									<li class="nav-item" > <a class="nav-link" id="profile-tab" data-toggle="tab" href="#Biography"><span class="p-tab-name">Accepted By</span><i class='bx bxs-user-rectangle font-24 d-sm-none'></i></a>

									</li>

                                    <li class="nav-item" > <a class="nav-link" id="profile-tab" data-toggle="tab" href="#bidders"><span class="p-tab-name">Bidders</span><i class='bx bxs-user-rectangle font-24 d-sm-none'></i></a>

									</li>

                                    <li class="nav-item" > <a class="nav-link" id="profile-tab" data-toggle="tab" href="#mile"><span class="p-tab-name">Milestone</span><i class='bx bxs-user-rectangle font-24 d-sm-none'></i></a>

									</li>

                                   

									

								</ul>

								<div class="tab-content mt-3">

									<div class="tab-pane fade" id="Experience">

										<div class="card shadow-none border mb-0 radius-15">

											<div class="card-body">

												<div class="d-sm-flex align-items-center mb-3">

                                                    <div class="row">

                                                        <div class="col-lg-12">

                                                            <h4 class="mb-0">Customer Details</h4>

                                                        </div>

                                                       

                                                            

                                                    </div>

                                                        

												</div>

                                                <div class="row">

                                                    <div class="col-lg-6 ">

                                                        <div class="d-md-flex align-items-center">

                                                            <div class="mb-md-0 mb-3">

                                                                <img src="../<?=$detail['avtar']?>" class="rounded-circle shadow" width="130" height="130" alt="" />

                                                            </div>

                                                            <div class="ml-md-4 flex-grow-1">

                                                                <div class="d-flex align-items-center mb-1">

                                                                    <h4 class="mb-0"><?=$detail['f_name']?> <?=$detail['l_name']?></h4>

                                                                </div>

                                                                <p class="text-primary"><i class='lni lni-user'></i> Customer</p>

                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="col-lg-6">

                                                        

                                                        <div class="form-row">

                                                            <div class="form-group col-md-12">

                                                                <label>Email</label>

                                                                <input type="text" class="form-control" value="<?=$email['email']?>"  name="email" disabled/>

                                                            </div>

                                                            <div class="form-group col-md-12">

                                                                <label>Phone Number</label>

                                                                <input type="text" class="form-control" value="<?=$detail['mobile']?>" name="phone" disabled/>

                                                            </div>

                                                        </div>

                                                        <div class="row">

                                                        

                                                        <div class="col-lg-12" style="display:flex;flex:1;justify-content:flex-end">

                                                             <a href="profile?token=<?=$userid?>" target="_blank"><i class="bi bi-eye"></i>View Profile</a>

                                                         </div>

                                                             

                                                     </div>

                                                    </div>

                                                   

                                                    

                                                </div>

                                               

											</div>

										</div>

									</div>

									<div class="tab-pane fade" id="Biography">

                                        <div class="card shadow-none border mb-0 radius-15">

											<div class="card-body">

                                                <?php

                                                    if(isset($accepter))

                                                    {

                                                        ?>

                                                            <div class="d-sm-flex align-items-center mb-3">

                                                    <div class="row">

                                                        <div class="col-lg-12">

                                                            <h4 class="mb-0"><?=$name?> Details</h4>

                                                        </div>

                                                       

                                                            

                                                    </div>

                                                        

												</div>

                                                <div class="row">

                                                    <div class="col-lg-6 ">

                                                        <div class="d-md-flex align-items-center">

                                                            <div class="mb-md-0 mb-3">

                                                                <img src="../<?=$accepter['avtar']?>" class="rounded-circle shadow" width="130" height="130" alt="" />

                                                            </div>

                                                            <div class="ml-md-4 flex-grow-1">

                                                                <div class="d-flex align-items-center mb-1">

                                                                    <h4 class="mb-0"><?=$accepter['f_name']?> <?=$accepter['l_name']?></h4>

                                                                </div>

                                                                <p class="text-primary"><?=$para?></p>

                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="col-lg-6">

                                                        

                                                        <div class="form-row">

                                                            <div class="form-group col-md-12">

                                                                <label>Email</label>

                                                                <input type="text" class="form-control" value="<?=$account['email']?>"  name="email" disabled/>

                                                            </div>

                                                            <div class="form-group col-md-12">

                                                                <label>Phone Number</label>

                                                                <input type="text" class="form-control" value="<?=$accepter['mobile']?>" name="phone" disabled/>

                                                            </div>

                                                        </div>

                                                        <div class="row">

                                                        

                                                        <div class="col-lg-12" style="display:flex;flex:1;justify-content:flex-end">

                                                             <a href="profile?token=<?=$acc_id?>" target="_blank"><i class="bi bi-eye"></i>View Profile</a>

                                                         </div>

                                                             

                                                     </div>

                                                    </div>

                                                   

                                                    

                                                </div>

                                                        <?php

                                                    }

                                                    else

                                                    {

                                                        ?>

                                                            The Project is not taken by anyone till now!

                                                        <?php

                                                    }

                                                ?>

												

                                               

											</div>

										</div>

                                    </div>

                                    <div class="tab-pane fade" id="doc">

                                        

                                        <div class="col-lg-6">

                                            <div class="card shadow-none border mb-0 radius-15">

                                                <div class="card-body" style="padding-top:10px;padding-bottom:3px">

                                                    <div class="row">

                                                        <?php

                                                            if(isset($attachments)) 

                                                            {

                                                                $counter=0;

                                                                foreach($attachments as $file)

                                                                {



                                                                    $ext=pathinfo($file['document'],PATHINFO_EXTENSION);

                                                                    if(strtolower($ext)=="pdf")

                                                                    {

                                                                        

                                                                    ?>

                                                                    <div class="col-md-6" id="file<?=$counter?>">

                                                                        <div class="col-md-4">

                                                                            <a href="../uploads/<?=$file['document']?>"  target="_blank"><img src="../images/PDF.svg" width="100px" height="100px"/></a>            

                                                                        </div>

                                                                    </div>

                                                                    <?php

                                                                    }

                                                                    else

                                                                    {

                                                                    ?>

                                                                    <div class="col-md-6" id="file<?=$counter?>">

                                                                        <div class="col-md-4">

                                                                            <a href="../uploads/<?=$file['document']?>" target="_blank"><img src="../uploads/<?=$file['document']?>" width="100px" height="100px"/></a>

                                                                        </div>

                                                                    </div>

                                                                    <?php

                                                                    }

                                                                }

                                                            }

                                                            else

                                                            {

                                                                ?>

                                                                    <p style="margin-left:10px">No attachments Found!</p> 

                                                                <?php

                                                            }

                                                        ?>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                        

                                    </div>

                                    <div class="tab-pane fade" id="bidders">

                                        <?php

                                            if(isset($bidders))

                                            {

                                                

                                        ?>

                                        <div class="row">

                                        <div class="col-lg-6" >

                                            <div class="dashboard-social-list" style="height:62vh">

                                                <ul class="list-group list-group-flush">

                                                <?php

                                                    foreach($bidders as $b)

                                                    {

                                                        $c=strtotime($b['time_stamp']);

                                                        $time = date("M d Y H:m", $c);

                                                        $time_type = '';

                                                        $type = $b['time_type'];

                                                        switch ($type) {

                                                            case 1:

                                                                $time_type = "Hours";

                                                                break;

                                                            case 2:

                                                                $time_type = "Days";

                                                                break;

                                                        }

                                                        $c_id = $b['c_id'];

                                                        $sql = "SELECT * FROM users where id='$c_id'";

                                                        if($result = $conn->query($sql))

                                                        {

                                                            if($result->num_rows > 0)

                                                            {

                                                                $bid = $result->fetch_assoc();

                                                            }

                                                        }

                                                        switch($bid['type'])

                                                        {

                                                            case 3:

                                                                $usertype = "Contractor";

                                                                $icon = "lni lni-users";

                                                                break;

                                                            

                                                            case 2:

                                                                $usertype = "Business / LLC";

                                                                $icon = "bx bx-group";

                                                                break;

                                                        }

                                                ?>

                                                    <li class="list-group-item d-flex align-items-center" style="cursor:pointer" onclick="viewbidderDetails('<?=$b['bid_expected']?>','<?=$b['time_no']?>','<?=$time_type?>','<?=$time?>','<?=$b['f_name']?> <?=$b['l_name']?>','<?=$b['avtar']?>','<?=$usertype?>','<?=$icon?>','<?=$c_id?>','<?=$b['description']?>')">

                                                        <div class="media align-items-center">

                                                            <div class="  rounded-circle">                                                               

                                                                <img src="../<?=$b['avtar']?>" class="rounded-circle shadow" width="50" height="50" alt="" />

                                                            </div>

                                                            <div class="media-body ml-2" style="margin-top:20px">

                                                                <h6 class="mb-0"><?=$b['f_name']?> <?=$b['l_name']?></h6>

                                                                <p><?=$time?></p>

                                                            </div>

                                                        </div>

                                                        <div class="ml-auto"><span class="badge badge-success">$<?=$b['bid_expected']?></span></div>

                                                    </li>

                                                <?php

                                                    }

                                                ?>

                                                </ul>

                                            </div>

                                        </div>

                                        <div class="col-lg-6" id="bidderdetails" style="display:none;height:62vh">

                                            <h4>Bidder Details</h4>

                                            <div class="d-md-flex align-items-center">

                                                <div class="mb-md-0 mb-3">

                                                    <img src="" id="bidderimage" class="rounded-circle shadow" width="80" height="80" alt="" />

                                                </div>

                                                <div class="ml-md-4 flex-grow-1">

                                                    <div class="d-flex align-items-center mb-1">

                                                    <a href="" id="bidderprofile"><h4 class="mb-0" id="biddername"></h4></a>

                                                    </div>

                                                    <p class="text-primary" id="bidderdet"></p>

                                                </div>

                                               

                                            </div>

                                            

                                            <div class="form-row" style="margin-top:10px">

                                                <div class="form-group col-md-12">

                                                    <label>Bid Amount</label>

                                                    <input type="text" class="form-control" value=""  id="bidamount" disabled/>

                                                </div>

                                                <div class="form-group col-md-12">

                                                    <label>Expected Delivery Time</label>

                                                    <input type="text" class="form-control" value="" id="bidtime" disabled/>

                                                </div>

                                                <div class="form-group col-md-12">

                                                    <label>Description</label>

                                                    <textarea rows="3" class="form-control" value="" id="biddescription"  name="address" disabled ></textarea>

                                                </div>

                                            </div>

                                        </div>

                                        </div>

                                        <?php

                                            }

                                        ?>

                                    </div>

                                    <div class="tab-pane fade" id="mile">

                                        <?php

                                            if(isset($milestone))

                                            {

                                                $i = 0;

                                                $color = ['youtube','facebook','dribbble','twitter','tumblr','linkedin','youtube','linkedin','dribbble','tumblr','facebook'];

                                                $ico = ['lni-star-empty','lni-slack','lni-pallet','lni-paperclip','lni-sketch','lni-surf-board','lni-bitbucket','lni-500px'];

                                        ?>

                                        <div class="row">

                                        <div class="col-lg-6" >

                                            <div class="dashboard-social-list" style="height:74vh">

                                                <ul class="list-group list-group-flush">

                                                <?php

                                                    foreach($milestone as $b)

                                                    {

                                                        

                                                        // echo $color[$i];

                                                        // echo $b['time_stamp'];

                                                        $d=strtotime($b['time_stamp']);

                                                        $tim = date("M d Y H:m", $d);

                                                        $e=strtotime($b['due_date']);

                                                        $due = date("M d Y ", $e);

                                                        $pay_status = "";

                                                        $status = "";

                                                        switch($b['pay_status'])

                                                        {

                                                            case 1:

                                                                $pay_status = "Paid";

                                                                $pay = "bi bi-check-all";

                                                                break;



                                                            case 0:

                                                                $pay_status = "Unpaid";

                                                                $pay = "bi bi-x";

                                                                break;

                                                        }

                                                        switch($b['mil_status'])

                                                        {

                                                            case 2:

                                                                $status = "Completed";

                                                                $icon = "bi bi-check-all";

                                                                break;



                                                            case 1:

                                                                $status = "Active";

                                                                $icon = "bi bi-toggle-on";

                                                                break;



                                                            case 0:

                                                                $status = "Unactive";

                                                                $icon = "bi bi-toggle-off";

                                                        }



                                                ?>

                                                    <li class="list-group-item d-flex align-items-center" style="cursor:pointer" onclick="viewmilestone('<?=$b['mil_title']?>','<?=$b['mil_desc']?>','<?=$tim?>','<?=$due?>','<?=$b['price']?>','<?=$pay_status?>','<?=$status?>','<?=$pay?>','<?=$icon?>')">

                                                        <div class="media align-items-center">

                                                        <div class="widgets-social bg-<?=$color[$i]?> rounded-circle text-white"><i class="lni <?=$ico[$i]?>"></i>

                                                        </div>

                                                            <div class="media-body ml-2" style="margin-top:20px">

                                                                <h6 class="mb-0"><?=$b['mil_title']?></h6>

                                                                <p><?=$tim?></p>

                                                            </div>

                                                        </div>

                                                        <div class="ml-auto"><span class="badge badge-success">$<?=$b['price']?></span></div>

                                                    </li>

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

                                        <div class="col-lg-6" id="milestonedetails" style="display:none;height:74vh">

                                            <h4>Milestone Details</h4>

                                            

                                            

                                            <div class="form-row" style="margin-top:10px">

                                                <div class="form-group col-md-12">

                                                    <label>Title</label>

                                                    <input type="text" class="form-control" value=""  id="miltitle" disabled/>

                                                </div>

                                                <div class="form-group col-md-12">

                                                    <label>Price</label>

                                                    <input type="text" class="form-control" value="" id="milprice" disabled/>

                                                </div>

                                                <div class="form-group col-md-12">

                                                    <label>Due Date</label>

                                                    <input type="text" class="form-control" value="" id="duedat" disabled/>

                                                </div>

                                                <div class="form-group col-md-6">

                                                    <label>Milestone status</label>

                                                    <p id="milestonestatus"></p>

                                                </div>

                                                <div class="form-group col-md-6">

                                                    <label>Payment status</label>

                                                    <p id="paymentstatus"></p>

                                                </div>

                                                <div class="form-group col-md-12">

                                                    <label>Description</label>

                                                    <textarea rows="3" class="form-control" value="" id="mildesc"  name="address" disabled ></textarea>

                                                </div>

                                            </div>

                                        </div>

                                        </div>

                                        <?php

                                            }

                                            else

                                            {

                                                ?>

                                                    <p style="margin:10px">No Milestones Found</p>

                                                <?php

                                            }

                                        ?>

                                    </div>

                                       

                                       

									

									<div class="tab-pane fade show active" id="Edit-Profile">

										<div class="card shadow-none border mb-0 radius-15">

											<div class="card-body">

												<div class="form-body">

													<div class="row">

														<div class="col-12 col-lg-12">

                                                        <div class="form-row" >

                                                            <div class="form-group col-md-6">

                                                                <label>Task Name</label>

                                                                <input type="text" class="form-control" value="<?=$detail['t_name']?>"  name="f_name" disabled/>

                                                            </div>

                                                            <div class="form-group col-md-6">

                                                                <label>Task Category</label>

                                                                <input type="text" class="form-control" value="<?=$category['category']?>" name="l_name" disabled/>

                                                            </div>

                                                        </div>

                                                        <div class="form-row">

                                                            <div class="form-group col-md-6">

                                                                <label>Posted On</label>

                                                                <input type="text" class="form-control" value="<?=$timestamp?>"  name="email" disabled/>

                                                            </div>

                                                            <div class="form-group col-md-6">

                                                                <label>End Date</label>

                                                                <input type="text" class="form-control" value="<?=$detail['end_date']?>" name="phone" disabled/>

                                                            </div>

                                                        </div>

                                                        <div class="form-row" >

                                                           

                                                            <div class="form-group col-md-6">

                                                                <label>Location</label>

                                                                <input type="text" class="form-control" value="<?=$detail['location']?>" name="nationality" disabled/>

                                                            </div>

                                                        

                                                            <div class="form-group col-md-6">

                                                                <label>Pay Type</label>

                                                                <input type="text" class="form-control" value="<?= $pay_type ?>"  name="tagline" disabled/>

                                                            </div>

                                                        </div>

                                                        <div class="form-row" >

                                                           

                                                            <div class="form-group col-md-6">

                                                                <label>Minimum Salary</label>

                                                                <input type="text" class="form-control" value="$ <?=$detail['min_salary']?>" name="nationality" disabled/>

                                                            </div>

                                                        

                                                            <div class="form-group col-md-6">

                                                                <label>Maximum Salary</label>

                                                                <input type="text" class="form-control" value="$ <?=$detail['max_salary']?>"  name="tagline" disabled/>

                                                            </div>

                                                        </div>

                                                        

                                                        <div class="form-row" >

                                                            <div class="form-group col-md-12">

                                                                <label>Description</label>

                                                                <textarea rows="3" class="form-control" value=""  name="address" disabled><?=$detail['t_description']?></textarea>

                                                            </div>

                                                        

                                                        </div>

                                                        

                                                        

                                                        

											

														</div>

													

													</div>

												</div>

											</div>

										</div>

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

		<!-- </div> -->

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



	<!--end switcher-->

	

</body>
<?php

    require_once 'javascript.php'; 

?>
<script>

    function viewbidderDetails(bid_expected,time_no,time_type,time,name,avtar,usertype,icon,userid,description)

    {

        $("#bidderimage").attr("src","../"+avtar);

        $("#biddername").html(name);

        $("#bidderdet").html("<i class='"+icon+"'></i>"+usertype);

        $("#bidamount").val("$"+bid_expected);

        $("#bidtime").val(time_no+" "+time_type)

        $("#biddescription").html(description);

        $("#bidderprofile").attr("href","profile?token="+userid)

        $("#bidderdetails").show();

    }

    // <li class="list-group-item d-flex align-items-center" style="cursor:pointer" onclick="viewmilestone('<?=$b['mil_title']?>','<?=$b['desc']?>','<?=$tim?>','<?=$due?>','<?=$b['price']?>','<?=$pay_status?>','<?=$status?>')">

    function viewmilestone(title,desc,tim,due,price,pay_status,status,pay,icon)

    {

        $("#miltitle").val(title);

        $("#milprice").val("$"+price);

        $("#mildesc").html(desc);

        $("#duedat").val(due);

        $("#paymentstatus").html("<i class='"+pay+"'></i>"+pay_status)

        $("#milestonestatus").html("<i class='"+icon+"'></i>"+status)

        $("#milestonedetails").show();

    }

</script>

</html>