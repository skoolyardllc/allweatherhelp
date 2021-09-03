<?php

    require_once 'lib/core.php';
    if(isset($_POST['read']))
    {
        $id = $_POST['id'];
        $sql = "UPDATE notifications set status = 2 where id = '$id'";
        if($conn->query($sql))
        {
            echo "read";
        }
        else
        {
            echo $conn->error;
        }
    }
?>