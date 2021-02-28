<?php
    require_once 'header.php';
    require_once 'navbar.php';

    if(isset($_POST['post_task'])){
        $t_name = $conn->real_escape_string($_POST['t_name']);
        $t_catagory = $conn->real_escape_string($_POST['t_catagory']);
        $location = $conn->real_escape_string($_POST['location']);
        $min_salary = $conn->real_escape_string($_POST['min_salary']);
        $max_salary = $conn->real_escape_string($_POST['max_salary']);
        $t_description = $conn->real_escape_string($_POST['t_description']);
        $radio_price = $_POST['radio_price'];
        $inputed_skills = $_POST['inputed_skills'];
        $end_date = date('Y-m-d', strtotime($_REQUEST['end_date']));
        $sql="insert into post_task (e_id,t_name,t_catagory,location,min_salary,max_salary,t_description,end_date,pay_type)
         values('$USER_ID','$t_name','$t_catagory','$location','$min_salary','$max_salary','$t_description','$end_date','$radio_price')"; 
         if($conn->query($sql))
         {
            $insertId = $conn->insert_id;
            $sql = "insert into skill_tasks (t_id,skills) values"; 
            foreach($inputed_skills as $inputed_skill)
            {
                $sql .= "($insertId,'$inputed_skill'),";
            }
            $sql = rtrim($sql,",");
            if($conn->query($sql))
            {
                $task_posted =true;
            } 
            else{
                $half_task_posted =true;
            }
         }
         else{
              $error =$conn->error;
         }
    }

    $sql = "select * from skill_tasks where e_id='$USER_ID'";
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


    $sql = "select * from post_task where e_id='$USER_ID'";
    if($result = $conn->query($sql))
    {
        if($result->num_rows)
        {
            $row=$result->fetch_assoc();
            $taskDetails=$row;
        }
    }


?>

<!-- Wrapper -->
<div id="wrapper">

    <div class="clearfix"></div>
    <!-- Header Container / End -->
    <form method="post">
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
                        <h3>Post a Task</h3>

                        <!-- Breadcrumbs -->
                        <nav id="breadcrumbs" class="dark">
                            <ul>
                                <li><a href="#">Home</a></li>
                                <li><a href="#">Dashboard</a></li>
                                <li>Post a Task</li>
                            </ul>
                        </nav>
                    </div>

                    <?php
                        if(isset($task_posted)){
                            ?>
                                <div class="alert alert-success" role="alert">
                                    Task has been posted !!!
                                </div>
                            <?php
                        }
                    ?>

                    <!-- Row -->
                    <div class="row">

                        <!-- Dashboard Box -->
                        <div class="col-xl-12">
                            <div class="dashboard-box margin-top-0">

                                <!-- Headline -->
                                <div class="headline">
                                    <h3><i class="icon-feather-folder-plus"></i> Task Submission Form</h3>
                                </div>

                                <div class="content with-padding padding-bottom-10">
                                    <div class="row">

                                        <div class="col-xl-6">
                                            <div class="submit-field">
                                                <h5>Project Name</h5>
                                                <input type="text" name="t_name" class="with-border" placeholder="e.g. build me a website">
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="submit-field">
                                                <h5>Category</h5>
                                                <select name="t_catagory" class="selectpicker with-border" data-size="7" title="Select Category">
                                                    <option>Admin Support</option>
                                                    <option>Customer Service</option>
                                                    <option>Data Analytics</option>
                                                    <option>Design & Creative</option>
                                                    <option>Legal</option>
                                                    <option>Software Developing</option>
                                                    <option>IT & Networking</option>
                                                    <option>Writing</option>
                                                    <option>Translation</option>
                                                    <option>Sales & Marketing</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xl-4">
                                            <div class="submit-field">
                                                <h5>Task Expiring Date</h5> 
                                                <div class="input-with-icon">
                                                    <div id="autocomplete-container">
                                                    <input type="date" id="end_date" name="end_date" >
                                                    <!-- value="<?php echo date('Y-m-d')?>" -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-4">
                                            <div class="submit-field">
                                                <h5>Location  <i class="help-icon" data-tippy-placement="right" title="Leave blank if it's an online job"></i></h5>
                                                <div class="input-with-icon">
                                                    <div id="autocomplete-container">
                                                        <input name="location" id="autocomplete-input" class="with-border" type="text" placeholder="Anywhere">
                                                    </div>
                                                    <i class="icon-material-outline-location-on"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-4">
                                            <div class="submit-field">
                                                <h5>What skills are required? <i class="help-icon" data-tippy-placement="right" title="Up to 5 skills that best describe your project"></i></h5>
                                                <div class="keywords-container">
                                                    <div class="keyword-input-container">
                                                        <input type="text" id="inputed_skills" class="keyword-input with-border" placeholder="Add Skills"/>
                                                        <div id="all_skills">
                                                        </div>
                                                        <button class="keyword-input-button ripple-effect" type="button" onclick="add_skills()"><i class="icon-material-outline-add"></i></button>
                                                    </div>
                                                    <div class="keywords-list"><!-- keywords go here --></div>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-12">
                                            <div class="submit-field">
                                                <h5>What is your estimated budget?</h5>
                                                <div class="row">
                                                    <div class="col-xl-4">
                                                        <div class="input-with-icon">
                                                            <input name="min_salary" class="with-border" type="text" placeholder="Minimum">
                                                            <i class="currency">USD</i>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <div class="input-with-icon">
                                                            <input name="max_salary" class="with-border" type="text" placeholder="Maximum">
                                                            <i class="currency">USD</i>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="feedback-yes-no margin-top-0">
                                                    <div class="radio">
                                                        <input id="radio-1" name="radio_price" type="radio"  value="1">
                                                        <label for="radio-1"><span class="radio-label"></span> Fixed Price Project</label>
                                                    </div>

                                                    <div class="radio">
                                                        <input id="radio-2" name="radio_price" type="radio" value="2">
                                                        <label for="radio-2"><span class="radio-label"></span> Hourly Project</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        
                                        
                                        
                                        <div class="col-xl-12">
                                            <div class="submit-field">
                                                <h5>Describe Your Project</h5>
                                                <textarea name="t_description" cols="30" rows="5" class="with-border"></textarea>
                                                <div class="uploadButton margin-top-30">
                                                    <input class="uploadButton-input" type="file" accept="image/*, application/pdf" id="upload" multiple/>
                                                    <label class="uploadButton-button ripple-effect" for="upload">Upload Files</label>
                                                    <span class="uploadButton-file-name">Images or documents that might be helpful in describing your project</span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-12">
                            <button name="post_task" class="button ripple-effect big margin-top-30"><i class="icon-feather-plus"></i> Post a Task</a>
                        </div>

                    </div>
                    <!-- Row / End -->

                    <!-- Footer -->
                    <div class="dashboard-footer-spacer"></div>
                    <div class="small-footer margin-top-15">
                        <ul class="footer-social-links">
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
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <!-- Footer / End -->

                </div>
            </div>
            <!-- Dashboard Content / End -->

        </div>
        <!-- Dashboard Container / End -->
   </form>

</div>

<?php
    require_once 'js-links.php';
?>

<script>
    function add_skills() {
        inputed_skills = $("#inputed_skills").val();
        var inhtml = `<input name="inputed_skills[]" type="hidden" value="${inputed_skills}"/>`;
        $("#all_skills").append(inhtml); 
    }

    
</script>

