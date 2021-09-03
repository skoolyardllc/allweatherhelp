<?php 



	require_once 'lib/core.php';





	$response = array(

				'success' => false,

				'message' => "no message",

				'data' => "",

				'total_amount' => "",

				'total_today' => "",

			);





	if($_SERVER["REQUEST_METHOD"] === "GET"){



		$user_id = $_GET['user_id'];

		$sql = "SELECT count(mt.id) as noOfRows FROM milestones_transaction mt, user_profile up WHERE mt.contractor_id = '{$user_id}' and up.u_id = mt.customer_id ORDER BY mt.id DESC";

		if($res = $conn->query($sql))

		{

			$noofresults = $res->fetch_assoc();

		}

		else

		{

			$error =  $conn->error;

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

		$pagebutton = "";

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

			$pagebutton .=	"<li><a href='javascript:;' onclick='pagination($page)' class='$active ripple-effect'>$page</a></li> &nbsp;";

		

		}  

		$response['pages']=$pagebutton;

		$query = "SELECT mt.id, mt.customer_id, mt.transaction_id, mt.transaction_detail, mt.amount, mt.status, mt.timestamp, up.f_name, up.l_name FROM milestones_transaction mt, user_profile up WHERE mt.contractor_id = '{$user_id}' and up.u_id = mt.customer_id ORDER BY mt.id DESC limit $page_first_result , $results_per_page";

		$result4show_transaction = $conn->query($query);

		if ($result4show_transaction->num_rows > 0) {

			$response["success"] = true;

			$inhtml ='';

			$htmlforphone = '';

			$total_amount = 0;

			 $total_today = 0;

			 $withdraw_today =0;

			 $withdraw_total = 0;

			 $t_date = date("Y-m-d");

			 $i=1;

			while($row = $result4show_transaction->fetch_assoc())

			{

				$id = $row['id'];

				$payment_ref = $row['transaction_id'];

				$customer_id = $row['customer_id'];

				$description = $row['transaction_detail'];

				$user = $row['f_name']." ".$row['l_name'];

				$amount = $row['amount'];

				$status = $row['status'];

				$timestamp = $row['timestamp'];



				if($status == 1){

					$status = "Money Credited";

				} else {

					$status = "Money withdrawal";

				}

				if($row['status']!=1)

				{

					$withdraw_total += $row['amount'];

				}

				if((strtotime($t_date)) < strtotime($row['timestamp']) && $row['status']!=1){

					$withdraw_today += $row['amount'];

				}

				if((strtotime($t_date)) < strtotime($row['timestamp'])){

					$total_today += $row['amount'];

				}



				$timestamp = date('M d Y', strtotime($row['timestamp']));

				// $project_id = $row['project_id'];

				$total_amount += $row['amount'];

				$onclicklaptop = "viewonlaptop(`$payment_ref`,`$user`,`$description`,`$timestamp`,`$amount`,`$status`,`$id`)";

				$onclickphone = "viewonphone(`$payment_ref`,`$user`,`$description`,`$timestamp`,`$amount`,`$status`,`$id`)";

				$inhtml .= "

							

							<tr>

								<td  class='arrows'>$i</td>

								<td data-label='Name'>$user</td>

								<td data-label='Date'>$timestamp</td>

								<td data-label='Amount'>$ $amount</td>

								<td data-label='View'>

									<button class='btn btn-outline-primary viewonlaptop' id='viewonlaptop$id' onclick='$onclicklaptop'><i class='bi bi-eye-fill'></i></button>

									<button class='btn btn-outline-primary viewonphone'><i class='bi bi-eye-fill'></i></button>

								</td>

							</tr>

				";

				/*$inhtml .= $total_price;*/

				$htmlforphone .= "<li>

									<div class='card border-primary mb-3' style='max-width: 18rem;'>

										<div class='card-body '>

											<div class='row'>

												<div class='col-lg-9' style='width:75%'>$user</div>

												<div class='col-lg-3' style='width:25%'><span class='badge badge-success'>$ $amount</span></div>

											</div>

										</div>

										<div class='card-footer'>

											<a href='.8449129' class='popup-with-zoom-anim button gray ripple-effect margin-top-5 margin-bottom-10' >More Info</a>

											<button class='btn btn-outline-primary btn-block viewonphone' style='border:0' data-toggle='modal' data-target='#small-dialog-1'> More Information <i class='bi bi-arrow-right'></i></button> 

										</div>

									</div>

								</li>

			";

				$i++;

			}

			$response["data"] = $inhtml;

			$response["htmlforphone"] = $htmlforphone;

			$response['total_amount'] = $total_amount;

			$response['total_today'] = $total_today;

			$response['withdraw_today']=$withdraw_today;

			$response['withdraw_total']=$withdraw_total;

			



		} else {

			$response["success"] = false;

			$response["message"] = "No response";

			$response["target"] = "";

		}

		echo json_encode($response);

		

	}







 ?>