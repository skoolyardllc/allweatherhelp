<?php
ob_start();
require_once '../lib/core.php';

$id=$_SESSION['master_admin_signed_in'];
if(!master_admin_auth())
{
   
    header("location: logout");
}

$sql="select up.*, u.id as uid from users u, user_profile up where u.email='$id' and u.id=up.u_id";
$res=$conn->query($sql);
if($res->num_rows > 0)
{
    $row=$res->fetch_assoc();
    $MASTER_DATA=$row;
}

 
$MASTER_ID=$MASTER_DATA['uid']; 

//user_auth($type,$subadmin);

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin Panel </title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="dist/css/style.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />    
  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <!--Icon Picker  -->
    <link rel="stylesheet" href="dist/fontawesome-5.11.2/css/all.min.css">
    <link rel="stylesheet" href="dist/iconpicker-1.5.0.css">
	<style>
.autocomplete-items {
  position: absolute;
  border: 1px solid #d4d4d4;
  border-bottom: none;
  border-top: none;
  z-index: 99;
  /*position the autocomplete items to be the same width as the container:*/
  top: 100%;
  left: 7%;
  right: 0;
}
.autocomplete-items div {
  padding: 10px;
  cursor: pointer;
  background-color: #fff; 
  border-bottom: 1px solid #d4d4d4; 
}
.card .nav.flex-column>li {
    border-bottom: 1px solid rgba(0,0,0,.125);
    margin: 0;}
.float-right {
    float: right!important;
}
.autocomplete-items div:hover {
  /*when hovering an item:*/
  background-color: #e9e9e9; 
}

.card-header {
    padding: .75rem 1.25rem;
    margin-bottom: 0;
    background-color: rgba(0,0,0,.03);
    border-bottom: 0 solid rgba(0,0,0,.125);
}
.card-header {
    background-color: transparent;
    border-bottom: 1px solid rgba(0,0,0,.125);
    padding: .75rem 1.25rem;
    position: relative;
    border-top-left-radius: .25rem;
    border-top-right-radius: .25rem;
}

.card-header:first-child {
    border-radius: calc(.25rem - 0) calc(.25rem - 0) 0 0;
}

.card {
    position: relative;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-direction: column;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 0 solid rgba(0,0,0,.125);
    border-radius: .25rem;
}

.badge-warning {
    color: #1f2d3d;
    background-color: #ffc107;
}

.badge-success {
    color: #fff;
    background-color: #28a745;
}
.badge-danger {
    color: #fff;
    background-color: red;
}
.btn-secondary{
    background-color: #343a40;
    color: white;
}

.card-footer:last-child {
    border-radius: 0 0 calc(.25rem - 0) calc(.25rem - 0);
}

.card-footer {
    padding: .75rem 1.25rem;
    background-color: rgba(0,0,0,.03);
    border-top: 0 solid rgba(0,0,0,.125);
}


._1qUuq{margin-left:.5rem;font-size:15px;font-size:.9375rem;font-weight:500;font-stretch:normal;font-style:normal;letter-spacing:.14px;letter-spacing:.00875rem;text-align:left;color:#4a4a4a}
._3qzZ9{display:-ms-flexbox;display:flex;-ms-flex-direction:row;flex-direction:row;-ms-flex-align:start;align-items:flex-start}
</style>
</head>
    <body class="hold-transition fixed skin-blue-light sidebar-mini">
<div class="wrapper">
