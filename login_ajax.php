<?php
    require_once './lib/core.php';


    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if(isset($_POST['register_user']))
        {
            $name = $_POST['name'];
            $image = $_POST['image'];
            $email = $_POST['email'];
            $type = $_POST['type'];
            $pro = $_POST['pro'];
            $password = md5('');
            $names = explode(' ', $name, 2);
            $f_name = $names[0];
            $l_name = $names[1];
            if(isset($_POST['login']))
            {
                    if(!user_login_with_social($email,$conn,2,$type))
                    {
                        echo "notRegistered";
                    }else
                    {
                        echo "loggedin";
                    } 
            }
            else
            {
                $sq = "select * from users where email = '$email'";
                if($result=$conn->query($sq))
                {
                    if($result->num_rows > 0)
                    {
                        if(user_login_with_social($email,$conn,2,$type))
                        {
                            echo "loggedin";
                        }else
                        {
                            echo "login err";
                        } 
                    }
                    else
                    {
                        $sql = "Insert into users(email,sign_type,type) values('$email','$type','$pro')";
                        if($conn->query($sql))
                        {
                            $insert = $conn->insert_id;
                            $sql = "INSERT INTO user_profile(u_id,f_name,l_name) values($insert,'$f_name','$l_name')";
                            $sql5="insert into bank(u_id,stat) values('$insert','$pro')";
                            if($pro==2)
                            {
                                $sql2 = "insert into adm(u_id,adm) values('$insert','00')"; 
                                if($conn->query($sql2))
                                {
                                    $sql3 = "insert into adm(u_id,adm) values('$insert','01')"; 
                                    if($conn->query($sql3))
                                    {
                                        $sql4="insert into insurance(u_id) values('$insert')";
                                        if($conn->query($sql4))
                                        {}
                                    }
                                }
                            }
                            
                            if($conn->query($sql) && $conn->query($sql5))
                            {
                                if(user_login_with_social($email,$conn,2,$type))
                                {
                                    echo "loggedin";
                                }else
                                {
                                    echo "login err";
                                }

                            }
                    }
                }
                
                }
                else
                {
                    $err= $conn->error;
                    if(strstr($err,"Duplicate entry '$email' for key 'email'"))
                    {
                            if(user_login_with_social($email,$conn,2,$type))
                            {
                                echo "loggedin";
                            }else
                            {
                                echo "login err";
                            } 
                    }
                }
            }
            
        }
    }

?>