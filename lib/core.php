<?php session_start();
    ob_start();


    require_once'PHPMailer/PHPMailerAutoload.php';
    require_once'config.php';   

//check page setting
function check_page($id,$conn)
{
    $sql="select * from services where link='$id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0)
       return true;
    else
    {
        header("location:error.php");
        die();
    }
}
 


//check user authpage
function user_auth()
{
    if (!isset($_SESSION['user_signed_in']))
        {
            if($_SERVER['REQUEST_URI']!='/login')
            {
                $_SESSION['page']=$_SERVER['REQUEST_URI'];   
                
            }
            return false; // IMPORTANT: Be sure to exit here!
        }
        else
        {
            session_regenerate_id(true);
            return true;
        }
}

    
function user_login_with_social($email,$conn,$user,$s_type)
{
    $sql="select email,id,type from users where email='$email' ";
    $res=$conn->query($sql);
    if($res->num_rows > 0)
    {   
        $row=$res->fetch_assoc(); 
        $type=$row['type'];
        // print_r($row);
        $id=$row['id'];
        $_SESSION['user_signed_in']=$email;
        $_SESSION['user_id']=$id;  
        $_SESSION['type']=$type;
        setcookie("new",$email, time() + (86400 * 80), "/");    
        setcookie("pass","", time() + (86400 * 80), "/");   
        setcookie("sign_in_type",$s_type,time() + (86400 * 80), "/");
        return true;
    }
    else
    return false;
}

//company login
function login($email,$password,$conn,$path)
{
    
    $sql="select * from users where email='$email' and password='$password'";
    $res=$conn->query($sql);
    if($res->num_rows > 0)
    {
        $row=$res->fetch_assoc(); 
        $type=$row['type'];
        $id=$row['id'];
        
        // switch($type)
        // {
        //     // case 1: 
        //     //     header("location: $path");
        //     //     $_SESSION['master_admin_signed_in']=$email;
        //     //     $_SESSION['id']=$id; 
        //     //     break;
        //     case 2: 
        //         header("location: $path");
        //         $_SESSION['user_signed_in']=$email;
        //         $_SESSION['id']=$id;  
        //         break;
        //     case 3: 
        //         break;
        //     default: return false;
        // }
        $_SESSION['user_signed_in']=$email;
        $_SESSION['user_id']=$id;  
        $_SESSION['type']=$type;  
        setcookie("email",$email, time() + (86400 * 80), "/");   
        setcookie("pass",$password, time() + (86400 * 80), "/");
        if($path=='dashboard')
        {
            header("location: dashboard");
            return true;
        }
        if($path=='editProfile')
        {
            header("location: editProfile");
            return true;
        }
        if($type==3)
        {
            header("location: search_task");
            return true;
        }
        if(isset($_SESSION['page']))
        {
            $page_url=$_SESSION['page'];
            unset($_SESSION['page']);
            header("location: home");
        }
        else
        {

            header("location: $path");
            return true;
        }
        
    }
    else
    {
        return false;
    }
   
}


 
 //check for cookie login
    function cookie_login($conn)
    {
        if (!isset($_SESSION['user_signed_in']))
        {         
            if(isset($_COOKIE["email"]) && isset($_COOKIE["pass"]))
            {
                $email=$_COOKIE["email"];
                $pass=$_COOKIE["pass"];
                $sql= "select email,type,id from users where email='$email' and password='$pass'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) 
                {
                    $row = $result->fetch_assoc();
                   $_SESSION['user_signed_in']=$email;
                   $_SESSION['user_id']=$row['id'];  
                   $_SESSION['type']=$row['type'];  
                }
            }
        }
    }

    
    
    function master_admin_auth()
    {
        if (!isset($_SESSION['master_admin_signed_in']))
        {
            if($_SERVER['REQUEST_URI']!='/login')
            {
                $_SESSION['page']=$_SERVER['REQUEST_URI'];   
            }
            return false; // IMPORTANT: Be sure to exit here!
        }
        else
        {
            session_regenerate_id(true);
            return true;
        }
    }

    
    
//if masteradmin already login
    function master_auto_redirect($conn)
    {
        if(isset($_SESSION['master_admin_signed_in']))
        {
            $email=$_SESSION['master_admin_signed_in'];
            $sql="select * from users where email='$email'";
            $res=$conn->query($sql);
            if($res->num_rows > 0)
            {
                $row=$res->fetch_assoc(); 
                header("location: dashboard"); 
            }
        }
    }
//user login redirect
function user_redirect($path)
{
    if(isset($_SESSION['signed_in']))
    {
        header("location: $path");
    }
}

//check token
function check_token($token)
{
    if(!isset($token))
    {
        header("location:404");
    }
}

//change pass
    function change_pass($pass,$npass,$cpass,$conn)
    {
        $email=$_SESSION['signed_in'];
        $getdata="select password from users where email='$email' and password='$pass'";
        $result=$conn->query($getdata);
        if ($result->num_rows > 0) 
        {
            if($npass==$cpass)
            {
                $ss="update users set password='$npass' where email='$email'";
                if($conn->query($ss)===true)
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }

//user Registration

function registration($f_name,$l_name,$contact,$email,$pass,$type,$conn)
{
   
        $sql="insert into users (email,password,type) values('$email','$pass',$type)";
        if($conn->query($sql)===true)
        {
            $u_id = $conn->insert_id;
            $sql="insert into user_profiles(u_id,f_name,l_name,contact,profile_pic,status) values($u_id,'$f_name','$l_name','$contact','user.png','Enabled')";
            if($conn->query($sql)===true)
            {
               return true;
            }
            else{
                 
               return false;
            }
        }
        else
        {
             return false;
        }
}

function upload_image($files)
{
     $uploadedFile = 'err';
    if(!empty($_FILES['images']["type"]))
    {
        $fileName = time().'_'.$_FILES['images']['name'];
        $valid_extensions = array("jpeg", "jpg", "png","pdf","bmp","JPG");
        $temporary = explode(".", $_FILES['images']["name"]);
        $file_extension = end($temporary);
        if((($_FILES['images']["type"] == "image/png") || ($_FILES['images']["type"] == "application/pdf") || ($_FILES['images']["type"] == "image/bmp") || ($_FILES['images']["type"] == "image/jpg") || ($_FILES['images']["type"] == "image/JPG") || ($_FILES['images']["type"] == "image/jpeg")) && in_array($file_extension, $valid_extensions))
        {
            $sourcePath = $_FILES['images']['tmp_name'];
            $targetPath = "uploads/".$fileName;
            if(move_uploaded_file($sourcePath,$targetPath))
            {
                $uploadedFile = $fileName;
                 return $uploadedFile;
            }
            else
            {
                $uploadedFile="err";
                 return $uploadedFile;
            }
        }
        else
        {
            $uploadedFile="err";
            return $uploadedFile;
        }
       
    }
    else
    {
            $uploadedFile="err";
            return $uploadedFile;
    }
}

function upload_image_cp($files,$path)
{
     $uploadedFile = 'err';
    if(!empty($_FILES['images']["type"]))
    {
         
        
        $valid_extensions = array("jpeg", "jpg", "png","pdf","bmp","JPG");
        $temporary = explode(".", $_FILES['images']["name"]);
        $file_extension = end($temporary);
        $fileName = time().'.'.$file_extension;
        if((($_FILES['images']["type"] == "image/png") || ($_FILES['images']["type"] == "application/pdf") || ($_FILES['images']["type"] == "image/bmp") || ($_FILES['images']["type"] == "image/jpg") || ($_FILES['images']["type"] == "image/JPG") || ($_FILES['images']["type"] == "image/jpeg")) && in_array($file_extension, $valid_extensions))
        {
            $sourcePath = $_FILES['images']['tmp_name'];
            $targetPath = $path.$fileName;
            if(move_uploaded_file($sourcePath,$targetPath))
            {
                $uploadedFile = $fileName;
                 return $uploadedFile;
            }
            else
            {
                $uploadedFile="err";
                 return $uploadedFile;
            }
        }
        else
        {
            $uploadedFile="err";
            return $uploadedFile;
        }
       
    }
    else
    {
            $uploadedFile="err";
            return $uploadedFile;
    }
}

//upload file 
function upload_file($files,$conn,$r_id)
{
    $uploadedFile = '';
    if(!empty($_FILES["type"]))
    {
        $fileName = time().'_'.str_replace(' ','-',$_FILES['name']);
        $valid_extensions = array("jpeg", "jpg", "png","pdf","bmp","JPG");
        $temporary = explode(".", $_FILES["name"]);
        $file_extension = end($temporary);
        if((($_FILES["type"] == "image/png") || ($_FILES["type"] == "application/pdf") || ($_FILES["type"] == "image/bmp") || ($_FILES["type"] == "image/jpg") || ($_FILES["type"] == "image/JPG") || ($_FILES["type"] == "image/jpeg")) && in_array($file_extension, $valid_extensions))
        {
            $sourcePath = $_FILES['tmp_name'];
            $targetPath = "uploads/".$fileName;
            if(move_uploaded_file($sourcePath,$targetPath))
            {
				if($_FILES["type"] != "application/pdf")
				{
					$image = imagecreatefromjpeg($targetPath);
            		imagejpeg($image,$targetPath,60);
				}
                $uploadedFile = $fileName;
                $sql="insert into documents_upload(p_id,src) values('$r_id','$uploadedFile')";

                if($conn->query($sql)===true)
                {
                    return "yes";
                }
                else
                {
                    return $conn->error;
                }
            }
        }
    }
}


function upload_imageu($files,$conn,$table,$column,$id) 
{
    $uploadedFile = 'err';
    if(!empty($_FILES['images']["type"]))
    {
        $fileName = time().'_'.str_replace(' ', '',$_FILES['images']['name']);
        $valid_extensions = array("jpeg", "jpg", "png","bmp","JPG");
        $temporary = explode(".", $_FILES['images']["name"]);
        $file_extension = end($temporary);
        if((($_FILES['images']["type"] == "image/png") || ($_FILES['images']["type"] == "image/bmp") || ($_FILES['images']["type"] == "image/jpg") || ($_FILES['images']["type"] == "image/JPG") || ($_FILES['images']["type"] == "image/jpeg")) && in_array($file_extension, $valid_extensions))
        {
            $sourcePath = $_FILES['images']['tmp_name'];
            $targetPath = "uploads/".$fileName;
            if(move_uploaded_file($sourcePath,$targetPath))
            {
                $uploadedFile = $fileName;
                if(isset($table))
                {
                    $sql="update $table set $column='$targetPath' where id=$id";
                    if($conn->query($sql)===true)
                    {
                        return $uploadedFile;
                    }
                    else
                    {
                        echo $fileName;
                        unlink("uploads/".$fileName);
                        return 'err';
                    }
                }
                return $uploadedFile;
            }
            else
            {
                $uploadedFile="err";
                 return $uploadedFile;
            }
        }
        else
        {
            $uploadedFile="err";
            return $uploadedFile;
        }
       
    }
    else
    {
            $uploadedFile="err";
            return $uploadedFile;
    }
}

function upload_image2($conn,$table,$column,$id,$image)
{
     $uploadedFile = 'err';
    if(!empty($_FILES[$image]["type"]))
    {
         $fileName = time().'_'.str_replace(' ', '',$_FILES[$image]['name']);
        $valid_extensions = array("jpeg", "jpg", "png","bmp","JPG");
        $temporary = explode(".", $_FILES[$image]["name"]);
        $file_extension = end($temporary);
        if((($_FILES[$image]["type"] == "image/png") || ($_FILES[$image]["type"] == "image/bmp") || ($_FILES[$image]["type"] == "image/jpg") || ($_FILES[$image]["type"] == "image/JPG") || ($_FILES[$image]["type"] == "image/jpeg")) && in_array($file_extension, $valid_extensions))
        {
            $sourcePath = $_FILES[$image]['tmp_name'];
             $targetPath = "uploads/".$fileName;
            if(move_uploaded_file($sourcePath,$targetPath))
            {
                $uploadedFile = $fileName;
                if(isset($table))
                {
                          $sql="update $table set $column='$targetPath' where u_id=$id";
                    if($conn->query($sql)===true)
                    {
                        return $uploadedFile;
                    }
                    else
                    {  
                        unlink("uploads/".$fileName);
                        return 'err';
                    }
                }
                return $uploadedFile;
            }
            else
            {
                $uploadedFile="err";
                 return $uploadedFile;
            }
        }
        else
        {
            $uploadedFile="err";
            return $uploadedFile;
        }
       
    }
    else
    {
            $uploadedFile="err";
            return $uploadedFile;
    }
}


//function to upload document
function upload_document($files)
{
     $uploadedFile = 'err';
    if(!empty($_FILES['images']["type"]))
    {
        $fileName = time().'_'.$_FILES['images']['name'];
        $valid_extensions = array("jpeg", "jpg","png","pdf","bmp","JPG");
        $temporary = explode(".", $_FILES['images']["name"]);
        $file_extension = end($temporary);
        if((($_FILES['images']["type"] == "image/png") || ($_FILES['images']["type"] == "application/pdf") || ($_FILES['images']["type"] == "image/bmp") || ($_FILES['images']["type"] == "image/jpg") || ($_FILES['images']["type"] == "image/JPG") || ($_FILES['images']["type"] == "image/jpeg")) && in_array($file_extension, $valid_extensions))
        {
            $sourcePath = $_FILES['images']['tmp_name'];
            $targetPath = "uploads/".$fileName;
            if(move_uploaded_file($sourcePath,$targetPath))
            {
                $uploadedFile = $fileName;
                return $uploadedFile;
            }
            else
            {
                $uploadedFile="err";
                 return $uploadedFile;
            }
        }
        else
        {
            $uploadedFile="err";
            return $uploadedFile;
        }
    }
}
 


//function for forget password.

function forget_pass($conn,$contact)
{
    $sql="select email from users where id=(select u_id from user_profiles where contact='$contact')";
    $res=$conn->query($sql);
    if($res->num_rows > 0)
    {
        $row=$res->fetch_assoc();
		$email=$row['email'];
		return $email;
    }
    else
    {
        return false;
    }
}

//function for change the password
function update_pass($conn,$contact,$pass)
{
    $sql="update users set password='$pass' where id=(select u_id from user_profiles where contact='$contact')";
    if($conn->query($sql)===true)
    {
        return true;
    }
    else
    {
        return false;
    }
}

function createDir($path)
{		
	if (!file_exists($path)) 
    {
		$old_mask = umask(0);
		mkdir($path, 0777, TRUE);
		umask($old_mask);
	}
}


 


function createThumb($path1, $path2, $file_type, $new_w, $new_h, $squareSize = ''){
	/* read the source image */
	$source_image = FALSE;
	
	if (preg_match("/jpg|JPG|jpeg|JPEG/", $file_type)) {
		$source_image = imagecreatefromjpeg($path1);
	}
	elseif (preg_match("/png|PNG/", $file_type)) {
		
		if (!$source_image = @imagecreatefrompng($path1)) {
			$source_image = imagecreatefromjpeg($path1);
		}
	}
	elseif (preg_match("/gif|GIF/", $file_type)) {
		$source_image = imagecreatefromgif($path1);
	}		
	if ($source_image == FALSE) {
		$source_image = imagecreatefromjpeg($path1);
	}

	$orig_w = imageSX($source_image);
	$orig_h = imageSY($source_image);
	
	if ($orig_w < $new_w && $orig_h < $new_h) {
		$desired_width = $orig_w;
		$desired_height = $orig_h;
	} else {
		$scale = min($new_w / $orig_w, $new_h / $orig_h);
		$desired_width = ceil($scale * $orig_w);
		$desired_height = ceil($scale * $orig_h);
	}
			
	if ($squareSize != '') {
		$desired_width = $desired_height = $squareSize;
	}

	/* create a new, "virtual" image */
	$virtual_image = imagecreatetruecolor($desired_width, $desired_height);
	// for PNG background white----------->
	$kek = imagecolorallocate($virtual_image, 255, 255, 255);
	imagefill($virtual_image, 0, 0, $kek);
	
	if ($squareSize == '') {
		/* copy source image at a resized size */
		imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $orig_w, $orig_h);
	} else {
		$wm = $orig_w / $squareSize;
		$hm = $orig_h / $squareSize;
		$h_height = $squareSize / 2;
		$w_height = $squareSize / 2;
		
		if ($orig_w > $orig_h) {
			$adjusted_width = $orig_w / $hm;
			$half_width = $adjusted_width / 2;
			$int_width = $half_width - $w_height;
			imagecopyresampled($virtual_image, $source_image, -$int_width, 0, 0, 0, $adjusted_width, $squareSize, $orig_w, $orig_h);
		}

		elseif (($orig_w <= $orig_h)) {
			$adjusted_height = $orig_h / $wm;
			$half_height = $adjusted_height / 2;
			imagecopyresampled($virtual_image, $source_image, 0,0, 0, 0, $squareSize, $adjusted_height, $orig_w, $orig_h);
		} else {
			imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $squareSize, $squareSize, $orig_w, $orig_h);
		}
	}
	
	if (@imagejpeg($virtual_image, $path2, 90)) {
		imagedestroy($virtual_image);
		imagedestroy($source_image);
		return TRUE;
	} else {
		return FALSE;
	}
}	
function number_to_words($num)
{ 
    $ones = array( 
    1 => "one", 
    2 => "two", 
    3 => "three", 
    4 => "four", 
    5 => "five", 
    6 => "six", 
    7 => "seven", 
    8 => "eight", 
    9 => "nine", 
    10 => "ten", 
    11 => "eleven", 
    12 => "twelve", 
    13 => "thirteen", 
    14 => "fourteen", 
    15 => "fifteen", 
    16 => "sixteen", 
    17 => "seventeen", 
    18 => "eighteen", 
    19 => "nineteen" 
    ); 
    $tens = array( 
    1 => "ten",
    2 => "twenty", 
    3 => "thirty", 
    4 => "forty", 
    5 => "fifty", 
    6 => "sixty", 
    7 => "seventy", 
    8 => "eighty", 
    9 => "ninety" 
    ); 
    $hundreds = array( 
    "hundred", 
    "thousand", 
    "million", 
    "billion", 
    "trillion", 
    "quadrillion" 
    ); //limit t quadrillion 
    $num = number_format($num,2,".",","); 
    $num_arr = explode(".",$num); 
    $wholenum = $num_arr[0]; 
    $decnum = $num_arr[1]; 
    $whole_arr = array_reverse(explode(",",$wholenum)); 
    krsort($whole_arr); 
    $rettxt = ""; 
    foreach($whole_arr as $key => $i)
    { 
        if($i < 20)
        { 
            $rettxt .= $ones[$i]; 
        }
        elseif($i < 100)
        { 
            $rettxt .= $tens[substr($i,0,1)]; 
            $rettxt .= " ".$ones[substr($i,1,1)]; 
        }
        else
        { 
            $rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0]; 
            $rettxt .= " ".$tens[substr($i,1,1)]; 
            $rettxt .= " ".$ones[substr($i,2,1)]; 
        } 
        if($key > 0)
        { 
            $rettxt .= " ".$hundreds[$key]." "; 
        } 
    } 
    if($decnum > 0)
    { 
        $rettxt .= " and "; 
        if($decnum < 20)
        { 
            $rettxt .= $ones[$decnum]; 
        }
        elseif($decnum < 100)
        { 
            $rettxt .= $tens[substr($decnum,0,1)]; 
            $rettxt .= " ".$ones[substr($decnum,1,1)]; 
        } 
    } 
return ucwords($rettxt); 
}

function image_category()
{
    $link = $_SERVER['PHP_SELF'];
    $link_array = explode('/',$link);
    $page = end($link_array);
    switch($page)
    {
        case 'createEditBlog.php':
            return 'Blogs';
    }
     
    
}
 
 
 

//distance matrix
 

//Upload multiple images 23/04/20
function upload_images($files,$conn,$table,$id_col,$column,$id,$images,$path)
{
	if(isset($_FILES[$images]))
    {
        $extension=array("jpeg","jpg","png","gif","pdf","PDF");
        foreach($_FILES[$images]["tmp_name"] as $key=>$tmp_name) 
        {
            $file_name=$_FILES[$images]["name"][$key];
            $file_tmp=$_FILES[$images]["tmp_name"][$key];
            $ext=pathinfo($file_name,PATHINFO_EXTENSION);
        
            if(in_array($ext,$extension)) 
            {
                $filename=basename($file_name,$ext);
                $newFileName=$filename.time().".".$ext;
                if(move_uploaded_file($file_tmp=$_FILES[$images]["tmp_name"][$key],"uploads/".$newFileName))
                {
                   echo  $sql="insert into $table($id_col, $column) values($id,'$path/$newFileName')";
                    if($conn->query($sql)===true)
                    {
                        $status=true;
                    }
                    else
                    {
                        echo $conn->error;
                        $status=false;
                        break;
                    }
                }
                else
                {
                    $status=false;
                    break;
                }
            }
            else 
            {
                array_push($error,"$file_name, ");
            }
        }
        return $status;
    }
}
//upload multiple images
function upload_images2($files,$conn,$table,$id_col,$column,$id,$images,$path)
{
     
	if(isset($_FILES[$images]))
    {
        $extension=array("jpeg","jpg","png","gif","pdf","PDF");
        foreach($_FILES[$images]["tmp_name"] as $key=>$tmp_name) 
        {
            $file_name=$_FILES[$images]["name"][$key];
            $file_tmp=$_FILES[$images]["tmp_name"][$key];
            $ext=pathinfo($file_name,PATHINFO_EXTENSION);
        
            if(in_array($ext,$extension)) 
            {
                $filename=basename($file_name,$ext);
                $newFileName=$filename.time().".".$ext;
                if(move_uploaded_file($file_tmp=$_FILES[$images]["tmp_name"][$key],"uploads/".$newFileName))
                {
                     $sql="update $table set $column='$path/$newFileName' where $id_col=$id";
                    if($conn->query($sql)===true)
                    {
                        $status=true;
                    }
                    else
                    {
                          $conn->error;
                        $status=false;
                        break;
                    }
                }
                else
                {
                    $status=false;
                    break;
                }
            }
            else 
            {
                array_push($error,"$file_name, ");
            }
        }
        return $status;
    }
}

						
?>

