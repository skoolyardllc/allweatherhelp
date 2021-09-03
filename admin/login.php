<?php



	require_once '../lib/core.php';



	if(isset($_POST['login']) || isset($_POST['loginarrow']))

	{

		$email = $conn->real_escape_string($_POST['email']);

		$password = md5($conn->real_escape_string($_POST['password']));

		$sql = "SELECT * FROM users where email = '$email' and password = '$password' and type='1'";

		if($result = $conn->query($sql))

		{

			if($result->num_rows > 0)

			{

				$row=$result->fetch_assoc();

				$id=$row['id'];

				$_SESSION['user_signed_in']=$email;

				$_SESSION['user_id']=$id;  

				$_SESSION['type']=$type;  

				header('Location:dashboard');

			}

			else

			{

				$error = "Invalid Login Details";

			}

		}

		else

		{

			echo $conn->error;

		}

	}

?>



<!DOCTYPE html>

<html lang="en">





<head>

	<!-- Required meta tags -->

	<meta charset="utf-8" />

	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

	<title>All Weather Help</title>

	<!--favicon-->

	<link rel="icon" href="../images/cyberflow-logo-1.png" type="image/png" />

	<!-- loader-->

	<link href="assets/css/pace.min.css" rel="stylesheet" />

	<script src="assets/js/pace.min.js"></script>

	<!-- Bootstrap CSS -->

	<link rel="stylesheet" href="assets/css/bootstrap.min.css" />

	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&amp;family=Roboto&amp;display=swap" />

	<!-- Icons CSS -->

	<link rel="stylesheet" href="assets/css/icons.css" />

	<!-- App CSS -->

	<link rel="stylesheet" href="assets/css/app.css" />

	<style>
        #mainRow{width:85%}
        @media only screen and (max-width: 600px) {
            #mainRow{width:110%}
        }

	</style>

</head>



<body class="bg-login">

	<!-- wrapper -->

	<div class="wrapper">

		<div class="section-authentication-login d-flex align-items-center justify-content-center">

			<div class="row" id="mainRow">

				<div class="col-12 col-lg-10 mx-auto">

					<div class="card radius-15">

						<div class="row no-gutters">

							<div class="col-lg-6">

								<img src="../images/bg.jpg" class="card-img login-img h-100" style="object-fit:cover" alt="..." id="loginimage">

							</div>

							<div class="col-lg-6">

								<form method="post">

									<div class="card-body p-md-5">

										<div class="text-center">

											<img src="../images/cyberflow-logo-1.png" width="80" alt="">

											<h3 class="mt-4 font-weight-bold">Welcome Admin</h3>

										</div>

										<?php

											if(isset($error))

											{

												?>

													<div class="alert alert-danger alert-dismissible fade show" role="alert">

														<?=$error?>

														<button type="button" class="close" data-dismiss="alert" aria-label="Close">	

														</button>

													</div>

												<?php

											}

										?>

										<!-- <div class="input-group shadow-sm rounded mt-5">

											<div class="input-group-prepend">	<span class="input-group-text bg-transparent border-0 cursor-pointer"><img src="assets/images/icons/search.svg" alt="" width="16"></span>

											</div>

											<input type="button" class="form-control  border-0" value="Log in with google">

										</div> -->

										<div class="login-separater text-center"> <span>LOGIN WITH EMAIL</span>

											<hr/>

										</div>

										<div class="form-group mt-4">

											<label>Email Address</label>

											<input type="text" name="email"; class="form-control" placeholder="Enter your email address" />

										</div>

										<div class="form-group">

											<label>Password</label>

											<input type="password" class="form-control" placeholder="Enter your password" name="password" />

										</div>

										<div class="form-row">

											<div class="form-group col">

												<div class="custom-control custom-switch">

													<!-- <input type="checkbox" class="custom-control-input" id="customSwitch1" checked>

													<label class="custom-control-label" for="customSwitch1">Remember Me</label> -->

												</div>

											</div>

											<!-- <div class="form-group col text-right"> <a href="#"><i class='bx bxs-key mr-2'></i>Forget Password?</a>

											</div> -->

										</div>

										<div class="btn-group mt-3 w-100">

											<button type="submit" name="login" class="btn btn-primary btn-block">Log In</button>

											<button type="submit" name="loginarrow" class="btn btn-primary"><i class="lni lni-arrow-right"></i>

											</button>

										</div>

										<hr>

										<div class="text-center">

										</div>

									</div>

								</form>

							</div>

						</div>

						<!--end row-->

					</div>

				</div>

			</div>

		</div>

	</div>

	<!-- end wrapper -->

</body>





</html>