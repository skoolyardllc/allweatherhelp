<?php
require_once 'header.php';
require_once 'navbar.php';
require_once 'left-navbar.php';

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    if(isset($_POST['deletem']))
    {
        $id=$_POST['deletem'];
        $sql = "delete from milestones where id=$id";
        if($conn->query($sql))
        {
            $resMember=true;   
        }
        else
        {
            $errorMember=$conn->error;
        }
    } 
    
    if(isset($_POST['deleteu']))
    {
        $id=$_POST['deleteu'];
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
    if(isset($_POST['deletep']))
    {
        $id=$_POST['deletep'];
        $sql = "delete from projects where id=$id";
        if($conn->query($sql))
        {
            $sql = "delete from milestones where p_id=$id"; 
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
    
    if(isset($_POST['block']))
    {
        $id=$_POST['block'];
        $sql="update user_profile set status=2 where id=$id";
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
        $sql="update user_profile set status=1 where id=$id";
        if($conn->query($sql))
        {
            $resSubject = "true";
        }
        else
        {
            $errorSubject=$conn->error;
        }
    }
    if(isset($_POST['hold']))
    {
        $id=$_POST['hold'];
        $sql="update projects set status=2 where id=$id";
        if($conn->query($sql))
        {
            $resMember = "true";
        }
        else
        {
            $errorMember=$conn->error;
        }
    }

    if(isset($_POST['active']))
    {
        $id=$_POST['active'];
        $sql="update projects set status=1 where id=$id";
        if($conn->query($sql))
        {
            $resMember = "true";
        }
        else
        {
            $errorMember=$conn->error;
        }
    }
    if(isset($_POST['completed']))
    {
        $id=$_POST['completed'];
        $sql="update projects set status=3 where id=$id";
        if($conn->query($sql))
        {
            $resMember = "true";
        }
        else
        {
            $errorMember=$conn->error;
        }
    } 
}

if(isset($_GET['token'])&&!empty($_GET['token']))
{
    $token=$_GET['token'];
    $sql="select up.*, u.email from users u, user_profile up where u.id='$token' and up.u_id=u.id";
    if($result=$conn->query($sql))
    {
        if($result->num_rows)
        {
            $row=$result->fetch_assoc();
            $contractor=$row;
        }
    }
    
    $sql="select * from projects where u_id='$token'";
    if($result=$conn->query($sql))
    {
        if($result->num_rows)
        {
            while($row=$result->fetch_assoc())
            {
                $projects[]=$row;
            }
        }
    }

    $sql="select up.*, u.email, u.id as uid from user_profile up, users u, projects p where p.u_id='$token' and up.u_id=p.assigned_to and u.id=p.assigned_to group by id";
    if($result=$conn->query($sql))
    {
        if($result->num_rows)
        {
            while($row=$result->fetch_assoc())
            {
                $users[]=$row;
            }
        }
    }
    
    $sql="select m.*, p.title as pname from milestones m, projects p where m.c_id='$token' and m.p_id=p.id";
    if($result=$conn->query($sql))
    {
        if($result->num_rows)
        {
            while($row=$result->fetch_assoc())
            {
                $milestones[]=$row;
            }
        }
    }            

}
         
?>
<div class="content-wrapper">
<section class="content-header">
        <h1>
            Contractor Details
        </h1>
        <ol class="breadcrumb">
            <li>
                <div class="pull-right">
                    <!-- <button title="" class="btn btn-primary" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i></button>  -->
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
                <div class="alert alert-success"><strong>Success!</strong> your request successfully updated.</div> 
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
                <table id="example1" class="table table-bordered table-hover">
                    <tbody>
                    <?php
                        if (isset($contractor)) 
                        {
                    ?>
                    
                            <tr> 
                                <th style="  text-align: center; background-color: #212529; color: white;" >Name</th>
                                <th style="  text-align: center; background-color: #808080; color: white;" id="name<?=$i?>"><?=$contractor['name'];?></th>  
                            </tr>
                            <tr> 
                                <th style="  text-align: center; background-color: #212529; color: white; " >Email</th>
                                <th style="  text-align: center; background-color: #808080; color: white;" id="email"><?=$contractor['email'];?></th>  
                            </tr>
                            <tr> 
                                <th style="  text-align: center; background-color: #212529; color: white;" >Mobile</th>
                                <th style="  text-align: center; background-color: #808080; color: white; " id="mobile"><?=$contractor['mobile'];?></th>  
                            </tr>
                            <tr> 
                                <th style="  text-align: center; background-color: #212529; color: white;" >Address</th>
                                <th style="  text-align: center; background-color: #808080; color: white;" id="address"><?=$contractor['address'];?></th>  
                            </tr>
                    <?php
                        }
                    ?>
                    </tbody>
                </table>

            </div>
        </div>
        <br>
        <h2>Employers</h2>
        <br>
        <div class="box">
            <div class="box-body">
                <table id="example2" class="table table-bordered table-hover">
                    <thead style="background-color: #212529; color: white;">
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
                            if (isset($users)) 
                            {
                                $i = 1;
                                foreach ($users as $detail) 
                                {     
                     ?> 
                                     <tr> 
                                         <td style="  text-align: center; " id="serialNo<?=$i?>"><?=$i?></td> 
                                         <td style="  text-align: center; " id="name<?=$i?>"><?=$detail['name'];?></td> 
                                         <td style="  text-align: center; " id="email<?=$i?>"><?=$detail['email'];?></td>
                                         <td style="  text-align: center; " id="mobile<?=$i?>"><?=$detail['mobile'];?></td>
                                         <td style="  text-align: center; " id="address<?=$i?>"><?=$detail['address'];?></td>
                                         <td>
                                        <form method="post">
                                            <button  class="btn btn-danger" type="submit" name="deleteu" value="<?=$detail['uid']?>">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                            <?php
                                                    if($detail['status']==1)
                                                    {
                                                ?>
                                                    <button  class="btn btn-warning" type="submit" name="block" value="<?=$detail['id']?>">
                                                                <i class="fa fa-ban ">Block</i>
                                                    </button>
                                                <?php
                                                    }else if($detail['status']==2)
                                                    {
                                                ?>
                                                        <button  class="btn btn-primary" type="submit" name="unblock" value="<?=$detail['id']?>">
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
        <br>
        <h2>Projects</h2>
        <br>
        <div class="box">
            <div class="box-body">
                <table id="example2" class="table table-bordered table-hover">
                    <thead style="background-color: #212529; color: white;">
                        <tr>
                             <th>S.No.</th>
                             <th>Title</th>
                             <th>Description</th>
                             <th>Project Budget</th>
                             <th>Start Date</th>
                             <th>Action</th>
                        </tr>
                    </thead>
                    <tbody> 
 
                    
                     <?php 
                            if (isset($projects)) 
                            {
                                $i = 1;
                                foreach ($projects as $detail) 
                                {     
                     ?> 
                                     <tr> 
                                         <td style="  text-align: center; " id="serialNo<?=$i?>"><?=$i?></td> 
                                         <td style="  text-align: center; " id="title<?=$i?>"><?=$detail['title'];?></td> 
                                         <td style="  text-align: center; " id="description<?=$i?>"><?=$detail['description'];?></td>
                                         <td style="  text-align: center; " id="bid_amount<?=$i?>"><?=$detail['bid_amount'];?></td>
                                         <td style="  text-align: center; " id="start_date<?=$i?>"><?=$detail['start_date'];?></td>
                                         <td>
                                        <form method="post">
                                            <button  class="btn btn-danger" type="submit" name="deletep" value="<?=$detail['id']?>">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                            <?php
                                                if($detail['status']==1)
                                                { 
                                            ?>
                                                    <button  class="btn btn-success" type="submit" name="completed" value="<?=$detail['id']?>">
                                                            <i class="fa fa-check-square ">Complete</i>
                                                    </button>
                                                    <button  class="btn btn-warning" type="submit" name="hold" value="<?=$detail['id']?>">
                                                        <i class="fa fa-ban"></i> Hold
                                                    </button>  
                                            <?php
                                                }
                                                else if($detail['status']==2)
                                                {
                                            ?>
                                                    <button  class="btn btn-success" type="submit" name="completed" value="<?=$detail['id']?>">
                                                            <i class="fa fa-check-square ">Complete</i>
                                                        </button>
                                                    <button  class="btn btn-info" type="submit" name="active" value="<?=$detail['id']?>">
                                                        <i class="fa fa-check"></i> Active
                                                    </button>
                                            <?php
                                                }
                                                else if($detail['status']==3)
                                                {
                                            ?>
                                                    <button  class="btn btn-warning" type="submit" name="hold" value="<?=$detail['id']?>">
                                                        <i class="fa fa-ban"></i> Hold
                                                    </button>    
                                                    <button  class="btn btn-info" type="submit" name="active" value="<?=$detail['id']?>">
                                                        <i class="fa fa-check"></i> Active
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
        
    </section>
  </div>
  <div class="control-sidebar-bg"></div>
    
  <?php
    require_once 'js-links.php';
  ?>