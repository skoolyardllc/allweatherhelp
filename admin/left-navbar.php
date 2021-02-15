 
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
                  <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
            </a>
         </li>
         
         <li class="treeview">
            <a href="#">
            <i class="fab fa-mailchimp"></i>
            <span>&nbspContractors</span>
            <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            
            <ul class="treeview-menu">
               <li><a href="contractors?token=1"><i class="fa fa-circle-o"></i>All Contractors</a></li>
               <li><a href="contractors?token=2"><i class="fa fa-circle-o"></i>Blocked</a></li>
               <li><a href="contractors?token=3"><i class="fa fa-circle-o"></i>Unblocked </a></li>
            </ul>
         </li>
         <li class="treeview">
            <a href="#">
            <i class="fa fa-users"></i>
            <span>Employers</span>
            <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            
            <ul class="treeview-menu">
               <li><a href="employers?token=1"><i class="fa fa-circle-o"></i>All Employers</a></li>
               <li><a href="employers?token=2"><i class="fa fa-circle-o"></i>Blocked</a></li>
               <li><a href="employers?token=3"><i class="fa fa-circle-o"></i>Unblocked </a></li>
            </ul>
         </li>
         <li class="treeview">
            <a href="#">
            <i class="fa fa-tasks"></i>
            <span>Projects</span>
            <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            
            <ul class="treeview-menu">
               <li><a href="projects?token=1"><i class="fa fa-circle-o"></i>All Projects</a></li>
               <li><a href="projects?token=2"><i class="fa fa-circle-o"></i>Active</a></li>
               <li><a href="projects?token=3"><i class="fa fa-circle-o"></i>On Hold</a></li>
               <li><a href="projects?token=4"><i class="fa fa-circle-o"></i>Completed</a></li>
            </ul>
         </li>

         <li>
           <a href="webinfoaddedit">
                <i class="fas fa-folder-open"></i><span>&nbsp&nbspWebsite Details</span>
            </a>
         </li>
         <li>
           <a href="testimonials">
                <i class="fa fa-comments"></i><span>Testimonials</span>
            </a>
         </li>
         <li>
           <a href="socialmedialinks">
                <i class="fas fa-clone"></i><span>&nbsp&nbspSocial Media Links</span>
            </a>
         </li>
         <li>
           <a href="logout">
                <i class="fas fa-sign-out-alt"></i><span>Logout</span>
            </a>
         </li>
      </ul>
   </section>
   <!-- /.sidebar -->
</aside>