<?php
require 'PHPMailer/PHPMailerAutoload.php';



session_start();


if(!isset($_POST['name']) || !isset($_POST['email'])  )
{
	header("location:../");
}

else{
	

$email=$_POST['email'];
$name=$_POST['name'];
$msg=$_POST['msg'];
$mob=$_POST['mob'];
$company=$_POST['company'];
$choise=$_POST['choise'];






?>

<html>
	<head>
		<title>
		Thankyou Massage.
		</title>

<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" href="style/img/logo2.png" />
		
		<link href="../style/files/bootstrap.min.css" rel="stylesheet">
		<link href="../style/files/animate.css" rel="stylesheet">
		<link href="../style/files/demo.css" rel="stylesheet">
		<script src="../style/files/jquery.min.js"></script>
		<script src="../style/files/bootstrap.min.js"></script>
		<link href="../style/files/custom.css" rel="stylesheet">
	
		
		
		<script>

			$(document).ready(function(){
				
			
  	var scrollTop = 0;
  $(window).scroll(function(){
	  
	    scrollTop = $(window).scrollTop();
     $('.counter').html(scrollTop);
	  if (scrollTop >= 100) {
		 $('#global-nav').removeClass('nav');
         $('#global-nav').addClass('scrolled-nav');
		$("#global-nav").css("top", "1");
		  
	  }
	  
	   else if (scrollTop < 100) {
      $('#global-nav').removeClass('scrolled-nav');
      $('#global-nav').addClass('nav');
		   
	   }
	  
	  if ($(window).width() > 960) {
   

  
    
    if (scrollTop >= 100) {
		
		$('#menunav2').fadeOut();
  		$("#menunav").css("border", "none");
  		$("#menunav").css("margin-top", "5px");
		 $('#menunav').addClass('animated fadeInRight');
    } 
	  else if (scrollTop < 100) {
     
		  $('#menunav2').fadeIn();
		$("#menunav").css("border-bottom", "1px solid #5d5d5d");
			$("#menunav").css("margin-top", "-5px");
		  $('#menunav').removeClass('animated fadeInRight');
    } 
	  
	  
	  
	   
	  
	  }
  }); 
				
});
		</script>
	
		
		<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/589ff7bbac3fa248b6469195/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
		
		
		
	
	</head>
	
	<body>
	
		
		
		<nav id="global-nav" class="nav navbar navbar-default animated fadeInDown">
			<div class="container">		
   				<div class="navbar-header">
      				<button id="menu" type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar"  style="margin-top:15px;">
        				<span class="icon-bar"></span>
        				<span class="icon-bar"></span>
        				<span class="icon-bar" ></span> 
					</button>	
	   
	   				<div class="navbar-brand site-title ">
						<a href="#"><img src="../style/img/logo.png" style="max-width:100%;object-fit:contain;">
						</a>
	  				</div>
				</div>
			
		
      			  
					
				
			 
  			<div class="collapse navbar-collapse" id="myNavbar">
      				 <ul id="menunav" class="nav navbar-nav navbar-right">
        				<li><a href="../#services">Services</a></li>
						<li><a  href="../#Portfolio">Portfolio</a></li>
						<li><a href="../about-us"> About Us</a></li>
								<li><a href="http://training.webixun.com"> Training</a></li>
						<li><a href="../contact_us">Contact Us</a></li>
						<li style="background:#95223f;color:#ffffff;margin-top:5pxS"><a class="dropdown"> 
          <span class="glyphicon glyphicon-earphone" style="font-size:20px;color:#ffffff"></span>
							<div class="dropdown-content animated fadeInRight"> <p>Phone: +91-8266838965<br><br>
							Mail: info@webixun.com	
								
								</p></div>
     </a></li>
      				</ul>
					
				</div>
				
				<div class="collapse navbar-collapse">
      					<ul id="menunav2" class="nav navbar-nav navbar-right">
        				<li><a href="../web_designing">Website Designing & Development </a></li>
						<li><a  href="../digital-marketing">Digital Marketing </a></li>
        				<li><a href="../e-eommerce">E-Commerce Website </a></li>
        				<li><a href="../web-applications">Web Applications</a></li>
      				</ul>
				</div>
			 </div>
		 </nav>
		
	
	<br><br><br><br><br>
	<div class="container">
	
	  <center><br><br> <h1 style="font-family: 'Lobster Two', cursive;color:#222222"><?php echo $a ?></h1> 
	<br><br>
		
		<a href="../" class="btn btn-danger" style="width:200px">Back To Home</a></center>
		
	</div>
	
	</body>
	
</html>
