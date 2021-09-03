<?php

    require_once 'header.php';

    // require_once 'navbar.php';

    

    $aajkadin = date("Y-m-d");

    $sql="SELECT * from post_task where end_date >= '$aajkadin' ORDER BY id DESC";

    $categoryDisplay = "";

    // $sql="select pt.*,sk.* from post_task pt,skill_tasks sk,bidding b where pt.id=sk.t_id";

    if(isset($_GET['category']) && !empty($_GET['category']))

    {

        $categoryToShow = $_GET['category'];

        // echo $categoryToShow;

        switch($categoryToShow)

        {

            case 1:

                $categoryDisplay = "For Grass Cutting";

                break;

            case 2:

                $categoryDisplay = "For Snow Shoveling";

                break;

            case 3:

                $categoryDisplay = "For Snow Plowing";

                break;

            case 4:

                $categoryDisplay = "For Junk Removal";

                break;

            case 5:

                $categoryDisplay = "For Tree Removal";

                break;

            case 6:

                $categoryDisplay = "For Water Restoration";

                break;

            case 7:

                $categoryDisplay = "For Vehicle Towing";

                break;

        }

        $sql="SELECT * from post_task where end_date >= '$aajkadin' and t_catagory=$categoryToShow ORDER BY id DESC";

        $query = "SELECT count(id) as noOfRows from post_task where end_date >= '$aajkadin' and t_catagory=$categoryToShow";

        if($TYPE = 3)

        {

            $query = "SELECT count(id) as noOfRows from post_task where cat_type=1 and t_catagory=$categoryToShow and end_date >= '$aajkadin' ";

        }

        else

        {

            $query = "SELECT count(id) as noOfRows from post_task where  end_date >= '$aajkadin' and t_catagory=$categoryToShow";

        }

    }

    else

    {

        if($TYPE = 3)

        {

            $query = "SELECT count(id) as noOfRows from post_task where cat_type=1 and end_date >= '$aajkadin' ";

        }

        else

        {

            $query = "SELECT count(id) as noOfRows from post_task where end_date >= '$aajkadin' ";

        }

    }

    // echo $query;

        if($res = $conn->query($query))

        {

            $noofresults = $res->fetch_assoc();

        }

        else

        {

            $error = $conn->error;

        }

        $noofresults['noOfRows'];

        $results_per_page = 10;  

        $number_of_page = ceil ($noofresults['noOfRows'] / $results_per_page);

        if(isset($_GET['page'])&& !empty($_GET['page']))

        {

            $page = $_GET['page'];

        }

        else

        {

            $page = 1;

        }

        $page_first_result = ($page-1) * $results_per_page;

        

  

        if($TYPE = 3)

        {

            if(isset($_GET['category']))

            {

                $sql="select * from post_task where cat_type=1 and t_catagory=$categoryToShow  and end_date >= '$aajkadin' order by id desc limit $page_first_result , $results_per_page";

            }

            else

            {

                $sql="select * from post_task where cat_type=1  and end_date >= '$aajkadin' order by id desc limit $page_first_result , $results_per_page";

            }

        }

        else if($TYPE == 2)

        {

            if(isset($_GET['category']))

            {

                $sql="select * from post_task where  t_catagory=$categoryToShow  and end_date >= '$aajkadin' order by id desc limit $page_first_result , $results_per_page";

            }

            else

            {

                $sql="select * from post_task where  end_date >= '$aajkadin' order by id desc limit $page_first_result , $results_per_page";

            }

        }

    // echo $sql ;

    if($result =$conn->query($sql))

    {

        $insertId = $conn->insert_id;

        if($result->num_rows)

        {

            while($row=$result->fetch_assoc())

            {

                $taskDetails[$row["id"]] = $row;

                $sql = "select * from skill_tasks where t_id=".$row["id"];

                if($res =$conn->query($sql))

                {

                    if($res->num_rows)

                    {

                        while($row1=$res->fetch_assoc())

                        {

                            $taskDetails[$row["id"]]["skills"][] = $row1;

                        }

                    }

                }

            }

        } 

    }

    else

    {

        $error =  $conn->error;

    }



    



        switch ($TYPE)

        {

            case 3:

                $sql="select distinct(s.skills) as skill from skill_tasks s ,post_task p where p.id=s.t_id and p.cat_type = 1"; 

                break;



            default :

                $sql="select distinct(skills) as skill from skill_tasks"; 

                break;

                

        }

    if($result =$conn->query($sql))

    {

        if($result->num_rows)

        {

            while($row=$result->fetch_assoc())

            {

                // $id=$row['t_id'];

                // if($TYPE!=3)

                // {

                //      $sq = "select pt.cat_type from post_task pt where id='8'";

                //     if($resulthai=$conn->query($sq))

                //     {

                //         while($ro = $resulthai->fetch_assoc())

                //         {

                //             $data[] = $ro;

                //             if($data['cat_type'] == 1)

                //             {

                //                 $skills[] = $row;

                //             }

                //         }

                        

                //     }

                // }

                // else

                // { 

                    $skills[] = $row;

                // }

                

                

            }

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

    else

    {

        echo $conn->error;

    }

?>

<?php

    require_once 'navbar.php';

?>

<div id="wrapper" >



    <!-- Header Container

================================================== -->



    <!-- Header Container / End -->

    





    <!-- Spacer -->

    <!-- <div class="margin-top-90"></div> -->

    <!-- Spacer / End-->

   

    <!-- Page Content

================================================== -->

    <div class="container" >

        <div class="row" style="margin-top:40px">

            <div class="col-xl-3 col-lg-4">

                <div class="sidebar-container">



                    <!-- Location -->

                    <div class="sidebar-widget">

                        <h3>Location</h3>

                        <div class="input-with-icon">

                            <div id="autocomplete-container">

                                <!-- <input id="location-input" type="text" placeholder="Location"> -->

                                <input name="location" id="location-input" oninput="addCities()" class="with-border" type="text" placeholder="Anywhere" list="cityname" required  >

                                <datalist id="cityname">



                                </datalist>

                            </div>

                            <i class="icon-material-outline-location-on"></i>

                        </div>

                    </div>



                    <!-- Category -->

                    <div class="sidebar-widget">

                        <h3>Category</h3>

                        <select id="catagory" class="selectpicker default" multiple data-selected-text-format="count" data-size="7"

                            title="All Categories">

                            <?php

                                                    foreach ($taskCategories as $cat)

                                                    {

                                                ?>

                                                

                                                        <option value="<?=$cat['id']?>"><?=$cat['category']?></option>

                                                        

                                                <?php

                                                    }

                                                ?> 

                        </select>

                    </div>



                    <!-- Budget -->

                    <div class="sidebar-widget">

                        <h3>Minimum Price</h3>

                        <div class="margin-top-20"></div>



                        <div class="bidding-field">

                            <!-- Quantity Buttons -->

                            <div class="qtyButtons with-border">

                                <div class="qtyDec"></div>

                                <input type="text" name="min_price" id="min_price" value="0">

                                <!-- <input type="hidden" id="etime_no" name="etime_no" class="form-control"> -->

                                <div class="qtyInc"></div>

                            </div>

                        </div>

                    </div>



                    <!-- Hourly Rate -->

                    <div class="sidebar-widget">

                        <h3>Maximum Price</h3>

                        <div class="margin-top-20"></div>



                        <!-- Range Slider -->

                        <div class="bidding-field">

                            <!-- Quantity Buttons -->

                            <div class="qtyButtons with-border">

                                <div class="qtyDec"></div>

                                <input type="text" name="max_price" id="max_price" placeholder="eg. 3" value="0">

                                <!-- <input type="hidden" id="etime_no" name="etime_no" class="form-control"> -->

                                <div class="qtyInc"></div>

                            </div>

                        </div>

                    </div>



                    <!-- Tags -->

                    <div class="sidebar-widget">

                        <h3>Skills</h3>



                        <div class="tags-container">

                            <?php

                                $i=0;

                                foreach ($skills as $skill){

                                    ?>

                                    <div class="tag">

                                    <input type="checkbox" value="<?=$skill['skill']?>" id="tag<?=$i?>"/>

                                    <label for="tag<?=$i?>"><?=$skill['skill']?></label>

                            </div>

                                <?php  

                                    $i++;  

                                }

                                ?>

                        </div>

                        <div class="clearfix"></div>



                        <!-- More Skills -->

                        <div class="keywords-container margin-top-20">

                            <div class="keyword-input-container">

                                <input id="add_skills" type="text" class="keyword-input" placeholder="add more skills" />

                                <button class="keyword-input-button ripple-effect"><i

                                        class="icon-material-outline-add"></i></button>

                            </div>

                            <div class="keywords-list">

                                <!-- keywords go here -->

                            </div>

                            <div class="clearfix"></div>

                        </div>



                        

                    </div>

                    <div class="clearfix"></div>

                    <button class="btn btn-primary"  style="background-color:#2a41e8;border-color:#2a41e8;width:100%" onclick="sortResults(1)">Search</button>

                </div>

            </div>

            <div class="col-xl-9 col-lg-8 content-left-offset">



                <div class="row">

                    <div class="col-lg-9">

                    <h3 class="page-title">Search Results <?=$categoryDisplay?></h3>

                    </div>

                    <div class="col-lg-3">

                        <button class="btn btn-primary" id="clearSearch"  style="display:none;background-color:#2a41e8;border-color:#2a41e8;width:100%" onclick="clearSearch()">Clear Search</button>

                    </div>

                </div>



                <!-- <div class="notify-box margin-top-15">

                    <div class="switch-container">

                        <label class="switch"><input type="checkbox"><span class="switch-button"></span><span

                                class="switch-text">Turn on email alerts for this search</span></label>

                    </div>



                    <div class="sort-by">

                        <span>Sort by:</span>

                        <select class="selectpicker hide-tick">

                            <option>Relevance</option>

                            <option>Newest</option>

                            <option>Oldest</option>

                            <option>Random</option>

                        </select>

                    </div>

                </div> -->



                <!-- Tasks Container -->

                <div class="tasks-list-container compact-list margin-top-35" id="sorted_div1"></div>

                <div class="tasks-list-container compact-list margin-top-35" id="sorted_div">

                    <?php

                    $counter=0;

                    foreach($taskDetails as $taskDetail)

                    {   

                        $counter++;

                    ?>

                    <!-- Task -->

                    <a href="bid_task?token=<?=$taskDetail['id']?>" class="task-listing">



                        <!-- Job Listing Details -->

                        <div class="task-listing-details">



                            <!-- Details -->

                            <div class="task-listing-description">

                                <h3 class="task-listing-title"><?=$taskDetail['t_name']?></h3>

                                <ul class="task-icons">

                                    <?php

                                        $date = date('Y-m-d H:i:s');

                                        $presentTime = new DateTime($date);

                                        $postedTime =new DateTime($taskDetail['time_stamp']);

                                        $interval = $postedTime->diff($presentTime);

                                    ?>

                                    <li><i class="icon-material-outline-location-on"></i> <?=$taskDetail['location']?>

                                    </li>

                                    <li><i class="icon-material-outline-access-time"></i>

                                        <?php echo $interval->format('%d days %H hours %i minutes')?> ago</li>

                                </ul>

                                <p class="task-listing-text"><?=$taskDetail['t_description']?></p>

                                <div class="task-tags">

                                    <input type="hidden" value="<?=$taskDetail['id']?>" id="t_id<?=$counter?>">

                                    <?php
                                    if(isset($taskDetail['skills']))
                                    {
                                        foreach($taskDetail['skills'] as $skillDetail)

                                        {

                                    ?>

                                    <span><?=$skillDetail['skills'] ?></span>

                                    <?php

                                        }
                                    }
                                        ?>

                                </div>

                            </div>



                        </div>



                        <div class="task-listing-bid">

                            <div class="task-listing-bid-inner">

                                <div class="task-offers">

                                    <?php

                                        $pay_type='';

                                        $type=$taskDetail['pay_type']; 

                                        switch ($type){

                                            case 1:

                                                $pay_type="Fixed hours";

                                                break;

                                            case 2:

                                                $pay_type = "Hourly rate";

                                                break;

                                        }

                                    ?>

                                    <strong>$<?=$taskDetail['min_salary']?> - $<?=$taskDetail['max_salary']?></strong>

                                    <span><?=$pay_type?></span>

                                </div>

                                <span class="button button-sliding-icon ripple-effect">Bid Now <i

                                        class="icon-material-outline-arrow-right-alt"></i></span>

                            </div>

                        </div>

                    </a>

                    <?php

                    }

                    ?>



                </div>

                <!-- Tasks Container / End -->





                <!-- Pagination -->

                <div class="clearfix"></div>

                <div class="row" >

                    <div class="col-md-12">

                        <!-- Pagination -->

                        <div class="pagination-container margin-top-60 margin-bottom-60">

                            <nav class="pagination" >

                                <ul id="buttonsForPagination">

                                    <?php
                                    if(isset($page))
                                    {
                                        for($page = 1; $page <= $number_of_page; $page++) 

                                        {  

                                            $active = "";

                                            $href = "";

                                            if(isset($_GET['page']) && $page == $_GET['page'] )

                                            {

                                                $active = "current-page";

                                            }

                                            else if(!isset($_GET['page']) && $page == 1)

                                            {

                                                $active = "current-page";

                                            }

                                            else

                                            {

                                                $active = "";

                                            }

                                            if(isset($_GET['category']))

                                            {

                                                $categoryShown = $_GET['category'];

                                                $href="search_task?category=$categoryShown&page=$page";

                                            }

                                            else

                                            {

                                                $href = "search_task?page=$page";

                                            }

                                            ?>

                                                <li><a href="<?=$href?>" class="<?=$active?> ripple-effect"><?=$page?></a></li>

                                            <?php

                                        

                                        }  

                                    }

                                    ?>

                                        <!-- <li class="pagination-arrow"><a href="#" class="ripple-effect"><i class="icon-material-outline-keyboard-arrow-left"></i></a></li>

                                        <li><a href="#" class="ripple-effect">1</a></li>

                                        <li><a href="#" class="current-page ripple-effect">2</a></li>

                                        <li><a href="#" class="ripple-effect">3</a></li>

                                        <li><a href="#" class="ripple-effect">4</a></li>

                                        <li class="pagination-arrow"><a href="#" class="ripple-effect"><i class="icon-material-outline-keyboard-arrow-right"></i></a></li> -->

                                </ul>

                                <ul id="ajaxButtons"></ul>

                            </nav>

                        </div>

                    </div>

                </div>

                <!-- Pagination / End -->



            </div>

        </div>

    </div>



    <?php

    require_once 'footer.php';

?>





</div>

<!-- Wrapper / End -->





<?php

    require_once 'js-links.php';

?>



<script>



// var t_id = $("#t_id" + counter).val();

// $("#t_id").val(t_id);

function addCities()

    {

        var city = $("#location-input").val();

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

    function clearSearch()

    {

        $("#clearSearch").hide();

        $("#sorted_div").show();

        $("#buttonsForPagination").hide();

        $("#sorted_div1").empty();

    }



 function sortResults(page) {

    var location= $("#location-input").val();

    var min_price= $("#min_price").val();

    var max_price= $("#max_price").val();

    var add_skills =[];

        $("input[type=checkbox]:checked").each(function()

        {

            add_skills.push($(this).val());

        })

    var catagories=[];

        console.log($('li[class=selected]>a>span.text').length)

        $("#catagory").siblings().find('a[aria-selected=true]>span.text').each(function()

        {

            catagories.push($(this).html());

        })

        console.log(catagories);

    $.ajax({

        url: "search_task_ajax.php",

        type: "post",

        data: {

            location: location,

            min_price: min_price,

            max_price: max_price,

            add_skills: JSON.stringify(add_skills),

            catagories: JSON.stringify(catagories),

            sorting_changes :true,

            userType : '<?=$TYPE?>',

            page:page,

        },

        success: function(data) {

            console.log(data);

            var obj = JSON.parse(data);

            if(obj.msg.trim()=='success'){

                $("#clearSearch").show();

                $("#sorted_div").hide();

                $("#sorted_div1").empty();

                $("#sorted_div1").append(obj.inhtml);

                $("#buttonsForPagination").hide();

                $("#ajaxButtons").html(obj.pages)

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

	$("#tasks").addClass('active');





</script>