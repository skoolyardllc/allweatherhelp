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

    
    if(isset($_POST['updateFile'])){
        $status =  upload_image('image');
        $result=[];
        $result['msg'] = $status;
        $des = $_POST['des'];
        $id = $_POST['id'];
        $user = $_POST['user'];
        $main_id = $_POST['main_id'];
        $sql = "insert into completed(description,img1,task_id,user_id) values('$des','$status','$id','$user')";
        if($conn->query($sql))
        {
            $new_id = $conn->insert_id;
             $sql = "update milestones set complete = $new_id where id = $main_id";
            if($conn->query($sql))
            {
                echo json_encode($result);
            }
            else
            {
                echo $conn->error();
            }
           
        }
        else
        {
            echo $conn->error();
        }
        
        // echo "hello";
    }

    if (isset($_POST['deleteFile'])){
        $filename = $_POST['filename'];
        $result=[];
        
        if(unlink("uploads/$filename")){
            $result['msg'] = 'deleted';
        }
        else{
            $result['msg'] = 'not deleted';
        }
        echo json_encode($result);
    }
    

?>