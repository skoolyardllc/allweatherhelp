<?php



//opne server error

ini_set('display_errors', 1);

error_reporting(1);



//select time zone

date_default_timezone_set('Asia/Kolkata');



//for the database

$servername = "localhost";

$username = "root_cyberflow";

$password = "I~z@Y-ydU72J";

$dbname = "allwheather";



// Create connection

$conn = new mysqli($servername, $username, $password, $dbname);



//google api key

$google_key="AIzaSyCl2Zq1Xr7l1qLT2INlKwvlpsFnlTa3D58";



// Check connection

if($conn->connect_error)

{

    die("Connection failed: " . $conn->connect_error);

}

//website link

$website_link="http://skoolyard.biz/awh"; 

//page value;

$admin=1;

$subadmin=2;

$user=3;

$deafult_img = $website_link."/images/avatar3.png";

//payment gateway details

$merchant_id=178079;

 

	$mail = new PHPMailer();

    $mail->SMTPDebug = false;                         // Enable verbose debug output

	$mail->isSMTP();                                      // Set mailer to use SMTP

	$mail->Host = 'mail.tattbooking.com';  // Specify main and backup SMTP servers

	$mail->SMTPAuth = true;                               // Enable SMTP authentication

	$mail->Username = 'info@tattbooking.com';                 // SMTP username

	$mail->Password = '${ZULymF5Ur+';                            // SMTP password

	$mail->SMTPSecure = 'ssl';                           // Enable TLS encryption, `ssl` also accepted

	$mail->Port = 465;             

	$mail->setFrom('info@tattbooking.com', 'Skoolyard');

	$mail->isHTML(true);                                   // Set email format to HTML

    $mail->AltBody = 'This is an auto generated email so please dont reply this';

  

 	 

?>