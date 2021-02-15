<?php
    require_once 'header.php';
    require_once 'navbar.php';
    require_once 'left-navbar.php';
 
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(isset($_POST['add']))
        {
            $platform=$_POST['platform'];
            $link=$_POST['link'];
            $icon=$_POST['Icon'];
            $sql="insert into socialmedia_links(platform, link, icon) values('$platform', '$link', '$icon')";
            if($conn->query($sql))
            {
                $resMember = "true";  
            }
            else
            {
                $errorMember=$conn->error;
            }
        }
        if(isset($_POST['delete']))
        {
            $id=$_POST['delete'];
            $sql="delete from socialmedia_links where id='$id'";
            if($conn->query($sql))
            {
                $resMember = "true";  
            }
            else
            {
                $errorMember=$conn->error;
            }
        }
            
        if(isset($_POST['edit']))
        {  
            $platform=$_POST['eplatform'];
            $link=$_POST['elink'];
            $id=$_POST['eid'];
            $icon=$_POST['eIcon'];
            $sql="update socialmedia_links set platform='$platform', link ='$link', icon='$icon' where id='$id'";
            if($conn->query($sql))
            {
                $resMember  = "true";
            }
            else
            {
                $errorMember=$conn->error;
            }
        }
    }

    $sql="select * from socialmedia_links";
    if($result =  $conn->query($sql))
    {
        if($result->num_rows)
        {
            while($row = $result->fetch_assoc())
            {
                $socialmedia[] = $row;
            }
        }
    }


 
?>

<style>
    .box-body{
	overflow: auto!important;
}
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="font-weight: 900;">
            Social Media Links
        </h1>
        <ol class="breadcrumb">
            <li>
                <div class="pull-right">
                    <button title="" class="btn btn-primary" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i></button> 
                    <a href="" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="Rebuild"><i class="fas fa-redo"></i></a>
                </div>
            </li>
        </ol>
    </section>

    <!-- Main content -->
      <br>
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
      
            <div class="box">
              <div class="box-body">
                <table id="example2" class="table table-bordered table-hover">
                    <thead style="background-color: #212529; color: white;">
                        <tr>
                             <th>S.No.</th>
                             <th>Platform</th>
                             <th>Link</th>
                             <th>Action</th>
                        </tr>
                    </thead>
                     <tbody> 
                     <?php 
                            if (isset($socialmedia)) 
                            {
                                $i = 1;
                                foreach ($socialmedia as $detail) 
                                {     
                     ?> 
                                     <tr> 
                                         <td style="  text-align: center; " id="serialNo<?=$i?>"><?=$i?></td> 
                                         <td style="  text-align: center; " id="platform<?=$i?>"><?=$detail['platform'];?></td> 
                                         <td style="  text-align: center; " id="link<?=$i?>"><?=$detail['link'];?></td>
                                         <td>
                                            <form method="post">
                                            <button name="confirm" type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-edit"  onclick="setEditValues(<?=$detail['id'] ?>,<?=$i?>)" value="<?=$detail['id'] ?>">
                                                            <i class="fa fa-edit">Edit</i>
                                                </button>
                                            <button  type="submit" class="btn btn-danger" name="delete" value="<?=$detail['id'] ?>">
                                                            <i class="fas fa-trash"> Delete</i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                 
                            <?php
                                $i++;           
                                }
                            }
                         ?>
          
                    </tbody>
                </table>
            </div>
            <!-- /.box-footer-->
        </div>    
      <!-- /.box -->
    </section>
    <!-- /.content -->
</div>

<div class="modal fade" id="modal-default">
        <div class="modal-dialog" >
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"> Add New Project Manager</h4>
                </div>
                <form method="post">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6"> 
                                <div class="form-group">
                                    <label>Platform</label><br>   
                                    <input type="text"  id="platform" name="platform" class="form-control" required>  
                                </div> 
                            </div>
                            <div class="col-md-6"> 
                                <div class="form-group">
                                    <label>Link</label><br>   
                                    <input type="text"  id="link" name="link" class="form-control"  required>  
                                </div> 
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-md-6"> 
                                <div class="form-group">
                                    <label>Select Icon</label><br>   
                                    <button type="button" id="GetIconPickerAdd" data-iconpicker-input="input#IconInput" data-iconpicker-preview="i#icon-preview-add">Select Icon</button>
                                    
                                </div> 
                            </div>
                            <div class="col-md-6"> 
                                <div class="form-group">
                                    <label>Preview</label><br>   
                                    <i class="" id="icon-preview-add"></i> 
                                    <input type="text" id="IconInput" name="Icon" required placeholder="Hidden etc. input for icon classname" autocomplete="off" spellcheck="false" /> 
                                </div> 
                            </div>
                        </div>   
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="submit" name="add" class="btn btn-primary" value="">Add</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>

    <div class="modal fade" id="modal-edit">
        <div class="modal-dialog" >
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Edit Details</h4>
                </div>
                <form method="post">
                    <div class="modal-body">
                        <div class="row">
                        <div class="col-md-6"> 
                                <div class="form-group">
                                    <label>Platform</label><br>   
                                    <input type="text"  id="eplatform" name="eplatform" class="form-control" required>  
                                </div> 
                            </div>
                            <div class="col-md-6"> 
                                <div class="form-group">
                                    <label>Link</label><br> 
                                    <input type="hidden" name="eid" id ="eid"/>  
                                    <input type="text"  id="elink" name="elink" class="form-control"  required>  
                                </div> 
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-md-6"> 
                                <div class="form-group">
                                    <label>Select Icon</label><br>   
                                    <button type="button" id="GetIconPickerEdit" data-iconpicker-input="input#eIconInput" data-iconpicker-preview="i#icon-preview-edit">Select Icon</button>
                                    
                                </div> 
                            </div>
                            <div class="col-md-6"> 
                                <div class="form-group">
                                    <label>Preview</label><br>   
                                    <i class="" id="icon-preview-edit"></i> 
                                    <input type="text" id="eIconInput" name="eIcon" required  autocomplete="off" spellcheck="false" /> 
                                </div> 
                            </div>
                        </div>  
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="submit" name="edit" class="btn btn-primary" value="">Edit</button>
                    </div>
                </form>
            </div>
        </div>
            <!-- /.modal-content -->
    </div>       

  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->       
<div class="control-sidebar-bg"></div>

<?php
    require_once 'js-links.php';
?>
<script>
    function setEditValues(id,count)
    {
        $("#eid").val(id); 
        $("#eplatform").val($("#platform"+count).html());
        $("#elink").val($("#link"+count).html());
        $("#eIconInput").val($("#IconInput"+count).html());
    }  
IconPicker.Init({
    jsonUrl: 'dist/iconpicker-1.5.0.json',
});


IconPicker.Run('#GetIconPickerEdit',function()
{
    console.log('Icon Picker');
});

IconPicker.Run('#GetIconPickerAdd',function()
{
    console.log('Icon Picker');
});
</script>


