<?php
    require_once "lib/core.php";

    $request  = json_decode(file_get_contents('php://input'),true); 
    if(isset($request['forgotPass']) && isset($request['email']))
    {
        $email = $conn->real_escape_string($request['email']);
        $sql = "select * from users where email ='$email'";
        if($res=$conn->query($sql))
        {
            if($res->num_rows==1)
            { 
                $mail->AltBody = 'This is an auto generated email so please dont reply this';
                $mail->AddAddress($email);                                           // set email format to HTML
                $mail->Subject = "Skoolyard Password Reset Request"; 
                $mail->isHtml(true);
                
                $mail->Body = 'We cannot simply send you your old password. A unique link to reset your
                password has been generated for you. To reset your password, <a href="localhost/skoolyard/passwordset.php?token='.$email.'">Click Here </a>and follow the instructions.';
                $mail->send();
                $result['msg']='success';
            }
            else
            {
                $result['msg']='no_user'; 
                $result['query']=$sql;
            }
        }
        else
        {
            $result['msg']='Something went wrong'; 
            $result['query']=$sql;
        }
        echo json_encode($result);
    }