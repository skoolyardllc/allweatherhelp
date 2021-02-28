<?php
    require_once 'lib/core.php';

    if (isset($_POST['changeAccount_type'])){
        $user_id = $_POST['userId'];
        $type = $_POST['type'];

        $sql = "update users set type='$type' where id='$user_id'";
        if ($conn->query($sql)){
            $qna['msg']='success';
            echo json_encode($qna);
        }
    }

    if (isset($_POST['changeBidding_amount'])){
        $user_id = $_POST['userId'];
        $amount = $_POST['amount'];

        $sql = "update user_profile set hourly_rate='$amount' where u_id='$user_id'";
        if ($conn->query($sql)){
            $qna['msg']='success';
            echo json_encode($qna);
        }
    }

    if (isset($_POST['add_skills'])){
        $user_id = $_POST['userId'];
        $skill = $_POST['skill'];

        $sql="insert into skills (skill,u_id) values('$skill','$user_id')";
        if ($conn->query($sql)){
            $qna['msg']='success';
            echo json_encode($qna);
        }
    }

    if (isset($_POST['delete_skill'])){
        $id = $_POST['id'];
        // $skill = $_POST['skill'];

        $sql="delete from skills where u_id = $id";
        if ($conn->query($sql)){
            $qna['msg']='success';
            echo json_encode($qna);
        }
    }

    if (isset($_POST['change_password'])){
        $user_id = $_POST['userId'];
        $current_password = md5($_POST['current_password']);
        $new_password = md5($_POST['new_password']);
        $rep_password = md5($_POST['rep_password']);
        $email=$_POST['email'];
        if(user_auth()){
            $sql="select * from users where email='$email' and password='$current_password'";
            $res=$conn->query($sql);
            if($res->num_rows > 0){
                if($new_password==$rep_password){
                    $sql = "update users set password='$new_password' where id='$user_id'";
                    if ($conn->query($sql)){
                        $qna['msg']='success';
                        echo json_encode($qna);
                    }
                }
                else
                {
                    $error['msg']='New password and repeated password are not same';
                    echo json_encode($error);
                }
            } 
            else
                {
                    $error['msg']='You typed in wrong current password';
                    echo json_encode($error);
                }
        }
    }


    if (isset($_POST['status_online'])){
        $userid = $_POST['userId'];
        $status = $_POST['status'];

        $sql="update user_profile set status='$status' where u_id='$userid'";
        if ($conn->query($sql)){
            $qna['msg']='success';
            echo json_encode($qna);
        }
    }

    if (isset($_POST['status_invisible'])){
        $userid = $_POST['userId'];
        $status = $_POST['status'];

        $sql="update user_profile set status='$status' where u_id='$userid'";
        if ($conn->query($sql)){
            $qna['msg']='success';
            echo json_encode($qna);
        }
    }
?>