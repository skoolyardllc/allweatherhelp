<?php
   require_once 'lib/core.php';
   require_once 'navbar.php';

   if(user_auth()){
      header('Location:index.php');
   }

   // $sql="select * from users where id='$USER_ID'";
   // $res = $conn->query($sql);
   // if($res->num_rows)
   // {
   //    $type = $res;
   // }
?>

<!doctype html>
<html lang="en">

<head>

<!-- Basic Page Needs
================================================== -->
<title>All Weather Help</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- CSS
================================================== -->
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/colors/blue.css">

</head>
<body>

<?php

if(isset($_POST['register']))
{
    $email = $conn->real_escape_string($_POST['emailaddress-register']);
    $pass = md5($conn->real_escape_string($_POST['password-register']));
    $passRepeat = md5($conn->real_escape_string($_POST['password-repeat-register']));
	$email = $conn->real_escape_string($_POST['emailaddress-register']);
	$type = $_POST['account-type-radio'];
    if($pass == $passRepeat){
		$sql = "insert into users(email,password,type) values('$email','$pass','$type')";
		if($conn->query($sql))
		{
				$success =true; 
				header('Location:index.php');
		}
		else{
			$error =$conn->error;
		}
	}
}

?>

<div class="margin-top-70"></div>

<!-- Titlebar
================================================== -->
<div id="titlebar" class="gradient">
	<div class="container">
		<div class="row">
			<div class="col-md-12">

				<h2>Register</h2>

				<!-- Breadcrumbs -->
				<nav id="breadcrumbs" class="dark">
					<ul>
						<li><a href="#">Home</a></li>
						<li>Register</li>
					</ul>
				</nav>

			</div>
		</div>
	</div>
</div>


<!-- Page Content
================================================== -->
<div class="container">
	<div class="row">
		<div class="col-xl-5 offset-xl-3">

			<div class="login-register-page">
				<!-- Welcome Text -->
				<div class="welcome-text">
					<h3 style="font-size: 26px;">Let's create your account!</h3>
					<span>Already have an account? <a href="login.php">Log In!</a></span>
				</div>

				<!-- Form -->
				<form method="post" id="register-account-form">
					<div class="account-type">
						<div>
							<input type="radio" value="3" name="account-type-radio" id="freelancer-radio" class="account-type-radio" checked/>
							<label for="freelancer-radio" class="ripple-effect-dark"><i class="icon-material-outline-account-circle"></i> Contractor</label>
							<!-- <input visibility="hidden" /> -->
						</div>

						<div>
							<input type="radio" value="2" name="account-type-radio" id="employer-radio" class="account-type-radio"/>
							<label for="employer-radio" class="ripple-effect-dark"><i class="icon-material-outline-business-center"></i> Employer</label>
						</div>
					</div>
					
					<div class="input-with-icon-left">
						<i class="icon-material-baseline-mail-outline"></i>
						<input type="text" class="input-text with-border" name="emailaddress-register" id="emailaddress-register" placeholder="Email Address" required/>
					</div>

					<div class="input-with-icon-left" title="Should be at least 8 characters long" data-tippy-placement="bottom">
						<i class="icon-material-outline-lock"></i>
						<input type="password" class="input-text with-border" name="password-register" id="password-register" placeholder="Password" required/>
					</div>

					<div class="input-with-icon-left">
						<i class="icon-material-outline-lock"></i>
						<input type="password" class="input-text with-border" name="password-repeat-register" id="password-repeat-register" placeholder="Repeat Password" required/>
					</div>
					<!-- Button -->
					<button class="button full-width button-sliding-icon ripple-effect margin-top-10" type="submit" name="register" form="register-account-form">Register <i class="icon-material-outline-arrow-right-alt"></i></button>
				</form>

				<!-- Social Login -->
				<div class="social-login-separator"><span>or</span></div>
				<div class="social-login-buttons">
					<button class="facebook-login ripple-effect"><i class="icon-brand-facebook-f"></i> Register via Facebook</button>
					<button class="google-login ripple-effect"><i class="icon-brand-google-plus-g"></i> Register via Google+</button>
				</div>
			</div>

		</div>
	</div>
</div>


<!-- Spacer -->
<div class="margin-top-70"></div>
<!-- Spacer / End-->

<?php 
	require_once 'js-links.php';
	require_once 'footer.php';
	?>