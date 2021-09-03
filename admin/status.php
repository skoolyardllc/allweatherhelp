<?php

    require_once '../lib/core.php';

    if(isset($_POST['approve']))
    {
        $id = $_POST['id'];
        $sql = "UPDATE users set stat=1 where id='$id'";
        if($conn->query($sql))
        {
            echo "ok";
        }  
        else
        {
            echo $conn->error;
        }
    }
    
    if(isset($_POST['block']))
    {
        $id = $_POST['id'];
        $sql = "UPDATE users set stat=2 where id='$id'";
        if($conn->query($sql))
        {
            echo "ok";
        }
        else
        {
            echo $conn->error;
        }
    }

?>