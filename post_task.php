<?php
    require_once 'header.php';
    require_once 'navbar.php';

    if(isset($_POST['post_task'])){
        $t_name = $conn->real_escape_string($_POST['t_name']);
        $t_catagoryNtype = explode("@",$conn->real_escape_string($_POST['t_catagory']));
        $location = $conn->real_escape_string($_POST['location']);
        $min_salary = $conn->real_escape_string($_POST['min_salary']);
        $max_salary = $conn->real_escape_string($_POST['max_salary']);
        $t_description = $conn->real_escape_string($_POST['t_description']);
        $radio_price = $_POST['radio_price'];
        $inputed_skills = $_POST['inputed_skills'];
        $inputed_files =$_POST['inputed_files'];
        $cat_type = $_POST['cat_type'];
        $end_date = date('Y-m-d', strtotime($_REQUEST['end_date']));
        $task_category = $t_catagoryNtype[0];
        $task_type_cat = $t_catagoryNtype[1];
        // print_r($inputed_skills);
        $sql="insert into post_task (e_id,t_name,t_catagory,cat_type,location,min_salary,max_salary,t_description,end_date,pay_type)
         values('$USER_ID','$t_name','$task_category','$task_type_cat','$location','$min_salary','$max_salary','$t_description','$end_date','$radio_price')"; 
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

            $sql = "insert into uploaded_documents (t_id,document) values"; 
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
    
    $sql = "select * from task_category";
    if($result = $conn->query($sql))
    {
        if($result->num_rows)
        {
            while($row=$result->fetch_assoc())
            { 
                $taskCategories[]=$row;
            }
           
        }
    }


?>

<!-- Wrapper -->
<div id="wrapper">

    <div class="clearfix"></div>
    <!-- Header Container / End -->
    <form method="post" id="postTaskForm">
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
                                <li><a href="home">Home</a></li>
                                <li><a href="dashboard">Dashboard</a></li>
                                <li>Post a Task</li>
                            </ul>
                        </nav>
                    </div>

                    <?php
                        if(isset($task_posted)){
                            ?>
                                
                            <?php
                        }
                    ?>
                    <div id="divForAlert" style="display: none;">
                        <div class="alert alert-success" role="alert">
                            Task has been posted !!! <a href="manage_task">See Your Tasks!</a>
                        </div>
                    </div>
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
                                                <h5>Task Name</h5>
                                                <input type="text" name="t_name" class="with-border" placeholder="e.g. build me a website" required>
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="submit-field">
                                                <h5>Category</h5>
                                                <select name="t_catagory" id="t_category" class="selectpicker with-border" data-size="7" title="Select Category" required>
                                                <?php
                                                    foreach ($taskCategories as $cat)
                                                    {
                                                ?>
                                                
                                                        <option value="<?=$cat['id']?>@<?=$cat['type']?>"><?=$cat['category']?></option>
                                                        <!-- <input type="hidden" name="cat_type" value="<?=$cat['type']?>" /> -->
                                                        
                                                <?php
                                                    }
                                                ?>    
                                               
                                                   
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xl-4">
                                            <div class="submit-field">
                                                <h5>Task Expiring Date</h5> 
                                                <div class="input-with-icon">
                                                    <div id="autocomplete-container">
                                                    <input type="date" id="end_date" min="<?=date('Y-m-d')?>" name="end_date" required>
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
                                                        <!-- <input name="location" id="" class="with-border" type="text" placeholder="Anywhere" required> -->
                                                        <input name="location" id="location" oninput="addCities()" class="with-border" type="text" placeholder="Anywhere" list="cityname" required  >
                                                        <datalist id="cityname">

                                                        </datalist>
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
                                                            <input name="min_salary" class="with-border" type="text" placeholder="Minimum" required>
                                                            <i class="currency">USD</i>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <div class="input-with-icon">
                                                            <input name="max_salary" class="with-border" type="text" placeholder="Maximum" required>
                                                            <i class="currency">USD</i>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="feedback-yes-no margin-top-0">
                                                    <div class="radio">
                                                        <input id="radio-1" name="radio_price" type="radio"  value="1" required>
                                                        <label for="radio-1"><span class="radio-label"></span> Fixed Price Project</label>
                                                    </div>

                                                    <div class="radio">
                                                        <input id="radio-2" name="radio_price" type="radio" value="2" required>
                                                        <label for="radio-2"><span class="radio-label"></span> Hourly Project</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        
                                        
                                        
                                        <div class="col-xl-12">
                                            <div class="submit-field">
                                                <h5>Describe Your Project</h5>
                                                <textarea name="t_description" cols="30" rows="5" class="with-border" required></textarea>
                                                <div class="uploadButton margin-top-30">
                                                    <input class="uploadButton-input" type="file" accept="image/*, application/pdf" id="upload" multiple/>
                                                    <label class="uploadButton-button ripple-effect" for="upload">Upload Files</label>
                                                    <span class="uploadButton-file-name">Images or documents that might be helpful in describing your task</span>
                                                </div>
                                                <div id="file_image">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="uploadDiv">
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-12">
                            <input type="hidden" value="<?=$USER_ID?>" name="post_task" /> 
                            <button name="" type="button" onclick="postTask()" class="button ripple-effect big margin-top-30"><i class="icon-feather-plus"></i> Post a Task</a>
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
        <!-- Dashboard Container / End -->
   </form>

</div>

<?php
    require_once 'js-links.php';
?>

<script>

    var counter=0;

    function add_skills() {
        inputed_skills = $("#inputed_skills").val();
        var inhtml = `<input name="inputed_skills[]" type="hidden" value="${inputed_skills}"/>`;
        $("#all_skills").append(inhtml); 
    }

    $(function(){
        $('#upload').change(function(e)
        {
            var formData = new FormData();
            formData.append('images',e.target.files[0]);
            formData.append('updateFile','true');
            $.ajax({

                url:'post_task_ajax.php',
                type:'post',
                processData:false,
                contentType: false,
                data:formData, 
                success:function(data){
                    var obj = JSON.parse(data);
                    console.log(obj);
                    if(obj.msg.trim()!='err'){
                    var inhtml = `
                                    <div id="fileId${counter}">
                                        <input name="inputed_files[]" type="hidden" value="${obj.href}"/>
                                        <a href='uploads/${obj.href}' target='_blank'><img width="180px" height="150px" style="padding-right: 10px;padding-bottom-10px;" src='uploads/${obj.msg}'></a>
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
    function postTask()
    {
        var valid = $("#postTaskForm")[0].checkValidity();
        console.log(valid);
        if( valid == true)
        {
            var formData = $("#postTaskForm").serialize();
            $.ajax({

                url:'post_task_ajax.php',
                type:'post',
                post_task:true,
                data:formData, 
                success:function(data){
                    if(data.trim()=='ok'){
                        $("#divForAlert").show();
                        $('#postTaskForm')[0].reset();
                        $('#uploadDiv').html('');
                        $("#all_skills").html('');
                        $(".keywords-list").html('');
                        $(".uploadButton-file-name").html('Images or documents that might be helpful in describing your task')
                        $("#t_category").val([]);
                    }
                },
                error:function(data)
                {
                    alert("Error Occured!");
                }
            })
        }
        else
        {
            alert("Please fill all the details!")
        }
        
    }
    function deleteFile(id,filename) {
        $.ajax({
                url:'post_task_ajax.php',
                type:'post',
                data:{
                    deleteFile:true,
                    filename:filename
                }, 
                success:function(data){
                    var obj = JSON.parse(data);
                        if(obj.msg.trim()=="deleted")
                        {
                            $('#'+id).remove();
                            $("#upload").val('');
                        }
                    }     
                ,
                error:function(data){}
            })

    }
    function addCities()
    {
        var city = $("#location").val();
        var dropdown = $("#cityname")
        dropdown.html(` <option><div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div></option>`);
        var cityHtml = "";
        const settings = {
            "async": true,
            "crossDomain": true,
            "url": "https://wft-geo-db.p.rapidapi.com/v1/geo/cities?limit=10&countryIds=US&namePrefix="+city,
            "method": "GET",
            "headers": {
                "x-rapidapi-key": "1f580689cbmshdd5bea507a565b3p19a00fjsn221be57165d2",
                "x-rapidapi-host": "wft-geo-db.p.rapidapi.com"
            }
        };

        $.ajax(settings).done(function (response) {
            dropdown.html('');
            for(var i=0; i < response.data.length;i++)
            {
                dropdown.append(`<option value=${response.data[i].name}>${response.data[i].name}</option>`)
            }
            // console.log(response.data[0].name);
        });
    }
    $("#dashboard").removeClass('active');
	$("#bookmarks").removeClass('active');
	$("#reviews").removeClass('active');
	$("#jobs").removeClass('active');
	$("#tasks").removeClass('active');
	$("#settings").removeClass('active');
	$("#milestone").removeClass('active');
	$("#tasks").addClass('active');

</script>
