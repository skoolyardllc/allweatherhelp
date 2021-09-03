<?php
    require_once 'lib/core.php';

    if (isset($_POST['changeBidding_amount'])){
        $user_id = $_POST['userId'];
        $amount = $_POST['amount'];
        $t_id = $_POST['t_id'];

        $sql = "update bidding set bid_expected='$amount' where c_id='$user_id' and t_id='$t_id'";
        if ($conn->query($sql)){
            $qna['msg']='success';
            echo json_encode($qna);
        }
    }


?>