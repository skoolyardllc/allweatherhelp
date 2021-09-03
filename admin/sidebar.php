<?php

    
    if(isset($_SESSION['society']))
    {
        $sql="select * from society where email='".$_SESSION['society']."' ";
        $result = $conn->query($sql);
        if($result->num_rows)
        {    
            $USER_DATA = $result->fetch_assoc();
                // echo "hello";
        }
        $STAT =  $USER_DATA['stat'];

    }

?>

        <div class="sidebar-wrapper" data-simplebar="true">
			<div class="sidebar-header">
				<div class="">
					<img src="../images/cyberflow-logo-1.png" class="logo-icon-2" alt="" />
				</div>
				<div>
					<h4 class="logo-text">AWH</h4>
				</div>
				<a href="javascript:;" class="toggle-btn ml-auto"> <i class="bx bx-menu"></i>
				</a>
			</div>
			<!--navigation-->
			<ul class="metismenu" id="menu">
				<li>
					<a href="dashboard" >
						<div class="parent-icon icon-color-1"><i class="bx bx-home-alt"></i>
						</div>
						<div class="menu-title">Dashboard</div>
					</a>
					
				</li>
				
							<li class="menu-label">Users</li>
							<li>
								<a class="has-arrow" href="javascript:;">
									<div class="parent-icon icon-color-10"><i class='lni lni-user'></i>
									</div>
									<div class="menu-title">Customers</div>
								</a>
								<ul>
									<li> <a href="customer"><i class="bx bx-right-arrow-alt"></i>All Customers</a>
									</li>
									<li> <a href="customer?token=1"><i class="bx bx-right-arrow-alt"></i>Approved</a>
									</li>
									<li> <a href="customer?token=2"><i class="bx bx-right-arrow-alt"></i>Blocked</a>
									</li>
									
								</ul>
							</li>
							<li>
								<a class="has-arrow" href="javascript:;">
									<div class="parent-icon icon-color-11"><i class='bx bx-group'></i>
									</div>
									<div class="menu-title">Business / LLC</div>
								</a>
								<ul>
									<li> <a href="business"><i class="bx bx-right-arrow-alt"></i>All Business</a>
									</li>
									<li> <a href="business?token=1"><i class="bx bx-right-arrow-alt"></i>Approved</a>
									</li>
									<li> <a href="business?token=2"><i class="bx bx-right-arrow-alt"></i>Blocked</a>
									</li>
									
								</ul>
							</li>
							<li>
								<a class="has-arrow" href="javascript:;">
									<div class="parent-icon icon-color-12"><i class='lni lni-users'></i>
									</div>
									<div class="menu-title">Contractors</div>
								</a>
								<ul>
									<li> <a href="contractor"><i class="bx bx-right-arrow-alt"></i>All Contractors</a>
									</li>
									<li> <a href="contractor?token=1"><i class="bx bx-right-arrow-alt"></i>Approved</a>
									</li>
									<li> <a href="contractor?token=2"><i class="bx bx-right-arrow-alt"></i>Blocked</a>
									</li>
									
								</ul>
							</li>
							
				<li class="menu-label">Tasks & Transactions</li>
				<li>
					<a class="has-arrow" href="javascript:;">
						<div class="parent-icon icon-color-6"><i class="fadeIn animated bx bx-exclude"></i>
						</div>
						<div class="menu-title"> Tasks</div>
					</a>
					<ul>
						<li> <a href="alltasks"><i class="bx bx-right-arrow-alt"></i>All Tasks</a>
						</li>
						<li> <a href="alltasks?token=1"><i class="bx bx-right-arrow-alt"></i>Completed</a>
						</li>
						<li> <a href="alltasks?token=2"><i class="bx bx-right-arrow-alt"></i>Ongoing</a>
						</li>
						
					</ul>
				</li>
				<li>
					<a  href="transactions">
						<div class="parent-icon icon-color-2"><i class="lni lni-money-location"></i>
						</div>
						<div class="menu-title"> Transactions</div>
					</a>
				</li>
				<!--  -->
				<li class="menu-label">Pofile</li>
				<!--<li>
					<a class="has-arrow" href="javascript:;">
						<div class="parent-icon icon-color-3"><i class="bx bx-lock"></i>
						</div>
						<div class="menu-title">Authentication</div>
					</a>
					<ul>
						<li> <a href="profile_status" ><i class="bx bx-right-arrow-alt"></i>Profile Status</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="edit_profile">
						<div class="parent-icon icon-color-4"><i class="bx bx-user-circle"></i>
						</div>
						<div class="menu-title">User Profile</div>
					</a>
				</li> -->
                <li>
					<a href="logout">
						<div class="parent-icon icon-color-5"><i class="fadeIn animated bx bx-arrow-from-right"></i>
						</div>
						<div class="menu-title">Logout</div>
					</a>
				</li>
                
			</ul>
			<!--end navigation-->
		</div>
		