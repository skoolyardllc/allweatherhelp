<?php
    require_once 'lib/core.php';
    session_destroy();
    setcookie(time() + (-86400 * 30), "/");
    header("location:login.php");
?>