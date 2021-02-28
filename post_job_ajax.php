<?php
    require_once 'lib/core.php';

    if (isset($_POST['add_tags'])){
        $user_id = $_POST['userId'];
        $tags = $_POST['tags'];

        $sql="insert into job_tags (tag,e_id) values('$tags','$user_id')";
        if ($conn->query($sql)){
            $qna['msg']='success';
            echo json_encode($qna);
        }
    }
?>