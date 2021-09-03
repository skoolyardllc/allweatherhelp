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

    if(isset($_POST['updateFile'])){
        $status =  upload_image('image');
        $result=[];
        $result['msg'] = $status;
        $ext=pathinfo($status,PATHINFO_EXTENSION);
        if(strtolower($ext)=="pdf")
        {
            $result['msg']="PDF.svg";
        }
        $result['href']=$status;
        echo json_encode($result);
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

    // //updating files
    // if(isset($_POST['updateFile']))
    // {
    //     $user_id = $_POST['user_id'];
        // $status =  upload_image2($conn,'user_profile','avtar',$user_id,'avatar');
    //      $result=[];
    //      $result['msg'] = $status;
    //      echo json_encode($result);
    // }
    if(isset($_POST['post_task'])){
        $USER = $conn->real_escape_string($_POST['post_task']);
        $t_name = $conn->real_escape_string($_POST['t_name']);
        $t_catagoryNtype = explode("@",$conn->real_escape_string($_POST['t_catagory']));
        $location = $conn->real_escape_string($_POST['location']);
        $min_salary = $conn->real_escape_string($_POST['min_salary']);
        $max_salary = $conn->real_escape_string($_POST['max_salary']);
        $t_description = $conn->real_escape_string($_POST['t_description']);
        $radio_price = $_POST['radio_price'];
        $inputed_skills = $_POST['inputed_skills'];
        $inputed_files =$_POST['inputed_files'];
        $cat_type = $_POST['cat_type'];
        $end_date = date('Y-m-d', strtotime($_REQUEST['end_date']));
        $task_category = $t_catagoryNtype[0];
        $task_type_cat = $t_catagoryNtype[1];
        // print_r($inputed_skills);
        $sql="insert into post_task (e_id,t_name,t_catagory,cat_type,location,min_salary,max_salary,t_description,end_date,pay_type)
         values('$USER','$t_name','$task_category','$task_type_cat','$location','$min_salary','$max_salary','$t_description','$end_date','$radio_price')"; 
         if($conn->query($sql))
         {
            $insertId = $conn->insert_id;

            $sql = "insert into skill_tasks (t_id,skills) values"; 
            foreach($inputed_skills as $inputed_skill)
            {
                $sql .= "($insertId,'$inputed_skill'),";
            }
            $sql = rtrim($sql,",");
            if($conn->query($sql))
            {
                $task_posted =true;
            } 

            $sql = "insert into uploaded_documents (t_id,document) values"; 
            foreach($inputed_files as $inputed_file)
            {
                $sql .= "($insertId,'$inputed_file'),";
            }
              $sql = rtrim($sql,",");
            if($conn->query($sql))
            {
                $task_posted =true;
                echo "ok";
            } 

         }
         else{
              echo $conn->error;
         }
    }
?>