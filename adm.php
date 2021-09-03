
<?php
    require_once 'header.php';
   require_once 'navbar.php';

   $sql="select * from adm where u_id='$USER_ID' and adm='00'";
   if($result = $conn->query($sql))
    {
        if($result->num_rows)
        {
            $row = $result->fetch_assoc();
            $manager=$row;
        }
        
    }

    $sql="select * from adm where u_id='$USER_ID' and adm='01'";
   if($result = $conn->query($sql))
    {
        if($result->num_rows)
        {
            $row = $result->fetch_assoc();
            $assistant=$row;
        }
        
    }

    

?>


<div id="wrapper">
    <div class="clearfix"></div>
    <!-- Header Container / End -->


    <!-- Dashboard Container -->
    <div class="dashboard-container">
    <?php
        require_once 'left-navbar.php';
    ?>
    <!-- Dashboard Content
        ================================================== -->
        <div class="dashboard-content-container" data-simplebar>
            <div class="dashboard-content-inner" >
                
                <!-- Dashboard Headline -->
                <div class="dashboard-headline">
                    <h3>Settings</h3>

                    <!-- Breadcrumbs -->
                    <nav id="breadcrumbs" class="dark">
                        <ul>
                            <li><a href="index">Home</a></li>
                            <li><a href="dashboard">Dashboard</a></li>
                            <li>Settings</li>
                        </ul>
                    </nav>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <?php
                        if(isset($changes)){
                            ?>

                                Snackbar.show({
                                        text: 'Your status has been changed to ONLINE !!',
                                        pos: 'bottom-center',
                                        showAction: false,
                                        actionText: "Dismiss",
                                        duration: 3000,
                                        textColor: '#fff',
                                        backgroundColor: '#383838'
                                    });
                                <div class="alert alert-success" role="alert" id="123456">
                                <?=$changes?>!!!
                                <span class="float-right" style="cursor:pointer" onclick="remove(123456)">x</span>
                                </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>                
                <!-- Row -->
                    <div class="row">
                        <form method="post">
                            <!-- Dashboard Box -->
                            <div class="col-xl-12">
                                <div class="dashboard-box margin-top-0">

                                    <!-- Headline -->
                                    <div class="headline">
                                        <h3><i class="fas fa-user"></i> Manager Details</h3>
                                    </div>

                                    <div class="content with-padding padding-bottom-0">

                                        <div class="row">

                                           

                                            <div class="col">
                                                <div class="row">
                                                        <div class="col-xl-12">
                                                           
                                                            
                                                        </div>
                                                        <div class="col-xl-6" >
                                                            <div class="submit-field">
                                                                <h5>First Name</h5>
                                                                <input type="text" name="m_fname" class="with-border" value="<?=$manager['fir_name']?>">
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-6" >
                                                            <div class="submit-field">
                                                                <h5>Last Name</h5>
                                                                <input type="text" name="m_lname" class="with-border" value="<?=$manager['las_name']?>">
                                                            </div>
                                                        </div> 

                                                        <div class="col-xl-6" >
                                                            <div class="submit-field">
                                                                <h5>Email Address</h5>
                                                                <input type="email" name="m_email" class="with-border" value="<?=$manager['email']?>">
                                                            </div>
                                                        </div> 

                                                        <div class="col-xl-6">
                                                            <div class="submit-field">
                                                                <h5>Phone Number</h5>
                                                                <input type="text" name="m_ph_no" class="with-border" value="<?=$manager['ph_no']?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <div class="submit-field">
                                                                <h5>Username</h5>
                                                                <input type="text" name="m_username" class="with-border" value="<?=$manager['username']?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6" >
                                                            <div class="submit-field">
                                                                <h5>Password</h5>
                                                                <input type="password" name="m_pass" class="with-border" value="<?=$manager['pass']?>">
                                                            </div>
                                                        </div>

                                                       
                                                                                                          
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- Dashboard Box -->
                            

                            

                        
                        <br><br>
                        <!-- Dashboard Box -->
                        
                            <!-- Dashboard Box -->
                            <div class="col-xl-12">
                                <div class="dashboard-box margin-top-0">

                                    <!-- Headline -->
                                    <div class="headline">
                                        <h3><i class="fas fa-user"></i> Assistant's Manager Details</h3>
                                    </div>

                                    <div class="content with-padding padding-bottom-0">

                                        <div class="row">

                                           

                                            <div class="col">
                                                <div class="row">
                                                        <div class="col-xl-12">
                                                           
                                                            
                                                        </div>
                                                        <div class="col-xl-6" >
                                                            <div class="submit-field">
                                                                <h5>First Name</h5>
                                                                <input type="text" name="a_fname" class="with-border" value="<?=$assistant['fir_name']?>">
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-6" >
                                                            <div class="submit-field">
                                                                <h5>Last Name</h5>
                                                                <input type="text" name="a_lname" class="with-border" value="<?=$assistant['las_name']?>">
                                                            </div>
                                                        </div> 

                                                        <div class="col-xl-6" >
                                                            <div class="submit-field">
                                                                <h5>Email Address</h5>
                                                                <input type="email" name="a_email" class="with-border" value="<?=$assistant['email']?>">
                                                            </div>
                                                        </div> 

                                                        <div class="col-xl-6">
                                                            <div class="submit-field">
                                                                <h5>Phone Number</h5>
                                                                <input type="text" name="a_ph_no" class="with-border" value="<?=$assistant['ph_no']?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <div class="submit-field">
                                                                <h5>Username</h5>
                                                                <input type="text" name="a_username" class="with-border" value="<?=$assistant['username']?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6" i>
                                                            <div class="submit-field">
                                                                <h5>Password</h5>
                                                                <input type="password" name="a_pass" class="with-border" value="<?=$assistant['pass']?>">
                                                            </div>
                                                        </div>

                                                       
                                                                                                          
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- Dashboard Box -->
                            

                            <div class="col-xl-12" style="padding-bottom:20px;" class="float-right">
                                <button type="button" onclick="adm(<?=$USER_ID?>)" name="update" class="button ripple-effect big margin-top-30">Save Changes</button>
                            </div>

                        </form>
                        
                    </div>
                    <!-- Row / End -->

                    <!-- Footer -->
                    <div class="dashboard-footer-spacer"></div>
                    <div class="small-footer margin-top-15">
                        <!-- <ul class="footer-social-links">
                            <li>
                                <a href="#" title="Facebook" data-tippy-placement="top">
                                    <i class="icon-brand-facebook-f"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#" title="Twitter" data-tippy-placement="top">
                                    <i class="icon-brand-twitter"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#" title="Google Plus" data-tippy-placement="top">
                                    <i class="icon-brand-google-plus-g"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#" title="LinkedIn" data-tippy-placement="top">
                                    <i class="icon-brand-linkedin-in"></i>
                                </a>
                            </li>
                        </ul> -->
                        <div class="clearfix"></div>
                    </div>
                    <!-- Footer / End -->
                
            </div>
        </div>
        <!-- Dashboard Content / End -->
    </div>
</div>

<?php
    require_once 'js-links.php';
?>      
<script>
   

    function remove(id)
    {
        $("#"+id).remove();
    }

    function adm(id)
    {
        var m_fname = $('input[name="m_fname"]').val();
        var m_lname = $('input[name="m_lname"]').val();
        var m_email = $('input[name="m_email"]').val();
        var m_ph_no = $('input[name="m_ph_no"]').val();
        var m_username = $('input[name="m_username"]').val();
        var m_pass = $('input[name="m_pass"]').val();
        var a_fname = $('input[name="a_fname"]').val();
        var a_lname = $('input[name="a_lname"]').val();
        var a_email = $('input[name="a_email"]').val();
        var a_ph_no = $('input[name="a_ph_no"]').val();
        var a_username = $('input[name="a_username"]').val();
        var a_pass = $('input[name="a_pass"]').val();
        
        $.ajax({
            url:"adm_ajax.php",
            type:"post",
            data:{
                update:true,
                userid: id,
                m_fname:m_fname,
                m_lname:m_lname,
                m_email:m_email,
                m_ph_no:m_ph_no,
                m_username:m_username,
                m_pass:a_pass,
                a_fname:a_fname,
                a_lname:a_lname,
                a_email:a_email,
                a_ph_no:a_ph_no,
                a_username:a_username,
                a_pass:a_pass,
            },
            success: function(data){
                console.log(data);
				if(data.trim()=="updated"){
					Snackbar.show({
					text: 'Administration Details Updated Successfully !!',
					pos: 'bottom-center',
					showAction: false,
					actionText: "Dismiss",
					duration: 3000,
					textColor: '#fff',
					backgroundColor: '#383838'
				}); 
				}
            },
            error: function(data) {
                console.log("galti");
            }
        });

    }

    $("#dashboard").removeClass('active');
	$("#bookmarks").removeClass('active');
	$("#reviews").removeClass('active');
	$("#jobs").removeClass('active');
	$("#tasks").removeClass('active');
	$("#settings").removeClass('active');
	$("#milestone").removeClass('active');
	$("#settings").addClass('active');


</script>