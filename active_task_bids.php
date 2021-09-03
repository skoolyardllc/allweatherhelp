<?php

    require_once 'header.php';

    require_once 'navbar.php';



	if (isset($_POST['saveEditButton'])){

		$ebid_id = $conn->real_escape_string($_POST['ebid_id']);

        $ebid_expected = $conn->real_escape_string($_POST['ebid_expected']);

        $etime_no = $conn->real_escape_string($_POST['etime_no']);

        $editTime_type = $conn->real_escape_string($_POST['editTime_type']);

		$edescription = $conn->real_escape_string($_POST['edescription']);



		$sql ="update bidding set bid_expected='$ebid_expected',time_no='$etime_no',time_type='$editTime_type',description='$edescription' where id='$ebid_id'";

		if($conn->query($sql))

		{

			$changes_saved =true; 

		}

		else{

			$error =$conn->error; 

		}

	}



    if(isset($_POST['delete_bid']))

    { 

        $id=$conn->real_escape_string($_POST['delete_bid']);

        

        $sql="delete from bidding where id=$id";

        

        if($conn->query($sql))

        {

            $deleteBid=true;   

        }

        else

        {

            $errorPost=$conn->error;

        }

    }



    $sql = "select pt.*,b.bid_expected,b.id as bid_id,b.t_id,b.c_id,b.time_no,b.time_type,b.description from post_task pt, bidding b where b.c_id ='$USER_ID' and pt.id=b.t_id order by b.id desc";

    if($result=$conn->query($sql)){

        if($result->num_rows){

            while($row=$result->fetch_assoc())

            {

				$t_id= $row['t_id'];

				$sql = "SELECT * from accepted_task where t_id='$t_id'";

				if($resu = $conn->query($sql))

				{

					if($resu->num_rows > 0)

					{



					}

					else

					{

						$active_bids[]=$row;

					}

				}

            }

        }

    }



?>





<style>	

/* .bidsOfUser{width: 50%;} */



@media screen and (max-width: 600px) {

	.bidsOfUser{width: 100%;}

}

</style>

<!-- Wrapper -->

<div id="wrapper">



<div class="clearfix"></div>

<!-- Header Container / End -->





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

				<h3>My Active Bids</h3>



				<!-- Breadcrumbs -->

				<nav id="breadcrumbs" class="dark">

					<ul>

						<li><a href="index.php">Home</a></li>

						<li><a href="dashboard.php">Dashboard</a></li>

						<li>My Active Bids</li>

					</ul>

				</nav>

			</div>



			<?php

			if(isset($changes_saved)){

				?>

					<div class="alert alert-success" role="alert">

						Your bid has been updated !!!

					</div>

				<?php

			}

			?>

	

			<!-- Row -->

			<div class="row">



				<!-- Dashboard Box -->

				<div class="col-xl-12">

					<div class="dashboard-box margin-top-0">



						<!-- Headline -->

						<div class="headline">

							<h3><i class="icon-material-outline-gavel"></i> Bids List</h3>

						</div>



						<div class="content">

							<ul class="dashboard-box-list">

                                <?php

								if(isset($active_bids))

								{

									foreach($active_bids as $active_bid){

                                    ?>                                            

									

                                        <li class="float-center">

                                            <!-- Job Listing -->

											

                                            <div class="job-listing width-adjustment">



                                                <!-- Job Listing Details -->

                                                <div class="job-listing-details">

                                                    <!-- Details -->

                                                    <div class="job-listing-description">

                                                        <h3 class="job-listing-title"><a href="bid_task?token=<?=$active_bid['t_id']?>"><?=$active_bid['t_name']?></a></h3>

														<p> <?=$active_bid['t_description']?></p>

													</div>

                                                </div>

                                            </div>

                                            <!-- Task Details -->

											<form method="post" class="bidsOfUser" >

                                            <?php

                                                $time_type='';

                                                switch ($active_bid['time_type']){

                                                    case 1:

                                                        $time_type="Hours";

                                                        break;

                                                    case 2:

                                                        $time_type = "Days";

                                                        break;

                                                }

                                            ?>

                                            <ul class="dashboard-task-info">

                                                <li><strong><?=$active_bid['bid_expected']?></strong><span>Hourly Rate</span></li>

                                                <li><strong><?=$active_bid['time_no']?> <?=$time_type?></strong><span>Delivery Time</span></li>

                                            </ul>

                                            <br>

                                            

                                                <!-- Buttons -->

                                                <div class="buttons-to-right always-visible">

                                                    <a onclick="giveTaskid(<?=$active_bid['bid_id']?>,<?=$active_bid['bid_expected']?>,<?=$active_bid['time_no']?>,<?=$active_bid['time_type']?>,'<?=$active_bid['description']?>')" href="#small-dialog" class="popup-with-zoom-anim button dark ripple-effect ico float-right" title="Edit Bid" data-tippy-placement="top"><i class="icon-feather-edit"></i></a>

                                                    <button  name="delete_bid" value="<?=$active_bid['bid_id']?>" class="button red ripple-effect ico float-right" title="Cancel Bid" data-tippy-placement="top"><i class="icon-feather-trash-2"></i></button>

                                                </div>

											</form>

                                        </li>

									<!-- </form> -->

                                    <?php

										}

                                    }

									else 

									{

										?>

											<div class="alert alert-primary">

												No active Bids at the moment!!

											</div>

										<?php

									}

                                    ?>

								

							</ul>

						</div>

					</div>

				</div>



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



</div>

<!-- Wrapper / End -->





<!-- Edit Bid Popup

================================================== -->

<div id="small-dialog" class="zoom-anim-dialog mfp-hide dialog-with-tabs">



	<!--Tabs -->

	<div class="sign-in-form">



		<ul class="popup-tabs-nav">

			<li><a href="#tab">Edit Bid</a></li>

		</ul>



		<div class="popup-tabs-container">

			<form method="post">

				<!-- Tab -->

				<div class="popup-tab-content" id="tab">

							

						<!-- Bidding -->

						<div class="bidding-widget">

							<!-- Headline -->

							<span class="bidding-detail">Set your <strong>minimal hourly rate</strong></span>



							<!-- Price Slider -->

							<!-- <div class="bidding-value">$<span id="biddingVal"></span></div> -->

							<!-- <input class="bidding-slider" onchange="change_bidding_amount(value)" type="text" value="$('#ebid_expected').val()" data-slider-handle="custom" data-slider-currency="$" data-slider-min="10" data-slider-max="60" data-slider-value="50" id="bid_slider" data-slider-step="1" data-slider-tooltip="hide" /> -->

							<div class="bidding-field">

								<!-- Quantity Buttons -->

								<div class="qtyButtons with-border">

									<div class="qtyDec"></div>

									<input type="text" name="ebid_expected" id="ebid_expected" value="">

									<!-- <input type="hidden" id="etime_no" name="etime_no" class="form-control"> -->

									<div class="qtyInc"></div>

								</div>

							</div>

							<input type="hidden" id="ebid_id" name="ebid_id" class="form-control">

							

							<!-- <input type="hidden" id="ebid_expected" name="ebid_expected" class="form-control"> -->

							

							<!-- <input type="hidden" id="edescription" name="edescription" class="form-control"> -->

							<!-- Headline -->

							<span class="bidding-detail margin-top-30">Set your <strong>delivery time</strong></span>



							<!-- Fields -->

							<div class="bidding-fields">

								<div class="bidding-field">

									<!-- Quantity Buttons -->

									<div class="qtyButtons with-border">

										<div class="qtyDec"></div>

										<input type="text" name="etime_no" id="etime_no" value="">

										<!-- <input type="hidden" id="etime_no" name="etime_no" class="form-control"> -->

										<div class="qtyInc"></div>

									</div>

								</div>

								

								<div class="bidding-field">

									<select name="editTime_type" id="editTime_type" class="selectpicker default with-border">

										<option  value="1" <?=$time_type_hours?>>Hours</option>

										<option  value="2" <?=$time_type_days?> >Days</option>

									</select>

								</div>

							</div>



							<div class="col-xl-12 margin-top-30">

								<div class="submit-field">

									<h5>Edit your bid</h5>

									<textarea name="edescription" id="edescription" cols="30" rows="8" value="rahul"

										class="with-border"></textarea>

								</div>

							</div>

					</div>

					

					<!-- Button -->

					<button name="saveEditButton" class="button full-width button-sliding-icon ripple-effect" type="submit">Save Changes <i class="icon-material-outline-arrow-right-alt"></i></button>



				</div>

			</form>



		</div>

	</div>

</div>

<!-- Edit Bid Popup / End -->



<?php

    require_once 'js-links.php';

?>



<script>







var request;

function giveTaskid(bid_id,amount,time_no,time_type,description) {

    $("#ebid_id").val(bid_id);

	$("#ebid_expected").val(amount);

	$("#etime_no").val(time_no);

	$("#edescription").val(description);

	$("#editTime_type").val(time_type);

	// $("#biddingVal").text(amount); 

	// $("#bid_slider").attr({"data-slider-value":amount,'value':amount});

	// var max = $("#bid_slider").attr("data-slider-max");

	// var p = (parseFloat(amount)/parseFloat(max))*100;

	// $(".slider-selection").css(`width:${p}%`);

	// $(".min-slider-handle").css(`left:${p}%`);

}



function change_bidding_amount(amount) {

	if(request!=undefined && request.status!=200)

	{

		request.abort()

	}

    request = $.ajax({

        url: "active_task_bids_ajax.php",

        type: "post",

        data: {

            userId: '<?=$USER_ID?>',

            changeBidding_amount: true,

            amount: amount,

			t_id: $('#ebid_id').val(),

        },

        success: function(data) {

            console.log(data);

        },

        error: function(data) {

            console.log("galti");

        }

    })

}



</script>