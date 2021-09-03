<?php

    require_once 'lib/core.php';

    if(isset($_POST['change']))
    {
        $id=$_POST['id'];
        $status=$_POST['status'];
        $sql="update milestones set mil_status='$status' where id='$id'";
        if($conn->query($sql))
        {
            echo "updated";
        }
        else 
        {
            echo $conn->error;
        }
    }

?>