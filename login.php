<?php
   require_once 'lib/core.php';
   require_once 'navbar.php';

   if(user_auth()){
	//    print_r($_SESSION);
      header('Location:index.php');
   }

    if(isset($_POST['emailaddress'])&&isset($_POST['password'])){
        $email=$conn->real_escape_string($_POST['emailaddress']);
        $pass=md5($conn->real_escape_string($_POST['password']));
        login($email,$pass,$conn,'index.php');
		if(!login($email,$password,$conn,'index'))
		{
			$error ="Invalid Email or Password";
		}
    }
     

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

<link rel="icon" href="./images/cyberflow-logo-1.png">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://kit.fontawesome.com/f662a74373.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<meta name="google-signin-client_id" content="669763476426-6ktheuk1ur095jgejbchrjevosiq1ur8.apps.googleusercontent.com">
<link rel="icon" href="./images/cyberflow-logo-1.png">
</head>
<body>
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v10.0" nonce="MXn16kXv"></script>
<div class="margin-top-70"></div>

<!-- Titlebar
================================================== -->
<div id="titlebar" class="gradient">
	<div class="container">
		<div class="row">
			<div class="col-md-12">

			<center><h2 style="text-align:center;padding-right:6rem">Log In</h2></center>

			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<?php
					if(isset($error))
					{
						?>
						<center>	<div class="alert alert-danger" id="error" style="width: 50%; text-align: center;" role="alert">
							<?=$error?>
							</div></center>
						<?php
					}
					else
					{
					?>
						<center>	<div class="alert alert-success" id="ture" style="display: none; width: 50%; text-align: center;" role="alert">
							</div></center>
						<?php
					}

				?>
				
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
			<center><div class="alert alert-danger" id="msg" style="display: none;" role="alert"><p id="error2" style="margin-top: 12px;"> </p><p id="error2" style="margin-top: 12px;"> </p></div></center>
			<center><div class="alert alert-success" id="msg2" style="display: none;" role="alert"><p id="success2" style="margin-top: 12px;"> </p></div></center>
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
					<h3>We're glad to see you again!</h3>
					<span>Don't have an account? <a href="signup">Sign Up!</a></span>
				</div>
					<div class="row" style="margin:5px;justify-content:center;" id="notRegistered" >

					</div>
				<!-- Form -->
				<form method="post" id="login-form">
					<div class="input-with-icon-left">
						<i class="icon-material-baseline-mail-outline"></i>
						<input type="text" class="input-text with-border" name="emailaddress" id="emailaddress" placeholder="Email Address" required/>
					</div>

					<div class="input-with-icon-left">
						<i class="icon-material-outline-lock"></i>
						<input type="password" class="input-text with-border" name="password" id="password" placeholder="Password" required/>
					</div>
					<button type="button" onclick="check()" id="forgotbtn" style="color: blue;" class="btn btn-default"><i class="bx bxs-key mr-2"></i>Forget Password?</button>
										
				
                    <!-- Button -->
                    <button class="button full-width button-sliding-icon ripple-effect margin-top-10" type="submit" name="login" form="login-form">LOG IN &nbsp <div id="spinspin" style="display: none;" class="spinner-border" role="status"><span class="sr-only"></span></div></button>
				</form>
				<!-- Social Login -->
				<div class="social-login-separator"><span>or</span></div>
				<div class="social-login-buttons">
					<button class="facebook-login ripple-effect" onclick="signfb()"><i class="icon-brand-facebook-f"></i> Log In via Facebook</button>
					<button class="google-login ripple-effect " onclick="{$('.abcRioButtonContentWrapper').click();}" ><i class="icon-brand-google-plus-g"></i> Log In via Google+</button>
					<div class="g-signin2" style='display:none' id="sigingoogle" data-onsuccess="onSignIn" data-width=""><i class="icon-brand-google-plus-g"></i> Register via Google+</div>
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

<script src="https://apis.google.com/js/platform.js" async defer></script>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v10.0&appId=325441855596069&autoLogAppEvents=1" nonce="u4D8LR2g"></script>

<script>
	function check()
	{
		var email=$('#emailaddress').val();
		console.log(email)
		$("#msg").hide()
		if(email=='')
		{
			$("#msg").show()
			$("#error2").html("Enter Registered Email Address")
		}
		else
		{
			checkemail(email);
		}
	}
	function checkemail(email) 
	{
		$("#forgotbtn").prop('disabled', false);
		$("#spinspin").show();
		fetch('forgetpasswordmail.php', {  
		method: 'POST',
		headers: {
			'Accept': 'application/json',
			'Content-Type': 'application/json',
		},
		body: JSON.stringify({
			forgotPass: email,
                email: email,
		})

		}).then(function(response) {
			return response.json()
		})
  		.then(function(data){
	  $("#forgotbtn").prop('disabled', true);
	  $("#spinspin").hide();
	  var mssg=data.msg;
	  
	  if(mssg=="success")
	  {
		$("#msg2").show()
		$("#success2").show();
	  	$("#success2").html("Reset Link Sent to Your Email id")

  	  }
	  else if(mssg=="no_user")
	  {
		$("#msg").show()
	  	$("#error2").html("Enter registered email address")
		$("#forgotbtn").prop('disabled', false);
  	  }
	  else if(mssg=="something_wrong")
	  {
		$("#msg").show()
	  	$("#error2").html("Something went wrong")
		$("#forgotbtn").prop('disabled', false);
  	  }
  })
		
}
$("#threebars").remove();
	function signfb()
	{
	
		
			var fbname;
			var fbemail;
			FB.login(function(response) {
				if (response.authResponse) {
				console.log('Welcome!  Fetching your information.... ');
				FB.api('/me', function(response) {
					console.log('Good to see you, ' + response.name + '.');
					fbname = response.name;
					console.log(fbname);
					console.log(JSON.stringify(response));
					// console.log(JSON.stringify(response.name));
					FB.api('/me', {fields: 'email'}, function(response) {
						console.log(response);
						fbemail = response.email;
						console.log(fbname+" "+fbemail)
						

						$.ajax({
							url: 'login_ajax.php',
							method: 'POST',
							data:{
								name: fbname,
								email:fbemail,
								type:'facebook' ,
								register_user:true,
								login:true,
							},
							success: function(data)
							{
								
								
									if(data.trim()=="loggedin")
									{
											window.location.href ='home'
									}
							}

						})
						
					});
					
				});
				} else {
				console.log('User cancelled login or did not fully authorize.');
				}
			});
			// console.log(".."+fbname);
		
	}

(function(w, d, s, l, i) {
        w[l] = w[l] || [];
        w[l].push({
            'gtm.start': new Date().getTime(),
            event: 'gtm.js'
        });
        var f = d.getElementsByTagName(s)[0],
            j = d.createElement(s),
            dl = l != 'dataLayer' ? '&l=' + l : '';
        j.async = true;
        j.src =
            'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
        f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', 'GTM-5Z4ZR6G');

	function onSignIn(googleUser) {
		var profile = googleUser.getBasicProfile();
		console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
		console.log('Name: ' + profile.getName());
		console.log('Image URL: ' + profile.getImageUrl());
		console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.

		$.ajax({
			url: 'login_ajax.php',
			method: 'POST',
			data:{
				name: profile.getName(),
				image:profile.getImageUrl(),
				email:profile.getEmail(),
				type:'google' ,
				register_user:true,
				login:true,
			},
			success: function(data)
			{
				 
				 
					if(data.trim()=="loggedin")
					{
							window.location.href ='home';
					}
					else if(data.trim()=="notRegistered")
					{
						$("#notRegistered").html(`<div class="notification notice closeable">
													<p>You are not Signed up !!</p>
												</div>`);
					}
			}

		})
	}
</script>