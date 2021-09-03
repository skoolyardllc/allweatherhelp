<?php
    require_once '../lib/core.php';
function loginApp($email,$password,$conn)
{
    
    $sql="select * from users where email='$email' and password='$password'";
    $res=$conn->query($sql);
    if($res->num_rows > 0)
    {
        $row=$res->fetch_assoc(); 
        $type=$row['type'];
        $id=$row['id'];
        $_SESSION['user_signed_in']=$email;
        $_SESSION['user_id']=$id;  
        $_SESSION['type']=$type;  
        $_SESSION['mode']="Phone";
        setcookie("email",$email, time() + (86400 * 80), "/");   
        setcookie("pass",$password, time() + (86400 * 80), "/");
        
    }
    else
    {
        return false;
    }
    
}
    if(isset($_POST['user_Login']))
    {
        $res = [];
        $email = $conn->real_escape_string($_POST['user_email']);
        $password = md5($conn->real_escape_string($_POST['user_password']));
        if(isset($_POST['set_session']))
        {
            $password = $conn->real_escape_string($_POST['user_password']);
        }
        $sql = "SELECT * from users where email = '$email' and password = '$password' ";
        if($result=$conn->query($sql))
        {
            if($result->num_rows > 0)
            {
                // echo "ok";
                $row=$result->fetch_assoc(); 
                $type=$row['type'];
                $id=$row['id'];
                $_SESSION['user_signed_in']=$email;
                $_SESSION['user_id']=$id;  
                $_SESSION['type']=$type;
                $_SESSION['mode']="Phone";
                $res['msg'] = "ok";
                $res['email'] = $email;
                $res['password'] = $password;
                $res['type'] = $type;
                $res['id'] = $id;
            }
            else
            {
                // echo "error";
                $res['msg'] = "wrong";
            }
        }
        else
        {
            // echo "error";
            $res['msg'] = "error";
        }

        echo json_encode($res);
    }

    if(isset($_POST['user_signUp']))
    {
        $res = [];
        $email = $conn->real_escape_string($_POST['user_email']);
        $password = md5($conn->real_escape_string($_POST['user_password']));
        $type = $conn->real_escape_string($_POST['user_type']);
        switch($type)
        {
            case 'Customer':
                $accType=5;
                break;
    
            case 'Contractor':
                $accType=3;
                break;
                
            case 'Business':
                $accType=2;
                break;
        }
        $sql = "SELECT * from users where email = '$email'  ";
        if($result=$conn->query($sql))
        {
            if($result->num_rows > 0)
            {
                // echo "ok";
                $res['msg'] = "alreadyRegistered";
            }
            else
            {
                // echo "error";
                // $res['msg'] = "error";
            
        
                $sql = "insert into users(email,password,type) values('$email','$password','$accType')";
                if($conn->query($sql))
                {
                    $id=$conn->insert_id;
                    $sql2 = "insert into user_profile(avtar,u_id) values('images/user-avatar-placeholder.png','$id')";
                    if($conn->query($sql2))
                    {
                        $sql3="insert into bank(u_id,stat) values('$id','$accType')";
                        if($conn->query($sql3))
                        {
                            if($accType==2)
                            {
                                $sql4 = "insert into adm(u_id,adm) values('$id','00')"; 
                                if($conn->query($sql4))
                                {
                                    $sql5 = "insert into adm(u_id,adm) values('$id','01')"; 
                                    if($conn->query($sql5))
                                    {
                                        $sql6="insert into insurance(u_id) values('$id')";
                                        if($conn->query($sql6))
                                        {
                                            loginApp($email,$password,$conn);
                                            $res['msg'] = "signedUp"; 
                                            $res['email'] = $email;
                                            $res['password'] = $password;
                                            $res['type'] = $accType;
                                            $res['id'] = $id;
                                        }
                                        else
                                        {
                                            $res['error']=$conn->error;
                                        }
                                    }
                                    else
                                    {
                                        $res['error']=$conn->error;
                                    } 
                                }
                                else
                                {
                                    $res['error']=$conn->error;
                                }
                                
                            }
                            else
                            {
                                loginApp($email,$password,$conn);
                                $res['msg'] = "signedUp"; 
                                $res['email'] = $email;
                                $res['password'] = $password;
                                $res['type'] = $accType;
                                $res['id'] = $id;
                            }
                            
                        }
                        else
                        {
                           
                            $res['error']=$conn->error;
                        }
                    }
                }
                else
                {
                    // echo "error";
                    $res['msg'] = "error";
                }
            }
        }

        echo json_encode($res);
    }

    if(isset($_POST['google_Login']))
    {
        $res = [];
        $email = $conn->real_escape_string($_POST['user_email']);
        $sql = "SELECT * from users where email = '$email' and sign_type!='0'";
        if($result=$conn->query($sql))
        {
            if($result->num_rows > 0)
            {
                // echo "ok";
                $row=$result->fetch_assoc(); 
                $type=$row['type'];
                $id=$row['id'];
                $_SESSION['user_signed_in']=$email;
                $_SESSION['user_id']=$id;  
                $_SESSION['type']=$type;
                $_SESSION['mode']="Phone";
                $res['msg'] = "ok";
                $res['email'] = $email;
                $res['password'] = "";
                $res['type'] = $type;
                $res['id'] = $id;
            }
            else
            {
                // echo "error";
                $res['msg'] = "wrong";
            }
        }
        else
        {
            // echo "error";
            $res['msg'] = $conn->error;
        }

        echo json_encode($res);
    }

    if(isset($_POST['google_Signup']))
    {
        $res = [];
        $email = $conn->real_escape_string($_POST['user_email']);
        $TYPE = $conn->real_escape_string($_POST['userType']);
        $password  = "";
        switch($TYPE)
        {
            case 'Customer':
                $accType=5;
                break;
    
            case 'Contractor':
                $accType=3;
                break;
                
            case 'Business':
                $accType=2;
                break;
        }
        $sql = "SELECT * from users where email = '$email' and sign_type!='0'";
        if($result=$conn->query($sql))
        {
            if($result->num_rows > 0)
            {
                // echo "ok";
                $row=$result->fetch_assoc(); 
                $type=$row['type'];
                $id=$row['id'];
                $_SESSION['user_signed_in']=$email;
                $_SESSION['user_id']=$id;  
                $_SESSION['type']=$type;
                $_SESSION['mode']="Phone";
                $res['msg'] = "ok";
                $res['email'] = $email;
                $res['password'] = "";
                $res['type'] = $type;
                $res['id'] = $id;
            }
            else
            {
                
                // echo "error";
                // $res['msg'] = "error";
            
        
                $sql = "insert into users(email,password,type,sign_type) values('$email','','$accType','google')";
                if($conn->query($sql))
                {
                    $id=$conn->insert_id;
                    $sql2 = "insert into user_profile(avtar,u_id) values('images/user-avatar-placeholder.png','$id')";
                    if($conn->query($sql2))
                    {
                        $sql3="insert into bank(u_id,stat) values('$id','$accType')";
                        if($conn->query($sql3))
                        {
                            if($accType==2)
                            {
                                $sql4 = "insert into adm(u_id,adm) values('$id','00')"; 
                                if($conn->query($sql4))
                                {
                                    $sql5 = "insert into adm(u_id,adm) values('$id','01')"; 
                                    if($conn->query($sql5))
                                    {
                                        $sql6="insert into insurance(u_id) values('$id')";
                                        if($conn->query($sql6))
                                        {
                                            loginApp($email,$password,$conn);
                                            $res['msg'] = "signedUp"; 
                                            $res['email'] = $email;
                                            $res['password'] = "";
                                            $res['type'] = $accType;
                                            $res['id'] = $id;
                                        }
                                        else
                                        {
                                            $res['error']=$conn->error;
                                        }
                                    }
                                    else
                                    {
                                        $res['error']=$conn->error;
                                    } 
                                }
                                else
                                {
                                    $res['error']=$conn->error;
                                }
                                
                            }
                            else
                            {
                                loginApp($email,$password,$conn);
                                $res['msg'] = "signedUp"; 
                                $res['email'] = $email;
                                $res['password'] = "";
                                $res['type'] = $accType;
                                $res['id'] = $id;
                            }
                            
                        }
                        else
                        {
                           
                            $res['error']=$conn->error;
                        }
                    }
                }
                else
                {
                    // echo "error";
                    $res['msg'] = "error";
                }
            
                
            }
        }
        else
        {
            // echo "error";
            $res['msg'] = $conn->error;
        }

        echo json_encode($res);
    }
?>