<?php
    require_once 'header.php';
    require_once 'navbar.php';
    require_once 'left-navbar.php';
 
    $id=$_SESSION['id'];
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {

        if(isset($_POST['add']))
        {
            $name=$_POST['name'];
            $email=$_POST['email'];
            $password=md5($_POST['password']);
            $mobile=$_POST['mobile'];
            $address=$_POST['address'];
            $sql="insert into users(email, password, type) values('$email', '$password', 3)";
            if($conn->query($sql))
            {
                $insert_id = $conn->insert_id;
                $sql="insert into user_profile(u_id, name, address, mobile, status) values('$insert_id', '$name', '$address', '$mobile', 1)";
                if($conn->query($sql))
                {
                    $resSubject=true;
                }
                else
                {
                    $errorSubject=$conn->error;
                }
            }
            else
            {
                $errorSubject=$conn->error;
            }
        }
        if(isset($_POST['edit']))
        {
            $name=$_POST['ename'];
            $email=$_POST['eemail'];
            $mobile=$_POST['emobile'];
            $address=$_POST['eaddress'];
            $id=$_POST['eid'];
            $sql="update user_profile set name='$name', mobile='$mobile', address='$address' where id='$id'";
            if($conn->query($sql))
            {
                $resSubject=true;
            }
            else
            {
                $errorSubject=$conn->error;
            }
        }

        if(isset($_POST['delete']))
        {
            $id=$_POST['delete'];
            
            $sql="delete from users where id=$id";
            if($conn->query($sql))
            {
                $sql="delete from user_profile where u_id=$id";  
                if($conn->query($sql))
                {
                    $resSubject = "true"; 
                } 
                else
                {
                    $errorSubject=$conn->error;
                }
            }
            else
            {
                $errorSubject=$conn->error;
            }
        }

        if(isset($_POST['block']))
        {
            $id=$_POST['block'];
            $sql="update user_profile set status=2 where u_id=$id";
            if($conn->query($sql))
            {
                $resSubject = "true";
            }
            else
            {
                $errorSubject=$conn->error;
            }
        }
        if(isset($_POST['unblock']))
        {
            $id=$_POST['unblock'];
            $sql="update user_profile set status=1 where u_id=$id";
            if($conn->query($sql))
            {
                $resSubject = "true";
            }
            else
            {
                $errorSubject=$conn->error;
            }
        }
    }

    if(isset($_GET['token'])&&!empty($_GET['token']))
    {
        $token = $_GET['token'];
        switch ($token) {
            case '1':
                $sql="select up.*, u.id as uid, u.email from users u, user_profile up where  u.type=3 and u.id=up.u_id";
                $title="All Contractors";
                break;
            case  "2":
                $sql="select up.*, u.id as uid, u.email from users u, user_profile up where up.status = 2 and u.type=3 and u.id=up.u_id";
                $title ="Blocked Contractors";
                break; 
            case "3": 
                $sql="select up.*, u.id as uid, u.email from users u, user_profile up where up.status = 1 and u.type=3 and u.id=up.u_id";
                $title ="Unblocked Contractors";
                break;
            default:
                $title="INVALID REQUEST";
                break;
        }
        
        $result =  $conn->query($sql);
        if($result->num_rows)
        {
            while($row = $result->fetch_assoc())
            {
                $companies[] = $row;
            }
        }

    }
    else{
        $title="INVALID REQUEST";
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
        <h1>
           <?=$title?>  
        </h1>
        <ol class="breadcrumb">
            <li>
                <div class="pull-right">
                    <button title="" class="btn btn-primary" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i></button> 
                    <a href="" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="Rebuild"><i class="fa fa-refresh"></i></a>
                </div>
            </li>
        </ol>
    </section>

    <!-- Main content -->
      <br>
    <section class="content">
        <?php
            if(isset($resSubject))
            {
        ?>
                <div class="alert alert-success"><strong>Success! </strong> your request successfully updated. </div> 
        <?php
            }
            else if(isset($errorSubject))
            {
        ?>
                <div class="alert alert-danger"><strong>Error! </strong><?=$errorSubject?></div> 
        <?php
                
            }
        ?>
      
            <div class="box">
              <div class="box-body">
                <table id="example2" class="table table-bordered table-hover">
                    <thead  style="background-color: #212529; color: white;">
                        <tr>
                             <th>S.No.</th>
                             <th>Name</th>
                             <th>Email</th>
                             <th>Mobile</th>
                             <th>Address</th>
                             <th>Action</th>
                        </tr>
                    </thead>
                     <tbody> 
                     <?php
                            if (isset($companies)) 
                            {
                                $i = 1;
                                foreach ($companies as $detail) 
                                { 
                     ?>
                                    <tr> 
                                     
                                        <td style="  text-align: center; " id="serialNo<?=$i?>"><?=$i?></td> 
                                         <td style="  text-align: center; " id="name<?=$i?>"><?=$detail['name'];?></td> 
                                         <td style="  text-align: center; " id="email<?=$i?>"><?=$detail['email'];?></td> 
                                         <td style="  text-align: center; " id="mobile<?=$i?>"><?=$detail['mobile'];?></td> 
                                         <td style="  text-align: center; " id="address<?=$i?>"><?=$detail['address'];?></td> 
                                           
                                        <td style="width:30%">
                                           
                                            <form method="post">
                                                <a href="viewcontractors?token=<?=$detail['uid']?>" class="btn btn-primary"><i class="fa fa-eye">View</i></a>
                                                <button name="confirm" type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-edit"  onclick="setEditValues(<?=$detail['id'] ?>,<?=$i?>)" value="<?=$detail['id'] ?>">
                                                            <i class="fa fa-edit">Edit</i>
                                                </button>
                                                <button  class="btn btn-danger" type="submit" name="delete" value="<?=$detail['uid']?>">
                                                            <i class="fas fa-trash"></i> Delete
                                                </button>
                                                <?php
                                                    if($detail['status']==1)
                                                    {
                                                ?>
                                                    <button  class="btn btn-warning" type="submit" name="block" value="<?=$detail['uid']?>">
                                                                <i class="fa fa-ban ">Block</i>
                                                    </button>
                                                <?php
                                                    }else if($detail['status']==2)
                                                    {
                                                ?>
                                                        <button  class="btn btn-primary" type="submit" name="unblock" value="<?=$detail['uid']?>">
                                                                    <i class="fa fa-check">Unblock</i>
                                                        </button>
                                                <?php
                                                    }
                                                ?>
                                                
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
                <h4 class="modal-title">Add A Contractor</h4>
            </div>
            <form method="post">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6"> 
                        <div class="form-group">
                                <label>Name</label><br>   
                                <input type="text"  id="name" name="name" class="form-control" required>  
                            </div> 
                    </div>
                    <div class="col-md-6"> 
                        <div class="form-group">
                                <label>Email</label><br>   
                                <input type="text"  id="email" name="email" class="form-control"  required>  
                            </div> 
                    </div>
                    </div>  
                <div class="row">
                    <div class="col-md-6"> 
                        <div class="form-group">
                                <label>Password</label><br>   
                                <input type="password"  id="password" name="password" class="form-control"  required>  
                            </div> 
                    </div>
                    <div class="col-md-6"> 
                        <div class="form-group">
                                <label>Mobile</label><br>   
                                <input type="text"  id="mobile" name="mobile" class="form-control"  required>  
                            </div> 
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-md-6"> 
                        <div class="form-group">
                                <label>Address</label><br>   
                                <input type="text"  id="address" name="address" class="form-control"  required>  
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
</div>
<div class="modal fade" id="modal-edit">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Edit Contractor Details</h4>
            </div>
            <form method="post">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6"> 
                        <div class="form-group">
                                <label>Name</label><br>   
                                <input type="text"  id="ename" name="ename" class="form-control" required>  
                            </div> 
                    </div>
                    <div class="col-md-6"> 
                        <div class="form-group">
                                <label>Email</label><br>   
                                <input type="text"  id="eemail" name="eemail" class="form-control"  required>
                                <input type="hidden" name="eid" id ="eid"/>
                            </div> 
                    </div>
                    </div>  
                <div class="row">
                    <div class="col-md-6"> 
                        <div class="form-group">
                                <label>Mobile</label><br>   
                                <input type="text"  id="emobile" name="emobile" class="form-control"  required>  
                            </div> 
                    </div>
                    <div class="row">
                            <div class="col-md-6"> 
                                <div class="form-group">
                                        <label>Address</label><br>   
                                        <input type="text"  id="eaddress" name="eaddress" class="form-control"  required>  
                                    </div> 
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
</div>
            <!-- /.modal-content -->

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
        $("#ename").val($("#name"+count).html());
        $("#eemail").val($("#email"+count).html());
        $("#emobile").val($("#mobile"+count).html());
        $("#eaddress").val($("#address"+count).html());
    }  
</script>

