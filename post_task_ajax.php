<?php
    require_once 'lib/core.php';

    if (isset($_POST['add_skills'])){
        $user_id = $_POST['userId'];
        $skill = $_POST['skill'];

        $sql="insert into skill_tasks (skills,e_id) values('$skill','$user_id')";
        if ($conn->query($sql)){
            $qna['msg']='success';
            echo json_encode($qna);
        }
    }

    if (isset($_POST['delete_skill'])){
        $id = $_POST['id'];

        echo $sql="delete from skill_tasks where id = $id";
        if ($conn->query($sql)){
            $qna['msg']='success';
            echo json_encode($qna);
        }
    }

?>