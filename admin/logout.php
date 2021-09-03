<?php
session_start();
session_destroy();
setcookie("new", '', time()-1000, "/");
setcookie("pass", '', time()-1000, "/");
header("location:login");
?>