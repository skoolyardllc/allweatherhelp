 
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
   <!-- sidebar: style can be found in sidebar.less -->
   <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
         <div class="image">
            <form enctype="multipart/form-data" action="image_upload_demo_submit.php" method="post" name="image_upload_form" id="image_upload_form">
               <div id="imgArea" class="pull-left image">
                  <img src="<?=$MASTER_DATA['user_pic']?>" width="48" height="48" >
                  <div class="progressBar">
                     <div class="bar"></div>
                     <div class="percent">0%</div>
                  </div>
                  <div id="imgChange"><span><i class="fa fa-edit"></i></span>
                     <input type="file" accept="image/*" name="image_upload_file" id="image_upload_file">
                  </div>
               </div>
            </form>
         </div>
         <div class="pull-left info">
            <p>Master Admin</p>
             <p><?=ucfirst($MASTER_DATA['name']);?></p>
         </div>
      </div>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
         <li class="header">MAIN NAVIGATION</li>
         <li>
            <a href="dashboard">
                  <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            </a>
         </li>

         <li>
           <a href="logout">
                <i class="fa fa-sign-out"></i><span>Logout</span>
            </a>
         </li>
      </ul>
   </section>
   <!-- /.sidebar -->
</aside>