<?php
    require_once 'header.php';
    require_once 'navbar.php';
    require_once 'left-navbar.php';
 
    $id=$_SESSION['id'];
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(isset($_POST['add']))
        {
            $sub_title=$_POST['sub_title'];
            $about=$_POST['about'];
            $title=$_POST['title'];
            $email=$_POST['email'];
            $mobile=$_POST['mobile'];
            $address=$_POST['address'];
            $sql="insert into website_details(title, email, about, sub_title, mobile, address) values('$title', '$email', '$about', '$sub_title', $mobile ,'$address')";
            if($conn->query($sql))
            {
                $insert_id = $conn->insert_id;
                if(upload_images2($_FILES,$conn,"website_details","id","logo",$insert_id,"projectFile",$website_link."/admin/uploads"))
                {
                    $resMember = "all_true";
                }
                else
                {
                    $resMember = "files_left";
                } 
            }
        }
    }
    
    if(isset($_POST['edit']))
    {  
        $sub_title=$_POST['sub_title'];
        $about=$_POST['about'];
        $title=$_POST['title'];
        $email=$_POST['email'];
        $mobile=$_POST['mobile'];
        $address=$_POST['address']; 
        $sql="select id from website_details";
        if($result =  $conn->query($sql))
        {
            if($result->num_rows)
            {
                $row = $result->fetch_assoc();
                    $wdid = $row;
            }
        }  
        $wid=$wdid['id'];
        $sql="update website_details set sub_title='$sub_title', title= '$title', about='$about', email='$email', mobile='$mobile', address='$address' where id='$wid'";
        if($conn->query($sql))
        {
            $insert_id = $wid;
            if(upload_images2($_FILES,$conn,"website_details","id","logo",$insert_id,"projectFile",$website_link."/admin/uploads"))
            {
                $resMember = "all_true";
            }
            else
            {
                $resMember = "files_left";
            } 
        }
        else{
                $errorMember=$conn->error;
        }
    }
        
        $sql="select * from website_details";
        if($result =  $conn->query($sql))
        {
            if($result->num_rows)
            {
                $row = $result->fetch_assoc();
                    $website_details = $row;
            }
        }   
        
    
       
    
?>
<style>
    .box-body{
	overflow: auto!important;
}
</style>

<div class="content-wrapper">

    <section class="content-header">
        <h1>
          Website Details
        </h1>
    </section>
    <section class="content">
        <?php
            if(isset($resMember))
            {
                switch($resMember)
                {
                    case 'all_true':
                ?>
                             <div class="alert alert-success"><strong>Success! </strong> your request successfully updated. </div>   
                <?php
                    break;
                    case 'files_left':
                ?>
                            <div class="alert alert-warning"><strong>Success! </strong> Updated Details, Failed to Update Image </div>   
                <?php
                }
        ?>
                
        <?php
            }
            else if(isset($errorMember))
            {
        ?>
                <div class="alert alert-danger"><strong>Error! </strong><?=$errorMember?></div> 
        <?php
                
            }
        ?>
        
                <form method="post" enctype="multipart/form-data">
                    <div class="row">
                        
                        <div class="col-md-5"> 
                            <div class="form-group">
                                <label>Title</label><br>   
                                <input type="text"  id="title" name="title" class="form-control" value="<?=$website_details['title']?>" required>  
                            </div> 
                        </div>
                        <div class="col-md-5"> 
                            <div class="form-group">
                                <label>Sub Title</label><br> 
                                <input type="text"  id="sub_title" name="sub_title" class="form-control" value="<?=$website_details['sub_title']?>" required>  
                            </div> 
                        </div>

                    </div>  
                    <div class="row">
                        <div class="col-md-10"> 
                            <div class="form-group">
                                <label style="margin-left:5px">About</label><br> 
                                <textarea type="text"  id="about" name="about" class="form-control" style="resize: vertical;height:150px" required>  <?=$website_details['about']?> </textarea> 
                            </div> 
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-md-5"> 
                            <div class="form-group">
                                <label>Email</label><br> 
                                <input type="text"  id="email" name="email" class="form-control" value="<?=$website_details['email']?>" required>  
                            </div> 
                        </div>
                    
                        <div class="col-md-5"> 
                            <div class="form-group">
                                <label>Contact Number</label><br> 
                                <input type="text"  id="mobile" name="mobile" class="form-control" value="<?=$website_details['mobile']?>" required>  
                            </div> 
                        </div> 
                    </div>
                    <div class="row">
                        <div class="col-md-5"> 
                            <div class="form-group">
                                <label>Address</label><br> 
                                <input type="text"  id="address" name="address" class="form-control" value="<?=$website_details['address']?>" required>  
                            </div> 
                        </div> 
                        
                    </div>
                    <div class="row" style="margin-bottom:20px">    
                        <div class="col-md-12"> 
                            <div class="form-group">
                                <label>Logo</label><br>  
                                <button type="button" class="btn btn-success" onclick="addFilesField()"><i class="fa fa-plus"></i></button>
                            </div> 
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:20px"> 
                        <?php
                            if(isset($website_details['logo'])) 
                            {
                                $counter=0;
                                $ext=pathinfo($website_details['logo'],PATHINFO_EXTENSION);
                                    ?>
                                        <div class="col-md-2" id="file<?=$counter?>">
                                            <div class="col-md-8">
                                                <a href="<?=$website_details['logo']?>" target="_blank"><img src="<?=$website_details['logo']?>" width="100px" height="100px"/></a>
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" class="btn btn-danger" onclick="deleteFile(<?=$website_details['id']?>,'file<?=$counter?>', '<?=$website_details['logo']?>')"><i class="fas fa-trash"></i></button>
                                            </div>
                                        </div>
                                        <?php 
                            }
                            
                            ?>
                    </div>
                    <div class="row">
                        <div class="col-md-4" id="filesDiv"> 
                                 
                                
                        </div>
                    </div>

        
                        <?php
                                if(isset($website_details))
                                {
                        ?>
                                    <button type="submit" name="edit" class="btn btn-primary" style="margin-top:10" value="">Edit</button>
                            <?php
                                }
                                else
                                {
                            ?>
                                        
                                    <button type="submit" name="add" class="btn btn-primary" style="margin-top:10" value="">Add</button>
                        <?php
                                }
                        ?> 
                </form>
         

    </section>
</div>
<?php
    require_once 'js-links.php';
?>

<script>
    var counter=1;
    
    function addFilesField()
    {
        if(counter==1)
        { 
            var inhtml  =  `<div class="row" style="margin-top:20px">    
                                <div class="col-md-10">
                                    <input   type="file" id='projectfile${counter}' name="projectFile[]" class="form-control"/>
                                </div> 
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger" onclick="removeField('projectfile${counter}')"><i class="fa fa-trash"></i></button>
                                </div> 
                            </div>`;
            $("#filesDiv").append(inhtml);
            counter++;
        }
    }
    function removeField(id)
    {
            $("#"+id).parent().parent().remove();
            
    }

function deleteFile(id,divId, logo)
{
    $.ajax({
        url:"deletelogo.php",
        type:"POST",
        data:{
            id:id,
            deleteImage:logo,
            logo:logo
        },
        success:function(data)
        {
            if(data.trim()=="ok")
            {
                $('#'+divId).remove();
            }
        },
        error:function()
        {

        }
    
    })
}
</script>
