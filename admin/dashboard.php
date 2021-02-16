<?php
require_once 'header.php';
require_once 'navbar.php';
require_once 'left-navbar.php';

$sql="SELECT count(id) as count from users where type=3";
if($result=$conn->query($sql))
{
    if($result->num_rows>0)
    {
        $row=$result->fetch_assoc(); 
        $contractors=$row['count']; 
    }

} 
//fetching blocked comapnies
$sql="SELECT count(id) as count from users where type=2";
if($result=$conn->query($sql))
{
    if($result->num_rows>0)
    {
        $row=$result->fetch_assoc(); 
        $employers=$row['count']; 
    }

} 

$sql="SELECT count(id) as count from projects";
if($result=$conn->query($sql))
{
    if($result->num_rows>0)
    {
        $row=$result->fetch_assoc(); 
        $p_total=$row['count']; 
    }
}

$sql="select * from projects order by id desc limit 10";
if($result=$conn->query($sql))
{
    if($result->num_rows>0)
    {
        while($row=$result->fetch_assoc())
        {
            $pdetails[]=$row; 
        }
        
    }
}

$sql="SELECT * from website_details";
if($result=$conn->query($sql))
{
    if($result->num_rows>0)
    {
        $row=$result->fetch_assoc(); 
            $comdata=$row; 
    }
}



?>
<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>

    <!-- overview section -->

    <section class="content">
        <div class="row">
            <div class="col-md-6">
            <!-- Info Boxes Style 2 -->
                <a href="contractor?token=1" style="background-color: white;">
                    <div class="info-box mb-3 bg-yellow">
                        <span class="info-box-icon"><i class="fa fa-building"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Contractors</span>
                            <span class="info-box-number"><?=$contractors?></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
                <a href="employers?token=1" style="background-color: white;">
                    <div class="info-box mb-3 bg-green">
                        <span class="info-box-icon"><i class="fa fa-tasks"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Employers</span>
                            <span class="info-box-number"><?=$employers?></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </a>

                <a href="projects?token=1" style="background-color: white;">
                    <div class="info-box mb-3 bg-red">
                        <span class="info-box-icon"><i class="fa fa-user-plus"></i></span>
                        <div class="info-box-content" style="color: white;">
                            <span class="info-box-text">Projects</span>
                            <span class="info-box-number"><?=$p_total?></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </a>
            </div>
            <div class="col-md-5">
            <?php
                if(isset($comdata))
                {
            ?>
                    
                    <div class="card card-widget widget-user-2 shadow-sm">
                        <div class="widget-user-header bg-yellow">
                            <div class="widget-user-image">
                                <img class="img-circle elevation-2" style="width: 80px; height: 80px; float: left;"src="<?=$comdata['logo']?>" alt="User Avatar">
                            </div>
                            <h3 class="widget-user-username" ><?=$comdata['title']?></h3>
                            <h5 class="widget-user-desc">&nbsp<?=$comdata['sub_title']?></h5>
                        </div>
                        <div class="card-footer p-0" style="background-color: white; ">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        Email <span class="float-right badge bg-blue" "><?=$comdata['email']?></span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                    Mobile<span class="float-right badge bg-green"><?=$comdata['mobile']?></span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                    Address<span class="float-right badge bg-red"><?=$comdata['address']?></span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                    About<span class="float-right badge bg-pink"><?=$comdata['about']?></span>
                                    </a>
                                </li>
                                
                            </ul>
                        </div>
                    </div>
            <?php
                }
            ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header border-transparent" style="background-color: #343a40;">
                        <h3 class="card-title" style="color: white;">Latest Projects</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table m-0" style="border-spacing: 2px;  font-size: 16px;">
                                <thead style="font-weight: 800; background-color: #6c757d; color: white;">
                                    <tr>
                                        <th style="text-align: center;">S.no.</th>
                                        <th style="text-align: center;">Title</th>
                                        <th style="text-align: center;">Status</th>
                                        <th style="text-align: center;">Start Date</th>
                                        <th style="text-align: center;">Project Budget</th>
                                    </tr>
                                </thead>
                                <tbody style="text-align: center;">
                                    <?php
                                        if(isset($pdetails))
                                        {
                                            $i=1;
                                            foreach($pdetails as $data)
                                            {
                                    ?>
                                                <tr>
                                                    <td style="padding: 12px; color: #17a2b8;"><?=$i?></td>
                                                    <td style="padding: 12px;"><?=$data['title']?></td>
                                                    <td style="padding: 12px;">
                                                    <?php
                                                        if($data['status']==1)
                                                        {
                                                            ?>
                                                            <span class="badge badge-danger">Hold</span>
                                                            <?php
                                                        }
                                                        else if($data['status']==2)
                                                        {
                                                            ?>
                                                            <span class="badge badge-warning">Active</span>
                                                            <?php
                                                        }
                                                        else if($data['status']==3)
                                                        {
                                                            ?>
                                                            <span class="badge badge-success">Completed</span>
                                                            <?php
                                                        }
                                                    ?>
                                                    </td>
                                                    <td style="padding: 12px;">
                                                    <?=$data['start_date']?>
                                                    </td>
                                                    <td style="padding: 12px;">
                                                    <?=$data['bid_amount']?>
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
                        <div class="card-footer clearfix">
                            <a href="projects?token=1" class="btn btn-sm btn-info float-right">View All Projects</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="control-sidebar-bg"></div>
<?php
require_once 'js-links.php';
?>