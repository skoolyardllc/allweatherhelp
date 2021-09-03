<?php
    require_once 'header.php';
   require_once 'navbar.php';


    if($TYPE==5)
    {
        $sql="select count(id) as count from employer_reviews where c_id='$USER_ID'";
        if($result=$conn->query($sql))
        {
            if($result->num_rows)
            {
                $row=$result->fetch_assoc();
                    $reviews_count=$row['count'];
            }
        }
        $sql="select sum(amount) as sum from milestones_payment where status='succeeded' and user_id='$USER_ID'";
        if($result=$conn->query($sql))
        {
            if($result->num_rows)
            {
                $row=$result->fetch_assoc();
                    $user_count=$row['sum'];
            }
        }
    }
    else if($TYPE==3||$TYPE==2)
    {
        $sql="select count(id) as count from accepted_task where c_id='$USER_ID'";
        if($result=$conn->query($sql))
        {
            if($result->num_rows)
            {
                $row=$result->fetch_assoc();
                    $reviews_count=$row['count'];
            }
        }
        $sql="select sum(amount) as sum from milestones_transaction where status='1' and contractor_id=$USER_ID";
        if($result=$conn->query($sql))
        {
            if($result->num_rows)
            {
                $row=$result->fetch_assoc();
                    $user_count=$row['sum'];
            }
        }
    }
   $sql="select count(id) as count from post_task where e_id='$USER_ID'";
   if($result=$conn->query($sql))
   {
       if($result->num_rows)
       {
           $row=$result->fetch_assoc();
            $tasks_count=$row['count'];
       }
   }
   $sql="select * from notes where u_id='$USER_ID' ORDER BY time_stamp desc limit 3";
   if($result=$conn->query($sql))
   {
       if($result->num_rows)
       {
           while($row=$result->fetch_assoc())
           { 
                $notes[]=$row;
           }
       }
   }

   $sql="select * from message where for_id='$USER_ID' limit 5";
   if($result=$conn->query($sql))
   {
       if($result->num_rows)
       {
           while($row=$result->fetch_assoc())
           { 
                $messages[]=$row;
           }
       }
   }
   $aaj = date("Y-m-d");
   $sql="select * from post_task where e_id='$USER_ID' and end_date >'$aaj'  limit 5";
   if($result=$conn->query($sql))
   {
       if($result->num_rows)
       {
           while($row=$result->fetch_assoc())
           { 
                $tasks[]=$row;
           }
       }
   }
   else
   {
       $error = $conn->error;
   }
   
?>
<style>
    @media only screen and (max-width:600px)
    {
        #lastone{display:none}
    }
</style>
<!-- Wrapper -->
<div id="wrapper">
    <!-- Dashboard Container -->
    <div class="dashboard-container">

        <?php
            require_once 'left-navbar.php';
        ?>

        <!-- Dashboard Content
	    ================================================== -->
        <div class="dashboard-content-container" data-simplebar>
            <div class="dashboard-content-inner">

                <!-- Dashboard Headline -->
                <div class="dashboard-headline">
                    <h3><?=$USER_DATA['f_name']?> <?=$USER_DATA['l_name']?>!</h3>
                    <span>We are glad to see you again!</span>

                    <!-- Breadcrumbs -->
                    <nav id="breadcrumbs" class="dark">
                        <ul>
                            <li><a href="index">Home</a></li>
                            <li>Dashboard</li>
                        </ul>
                    </nav>
                </div>

                <!-- Fun Facts Container -->
                <div class="fun-facts-container">
                    <div class="fun-fact" data-fun-fact-color="#36bd78">
                        <div class="fun-fact-text">
                            <span>Tasks</span>
                            <h4><?=$tasks_count?></h4>
                        </div>
                        <div class="fun-fact-icon"><i class="icon-material-outline-gavel"></i></div>
                    </div>
                    <div class="fun-fact" data-fun-fact-color="#b81b7f">
                        <div class="fun-fact-text">
                            <span>Total Transactions</span>
                            <h4><?=$user_count?></h4>
                        </div>
                        <div class="fun-fact-icon"><i class="icon-material-outline-business-center"></i></div>
                    </div>
                    <div class="fun-fact" data-fun-fact-color="#efa80f">
                        <div class="fun-fact-text">
                            <span>Reviews</span>
                            <h4><?=$reviews_count?></h4>
                        </div>
                        <div class="fun-fact-icon"><i class="icon-material-outline-rate-review"></i></div>
                    </div>

                    <!-- Last one has to be hidden below 1600px, sorry :( -->
                    <div class="fun-fact" data-fun-fact-color="#2a41e6" id="lastone">
                        <div class="fun-fact-text">
                            <span>This Month Views</span>
                            <h4>987</h4>
                        </div>
                        <div class="fun-fact-icon"><i class="icon-feather-trending-up"></i></div>
                    </div>
                </div>

                <!-- Row -->
                <div class="row">

                    <div class="col-xl-8">
                        <div class="dashboard-box main-box-in-row">
                            <div class="headline">
                                <h3><i class="icon-feather-bar-chart-2"></i> Your Transactions</h3>
                                <div class="sort-by">
                                    <!-- <select class="selectpicker hide-tick">
                                        <option>Last 6 Months</option>
                                        <option>This Year</option>
                                        <option>This Month</option>
                                    </select> -->
                                </div>
                            </div>
                            <div class="content">
                                <div class="chart">
                                    <canvas id="chart" width="100" height="45"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="dashboard-box child-box-in-row">
                            <div class="headline">
                                <h3><i class="icon-material-outline-note-add"></i> Notes</h3>
                            </div>

                            <div class="content with-padding" id="notes">
                                <!-- Note -->
                            <?php
                                if(isset($notes))
                                {
                                    $i=1;
                                    foreach($notes as $data)
                                    {
                            ?>
                                        <div class="dashboard-note"  id="note<?=$data['id']?>">
                                            <p><?=$data['description']?>
                                            </p>
                                            <div class="note-footer">
                                                <span class="note-priority <?=$data['priority']?>"><?=ucfirst($data['priority'])?> Priority</span>
                                                <div class="note-buttons">
                                                    <button type="button" onclick="deletenote(<?=$data['id']?>)"><i
                                                            class="icon-feather-trash-2"></i></button>
                                                </div>
                                            </div>
                                        </div>
                            <?php
                                        $i++;
                                    }
                                }
                            ?>
                            </div>
                            <div class="add-note-button">
                                <a href="#small-dialog"
                                    class="popup-with-zoom-anim button full-width button-sliding-icon">Add Note <i
                                        class="icon-material-outline-arrow-right-alt"></i></a>
                            </div>
                        </div>
                        <!-- Dashboard Box / End -->
                    </div>
                </div>
                <!-- Row / End -->

                <!-- Row -->
                <div class="row">
                    <!-- Dashboard Box -->
                    <div class="col-xl-6">
                        <div class="dashboard-box">
                            <div class="headline">
                                <h3><i class="icon-material-baseline-notifications-none"></i> Notifications</h3>
                                <button class="mark-as-read ripple-effect-dark" data-tippy-placement="left"
                                    title="Mark all as read">
                                    <i class="icon-feather-check-square"></i>
                                </button>
                            </div>
                            <div class="content">
                                <ul class="dashboard-box-list">
                                    <?php
                                    if(isset($messages))
                                    {
                                        foreach($messages as $data)
                                        {
                                    ?>
                                        <li>
                                            <span class="notification-icon"><i
                                                    class="icon-material-outline-group"></i></span>
                                            <span class="notification-text">
                                                <strong><?=$data['msg']?></strong>
                                            </span>
                                            <!-- Buttons -->
                                            <div class="buttons-to-right">
                                                <a href="#" class="button ripple-effect ico" title="Mark as read"
                                                    data-tippy-placement="left"><i
                                                        class="icon-feather-check-square"></i></a>
                                            </div>
                                        </li>
                                    <?php
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Dashboard Box -->
                    <div class="col-xl-6">
                        <div class="dashboard-box">
                            <div class="headline">
                                <h3><i class="icon-material-outline-assignment"></i>Tasks</h3>
                            </div>
                            <div class="content">
                                <ul class="dashboard-box-list">
                                    <?php
                                    if(isset($tasks))
                                    {
                                        foreach($tasks as $data)
                                        {
                                        ?>
                                            <li>
                                                <div class="invoice-list-item">
                                                    <strong><?=$data['t_name']?></strong>
                                                    <ul>
                                                        <?php
                                                            if($data['end_date'] < date("Y-m-d"))
                                                            {
                                                        ?>
                                                                <li><span class="unpaid">Completed</span></li>
                                                        <?php
                                                            }
                                                            else if($data['end_date'] > date("Y-m-d"))
                                                            {
                                                        ?>
                                                                <li><span class="paid">Ongoing</span></li>
                                                        <?php
                                                            }
                                                        ?>
                                                        <li>End Date: <?=$data['end_date']?></li>
                                                    </ul>
                                                </div>
                                            </li>
                                        <?php
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- Row / End -->

                <!-- Footer -->
                <div class="dashboard-footer-spacer"></div>
                <div class="small-footer margin-top-15">
                    <div class="small-footer-copyrights">
                    </div>
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
    <!-- Dashboard Container / End -->

</div>
<!-- Wrapper / End -->

<div id="small-dialog" class="zoom-anim-dialog mfp-hide dialog-with-tabs">

    <div class="sign-in-form">

        <ul class="popup-tabs-nav">
            <li><a href="#tab">Add Note</a></li>
        </ul>

        <div class="popup-tabs-container">

            <!-- Tab -->
            <div class="popup-tab-content" id="tab">

                <!-- Welcome Text -->
                <div class="welcome-text">
                    <h3>Do Not Forget 😎</h3>
                </div>

                <!-- Form -->
                <form method="post" id="add-note">

                    <select id="priority" class="selectpicker with-border default margin-bottom-20" data-size="7" title="Priority">
                        <option value="low">Low Priority</option>
                        <option value="medium">Medium Priority</option>
                        <option value="high">High Priority</option>
                    </select>

                    <textarea id="desc" cols="10" placeholder="Note" class="with-border"></textarea>
                    <button class="button full-width button-sliding-icon ripple-effect" type="button" onclick="addnote()" form="add-note">Add Note<i class="icon-material-outline-arrow-right-alt"></i></button>

                </form>

                <!-- Button -->
                

            </div>

        </div>
    </div>
</div>
<!-- Apply for a job popup / End -->


<!-- Scripts
================================================== -->
<script src="js/jquery-3.4.1.min.js"></script>
<script src="js/jquery-migrate-3.1.0.min.html"></script>
<script src="js/mmenu.min.js"></script>
<script src="js/tippy.all.min.js"></script>
<script src="js/simplebar.min.js"></script>
<script src="js/bootstrap-slider.min.js"></script>
<script src="js/bootstrap-select.min.js"></script>
<script src="js/snackbar.js"></script>
<script src="js/clipboard.min.js"></script>
<script src="js/counterup.min.js"></script>
<script src="js/magnific-popup.min.js"></script>
<script src="js/slick.min.js"></script>
<script src="js/custom.js"></script>

<!-- Snackbar // documentation: https://www.polonel.com/snackbar/ -->
<script>
// Snackbar for user status switcher
$('#snackbar-user-status label').click(function() {
    Snackbar.show({
        text: 'Your status has been changed!',
        pos: 'bottom-center',
        showAction: false,
        actionText: "Dismiss",
        duration: 3000,
        textColor: '#fff',
        backgroundColor: '#383838'
    });
});

function addnote() 
{
    var priority=$("#priority").val();
    var desc=$("#desc").val();
    $.ajax({
        url: "add_note_ajax.php",
        type: "POST",
        data: {
            priority: priority,
            add_note: true,
            desc: desc,
            uid: <?=$USER_ID?>
        },
        success: function(response) 
        {

            $(".mfp-close").trigger("click");
            var obj=JSON.parse(response);
            displaynotes(obj);
        },
        error: function(response) {
            console.log("galti");
        }
    })
}
function displaynotes(obj)
    {
        var i=1;
        $("#notes").empty();
            $.each(obj,function(k, v)
            {
                $("#notes").append(`<div class="dashboard-note"  id="note${v.id}">
                                            <p>${v.description}</p>
                                            <div class="note-footer">
                                                <span class="note-priority ${v.priority}">${v.priority} Priority</span>
                                                <div class="note-buttons">
                                                    <button type="button" onclick="deletenote(${v.id})"><i
                                                            class="icon-feather-trash-2"></i></button>
                                                </div>
                                            </div>
                                        </div>`)
                i++;
            })
    }
function deletenote(nid) 
{
    console.log(nid)
    $.ajax({
        url: "add_note_ajax.php",
        type: "post",
        data: {
            delnoteid: nid,
            delnote: true,
        },
        success: function(data) 
        {
            console.log("hii")
            $('#note'+nid).remove();
        },
        error: function(data) {
            console.log("galti");
        }
    })
}

</script>

<!-- Chart.js // documentation: http://www.chartjs.org/docs/latest/ -->
<script src="js/chart.min.js"></script>
<script>
Chart.defaults.global.defaultFontFamily = "Nunito";
Chart.defaults.global.defaultFontColor = '#888';
Chart.defaults.global.defaultFontSize = '14';

var arr=[];
var arr2=[];
$(document).ready(function() {
    $.ajax({
        url: "add_note_ajax.php",
        type: "POST",
        data: {
            chartdata: true,
            type: <?=$TYPE?>,
            userid: <?=$USER_ID?>
        },
        success: function(response) 
        {
            var obj=JSON.parse(response);
            arr = obj.amount_new
            var ctx = document.getElementById('chart').getContext('2d');

            var chart = new Chart(ctx, {
                type: 'line',
                
                data: {
                    labels: ["Jan", "Feb", "Mar", "Apr", "May", "June", "July", "Aug", "Sept", "Oct", "Nov", "Dec"],
                    datasets: [{
                        label: "Amount",
                        backgroundColor: 'rgba(42,65,232,0.08)',
                        borderColor: '#2a41e8',
                        borderWidth: "3",
                        data: arr,
                        pointRadius: 5,
                        pointHoverRadius: 5,
                        pointHitRadius: 10,
                        pointBackgroundColor: "#fff",
                        pointHoverBackgroundColor: "#fff",
                        pointBorderWidth: "2",
                    }]
                },

                options: {

                    layout: {
                        padding: 10,
                    },

                    legend: {
                        display: false
                    },
                    title: {
                        display: false
                    },

                    scales: {
                        yAxes: [{
                            scaleLabel: {
                                display: false
                            },
                            gridLines: {
                                borderDash: [6, 10],
                                color: "#d8d8d8",
                                lineWidth: 1,
                            },
                        }],
                        xAxes: [{
                            scaleLabel: {
                                display: false
                            },
                            gridLines: {
                                display: false
                            },
                        }],
                    },

                    tooltips: {
                        backgroundColor: '#333',
                        titleFontSize: 13,
                        titleFontColor: '#fff',
                        bodyFontColor: '#fff',
                        bodyFontSize: 13,
                        displayColors: false,
                        xPadding: 10,
                        yPadding: 10,
                        intersect: false
                    }
                },


            });
        },
        error: function(response) {
            console.log("error");
        }
    })
});
// console.log(arr);


    $("#dashboard").removeClass('active');      
	$("#bookmarks").removeClass('active');
	$("#reviews").removeClass('active');
	$("#jobs").removeClass('active');
	$("#tasks").removeClass('active');
	$("#settings").removeClass('active');
	$("#milestone").removeClass('active');
	$("#dashboard").addClass('active');

</script>

</body>

<!-- Mirrored from www.vasterad.com/themes/AWH/dashboard.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 10 Feb 2021 18:39:02 GMT -->

</html>