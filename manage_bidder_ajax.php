<?php
    require_once 'lib/core.php';

if (isset($_POST['delete_bid'])){
        $id = $_POST['id'];
        // $skill = $_POST['skill'];

        $sql="delete from bidding where id = $id";
        if ($conn->query($sql)){
            $qna['msg']='success';
            echo json_encode($qna);
        }
    }

?>