<?php

    require_once 'header.php';
    require_once 'navbar.php';

    // print_r($bankingDetails);

    

if(isset($_SESSION['user_signed_in']))
{
    // print_r($_SESSION);
    if(isset($_POST['save']))

    {

        $method=$_POST['radio'];

        switch($method)

        {

            case 'Account':

                $acc_no = $_POST['acc_no'];

                $routing_no = $_POST['routing_no'];

                $sql = "update bank set method='$method', acc_no = '$acc_no',routing_no = '$routing_no' where u_id='$USER_ID'";

                break;

            case 'Card':

                $card_no = $_POST['card_no'];

                $name_card = $_POST['name_card'];

                $sql = "update bank set method='$method', card_no = '$card_no',name_card = '$name_card' where u_id='$USER_ID'";

                break;

            case 'Cashapp':

                $username = $_POST['cashapp'];

                $sql = "update bank set method='$method', username='$username' where u_id='$USER_ID'";

                break; 

            case 'PayPal':

                $username = $_POST['paypal'];

                $sql = "update bank set method='$method', username='$username' where u_id='$USER_ID'";

                break;

        }

        if($conn->query($sql))

		{

			$changes = "Bank Details Updated Succesfull"; 

		}

		else{

			$changes = $conn->error; 

		}

        

    }



    $sql="select * from bank where u_id='$USER_ID'";

    if($result = $conn->query($sql))

    {

        if($result->num_rows)

        {

            $bankingDetails = $result->fetch_assoc();

            

        }

        

    }

    // echo gettype($bankingDetails);

    $chck1='';

    $chck2='';

    $chck3='';

    $chck4='';

    $show1='none';

    $show2='none';

    $show3='none';

    $show4='none';

    if(isset($bankingDetails))
    {
        switch($bankingDetails['method'])

        {

            case 'Account':

                $chck1='checked';

                $show1='show';

                break;

            case 'Card':

                $chck2='checked';

                $show2='show';

                break;

            case 'Cashapp':

                $chck3='checked';

                $show3='show';

                break; 

            case 'PayPal':

                $chck4='checked';

                $show4='show';

                break;

        }
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

                                        <h3><i class="fas fa-credit-card"></i> Banking Details</h3>

                                    </div>



                                    <div class="content with-padding padding-bottom-0">



                                        <div class="row">



                                           



                                            <div class="col">

                                                <div class="row">

                                                        <div class="col-xl-12">

                                                           

                                                            <div class="feedback-yes-no">

                                                                <strong>Method</strong>

                                                                <div class="radio" onclick="show(8077,122)">

                                                                    <input id="radio-rating-1" name="radio" type="radio" value="Account" <?=$chck1?>>

                                                                    <label for="radio-rating-1"><span class="radio-label"></span> Account Details</label>

                                                                </div>

                                                                <div class="radio" onclick="show(484,48)">

                                                                    <input id="radio-rating-2" name="radio" type="radio" value="Card" <?=$chck2?>>

                                                                    <label for="radio-rating-2"><span class="radio-label"></span> Card Details</label>

                                                                </div>

                                                                <div class="radio" onclick="showbaby(69)">

                                                                    <input id="radio-rating-3" name="radio" type="radio" value="Cashapp" <?=$chck3?>>

                                                                    <label for="radio-rating-3"><span class="radio-label"></span> Cashapp</label>

                                                                </div>

                                                                <div class="radio" onclick="showbaby(8449)">

                                                                    <input id="radio-rating-4" name="radio" type="radio" value="PayPal" <?=$chck4?>> 

                                                                    <label for="radio-rating-4"><span class="radio-label"></span> PayPal</label>

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-xl-12" id="8077" style="display:<?=$show1?>;">

                                                            <div class="submit-field">

                                                                <h5>Account Number</h5>

                                                            

                                                                <input type="number" name="acc_no" class="with-border" value="<?=$bankingDetails['acc_no']?>">

                                                            </div>

                                                        </div>



                                                        <div class="col-xl-12" id="122" style="display:<?=$show1?>;">

                                                            <div class="submit-field">

                                                                <h5>Routing Number</h5>

                                                                <input type="number" name="routing_no" class="with-border" value="<?=$bankingDetails['routing_no']?>">

                                                            </div>

                                                        </div> 



                                                        <div class="col-xl-12" id="484" style="display:<?=$show2?>;">

                                                            <div class="submit-field">

                                                                <h5>Card Number</h5>

                                                                <input type="number" name="card_no" class="with-border" value="<?=$bankingDetails['card_no']?>">

                                                            </div>

                                                        </div> 



                                                        <div class="col-xl-12" id="48" style="display:<?=$show2?>;">

                                                            <div class="submit-field">

                                                                <h5>Name on Card</h5>

                                                                <input type="text" name="name_card" class="with-border" value="<?=$bankingDetails['name_card']?>">

                                                            </div>

                                                        </div>

                                                        <div class="col-xl-12" id="69" style="display:<?=$show3?>;">

                                                            <div class="submit-field">

                                                                <h5>Cashapp Username</h5>

                                                                <input type="text" name="cashapp" class="with-border" value="<?=$bankingDetails['username']?>">

                                                            </div>

                                                        </div>

                                                        <div class="col-xl-12" id="8449" style="display:<?=$show4?>;">

                                                            <div class="submit-field">

                                                                <h5>Paypal Username</h5>

                                                                <input type="text" name="paypal" class="with-border" value="<?=$bankingDetails['username']?>">

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

                                                                    $customer = '';

                                                                    $cus_show='none';

                                                                    $show8='none';

                                                                    $show9='none';

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

                                                                            $customer = "checked";

                                                                            $cus_show ='show';

                                                                            break;

                                                                    }

                                                                ?>

                                                                    <div style="cursor:not-allowed;display:<?=$show8?>">

                                                                        <input type="radio" value="3" style="cursor:not-allowed" name="account-type-radio" id="freelancer-radio" class="account-type-radio"  <?=$contract_check?> disabled/>

                                                                        <label for="freelancer-radio" style="cursor:not-allowed" class="ripple-effect-dark"><i class="icon-material-outline-account-circle"></i> Contractor</label>

                                                                    </div>



                                                                    <div style="cursor:not-allowed;display:<?=$show9?>">

                                                                        <input type="radio" value="2" style="cursor:not-allowed" name="account-type-radio" id="employer-radio"  class="account-type-radio" <?=$employeer_check?> disabled/>

                                                                        <label for="employer-radio" style="cursor:not-allowed" class="ripple-effect-dark"><i class="icon-material-outline-business-center"></i> Employer</label>

                                                                    </div>

                                                                    <div style="cursor:not-allowed;display:<?=$cus_show?>">

                                                                        <input type="radio" value="5" style="cursor:not-allowed" name="account-type-radio" id="customer-radio"  class="account-type-radio" <?=$customer?> disabled/>

                                                                        <label for="customer-radio" style="cursor:not-allowed" class="ripple-effect-dark"><i class="icon-material-outline-business-center"></i> Customer</label>

                                                                    </div>

                                                                </div>

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

                                <button type="submit" name="save" class="button ripple-effect big margin-top-30">Save Changes</button>

                            </div>



                        </form>



                        <!-- Dashboard Box -->

                       

                        

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

    

    function showbaby(id)

    {

        $("#8077").hide();

        $("#122").hide();

        $("#484").hide();

        $("#48").hide();

        $("#69").hide();

        $("#8449").hide();

        $("#"+id).show();

        

    }

    function show(id1,id2)

    {

        $("#8077").hide();

        $("#122").hide();

        $("#484").hide();

        $("#48").hide();

        $("#69").hide();

        $("#8449").hide();

        $("#"+id1).show();

        $("#"+id2).show();

    }





    function remove(id)

    {

        $("#"+id).remove();

    }



    // onclick="bank(<?=$USER_ID?>)" p yeh function daalo aur button type change karo 

    // function bank(id)

    // {

    //     var method = $('input[name="radio"]').val();

    //     var acc_no = $('input[name="acc_no"]').val();

    //     var routing_no = $('input[name="routing_no"]').val();

    //     var card_no = $('input[name="card_no"]').val();

    //     var name_card = $('input[name="name_card"]').val();

    //     var cashapp = $('input[name="cashapp"]').val();

    //     var paypal = $('input[name="paypal"]').val();

    //     console.log(method);



    //     $.ajax({

    //         url:"bank_ajax.php",

    //         type:"post",

    //         data:{

    //             save:true,

    //             userid: id,

    //             method:method,

    //             acc_no:acc_no,

    //             routing_no:routing_no,

    //             card_no:card_no,

    //             name_card:name_card,

    //             cashapp:cashapp,

    //             paypal:paypal

               

    //         },

    //         success: function(data){

    //             console.log(data);

	// 			if(data.trim()=="updated"){

	// 				Snackbar.show({

	// 				text: 'Banking Details Updated Successfully !!',

	// 				pos: 'bottom-center',

	// 				showAction: false,

	// 				actionText: "Dismiss",

	// 				duration: 3000,

	// 				textColor: '#fff',

	// 				backgroundColor: '#383838'

	// 			}); 

	// 			}

    //         },

    //         error: function(data) {

    //             console.log("galti");

    //         }

    //     });

    // }



    // $("#dashboard").removeClass('active');

	// $("#bookmarks").removeClass('active');

	// $("#reviews").removeClass('active');

	// $("#jobs").removeClass('active');

	// $("#tasks").removeClass('active');

	// $("#settings").removeClass('active');

	// $("#milestone").removeClass('active');

	// $("#settings").addClass('active');



</script>