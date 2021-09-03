<?php
    require_once 'lib/core.php';

if (isset($_POST['delete_skill'])){
    $id = $_POST['id'];

   $sql="delete from skill_tasks where id ='$id'";
    if ($conn->query($sql)){
        $qna['msg']='success';
        echo json_encode($qna);
    }
}


?> 