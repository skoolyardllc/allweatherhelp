<?php
    require_once 'header.php';
    require_once 'navbar.php';
    require_once 'left-navbar.php';
 
    $id=$_SESSION['id'];
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(isset($_POST['add']))
        {
            $name = $_POST['name'];
            $sort_order = $_POST['sort_order'];
            $description = $_POST['description'];
            $sql="insert into testimonials(name, description, sort_order) values('$name', '$description','$sort_order')";
            if($conn->query($sql))
            {
                $insert_id = $conn->insert_id;
                if(upload_images2($_FILES,$conn,"testimonials","id","image",$insert_id,"projectFile",$website_link."/admin/uploads"))
                {
                    $resMember = "all_true";
                }
                else
                {
                    $resMember = "files_left";
                } 
            }
        }
        if(isset($_POST['edit']))
        {
            $token = $_GET['token'];
            $name = $_POST['name'];
            $sort_order = $_POST['sort_order'];
            $description = $_POST['description'];   
            $sql="update testimonials set name='$name', description='$description', sort_order='$sort_order' where id='$token'";
            if($conn->query($sql))
            {
                $insert_id = $token;
                if(upload_images2($_FILES,$conn,"testimonials","id","image",$insert_id,"projectFile",$website_link."/admin/uploads"))
                {
                    $resMember = "all_true";
                }
                else
                {
                    $resMember = "files_left";
                } 
            }else
            {
                 $errorMember = "Something Went Wrong";
            }
        }
    }
    
    if(isset($_GET['token'])&&!empty($_GET['token']))
    {
        $token=$_GET['token'];
        

        $sql="select * from testimonials where id='$token'";
        if($result =  $conn->query($sql))
        {
            if($result->num_rows)   
            {
                $row = $result->fetch_assoc();
                    $testimonials = $row;
            }
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
          Testimonial Details
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
                                <label>Name</label><br>   
                                <input type="text"  id="name" name="name" class="form-control" value="<?=$testimonials['name']?>" required>  
                            </div> 
                        </div>
                        <div class="col-md-5"> 
                            <div class="form-group">
                                <label>Sort Order</label><br> 
                                <input type="text"  id="sort_order" name="sort_order" class="form-control" value="<?=$testimonials['sort_order']?>" required>  
                            </div> 
                        </div>

                    </div>  
                    <div class="row">
                        <div class="col-md-10"> 
                            <div class="form-group">
                                <label style="margin-left:5px">Description</label><br> 
                                <textarea type="text"  id="description" name="description" class="form-control" style="resize: vertical;height:150px" required>  <?=$testimonials['description']?> </textarea> 
                            </div> 
                        </div>
                    </div> 
                    
                    <div class="row" style="margin-bottom:20px">    
                        <div class="col-md-12"> 
                            <div class="form-group">
                                <label>Image</label><br>  
                                <button type="button" class="btn btn-success" onclick="addFilesField()"><i class="fa fa-plus"></i></button>
                            </div> 
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:20px"> 
                        <?php
                            if(isset($testimonials)) 
                            {
                                $counter=0;
                                

                                    $ext=pathinfo($testimonials['image'],PATHINFO_EXTENSION);
                                    ?>
                                        <div class="col-md-2" id="file<?=$counter?>">
                                            <div class="col-md-8">
                                                <a href="<?=$testimonials['image']?>" target="_blank"><img src="<?=$testimonials['image']?>" width="100px" height="100px"/></a>
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" class="btn btn-danger" onclick="deleteFile(<?=$testimonials['id']?>,'file<?=$counter?>', '<?=$testimonials['image']?>')"><i class="fa fa-trash"></i></button>
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
                                if(isset($testimonials))
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

function deleteFile(id,divId, image)
{
    $.ajax({
        url:"deletetimage.php",
        type:"POST",
        data:{
            id:id,
            deleteImage:image,
            image:image
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
