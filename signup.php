<?php
   require_once 'lib/core.php';
   require_once 'navbar.php';

   if(user_auth()){
      header('Location:home.php');
   }

   // $sql="select * from users where id='$USER_ID'";
   // $res = $conn->query($sql);
   // if($res->num_rows)
   // {
   //    $type = $res;
   // }

if(isset($_POST['register']))
{

    $email = $conn->real_escape_string($_POST['emailaddress-register']);
    $pass = md5($conn->real_escape_string($_POST['password-register']));
    $passRepeat = md5($conn->real_escape_string($_POST['password-repeat-register']));
	$email = $conn->real_escape_string($_POST['emailaddress-register']);
	$type = $_POST['account-type-radio'];
    if($pass == $passRepeat)
	{
		$sql = "insert into users(email,password,type) values('$email','$pass','$type')";
		if($conn->query($sql))
		{
			$id=$conn->insert_id;
			$sql2 = "insert into user_profile(avtar,u_id) values('images/user-avatar-placeholder.png','$id')";
			if($conn->query($sql2))
            {
                $sql3="insert into bank(u_id,stat) values('$id','$type')";
				if($conn->query($sql3))
				{
					$signedup = "You have Signed Up successfully <br> Go login Now!";
					login($email,$pass,$conn,'editProfile');
				}
				else
				{
					$errorMember=$conn->error;
				}
            }
            else
            {
                $errorMember=$conn->error;
            }
			
			if($type==2)
			{
				$sql2 = "insert into adm(u_id,adm) values('$id','00')"; 
				if($conn->query($sql2))
				{
					$sql3 = "insert into adm(u_id,adm) values('$id','01')"; 
					if($conn->query($sql3))
					{
						$sql4="insert into insurance(u_id) values('$id')";
						if($conn->query($sql4))
						{
							$signedup = "You have Signed Up successfully <br> Go login Now!"; 
							login($email,$pass,$conn,'editProfile');
						}
						else
						{
							$errorMember=$conn->error;
						}
					}
					else
					{
						$errorMember=$conn->error;
					} 
				}
				else
				{
					$errorMember=$conn->error;
				}
				
			}
		}
		else
		{
			$errorMember=$conn->error;
		}
	}
	else
	{
		$errorMember = "Password Mismatch!";
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
<meta name="google-signin-client_id" content="669763476426-6ktheuk1ur095jgejbchrjevosiq1ur8.apps.googleusercontent.com">
<link rel="icon" href="./images/cyberflow-logo-1.png">

</head>
<body>
<div class="margin-top-70"></div>

<!-- Titlebar
================================================== -->
<div id="titlebar" class="gradient">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
			<center><h2 style="padding-right:6rem">Register</h2></center>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<?php
					if(isset($signedup))
					{
						?>
							<div class="alert alert-success" role="alert">
							<center><?=$signedup?></center>
							</div>
						<?php
					}
					else if(isset($errorMember))
					{
						?>
							<div class="alert alert-danger" role="alert">
							<center><?=$errorMember?></center>
							</div>
						<?php
					}

				?>
			

				
				<!-- Breadcrumbs -->
				

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
				<div class="welcome-text" >
					<h3 style="font-size: 26px;">Let's create your account!</h3>
					<span>Already have an account? <a href="login.php" id="sigin">Log In!</a></span>
					<div id="alertkijagah"></div>
				</div>

				<!-- Form -->
				<form method="post" id="register-account-form">
					<div class="account-type">
						<div>
							<input type="radio" value="3" name="account-type-radio" id="freelancer-radio" class="account-type-radio" />
							<label for="freelancer-radio" class="ripple-effect-dark"><i class="icon-material-outline-account-circle"></i> Contractor</label>
							<!-- <input visibility="hidden" /> -->
						</div>

						<div>
							<input type="radio" value="2" name="account-type-radio" id="employer-radio" class="account-type-radio"/>
							<label for="employer-radio" class="ripple-effect-dark"><i class="icon-material-outline-business-center"></i> Business </label>
						</div>

						<div>
							<input type="radio" value="5" name="account-type-radio" id="customer-radio" class="account-type-radio"/>
							<label for="customer-radio" class="ripple-effect-dark"><i class="fas fa-user"></i> Customer</label>
						</div>
					</div>
					<div class="social-login-buttons" >
						<button class="facebook-login ripple-effect" type="button" onclick="signfb()"><i class="icon-brand-facebook-f"></i> Register via Facebook</button>
						<!-- <div class="fb-login-button"  data-width="" data-size="large" data-button-type="continue_with" data-layout="default" data-auto-logout-link="false" onlogin="signuser" data-use-continue-as="false"></div> -->
						<button type="button" class="google-login ripple-effect" onclick="siginn()"><i class="icon-brand-google-plus-g"></i> Register via Google+</button>
						<div class="g-signin2" style='display:none' id="sigingoogle" data-onsuccess="onSignIn" data-width=""><i class="icon-brand-google-plus-g"></i> Register via Google+</div>
					</div>
					<div class="social-login-separator"><span>or</span></div>
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
				<!-- <div class="social-login-separator"><span>or</span></div>
				<div class="social-login-buttons">
					<button class="facebook-login ripple-effect"><i class="icon-brand-facebook-f"></i> Register via Facebook</button>
					<button class="google-login ripple-effect g-signin2" data-onsuccess="onSignIn"><i class="icon-brand-google-plus-g"></i> Register via Google+</button>
				</div> -->
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
		$("#threebars").remove();
		function signfb()
		{
		
			if ($("#freelancer-radio").is(":checked") || $("#employer-radio").is(":checked") || $("#customer-radio").is(":checked")) 
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
							var pro  ;
							if ($("#freelancer-radio").is(":checked") ) 
							{
								pro=$("#freelancer-radio").val();
							}
							else if( $("#employer-radio").is(":checked"))
							{
								pro=$("#employer-radio").val();
							}
							else if($("#customer-radio").is(":checked"))
							{
								pro=$("#customer-radio").val();
							}
							console.log(pro);

							$.ajax({
								url: 'login_ajax.php',
								method: 'POST',
								data:{
									name: fbname,
									email:fbemail,
									type:'facebook' ,
									register_user:true,
									pro:pro,
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
			else
			{
				$("#alertkijagah").html(`<div class="notification notice closeable">
									<p>Please select the account type first</p>
								</div>`);
			}
		}

		window.fbAsyncInit = function() {
		FB.init({
		appId      : '325441855596069', // App ID
		channelUrl : 'http://localhost.com/channel.html', // Channel File
		status     : true, // check login status
		cookie     : true, // enable cookies to allow the server to access the session
		oauth      : true, // enable OAuth 2.0
		xfbml      : true  // parse XFBML
		});
		};
		(function(d){
		var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
		js = d.createElement('script'); js.id = id; js.async = true;
		js.src = "//connect.facebook.net/en_US/all.js";
		d.getElementsByTagName('head')[0].appendChild(js);
		}(document));


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

	function siginn()
	{
		if ($("#freelancer-radio").is(":checked") || $("#employer-radio").is(":checked") || $("#customer-radio").is(":checked")) 
		{
			$(".abcRioButtonContentWrapper").click();
		}
		else
		{
			$("#alertkijagah").html(`<div class="notification notice closeable">
								<p>Please select the account type first</p>
							</div>`);
		}
		
		// $("#sigin").click();
		// jQuery("div#sigingoogle").trigger("click")
		// console.log("hello")
	}

	function signuser(facebookUser)
	{
		// console.log("login")
		var name;
		var id;
		FB.api('/me', function(response) {
			console.log(JSON.stringify(response));
			name = JSON.stringify(response.email);
			id = response.id;
		});
		FB.login(function(response) {
			console.log(JSON.stringify(response));
			// console.log("j")
		}, {
			scope: 'email', 
			return_scopes: true
		});
		// console.log("hell"+name)
		FB.getLoginStatus(function(response) {
		if (response.status === 'connected') {
			var accessToken = response.authResponse.accessToken;
			console.log(response)
		} 
		} );
	}

	function onSignIn(googleUser) {
		if ($("#freelancer-radio").is(":checked") || $("#employer-radio").is(":checked") || $("#customer-radio").is(":checked")) 
		{
			
			
			var profile = googleUser.getBasicProfile();
			console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
			console.log('Name: ' + profile.getName());
			console.log('Image URL: ' + profile.getImageUrl());
			console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
			var pro  ;
			if ($("#freelancer-radio").is(":checked") ) 
			{
				pro=$("#freelancer-radio").val();
			}
			else if( $("#employer-radio").is(":checked"))
			{
				pro=$("#employer-radio").val();
			}
			else if($("#customer-radio").is(":checked"))
			{
				pro=$("#customer-radio").val();
			}
			console.log(pro);

			$.ajax({
				url: 'login_ajax.php',
				method: 'POST',
				data:{
					name: profile.getName(),
					image:profile.getImageUrl(),
					email:profile.getEmail(),
					type:'google' ,
					register_user:true,
					pro:pro,
				},
				success: function(data)
				{
					
					
						if(data.trim()=="loggedin")
						{
								window.location.href ='index'
						}
				}

			})
		}
		else
		{
			$("#alertkijagah").html(`<div class="notification notice closeable">
								<p>Please select the account type first</p>
							</div>`);
		}
	}

	</script>