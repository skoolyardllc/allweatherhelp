<?php
    require_once 'header.php';
    require_once 'navbar.php';

    

    // $sql = "select * from skill_tasks where e_id='$USER_ID'";
    // if($result = $conn->query($sql))
    // {
    //     if($result->num_rows)
    //     {
    //         while($row=$result->fetch_assoc())
    //         {
    //             $skills[]=$row;
    //         }
    //     }
    // }


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

    if (isset($_GET['token']) and !empty($_GET['token']))
    {
        $t_id = $conn->real_escape_string($_GET['token']);

        $sql="select pt.*,tc.id as cat_id, tc.type,tc.category from post_task pt,task_category tc where pt.id='$t_id' and tc.id=pt.t_catagory";
        if($result = $conn->query($sql))
        {
            // echo "d";
            if($result->num_rows)
            {
                // echo $t_id;
                $row=$result->fetch_assoc();
                $etaskDetails=$row;
            }
        }


        $sql = "select * from skill_tasks where t_id='$t_id'";
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

        $sql = "select * from uploaded_documents where t_id='$t_id'";
        if($result = $conn->query($sql))
        {
            if($result->num_rows)
            {
                while($row=$result->fetch_assoc())
                {
                    $documents[]=$row;
                }
            }
        }
    
        if(isset($_POST['edit_task'])){
            $t_name = $conn->real_escape_string($_POST['t_name']);
            $t_catagoryNtype = explode("@",$conn->real_escape_string($_POST['t_catagory']));            
            $location = $conn->real_escape_string($_POST['location']);
            $min_salary = $conn->real_escape_string($_POST['min_salary']);
            $max_salary = $conn->real_escape_string($_POST['max_salary']);
            $t_description = $conn->real_escape_string($_POST['t_description']);
            $radio_price = $_POST['radio_price'];
            $inputed_skills = $_POST['inputed_skills'];
            $inputed_files =$_POST['inputed_files'];
            $task_category = $t_catagoryNtype[0];
            $task_type_cat = $t_catagoryNtype[1];
            // print_r($t_catagoryNtype);
            // echo $_POST['t_catagory'];
            $end_date = date('Y-m-d', strtotime($_REQUEST['end_date']));
            // $sql="insert into post_task (e_id,t_name,t_catagory,location,min_salary,max_salary,t_description,end_date,pay_type)
            //  values('$USER_ID','$t_name','$t_catagory','$location','$min_salary','$max_salary','$t_description','$end_date','$radio_price')"; 
            
            $sql="update post_task set e_id='$USER_ID',t_name='$t_name',t_catagory='$task_category',cat_type='$task_type_cat',location='$location',min_salary='$min_salary',
            max_salary='$max_salary',t_description='$t_description',end_date='$end_date',pay_type='$radio_price' where id='$t_id'"; 
            // echo $insertId="SELECT @update_id";
            if($conn->query($sql))
            {
                // $insertId = $conn->insert_id;
                
                $sql = "insert into skill_tasks (t_id,skills) values"; 
                foreach($inputed_skills as $inputed_skill)
                {
                    $sql .= "('$t_id','$inputed_skill'),";
                }
                $sql = rtrim($sql,",");
                if($conn->query($sql))
                {
                    $task_posted =true;
                } 

                $sql = "insert into uploaded_documents (t_id,document) values"; 
                foreach($inputed_files as $inputed_file)
                {
                    $sql .= "('$t_id','$inputed_file'),";
                }
                $sql = rtrim($sql,",");
                if($conn->query($sql))
                {
                    $task_posted =true;
                }
                $updated="Task Updated Successfully!!";

            }
            else{
                $error =$conn->error;
            }
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
                        <h3>Edit task </h3>

                        <!-- Breadcrumbs -->
                        <nav id="breadcrumbs" class="dark">
                            <ul>
                                <li><a href="home">Home</a></li>
                                <li><a href="dashboard">Dashboard</a></li>
                                <li>Edit a Task</li>

                            </ul>
                        </nav>
                    </div>

                    <?php
                        if(isset($updated)){
                            ?>
                                <div class="alert alert-success" role="alert">
                                    <?=$updated?>!!
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
                                    <h3><i class="icon-feather-folder-plus"></i> Task Edit Form</h3>
                                </div>

                                <div class="content with-padding padding-bottom-10">
                                    <div class="row">

                                        <div class="col-xl-6">
                                            <div class="submit-field">
                                                <h5>Project Name</h5>
                                                <input type="text" name="t_name" value="<?=$etaskDetails['t_name']?>" class="with-border" placeholder="e.g. build me a website">
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="submit-field">
                                                <h5>Category</h5>
                                                <select name="t_catagory" class="selectpicker with-border" data-size="7" title="Select Category" required>
                                                <?php

                                                
                                                    foreach ($taskCategories as $cat)
                                                    {
                                                        $select = '';
                                                        if($etaskDetails['cat_id'] == $cat['id'])
                                                        {
                                                            $select = 'selected';
                                                        }
                                                ?>
                                                        <option value="<?=$cat['id']?>@<?=$cat['type']?>" <?=$select?>><?=$cat['category']?></option>
                                                        
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
                                                    <input value="<?=$etaskDetails['end_date']?>" type="date" id="end_date" name="end_date" >
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
                                                        <input name="location" value="<?=$etaskDetails['location']?>" id="" class="with-border" type="text" placeholder="Anywhere">
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
                                                    <div class="keywords-list">
                                                    <?php
                                                        foreach($skills as $skill)
                                                        {
                                                        ?>
                                                        <span class="keyword"><span onclick="delete_skill(<?=$skill['id']?>)" class="keyword-remove"></span><span class="keyword-text"><?=$skill['skills']?></span></span>
                                                        <?php
                                                        }
                                                    ?>
                                                    </div>
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
                                                            <input value="<?=$etaskDetails['min_salary']?>" name="min_salary" class="with-border" type="text" placeholder="Minimum">
                                                            <i class="currency">USD</i>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <div class="input-with-icon">
                                                            <input value="<?=$etaskDetails['max_salary']?>" name="max_salary" class="with-border" type="text" placeholder="Maximum">
                                                            <i class="currency">USD</i>
                                                        </div>
                                                    </div>
                                                </div>

                                                <?php
                                                    $fix_price='';
                                                    $hourly_price='';
                                                    $type=$etaskDetails['pay_type'];
                                                    switch($type){
                                                        case 1:
                                                            $fix_price="checked";
                                                            break;
                                                        case 2:
                                                            $hourly_price="checked";
                                                            break;
                                                    }
                                                ?>
                                                <div class="feedback-yes-no margin-top-0">
                                                    <div class="radio">
                                                        <input id="radio-1" name="radio_price" <?=$fix_price?> type="radio" value="1">
                                                        <label for="radio-1"><span class="radio-label"></span> Fixed Price Project</label>
                                                    </div>

                                                    <div class="radio">
                                                        <input id="radio-2" name="radio_price" <?=$hourly_price?> type="radio" value="2">
                                                        <label for="radio-2"><span class="radio-label"></span> Hourly Project</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        
                                        
                                        
                                        <div class="col-xl-12">
                                            <div class="submit-field">
                                                <h5>Describe Your Project</h5>
                                                <textarea name="t_description" cols="30" rows="5" class="with-border"><?=$etaskDetails['t_description']?></textarea>
                                                <div class="uploadButton margin-top-30">
                                                    <input class="uploadButton-input" type="file" accept="image/*, application/pdf" id="upload" multiple/>
                                                    <label class="uploadButton-button ripple-effect" for="upload">Upload Files</label>
                                                    <span class="uploadButton-file-name">Images or documents that might be helpful in describing your project</span>
                                                </div>
                                               

                                                <div id="file_image">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="uploadDiv">
                                        <?php
                                                    foreach($documents as $document)
                                                    {
                                                    ?>
                                                    <!-- <span class="keyword"><span onclick="delete_document(<?=$document['id']?>)" class="keyword-remove"></span><span class="keyword-text"><?=$document['document']?></span></span> -->
                                                    <div>
                                                        <img width="180px" height="150px" style="padding-right: 10px;padding-bottom-10px;" src='uploads/<?=$document['document']?>'>
                                                        <button type="button" class="btn btn-danger" onclick="deleteFile(<?=$document['id']?>,<?=$document['document']?>)"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                    </div>
                                                    <?php
                                                    }
                                                ?>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-12">
                            <button name="edit_task" class="button ripple-effect big margin-top-30"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit Task</a>
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

    // $("#t_name").val($("#et_name").html());

    var counter=0;
    var i=0;
    function add_skills() {
        inputed_skills = $("#inputed_skills").val();
        var inhtml = `<input name="inputed_skills[]" id="del${i}" type="hidden" value="${inputed_skills}"/>`;
        $("#all_skills").append(inhtml); 
        i++;
    }

    var bid_id = $("#ebid_id").val();

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
                    if(obj.msg.trim()!='err'){
                    var inhtml = `
                                    <div id="fileId${counter}">
                                        <input name="inputed_files[]" type="hidden" value="${obj.msg}"/>
                                        <img width="180px" height="150px" style="padding-right: 10px;padding-bottom-10px;" src='uploads/${obj.msg}'>
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

    function delete_skill(skill) {
        $.ajax({
            url:"post_task_edit_ajax.php",
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
    
</script>
