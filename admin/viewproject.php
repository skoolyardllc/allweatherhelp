<?php
require_once 'header.php';
require_once 'navbar.php';
require_once 'left-navbar.php';

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    if(isset($_POST['delete']))
    {
        $id=$_POST['delete'];
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
    if(isset($_POST['delete_bid']))
    {
        $id=$_POST['delete_bid'];
        $sql = "delete from project_bids where id=$id";
        if($conn->query($sql))
        {
            $resMember=true;   
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
    
    $sql="select p.*, up.name from projects p, user_profile up where p.id='$token' and p.u_id=up.u_id";
    if($result=$conn->query($sql))
    {
        if($result->num_rows)
        {
            $row=$result->fetch_assoc();
            $project=$row;
            $sql="select name from user_profile up, projects p where p.assigned_to=up.u_id";
            if($result=$conn->query($sql))
            {
                if($result->num_rows)
                {
                    $row=$result->fetch_assoc();
                    $project['assigned_to']=$row['name'];
                }
            }
        }
    }

    if(isset($_POST['assign']))
    {
        $id=$_POST['assign'];
        $sql = "update projects set assigned_to=$id where id='$token'";
        if($conn->query($sql))
        {
            $resMember=true;   
        }
        else
        {
            $errorMember=$conn->error;
        }
    } 
    
    $sql="select * from milestones where p_id='$token'";
    if($result=$conn->query($sql))
    {
        if($result->num_rows)
        {
            while($row=$result->fetch_assoc())
            {
                $milestone[]=$row;
            }
        }
    }            
    $sql="select * from project_bids where p_id='$token'";
    if($result=$conn->query($sql))
    {
        if($result->num_rows)
        {
            while($row=$result->fetch_assoc())
            {
                $bids[]=$row;
            }
        }
    }            

}
         
?>
<div class="content-wrapper">
<section class="content-header">
        <h1>
            Project Details
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
                        if (isset($project)) 
                        {
                    ?>
                    
                            <tr> 
                                <th style="  text-align: center; background-color: #212529; color: white;" >Title</th>
                                <th style="  text-align: center; background-color: #808080; color: white;" id="title<?=$i?>"><?=$project['title'];?></th>  
                            </tr>
                            <tr> 
                                <th style="  text-align: center; background-color: #212529; color: white; " >Description</th>
                                <th style="  text-align: center; background-color: #808080; color: white;" id="description"><?=$project['description'];?></th>  
                            </tr>
                            <tr> 
                                <th style="  text-align: center; background-color: #212529; color: white;" >Project Budget</th>
                                <th style="  text-align: center; background-color: #808080; color: white; " id="bid_amount"><?=$project['bid_amount'];?></th>  
                            </tr>
                            <tr> 
                                <th style="  text-align: center; background-color: #212529; color: white;" >Assigned By</th>
                                <th style="  text-align: center; background-color: #808080; color: white;" id="assigned_by"><?=$project['name'];?></th>  
                            </tr>
                            <tr> 
                                <th style="  text-align: center; background-color: #212529; color: white;" >Assigned To</th>
                                <th style="  text-align: center; background-color: #808080; color: white;" id="assigned_to"><?=$project['assigned_to'];?></th>  
                            </tr>
                            <tr> 
                                <th style="  text-align: center; background-color: #212529; color: white;" >Start Date</th>
                                <th style="  text-align: center; background-color: #808080; color: white;" id="start_date"><?=$project['start_date'];?></th>  
                            </tr>
                    <?php
                        }
                    ?>
                    </tbody>
                </table>

            </div>
        </div>
        <br>
        <h2>Milestones</h2>
        <br>
        <div class="box">
            <div class="box-body">
                <table id="example2" class="table table-bordered table-hover">
                    <thead style="background-color: #212529; color: white;">
                        <tr>
                             <th>S.No.</th>
                             <th>Description</th>
                             <th>Amount</th>
                             <th>Start Date</th>
                             <th>Due Date</th>
                             <th>Action</th>
                        </tr>
                    </thead>
                    <tbody> 
 
                    
                     <?php 
                            if (isset($milestone)) 
                            {
                                $i = 1;
                                foreach ($milestone as $detail) 
                                {     
                     ?> 
                                     <tr> 
                                         <td style="  text-align: center; " id="serialNo<?=$i?>"><?=$i?></td> 
                                         <td style="  text-align: center; " id="description<?=$i?>"><?=$detail['description'];?></td> 
                                         <td style="  text-align: center; " id="amount<?=$i?>"><?=$detail['amount'];?></td>
                                         <td style="  text-align: center; " id="start_date<?=$i?>"><?=$detail['start_date'];?></td>
                                         <td style="  text-align: center; " id="due_date<?=$i?>"><?=$detail['due_date'];?></td>
                                         <td>
                                        <form method="post">
                                            <button  class="btn btn-danger" type="submit" name="delete" value="<?=$detail['id']?>">
                                                <i class="fas fa-trash"></i> Delete
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
        <br>
        <h2>Project Bids</h2>
        <br>
        <div class="box">
            <div class="box-body">
                <table id="example2" class="table table-bordered table-hover">
                    <thead style="background-color: #212529; color: white;">
                        <tr>
                             <th>S.No.</th>
                             <th>Description</th>
                             <th>Amount</th>
                             <th>Due Date</th>
                             <th>Action</th>
                        </tr>
                    </thead>
                    <tbody> 
 
                    
                     <?php 
                            if (isset($bids)) 
                            {
                                $i = 1;
                                foreach ($bids as $detail) 
                                {     
                     ?> 
                                     <tr> 
                                         <td style="  text-align: center; " id="serialNo<?=$i?>"><?=$i?></td> 
                                         <td style="  text-align: center; " id="description<?=$i?>"><?=$detail['description'];?></td> 
                                         <td style="  text-align: center; " id="amount<?=$i?>"><?=$detail['bid_amount'];?></td>
                                         <td style="  text-align: center; " id="due_date<?=$i?>"><?=$detail['due_date'];?></td>
                                         <td>
                                        <form method="post">
                                            <button  class="btn btn-danger" type="submit" name="delete" value="<?=$detail['id']?>">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                            <button  class="btn btn-primary" type="submit" name="assign" value="<?=$detail['u_id']?>">
                                                <i class="fa fa-check"></i> Assign
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
        
    </section>
  </div>
  <div class="control-sidebar-bg"></div>
    
  <?php
    require_once 'js-links.php';
  ?>