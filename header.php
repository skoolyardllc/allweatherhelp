<?php

   require_once 'lib/core.php';



      $lin = $_SERVER['PHP_SELF'];

      $lin_array = explode('/',$lin);

      $pag = end($lin_array);



      if(!isset($_SESSION['user_signed_in']) && $pag!='index.php')

      {

         header('Location:index');

      }

      if(isset($_SESSION['user_signed_in']))
         {

         $id = $_SESSION['user_id']; 

         $EMAIL=$_SESSION['user_signed_in'];

         $sql="select u.*, up.f_name, up.l_name,up.mobile, up.user_wallet from users u, user_profile up where u.email='$EMAIL' and u.id = '$id' and u.id=up.u_id";

         if($result_user = $conn->query($sql))

         {

            if($result_user->num_rows)

            {    

               $USER_DATA = $result_user->fetch_assoc();

            }

         }

         else

         {

            echo $conn->error;

         }

         

         $TYPE = $USER_DATA['type'];

         $wallet = $USER_DATA['user_wallet'];

         $USER_EMAIL = $USER_DATA['email'];

         $USER_ID=$USER_DATA['id'];

         $_SESSION['type'] = $TYPE;

         $link = $_SERVER['PHP_SELF'];

         $link_array = explode('/',$link);

         $page = end($link_array);

         // print_r($_session);

         if(($USER_DATA['f_name']=="" || $USER_DATA['l_name']=="" || $USER_DATA['mobile']=="") && $page!='editProfile.php' && isset($_SESSION['user_signed_in']))

         {

            if($TYPE==2)

            {

               $sql = "select * from insurance where u_id='$USER_ID'";

               if($resu = $conn->query($sql))

               {

                  if($resu->num_rows)

                  {

                     $in = $resu->fetch_assoc();

                  }

               }

               if($in['in_company']=="" || $in['policy_no']=="" || $in['dcoument']=="")

               {

                  $enteryourdetailsemp = 'hello';

                  header("location:editProfile");

               }

               else

               {

                  $enteryourdetailsemp = false;

               }

            }

            else

            {

               $enterdetails = true;

               header("location:editProfile");

            }

         }

         else

         {

            $enterdetails = false;

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

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

<link rel="icon" href="./images/cyberflow-logo-1.png">

<script src="https://kit.fontawesome.com/f662a74373.js" crossorigin="anonymous"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">

<!-- CSS only -->

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

<style>

   .dropdown-toggle::after 

   {

      content:none

   }

   .dropup .dropdown-toggle::after

   {

      content:none

   }

   a{text-decoration: none !important;}

   .mm-prev{margin:5px !important;padding-top:0 !important}

   @media screen and (max-width: 600px) {

  .caty {

   width:50%

  }

  .mm-panels{margin-top:75px}

  .photoonphone{

        margin-right:-25px !important;

    }

    #logo{flex: 1;

    display:flex;

    justify-content: center;margin-right: 40px;}

}

</style>

</head>

<body>



