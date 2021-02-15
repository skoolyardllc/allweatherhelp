<?php
    require_once 'header.php';
    require_once 'navbar.php';
    require_once 'left-navbar.php';
 
    $id=$_SESSION['id'];
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(isset($_POST['add']))
        {
            $start_date=$_POST['start_date'];
            $bid_amount=$_POST['bid_amount'];
            $title=$_POST['title'];
            $description=$_POST['description'];
            $assigned_to=$_POST['assigned_to'];
            $sql="insert into projects(title, description, bid_amount, start_date, assigned_to, status) values('$title', '$description', '$bid_amount', '$start_date', $assigned_to ,'1')";
            if($conn->query($sql))
            {
                $resMember = true; 
            }
            else
            {
                $errorMember=$conn->error;
            }
        }
    }

    if(isset($_GET['token'])&& !empty($_GET['token']))
    {   
        $token=$_GET['token'];     
        if(isset($_POST['edit']))
        {  
            $start_date=$_POST['start_date'];
            $bid_amount=$_POST['bid_amount'];
            $title=$_POST['title'];
            $description=$_POST['description'];
            $assigned_to=$_POST['assigned_to'];    
            $sql="update projects set start_date='$start_date', assigned_to='$assigned_to', title='$title', description='$description', bid_amount='$bid_amount'  where id='$token'";
            if($conn->query($sql))
            {
                $resMember = true;
            }
            else
            {
                $errorMember=$conn->error;
            }
        }  
        $sql="select * from projects where id='$token'";
        $result =  $conn->query($sql);
        if($result->num_rows)
        {
            $row = $result->fetch_assoc();
                $project[] = $row;
        }   
    }
    
    $sql="select up.* from user_profile up, users u where u.type=3 and u.id=up.u_id";
    if($result =  $conn->query($sql))
    {
        if($result->num_rows)
        {
            while($row = $result->fetch_assoc())
            {
                $users[] = $row;
            }
        }
    }

    $sql="select up.* from user_profile up, users u where u.type=2 and u.id=up.u_id";
    if($result =  $conn->query($sql))
    {
        if($result->num_rows)
        {
            while($row = $result->fetch_assoc())
            {
                $contractor[] = $row;
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
          Project Details
        </h1>
    </section>
    <section class="content">
        <?php
            if(isset($resMember))
            {
        ?>
                <div class="alert alert-success"><strong>Success! </strong> your request successfully updated. </div>   
        <?php
            }
            else if(isset($errorMember))
            {
        ?>
                <div class="alert alert-danger"><strong>Error! </strong><?=$errorMember?></div> 
        <?php
                
            }
        ?>
        
                <form method="post">
                    <div class="row">
                        
                        <div class="col-md-5"> 
                            <div class="form-group">
                                <label>Project Title</label><br>   
                                <input type="text"  id="title" name="title" class="form-control" value="<?=$project['title']?>" required>  
                            </div> 
                        </div>
                        <div class="col-md-5"> 
                            <div class="form-group">
                                <label>Start Date</label><br> 
                                <input type="date"  id="start_date" name="start_date" class="form-control" value="<?=$project['start_date']?>" required>  
                            </div> 
                        </div>

                    </div>  
                    <div class="row">
                        <div class="col-md-10"> 
                            <div class="form-group">
                                <label style="margin-left:5px">Project Description</label><br> 
                                <textarea type="text"  id="description" name="description" class="form-control" style="resize: vertical;height:150px" required>  <?=$project['description']?> </textarea> 
                            </div> 
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-md-5"> 
                            <div class="form-group">
                                <label>Bid Amount</label><br> 
                                <input type="text"  id="bid_amount" name="bid_amount" class="form-control" value="<?=$project['bid_amount']?>" required>  
                            </div> 
                        </div>
                    
                        <div class="col-md-5"> 
                            <div class="form-group">
                                <label>Assigned To</label><br> 
                                <select name="assigned_to" id="assigned_to" class="form-control">
                                <?php
                                    if(isset($users))
                                    {
                                        foreach($users as $data)
                                        {   
                                            $selected="";
                                            if($data['u_id']==$project['assigned_to'])
                                            {
                                             $selected="selected";   
                                            }
                                                
                                ?>
                                                <option value="<?=$data['u_id']?>" <?=$selected?>><?=$data['name']?></option>
                                <?php
                                            
                                        }
                                    }
                                ?>  
                                </select> 
                            </div> 
                        </div> 
                    </div>
                    <div class="row">
                        <div class="col-md-5"> 
                            <div class="form-group">
                                <label>Contractor</label><br> 
                                <select name="assigned_to" id="assigned_to" class="form-control">
                                <?php
                                    if(isset($contractor))
                                    {
                                        foreach($contractor as $data)
                                        {   
                                            $selected="";
                                            if($data['u_id']==$project['u_id'])
                                            {
                                             $selected="selected";   
                                            }
                                                
                                ?>
                                                <option value="<?=$data['u_id']?>" <?=$selected?>><?=$data['name']?></option>
                                <?php
                                            
                                        }
                                    }
                                ?>  
                                </select> 
                            </div> 
                        </div> 
                    </div>
        
                        <?php
                                if(isset($project))
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
        var inhtml  = `<div class="row" style="margin-top:20px">    
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

    function removeField(id)
    {
            $("#"+id).parent().parent().remove();
            
    }

function deleteFile(id,divId)
{
    $.ajax({
        url:"files_ajax.php",
        type:"POST",
        data:{
            deleteFile:id
        },
        success:function(data)
        {
           
            if(data.trim()=="ok")
            {
                $("#"+divId).remove();  
            }else
            {
                console.log(data);
            }
        },
        error:function()
        {

        }
    
    })
}
</script>



