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

		

		$sql = "SELECT count(id) as noOfRows FROM milestones_payment WHERE user_id = '{$user_id}' ORDER BY id DESC";

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

		

		$query = "SELECT * FROM milestones_payment WHERE user_id = '{$user_id}' ORDER BY id DESC limit $page_first_result , $results_per_page";

		$result4show_transaction = $conn->query($query);

		if ($result4show_transaction->num_rows > 0) {

			$response["success"] = true;

			$inhtml ='';

			$total_amount = 0;

			 $total_today = 0;

			 $t_date = date("Y-m-d");

			 $i=0;

			while($row = $result4show_transaction->fetch_assoc())

			{

				$id = $row['id'];

				$contractor_id = $row['contractor_id'];

				$payment_ref = $row['payment_ref'];

				$description = $row['description'];

				$amount = $row['amount'];

				$status = $row['status'];

				$amm = "";

				if($status == "succeeded")

				{

					$amm = "<span class='badge badge-success' style='font-size:15px'x>$ $amount</span>";

				}

				else

				{

					$amm = "<span class='badge badge-danger' style='font-size:15px'>$ $amount</span>";

				}

				$sql = "select up.f_name , up.l_name from user_profile up where up.u_id='$contractor_id'";

				if($result =$conn->query($sql))

				{

					if($result->num_rows)

					{

						$details = $result->fetch_assoc();

					}

				}

				$user = $details['f_name'] ." ". $details['l_name'];

				if((strtotime($t_date)) < strtotime($row['timestamp'])){

					$total_today += $row['amount'];

				}



				$timestamp = date('M d Y', strtotime($row['timestamp']));

				$project_id = $row['project_id'];

				$total_amount += $row['amount'];

				$onclicklaptop = "viewonlaptop(`$payment_ref`,`$user`,`$description`,`$timestamp`,`$amount`,`$status`,`$id`,`$project_id`)";

				$i++;



				$inhtml .= "

							<!--<div class='accordion__item js-accordion-item '>

								<div class='accordion-header js-accordion-header'>$description || $timestamp</div> 



								<div class='accordion-body js-accordion-body'>



									<div class='accordion-body__contents'>

										<label >Id : </label>

										<input type='text' class='form-control' value='$id' disabled>

										<label >Payment Reference : </label>

										<input type='text' class='form-control' value='$payment_ref' disabled>

										<label >Description : </label>

										<input type='text' class='form-control' value='$description' disabled>

										<label >Amount : </label>

										<input type='text' class='form-control' value='$amount' disabled>

										<label >View : </label>

										<a href='milestone?token=$project_id'><i class='fas fa-eye'></i> View</a>

										<label >Date and Time : </label>

										<input type='text' class='form-control' value='$timestamp' disabled>

										<label >Invoice : </label>

										<a href='#'><i class='fas fa-file-invoice-dollar text-info'></i></a>

									</div>



								</div>

							</div>-->



							<tr>

								<td  class='arrows'>$i </td>

								<td data-label='Name'>$user</td>

								<td data-label='Date'>$timestamp</td>

								<td data-label='Amount'>$amm</td>

								<td data-label='View'>

									<button class='btn btn-outline-primary viewonlaptop' id='viewonlaptop$id' onclick='$onclicklaptop'><i class='bi bi-eye-fill'></i></button>

									<button class='btn btn-outline-primary viewonphone'><i class='bi bi-eye-fill'></i></button>

								</td>

							</tr>

					<!--<tr>

						<td>$id</td>

						<td>$payment_ref</td>

						<td>$description</td>

						<td>$amount</td>

						<td>$status</td>

						<td class='text-center'><a href='milestone?token=$project_id'><i class='fas fa-eye'></i></a></td>

						<td>$timestamp</td>

						<td class='text-center'><i class='fas fa-file-invoice-dollar text-info'></i></td>

						

					</tr>-->";

				/*$inhtml .= $total_price;*/

				

			}

			$response["data"] = $inhtml;

			$response['total_amount'] = $total_amount;

			$response['total_today'] = $total_today;

			

		} else {

			$response["success"] = false;

			$response["message"] = "No response";

			$response["target"] = "";

		}

		echo json_encode($response);

		

	}







 ?>