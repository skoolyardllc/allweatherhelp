<?php
    require_once 'header.php';
    require_once 'navbar.php';

    if(isset($_POST['post_jobs'])){
        $job_title = $conn->real_escape_string($_POST['job_title']);
        $job_type = $conn->real_escape_string($_POST['job_type']);
        $job_catagory = $conn->real_escape_string($_POST['job_catagory']);
        $location = $conn->real_escape_string($_POST['location']);
        $min_usd = $conn->real_escape_string($_POST['min_usd']);
        $max_usd = $conn->real_escape_string($_POST['max_usd']);
        $job_description = $conn->real_escape_string($_POST['job_description']);
        $tags = $_POST['tags'];
        $end_date = date('Y-m-d', strtotime($_REQUEST['end_date']));
        $sql="insert into post_job (e_id,j_title,j_type,catagory,location,min_salary,max_salary,j_description,end_date)
         values('$USER_ID','$job_title','$job_type','$job_catagory','$location','$min_usd','$max_usd','$job_description','$end_date')"; 
        if($conn->query($sql))
		{
            $insertId = $conn->insert_id;
            $sql = "insert into job_tags (j_id,tag) values"; 
            foreach($tags as $tag)
            {
                $sql .= "($insertId,'$tag'),";
            }
            $sql = rtrim($sql,",");
            if($conn->query($sql))
            {
                $job_posted =true;
            } 
            else{
                $half_job_posted =true;
            }
		}
		else{
			 $error =$conn->error;
		}
    }

    $sql = "select * from post_tags where e_id='$USER_ID'";
    if($result = $conn->query($sql))
    {
        if($result->num_rows)
        {
            while($row=$result->fetch_assoc())
            {
                $tags[]=$row;
            }
        }
    }
?>




<div id="wrapper">

<!-- Header Container
================================================== -->

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
                    
                        <h3>Post a Job</h3>

                        <!-- Breadcrumbs -->
                        <nav id="breadcrumbs" class="dark">
                            <ul>
                                <li><a href="#">Home</a></li>
                                <li><a href="#">Dashboard</a></li>
                                <li>Post a Job</li>
                            </ul>
                        </nav>
                    </div>
            
                    <?php
                        if(isset($job_posted)){
                            ?>
                                <div class="alert alert-success" role="alert">
                                Job has been posted !!!
                                </div>
                            <?php
                        }
                    ?>

                        <?php
                            if(isset($half_job_posted)){
                                ?>
                                    <div class="alert alert-success" role="alert">
                                    Job has been posted without job tags!!!
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
                                    <h3><i class="icon-feather-folder-plus"></i> Job Submission Form</h3>
                                </div>

                                <div class="content with-padding padding-bottom-10">
                                    <div class="row">

                                        <div class="col-xl-4">
                                            <div class="submit-field">
                                                <h5>Job Title</h5>
                                                <input name="job_title" type="text" class="with-border">
                                            </div>
                                        </div>

                                        <div class="col-xl-4">
                                            <div class="submit-field">
                                                <h5>Job Type</h5>
                                                <select name="job_type" class="selectpicker with-border" data-size="7" title="Select Job Type">
                                                    <option>Full Time</option>
                                                    <option>Freelance</option>
                                                    <option>Part Time</option>
                                                    <option>Internship</option>
                                                    <option>Temporary</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xl-4">
                                            <div class="submit-field">
                                                <h5>Job Category</h5>
                                                <select name="job_catagory" class="selectpicker with-border" data-size="7" title="Select Category">
                                                    <option>Accounting and Finance</option>
                                                    <option>Clerical & Data Entry</option>
                                                    <option>Counseling</option>
                                                    <option>Court Administration</option>
                                                    <option>Human Resources</option>
                                                    <option>Investigative</option>
                                                    <option>IT and Computers</option>
                                                    <option>Law Enforcement</option>
                                                    <option>Management</option>
                                                    <option>Miscellaneous</option>
                                                    <option>Public Relations</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xl-4">
                                            <div class="submit-field">
                                                <h5>Job Expiring Date</h5> 
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
                                                <h5>Location</h5>
                                                <div class="input-with-icon">
                                                    <div id="autocomplete-container">
                                                        <input name="location" id="autocomplete-input" class="with-border" type="text" placeholder="Type Address">
                                                    </div>
                                                    <i class="icon-material-outline-location-on"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-4">
                                            <div class="submit-field">
                                                <h5>Salary</h5>
                                                <div class="row">
                                                    <div class="col-xl-6">
                                                        <div class="input-with-icon">
                                                            <input name="min_usd" class="with-border" type="text" placeholder="Min">
                                                            <i class="currency">USD</i>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <div class="input-with-icon">
                                                            <input name="max_usd" class="with-border" type="text" placeholder="Max">
                                                            <i class="currency">USD</i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-4">
                                            <div class="submit-field">
                                                <h5>Tags <span>(optional)</span>  <i class="help-icon" data-tippy-placement="right" title="Maximum of 10 tags"></i></h5>
                                                <div class="keywords-container">
                                                    <div class="keyword-input-container">
                                                        <input id="tags" type="text" class="keyword-input with-border" placeholder="e.g. job title, responsibilites"/>
                                                        <div id="all_tags">
                                                        </div>
                                                        <button class="keyword-input-button ripple-effect" type="button" onclick="add_tags()"><i class="icon-material-outline-add"></i></button>
                                                    </div>
                                                    <div class="keywords-list"><!-- keywords go here --></div>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-12">
                                            <div class="submit-field">
                                                <h5>Job Description</h5>
                                                <textarea name="job_description" cols="30" rows="5" class="with-border"></textarea>
                                                <div class="uploadButton margin-top-30">
                                                    <input class="uploadButton-input" type="file" accept="image/*, application/pdf" id="upload" multiple/>
                                                    <label class="uploadButton-button ripple-effect" for="upload">Upload Files</label>
                                                    <span class="uploadButton-file-name">Images or documents that might be helpful in describing your job</span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-12">
                            <button type="submit" name="post_jobs" class="button ripple-effect big margin-top-30"><i class="icon-feather-plus"></i> Post a Job</button>
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
<!-- Wrapper / End -->

<?php
 require_once 'js-links.php';
 ?>

 <script>
     function add_tags() {
        tags = $("#tags").val();
        var inhtml = `<input name="tags[]" type="hidden" value="${tags}"/>`;
        $("#all_tags").append(inhtml); 
    }

    
    $(".keyword-remove").click(function(e)
    {
        var tag_value = $(this).next().val()
        alert(tag_value);
    })
 </script>