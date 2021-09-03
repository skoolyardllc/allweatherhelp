<?php

    require_once 'header.php';

   require_once 'navbar.php';

  

   if(isset($_POST['save_changes'])){

        $f_name = $conn->real_escape_string($_POST['f_name']);

        $l_name = $conn->real_escape_string($_POST['l_name']);

        $tagline = $conn->real_escape_string($_POST['tagline']);

        $nationality = $conn->real_escape_string($_POST['nationality']);

        $intro = $conn->real_escape_string($_POST['intro']);

        $mobile = $conn->real_escape_string($_POST['mobile']);

        $address = $conn->real_escape_string($_POST['address']);
        if(isset($_POST['inputed_files']))
        {
            $inputed_files =$_POST['inputed_files'];
        }
        

        $inName = $_POST['inName'];

        $polNo = $_POST['polNo'];

       



        if($TYPE == 2)

        {

             $insurance = "update insurance set in_company='$inName' , policy_no='$polNo' where u_id='$USER_ID'";

            if($conn->query($insurance))

            {

               

            }

            else{

                echo $conn->error;

            }

            

        }

        // $sql= "insert into user_profile (f_name,l_name,tagline,nationality,intro,u_id) values('$f_name','$l_name','$tagline','$nationality','$intro','$USER_ID')";

        $sql="update user_profile set f_name='$f_name',l_name='$l_name',tagline='$tagline',nationality='$nationality',intro='$intro',mobile='$mobile',address='$address' where u_id='$USER_ID'" ;

        if($conn->query($sql))

		{

            $insertId = $conn->insert_id;

			$changes_saved =true; 

		}

		else{

			$error =$conn->error; 

		}


        if(isset($inputed_files))
        {
            $sql = "insert into user_documents (u_id,document) values"; 

            foreach($inputed_files as $inputed_file)

            {

                $sql .= "($insertId,'$inputed_file'),";

            }

            $sql = rtrim($sql,",");

            if($conn->query($sql))

            {

                $task_posted =true;

            } 
        }
    }



    $dikhao = 'none';

    switch($TYPE)

    {

        case 2:

            $dikhao = 'show';

            break;

    }



        if($TYPE == 2)

        {

            $sql = "Select * from insurance where u_id='$USER_ID'";

            if($result = $conn->query($sql))

            {



                $row = $result->fetch_assoc();

                $insu = $row;

                // print_r($insu);

            }

            else{

                echo $conn->error;

            }

            

        }

 

$sql = "select * from skills where u_id='$USER_ID'";

if($result = $conn->query($sql))

{

    if($result->num_rows)

    {

        while($row=$result->fetch_assoc())

        {

            $skills[]=$row;

        }

    }

}



$sql = "select * from user_profile where u_id='$USER_ID'";

if($result = $conn->query($sql))

{

    if($result->num_rows)

    {

        $row = $result->fetch_assoc();

        $profile=$row;

    }

}



//    if(user_auth()){

//       header('Location:index.php');

//    }
$enteryourdetailsemp="";
$enterdetails="";

if(($USER_DATA['f_name']=="" || $USER_DATA['l_name']=="" || $USER_DATA['mobile']=="") )

   {

      if($TYPE==2)

      {

         

         if($in['in_company']=="" || $in['policy_no']=="" || $in['dcoument']=="")

         {

            $enteryourdetailsemp = 'hello';

           

         }

         else

         {

            $enteryourdetailsemp = false;

         }

      }

      else

      {

         $enterdetails = 'true';

        

      }

   }

   else

   {

      $enterdetails = false;

   }

   ?>

   <style>

    a #poland:hover{

        cursor:pointer;

        background:blue;

    }

    @media screen and (max-width: 600px) 

    {

        .editProfile{

            width:100%;

        }

    }

   </style>

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

                

                <?php

                if(isset($changes_saved)){

                    ?>

                        <div class="alert alert-success" role="alert">

                            Your profile has been updated !!!

                        </div>

                    <?php

                }

                if($enteryourdetailsemp=='hello')

                {

                    ?>

                        <div class="alert alert-primary" role="alert">

                            First Enter your details to experience all the services!

                        </div>

                    <?php

                }

                if($enterdetails=='true')

                {

                    ?>

                        <div class="alert alert-primary" role="alert">

                            First Enter your details to experience all the services!

                        </div>

                    <?php

                }

                ?>

                

                <!-- Row -->

                    <div class="row">

                        <form method="post">

                            <!-- Dashboard Box -->

                            <div class="col-xl-12">

                                <div class="dashboard-box margin-top-0">



                                    <!-- Headline -->

                                    <div class="headline">

                                        <h3><i class="icon-material-outline-account-circle"></i> My Account</h3>

                                    </div>



                                    <div class="content with-padding padding-bottom-0">



                                        <div class="row">



                                            <div class="col-auto editProfile" >

                                                <div class="avatar-wrapper" data-tippy-placement="bottom" title="Change Avatar">

                                                    <img class="profile-pic" src="<?=$profile['avtar']?>" alt="" />

                                                    <div class="upload-button"></div>

                                                    <input class="file-upload" id="avatar-upload" type="file" accept="image/*"/>

                                                </div>

                                            </div>



                                            <div class="col editProfile" >

                                                <div class="row">

                                                     

                                                        <div class="col-xl-6">

                                                            <div class="submit-field">

                                                                <h5>First Name</h5>

                                                                <input type="text" name="f_name" class="with-border" value="<?=$profile['f_name']?>">

                                                            </div>

                                                        </div>



                                                        <div class="col-xl-6">

                                                            <div class="submit-field">

                                                                <h5>Last Name</h5>

                                                                <input type="text" name="l_name" class="with-border" value="<?=$profile['l_name']?>">

                                                            </div>

                                                        </div> 



                                                        <div class="col-xl-6">

                                                            <div class="submit-field">

                                                                <h5>Mobile Number</h5>

                                                                <input type="text" name="mobile" class="with-border" value="<?=$profile['mobile']?>">

                                                            </div>

                                                        </div> 



                                                        <div class="col-xl-6">

                                                            <div class="submit-field">

                                                                <h5>Email</h5>

                                                                <input type="text" name="email" class="with-border" value="<?=$USER_EMAIL?>" disabled>

                                                            </div>

                                                        </div>



                                                        <div class="col-xl-6">

                                                            <!-- Account Type -->

                                                            <div class="submit-field">

                                                                <h5>Account Type</h5>

                                                                <div class="account-type">

                                                                <?php

                                                                    $contract_check='';

                                                                    $employeer_check=''; 

                                                                    $customer_check='';

                                                                    $show8='none';

                                                                    $show9='none';

                                                                    $show10='none';

                                                                    // echo $TYPE;

                                                                    switch ($TYPE){

                                                                        case 3:

                                                                            $contract_check="checked";

                                                                            $show8='show';

                                                                            break;

                                                                        case 2:

                                                                            $employeer_check = "checked";

                                                                            $show9='show';

                                                                            break;

                                                                        case 5:

                                                                            $customer_check = "checked";

                                                                            $show10='show';

                                                                            break;

                                                                    }

                                                                ?>

                                                                    <div style="cursor:not-allowed;display:<?=$show8?>">

                                                                        <input type="radio" value="3" style="cursor:not-allowed" name="account-type-radio" id="freelancer-radio" class="account-type-radio"  <?=$contract_check?> disabled/>

                                                                        <label for="freelancer-radio" style="cursor:not-allowed" class="ripple-effect-dark"><i class="icon-material-outline-account-circle"></i> Contractor</label>

                                                                    </div>



                                                                    <div style="cursor:not-allowed;display:<?=$show9?>">

                                                                        <input type="radio" value="2" style="cursor:not-allowed" name="account-type-radio" id="employer-radio"  class="account-type-radio" <?=$employeer_check?> disabled/>

                                                                        <label for="employer-radio" style="cursor:not-allowed" class="ripple-effect-dark"><i class="icon-material-outline-business-center"></i> Business</label>

                                                                    </div>

                                                                    <div style="cursor:not-allowed;display:<?=$show10?>">

                                                                        <input type="radio" value="5" style="cursor:not-allowed" name="account-type-radio" id="employer-radio"  class="account-type-radio" <?=$customer_check?> disabled/>

                                                                        <label for="employer-radio" style="cursor:not-allowed" class="ripple-effect-dark"><i class="icon-material-outline-business-center"></i> Customer</label>

                                                                    </div>

                                                                </div>

                                                            </div>

                                                        </div>



                                                        <div class="col-xl-12">

                                                            <div class="submit-field">

                                                                <h5>Address</h5>

                                                                    <textarea name="address" cols="30" rows="5" class="with-border"><?=$profile['address']?></textarea>

                                                            </div>

                                                        </div>



                                                        



                                                </div>

                                            </div>

                                        </div>



                                    </div>

                                </div>

                            </div>



                            <!-- Dashboard Box -->

                            <div class="col-xl-12">

                                <div class="dashboard-box" style="display:<?=$dikhao?>">



                                    <!-- Headline -->

                                    <div class="headline">

                                        <h3><i class="fas fa-heartbeat"></i> Insurance Detials</h3>

                                    </div>



                                    <div class="content">

                                        <ul class="fields-ul">

                                        <li >

                                            <div class="row" >

                                                <div class="col-xl-6" >

                                                    <div class="submit-field">

                                                        <div class="bidding-widget">

                                                            <!-- Headline -->

                                                          <input type="hidden" value="<?=$profile['u_id']?>" name="userId">



                                                            <!-- Slider -->

                                                            <!-- <div class="bidding-value margin-bottom-10">$<span id="biddingVal"></span></div> -->

                                                            <!-- <input class="bidding-slider" type="text" onchange="change_bidding_amount(value)" name="bidding" data-slider-handle="custom" data-slider-currency="$" data-slider-min="5" data-slider-max="150" data-slider-value="<?=$profile['hourly_rate']?>" data-slider-step="1" data-slider-tooltip="hide" /> -->

                                                                <label for="insurnce">Name of the Insurance Company : </label>

                                                                <input class="form-control with-border" name="inName" value="<?=$insu['in_company']?>" placeholder="Name of Insurance Company" />

                                                        </div>

                                                    </div>

                                                </div>



                                                <div class="col-xl-6" >

                                                    <div class="submit-field">

                                                        <div class="bidding-widget">

                                                                 <label for="insurnce">Policy Number : </label>

                                                                <input class="form-control with-border" name="polNo" value="<?=$insu['policy_no']?>" placeholder="Policy Number" />

                                                        </div>

                                                    </div>

                                                </div>

                                               



                                                <div class="col-xl-4" >

                                                    <div class="submit-field">

                                                        <h5>Document or Photo of Policy</h5>

                                                        

                                                        <!-- Attachments -->

                                                        <a href="uploads/<?=$insu['document']?>" id="poland">

                                                        <div class="attachments-container margin-top-0 margin-bottom-0">

                                                            <div class="attachment-box ripple-effect">

                                                                <span> <?=$insu['document']?></span>

                                                                <br><span></span>

                                                                <i>PDF / IMG</i>

                                                                

                                                            </div>

                                                            

                                                        </div>

                                                        </a>

                                                        <div class="clearfix"></div>

                                                        

                                                        <!-- Upload Button -->

                                                        <div class="uploadButton margin-top-0">

                                                            <input class="uploadButton-input" type="file"  accept="image/*, application/pdf" id="upload" name="policy"/>

                                                            <label class="uploadButton-button ripple-effect" for="upload">Upload/Update File</label>

                                                            <span class="uploadButton-file-name">Maximum file size: 10 MB</span>

                                                        </div>

                                                        <div id="file_image">

                                                        </div>

                                                        

                                                        <div id="uploadDiv">

                                                        </div>



                                                    </div>

                                                </div>

                                            </div>

                                        </li>

                                       

                                    </ul>

                                    </div>

                                    

                                </div>

                            </div>



                            <!-- <div class="col-xl-12" style="padding-bottom:20px;" class="float-right">

                                <button type="submit" name="insurance" class="button ripple-effect big margin-top-30">Save Changes</button>

                            </div> -->



                            <div class="col-xl-12">

                                <div class="dashboard-box">



                                    <!-- Headline -->

                                    <div class="headline">

                                        <h3><i class="icon-material-outline-face"></i> My Profile</h3>

                                    </div>



                                    <div class="content">

                                        <ul class="fields-ul">

                                        

                                        <li>

                                            <div class="row">

                                                <div class="col-xl-6">

                                                    <div class="submit-field">

                                                        <h5>Tagline</h5>

                                                                <input name="tagline" type="text" class="with-border" value="<?=$profile['tagline']?>">

                                                    </div>

                                                </div>



                                                <div class="col-xl-6">

                                                    <div class="submit-field">

                                                        <h5>Nationality</h5>

                                                        <select name="nationality" class="selectpicker with-border" data-size="7" title="Select Job Type" data-live-search="true">

                                                            <option value="AR">Argentina</option>

                                                            <option value="AM">Armenia</option>

                                                            <option value="AW">Aruba</option>

                                                            <option value="AU">Australia</option>

                                                            <option value="AT">Austria</option>

                                                            <option value="AZ">Azerbaijan</option>

                                                            <option value="BS">Bahamas</option>

                                                            <option value="BH">Bahrain</option>

                                                            <option value="BD">Bangladesh</option>

                                                            <option value="BB">Barbados</option>

                                                            <option value="BY">Belarus</option>

                                                            <option value="BE">Belgium</option>

                                                            <option value="BZ">Belize</option>

                                                            <option value="BJ">Benin</option>

                                                            <option value="BM">Bermuda</option>

                                                            <option value="BT">Bhutan</option>

                                                            <option value="BG">Bulgaria</option>

                                                            <option value="BF">Burkina Faso</option>

                                                            <option value="BI">Burundi</option>

                                                            <option value="KH">Cambodia</option>

                                                            <option value="CM">Cameroon</option>

                                                            <option value="CA">Canada</option>

                                                            <option value="CV">Cape Verde</option>

                                                            <option value="KY">Cayman Islands</option>

                                                            <option value="CO">Colombia</option>

                                                            <option value="KM">Comoros</option>

                                                            <option value="CG">Congo</option>

                                                            <option value="CK">Cook Islands</option>

                                                            <option value="CR">Costa Rica</option>

                                                            <option value="CI">Côte d'Ivoire</option>

                                                            <option value="HR">Croatia</option>

                                                            <option value="CU">Cuba</option>

                                                            <option value="CW">Curaçao</option>

                                                            <option value="CY">Cyprus</option>

                                                            <option value="CZ">Czech Republic</option>

                                                            <option value="DK">Denmark</option>

                                                            <option value="DJ">Djibouti</option>

                                                            <option value="DM">Dominica</option>

                                                            <option value="DO">Dominican Republic</option>

                                                            <option value="EC">Ecuador</option>

                                                            <option value="EG">Egypt</option>

                                                            <option value="GP">Guadeloupe</option>

                                                            <option value="GU">Guam</option>

                                                            <option value="GT">Guatemala</option>

                                                            <option value="GG">Guernsey</option>

                                                            <option value="GN">Guinea</option>

                                                            <option value="GW">Guinea-Bissau</option>

                                                            <option value="GY">Guyana</option>

                                                            <option value="HT">Haiti</option>

                                                            <option value="HN">Honduras</option>

                                                            <option value="HK">Hong Kong</option>

                                                            <option value="HU">Hungary</option>

                                                            <option value="IS">Iceland</option>

                                                            <option value="IN">India</option>

                                                            <option value="ID">Indonesia</option>

                                                            <option value="NO">Norway</option>

                                                            <option value="OM">Oman</option>

                                                            <option value="PK">Pakistan</option>

                                                            <option value="PW">Palau</option>

                                                            <option value="PA">Panama</option>

                                                            <option value="PG">Papua New Guinea</option>

                                                            <option value="PY">Paraguay</option>

                                                            <option value="PE">Peru</option>

                                                            <option value="PH">Philippines</option>

                                                            <option value="PN">Pitcairn</option>

                                                            <option value="PL">Poland</option>

                                                            <option value="PT">Portugal</option>

                                                            <option value="PR">Puerto Rico</option>

                                                            <option value="QA">Qatar</option>

                                                            <option value="RE">Réunion</option>

                                                            <option value="RO">Romania</option>

                                                            <option value="RU">Russian Federation</option>

                                                            <option value="RW">Rwanda</option>

                                                            <option value="SZ">Swaziland</option>

                                                            <option value="SE">Sweden</option>

                                                            <option value="CH">Switzerland</option>

                                                            <option value="TR">Turkey</option>

                                                            <option value="TM">Turkmenistan</option>

                                                            <option value="TV">Tuvalu</option>

                                                            <option value="UG">Uganda</option>

                                                            <option value="UA">Ukraine</option>

                                                            <option value="GB">United Kingdom</option>

                                                            <option value="US" selected>United States</option>

                                                            <option value="UY">Uruguay</option>

                                                            <option value="UZ">Uzbekistan</option>

                                                            <option value="YE">Yemen</option>

                                                            <option value="ZM">Zambia</option>

                                                            <option value="ZW">Zimbabwe</option>

                                                        </select>

                                                    </div>

                                                </div>



                                                <div class="col-xl-12">

                                                    <div class="submit-field">

                                                        <h5>Introduce Yourself</h5>

                                                            <textarea name="intro" cols="30" rows="5" class="with-border"><?=$profile['intro']?></textarea>

                                                    </div>

                                                </div>



                                            </div>

                                        </li>

                                    </ul>

                                    </div>

                                    

                                </div>

                            </div>



                            <div class="col-xl-12" style="padding-bottom:20px;" class="float-right">

                                <button type="submit" name="save_changes" class="button ripple-effect big margin-top-30">Save Changes</button>

                            </div>



                        </form>



                        <!-- Dashboard Box -->

                        <div class="col-xl-12">

                            <div id="test1" class="dashboard-box">



                                <!-- Headline -->

                                <div class="headline">

                                    <h3><i class="icon-material-outline-lock"></i> Password & Security</h3>

                                </div>



                                <div class="content with-padding">

                                    <div class="row">

                                        <div class="col-xl-4">

                                            <div class="submit-field">

                                                <h5>Current Password</h5>

                                                <input id="current_password" name="current_password" type="password" class="with-border">

                                            </div>

                                        </div>



                                        <div class="col-xl-4">

                                            <div class="submit-field">

                                                <h5>New Password</h5>

                                                <input id="new_password" name="new_password" type="password" class="with-border">

                                            </div>

                                        </div>



                                        <div class="col-xl-4">

                                            <div class="submit-field">

                                                <h5>Repeat New Password</h5>

                                                <input id="rep_password" name="rep_password" type="password" class="with-border">

                                            </div>

                                        </div>



                                        <div class="col-xl-12">

                                            <div class="checkbox">

                                                <input type="checkbox" id="two-step" checked>

                                                <label for="two-step"><span class="checkbox-icon"></span> Enable Two-Step Verification via Email</label>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-xl-12">

                                        <button type="button" name="change_pass" onclick="change_password()" class="button ripple-effect big margin-top-30">Change Password</button>

                                    </div>

                                </div>

                            </div>

                        </div>

                        

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



    var request;

    $(function(){

        $('#upload').change(function(e)

        {

            var formData = new FormData();

            formData.append('user_id','<?=$USER_ID?>');

            formData.append('images',e.target.files[0]);

            formData.append('updateFile','true');

            $.ajax({

                url:'editProfile_ajax.php',

                type:'post',

                processData:false,

                contentType: false,

                data:formData, 

                success:function(data){

                    var obj = JSON.parse(data);

                    if(obj.msg.trim()!='err'){

                    var inhtml = `

                                    <div id="fileId${counter}">

                                        <input name="inputed_files[]" type="hidden" value="${obj.msg}"/>

                                        <img width="100px" height="100px" style="padding-right: 10px;" src='uploads/${obj.msg}'>

                                        <button type="button" class="btn btn-danger" onclick="deleteFile('fileId${counter}','${obj.msg}')"><i class="fa fa-trash" aria-hidden="true"></i></button>

                                    </div>`;

                                $('#uploadDiv').append(inhtml);

                                counter++;

                    }

                },

                error:function(data){}

            })

        })

    })                                                           



    $(function(){

        $('#avatar-upload').change(function(e)

        {

            var formData = new FormData();

            formData.append('user_id','<?=$USER_ID?>');

            formData.append('avatar',e.target.files[0]);

            formData.append('updateImage','true');

            $.ajax({

                url:'editProfile_ajax.php',

                type:'post',

                processData:false,

                contentType: false,

                data:formData, 

                success:function(data){},

                error:function(data) {}

            })

        })

    })



    
    $(function(){

        $('#upload-File').change(function(e)

        {

            var formData = new FormData();

            formData.append('user_id','<?=$USER_ID?>');

            formData.append('avatar',e.target.files[0]);

            formData.append('updateFile','true');

            $.ajax({

                url:'editProfile_ajax.php',

                type:'post',

                processData:false,

                contentType: false,

                data:formData, 

                success:function(data){},

                error:function(data) {}

            })

        })

    })

    

    function change_account_type(type) {

        $.ajax({

            url:"editProfile_ajax.php",

            type:"post",

            data:{

                userId: '<?=$USER_ID?>',

                changeAccount_type:true,

                type:type,

            },

            success: function(data){

                console.log(data);

            },

            error: function(data) {

                console.log("galti");

            }

        })

    }



    function change_bidding_amount(amount) {

        if(request!=undefined && request.status!=200)

        {

            request.abort()

        }

        request = $.ajax({

            url:"editProfile_ajax.php",

            type:"post",

            data:{

                userId: '<?=$USER_ID?>',

                changeBidding_amount:true,

                amount:amount,

            },

            success: function(data){

                console.log(data);

            },

            error: function(data) {

                console.log("galti");

            }

        })

    }



    function add_skills() {

        skills = $("#inputed_skills").val();

        $.ajax({

            url:"editProfile_ajax.php",

            type:"post",

            data:{

                userId: '<?=$USER_ID?>',

                add_skills:true,

                skill:skills,

            },

            success: function(data){

                console.log(data);

            },

            error: function(data) {

                console.log("galti");

            }

        })

    }



    function delete_skill(skill) {

        $.ajax({

            url:"editProfile_ajax.php",

            type:"post",

            data:{

                id:skill,

                delete_skill:true,

            },

            success: function(data){

                console.log(data);

            },

            error: function(data) {

                console.log("galti");

            }

        })

    }



    function change_password() {

        current_password = $("#current_password").val();

        new_password = $("#new_password").val();

        rep_password = $("#rep_password").val();

        

        $.ajax({

            url:"editProfile_ajax.php",

            type:"post",

            data:{

                userId: '<?=$USER_ID?>',

                change_password:true,

                current_password:current_password,

                new_password:new_password,

                rep_password:rep_password,

                email:'<?=$_SESSION['user_signed_in']?>'

            },

            success: function(data){

                console.log(data);

                    var obj = JSON.parse(data);

                    if(obj.msg.trim()=='success')

                {

                    Snackbar.show({

                    text: 'Your password has been changed!',

                    pos: 'bottom-center',

                    showAction: false,

                    actionText: "Dismiss",

                    duration: 3500,

                    textColor: '#fff',

                    backgroundColor: '#383838'

                    });

                }

                else if(obj.msg.trim()=='OOPS!!! New password and repeated password are not same!!'){

                    Snackbar.show({

                    text: 'New password and repeated password are not same',

                    pos: 'bottom-center',

                    showAction: false,

                    actionText: "Dismiss",

                    duration: 3500,

                    textColor: '#fff',

                    backgroundColor: '#383838'

                    });

                }

                else if(obj.msg.trim()=='You typed in wrong current password'){

                    Snackbar.show({

                    text: 'OOPS!!! You typed in wrong current password!!',

                    pos: 'bottom-center',

                    showAction: false,

                    actionText: "Dismiss",

                    duration: 3500,

                    textColor: '#fff',

                    backgroundColor: '#383838'

                    });

                }

            },

            error: function(data) {

                console.log("galti");

            }

        })

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