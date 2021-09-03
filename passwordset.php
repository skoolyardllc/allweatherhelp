<?php
    require_once "lib/core.php";
    if(isset($_GET['token'])&&!empty($_GET['token']))
    {
        $token=$_GET['token'];
    }
    if(isset($_POST['login']))
    {
        $p1=md5($_POST['p1']);
        $p2=md5($_POST['p2']);
        if($p1==$p2)
        {
            $sql="update users set password='$p1' where email='$token'";
            if($conn->query($sql))
            {
                $resMember="Password Reset Successful";
            }
            else
            {
                $errorMember=$conn->error;
            }
        }
        else
        {
            $errorMember="Password Mismatched!! Try Again";
        }
    } 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- CSS
    ================================================== -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/colors/blue.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" href="./images/cyberflow-logo-1.png">
    <script src="https://kit.fontawesome.com/f662a74373.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <style>
    html,body { height: 100%; }

body{
	display: -ms-flexbox;
	display: -webkit-box;
	display: flex;
	-ms-flex-align: center;
	-ms-flex-pack: center;
	-webkit-box-align: center;
	align-items: center;
	-webkit-box-pack: center;
	justify-content: center;
	background-color: #f5f5f5;
}

form{
	padding-top: 10px;
	font-size: 14px;
	margin-top: 30px;
}

.card-title{ font-weight:300; }

.btn{
	font-size: 14px;
	margin-top:20px;
}

.login-form{ 
	width:320px;
	margin:20px;
}

.sign-up{
	text-align:center;
	padding:20px 0 0;
}

span{
	font-size:14px;
}
</style>
    </head>
<body>
    <div id="wrapper">
        <div class="card login-form">
        <?php
        if(isset($errorMember))
        {
        ?>
            <div class="alert alert-danger" role="alert">
                <?=$errorMember?>
            </div>
        <?php
        }
        else if(isset($resMember))
        {
        ?>
            <div class="alert alert-success" role="alert">
                <?=$resMember?>
            </div>
        <?php
        }
        ?>
            <div class="card-body">
                <h3 class="card-title text-center"> <strong>Reset password</strong>  </h3>
                
                <div class="card-text">
                    <form method="post">
                        <div class="form-group">
                            <label>New Password</label>
                            <input type="password" name="p1" class="form-control form-control-sm" >
                            <label>Confirm Password</label>
                            <input type="password" name="p2" class="form-control form-control-sm" >
                        </div>
                        <button type="submit" name="login" class="btn btn-primary btn-block">Reset</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
    