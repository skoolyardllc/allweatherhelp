<?php
    require_once 'lib/core.php';

    if (isset($_POST['change_bookmark'])){
        $user_id = $_POST['userId'];
        $f_id = $_POST['f_id'];
        
        $sql = "select * from bookmarks where u_id='$user_id' and f_id='$f_id'";
        if ($result =$conn->query($sql)){
            if(!($result->num_rows)){
                $sql = "insert into bookmarks (f_id,u_id) values('$f_id','$user_id')";
                if ($conn->query($sql)){
                    $qna['msg']='successfully inserted';
                    echo json_encode($qna);
                }
            }
            else{
               $sql ="delete from bookmarks where u_id='$user_id' and f_id='$f_id'";
                if ($conn->query($sql)){
                    $qna['msg']='successfully deleted';
                    echo json_encode($qna);
                }
            }
        }
    }

    if(isset($_POST['addmsg']))
    {
        $for=$_POST['for'];
        $from=$_POST['from'];
        $msg=$_POST['addmsg'];
        $sql="insert into message(for_id, from_id, msg) values('$for', '$from', '$msg')";
        if ($conn->query($sql))
        {
            echo "success";
        }
        else
        {
            echo $error=$conn->error;
        }
    }


?>