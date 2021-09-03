<?php
session_start();
if(isset($_SESSION['mode']) )
{
 ?>
    <script type="text/javascript"> 
            
           window.ReactNativeWebView.postMessage('logout')   
     </script>  
  <?php  
   
     
    session_destroy();
    // header("location:login.php");
}
else
{
     
    session_destroy();
    header("location:login.php");
}
    

// print_r($_SESSION);
?>

 
   
    
   