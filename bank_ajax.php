<?php

    require_once 'lib/core.php';

    if(isset($_POST['save']))
    {
        $method=$_POST['radio'];
        $acc_no = $_POST['acc_no'];
        $routing_no = $_POST['routing_no'];
        $card_no = $_POST['card_no'];
        $name_card = $_POST['name_card'];
        $cashapp = $_POST['cashapp'];
        $paypal = $_POST['paypal'];
        $USER_ID = $_POST['userid'];
        switch($method)
        {
            case 'Account':
                $sql = "update bank set method='$method', acc_no = '$acc_no',routing_no = '$routing_no' where u_id='$USER_ID'";
                break;
            case 'Card':
               
                $sql = "update bank set method='$method', card_np = '$card_no',name_card = '$name_card' where u_id='$USER_ID'";
                break;
            case 'Cashapp':
               
                $sql = "update bank set method='$method', username='$cashapp' where u_id='$USER_ID'";
                break; 
            case 'PayPal':
                
                $sql = "update bank set method='$method', username='$paypal' where u_id='$USER_ID'";
                break;
        }
        if($conn->query($sql))
        {
            $changes = "Bank Details Updated Succesfull"; 
        }
        else{
            $changes = $conn->error; 
        }
        
    }

?>
