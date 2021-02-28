<?php
   require_once 'lib/core.php';

   cookie_login($conn);
   if(!user_auth()){
      header('Location:login.php');
   }

   // $sql="select * from users where id='$USER_ID'";
   // $res = $conn->query($sql);
   // if($res->num_rows)
   // {
   //    $type = $res;
   // }
       $USER_ID = $_SESSION['user_id']; 
      //  $PASSWORD = $_SESSION['PASSWORD']; 
       $sql="select u.* from users u  where u.email='".$_SESSION['user_signed_in']."' and u.id = '$USER_ID'";
      if($result = $conn->query($sql))
      {
         if($result->num_rows)
         {    
            $USER_DATA = $result->fetch_assoc();
         }
      }
      else
      {
         echo $conn->error;
      }
      
   $TYPE = $USER_DATA['type'];
   $_SESSION['type'] = $TYPE;
   

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
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>
<body>

