<?php 

	require_once 'lib/core.php';


	$response = array(
			"success" => false,
			"message" => "No Message",
			"data" => array(),
			"target" => "index.html");


	
	if($_SERVER['REQUEST_METHOD'] === "POST"){
		$milestone_id = $_POST['id'];
		$title = "Milestone- ".$_POST['title'];
		$customer_id = $_POST['customer_id'];
		$emp_id = $_POST['emp_id'];
		$amount = $_POST['amount'];
		$task_id = $_POST['task_id'];
		$stripeToken = $_POST['stripeToken'];
		$payment_ref = $milestone_id.rand(100000, 999999);

		// $sql = "SELECT email from users WHERE id = '{$customer_id}'";
		// $email = $conn->query($sql);


		$sql2 = "SELECT u.email,up.f_name from user_profile up,users u WHERE  u.id=up.u_id and up.u_id = '{$customer_id}' ";
		if($result_name = $conn->query($sql2))
		{
			$row = $result_name->fetch_assoc();
			$name = $row['f_name'];
			$email = $row['email'];
		}else
		{
			echo $conn->error;
		}

		



		// print_r($_POST);
		
		$sql = "INSERT INTO milestones_payment(milestone_id, payment_ref, description, amount, user_id,contractor_id, project_id) VALUES('{$milestone_id}', '{$payment_ref}', '{$title}', '{$amount}', '{$customer_id}','{$emp_id}', '{$task_id}')";
		$result_insert = $conn->query($sql);

	


		//include Stripe PHP library
		  require_once('lib/StripePayment/init.php');    
		  //set stripe secret key and publishable key
		  $stripe = array(
		    "secret_key"      => "sk_test_51ImyzVSEHoT1T6uLsDmZ1anNCc9IYgwdOCZfZ2iRRY53iAyFL5iyRQIC84TIi3bUIjFFCgDdo3iva9LTO5tZ8qm200N2QNG6Ga",
		    "publishable_key" => "pk_test_51ImyzVSEHoT1T6uL8zjq5RsKnx1XcCWPxmViB1AViNCKkCJv7NtEMQWgvMAvWE4ukjNeKr60qEyWyVCjAxHJds9z00gjIkCcr2"
		  );    
		  \Stripe\Stripe::setApiKey($stripe['secret_key']);    
		  //add customer to stripe
		  $customer = \Stripe\Customer::create(array(
		  	'name' =>  $name,
		      'email' => $email,
		      'source'  => $stripeToken,
		      'address' => ["city" => "Delhi", "country" => "India", "line1" => "Usake badd nahi pta", "line2" => "no landmark", "postal_code" => "110044", "state" => "New Delhi"]
		  ));

		  // print_r($customer);


		  // item details for which payment made
		      $itemName = $title;
		      $itemNumber = "PHPZAG987654321";
		      $itemPrice =  $amount*100;
		      $currency = "INR"; /*usd*/
		      $orderID = $payment_ref;    
		      // details for which payment performed
		      $payDetails = \Stripe\Charge::create(array(
		          'customer' => $customer->id,
		          'amount'   => $itemPrice,
		          'currency' => $currency,
		          'description' => $itemName,
		          'metadata' => array(
		              'order_id' => $orderID
		          )
		      ));


		   // get payment details
		     $paymenyResponse = $payDetails->jsonSerialize();
		     $status = $paymenyResponse['status'];
		     
		    if($paymenyResponse){


		    	$sql = "UPDATE milestones_payment SET status = '{$status}' WHERE milestone_id = '{$milestone_id}'";
		    	$result = $conn->query($sql);
				if($status=="succeeded")
				{
					$sql = "UPDATE milestones SET pay_status = '1' , mil_status='2' WHERE id = '{$milestone_id}'";
		    		$result = $conn->query($sql);
					$sql = "INSERT INTO notifications(msg,link,for_id,status,task) values('Payment Received for milestone','milestone?token=$task_id','$emp_id',1,'$task_id')";
					if($result = $conn->query($sql))
					{
						$response['mssgSent'] = "done";
					}
					else
					{
						$response['mssgSent'] = $conn->error;
					}
				}

		    	$sql_transaction = "INSERT INTO milestones_transaction(contractor_id, customer_id, transaction_id, transaction_detail, amount, status) VALUES ('{$emp_id}', '{$customer_id}', '{$payment_ref}', '{$title}', '{$amount}', '1')";
		    	/*status = 1 means added and status 0 means deducted*/
		    	if(!$result_transaction = $conn->query($sql_transaction)){
		    		echo "Please contact admin with the below error<br>";
		    		echo $conn->error;
		    	}



		    	$sql_user_wallet = "SELECT user_wallet FROM user_profile WHERE u_id = '{$emp_id}'";
		    	if($result_user_wallet = $conn->query($sql_user_wallet)){

		    	$row_user_wallet = $result_user_wallet->fetch_assoc();
		    	$user_wallet = $row_user_wallet['user_wallet'];

		    	$total_user_wallet = $user_wallet+$amount;

		    	$sql_update_wallet = "UPDATE user_profile SET user_wallet = '{$total_user_wallet}' WHERE u_id = {$emp_id}";
		    	if(!$result_update_wallet = $conn->query($sql_update_wallet)){
		    		echo "Someting went wrong while adding amount in user_profile amount";
		    	}


		    } /*if result user wallet*/


		    $response["success"] = true;
		    $response["message"] = "Thanks {$name}, Your Payment has been successfully Process!";  
			


	} /*if paymenyResponse*/

	else {
		$response["success"] = true;
		$response["message"] = "Hellow {$name}, Please contact admin we are facing problem while processing your payment!";
	}



	} /*Server request POST*/
	else{

		header("location : index.php");
	}



	echo json_encode($response);




 ?>