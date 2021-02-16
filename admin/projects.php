<?php
    require_once 'header.php';
    require_once 'navbar.php';
    require_once 'left-navbar.php';
 
    $id=$_SESSION['id'];
    
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(isset($_POST['delete']))
        {
            $id=$_POST['delete'];
            $sql = "delete from projects where id=$id";
            
            if($conn->query($sql))
            {
                $resMember=true;   
            }
            else
            {
                $errorMember=$conn->error;
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
        $token = $_GET['token'];
        switch ($token) {
            case '1':
                $sql="select p.* from projects p";
                $title ="All Projects";
                break;
            case  "2":
                $sql="select p.* from projects p where p.status = 1";
                $title ="Active Projects";
                break; 
            case "3": 
                $sql="select p.* from projects p where p.status = 2";
                $title="Projects on Hold";
                break;
            case "4": 
                $sql="select p.* from projects p where p.status = 3";
                $title="Completed Projects";
                break;
            default:
                $title="INVALID REQUEST";
                break;
        }
        
        if($result =  $conn->query($sql))
        {
            if($result->num_rows)
            {
                while($row = $result->fetch_assoc())
                {
                    $projects[] = $row;
                }
            }
        }

    }
    else
    {
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
        <h1 style="font-weight: 900;">
            <?=$title?>
        </h1>
        <ol class="breadcrumb">
            <li>
                <div class="pull-right">
                    <a href="" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="Rebuild"><i class="fa fa-refresh"></i></a>
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
                             <th>Project Title</th>
                             <th>Project Description</th>
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
                                            <a href="viewproject?token=<?=$detail['id']?>" class="btn btn-primary"> <i class="fa fa-eye">View</i> </a>
                                            <button  class="btn btn-danger" type="submit" name="delete" value="<?=$detail['id']?>">
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
      <!-- /.box -->
    </section>
    <!-- /.content -->
</div>

          

  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->       
<div class="control-sidebar-bg"></div>

  

<?php
    require_once 'js-links.php';
?>



