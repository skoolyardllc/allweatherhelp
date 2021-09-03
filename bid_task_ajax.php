<?php
    require_once 'lib/core.php';

    // if (isset($_POST['changeBidding_amount'])){
    //     $user_id = $_POST['userId'];
    //     $amount = $_POST['amount'];

    //     $sql = "update bidding set bid_expected='$amount' where c_id='$user_id'";
    //     if ($conn->query($sql)){
    //         $qna['msg']='success';
    //         echo json_encode($qna);
    //     }
    // }

    if (isset($_POST['change_bookmark'])){
        $user_id = $_POST['userId'];
        $t_id = $_POST['task_id'];
        
        $sql = "select * from bookmarks where u_id='$user_id' and t_id='$t_id'";
        if ($result =$conn->query($sql))
        {
            if(!($result->num_rows))
            {
                $sql = "insert into bookmarks (t_id, u_id) values('$t_id','$user_id')";
                if ($conn->query($sql))
                {
                    $qna['msg']='successfully inserted';
                    echo json_encode($qna);
                }
            }
            else
            {
               $sql ="delete from bookmarks where u_id='$user_id' and t_id='$t_id'";
                if ($conn->query($sql)){
                    $qna['msg']='successfully deleted';
                    echo json_encode($qna);
                }
            }
        }
    }
    if (isset($_POST['change_bookmark_user'])){
        $user_id = $_POST['userId'];
        $f_id = $_POST['f_id'];
        
        $sql = "select * from bookmarks where u_id='$user_id' and f_id='$f_id'";
        if ($result =$conn->query($sql))
        {
            if(!($result->num_rows))
            {
                $sql = "insert into bookmarks (f_id, u_id) values('$f_id','$user_id')";
                if ($conn->query($sql))
                {
                    $qna['msg']='successfully inserted';
                    echo json_encode($qna);
                }
            }
            else
            {
               $sql ="delete from bookmarks where u_id='$user_id' and t_id='$t_id'";
                if ($conn->query($sql)){
                    $qna['msg']='successfully deleted';
                    echo json_encode($qna);
                }
            }
        }
    }


?>