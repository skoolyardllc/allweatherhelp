<?php



require_once 'header.php';

require_once 'navbar.php';





$sql = "select count(u.id) as noOfRows from users u , user_profile up where u.id = up.u_id and (u.type = 3 or u.type=2) and up.f_name !=''";

if($res = $conn->query($sql))

{

    $noofresults = $res->fetch_assoc();

}

else

{

    $error =  $conn->query($sql);

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







$sql = "select u.*,up.u_id as u_id , up.* from users u , user_profile up where u.id = up.u_id and (u.type = 3 or u.type=2) and up.f_name !='' order by u.id asc limit $page_first_result , $results_per_page";





if($result = $conn->query($sql))

{

    // echo "hello";

    while($row=$result->fetch_assoc())

    {

        $thekedar[] = $row;

        // $id = $thekedar['u_id'];

        

    }

    // print_r($thekedar);

    

}

else

{

    echo $conn->error;

}



?>



<div id="wrapper">



<!-- Header Container

================================================== -->

   

    <!-- Header Container / End -->



    <!-- Spacer -->

    <div class="margin-top-90"></div>

    <!-- Spacer / End-->



    <!-- Page Content

    ================================================== -->

    <div class="container">

        <div class="row">

            <div class="col-xl-1 col-lg-3">

                <div class="sidebar-container">

                    

                    <!-- Location -->

                    <!-- <div class="sidebar-widget">

                        <h3>Location</h3>

                        <div class="input-with-icon">

                            <div id="autocomplete-container">

                                <input id="autocomplete-input" type="text" placeholder="Location">

                            </div>

                            <i class="icon-material-outline-location-on"></i>

                        </div>

                    </div> -->



                    <!-- Category -->

                    <!-- <div class="sidebar-widget">

                        <h3>Category</h3>

                        <select class="selectpicker default" multiple data-selected-text-format="count" data-size="7" title="All Categories" >

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

                    </div> -->



                    <!-- Keywords -->

                    <!-- <div class="sidebar-widget">

                        <h3>Keywords</h3>

                        <div class="keywords-container">

                            <div class="keyword-input-container">

                                <input type="text" class="keyword-input" placeholder="e.g. task title"/>

                                <button class="keyword-input-button ripple-effect"><i class="icon-material-outline-add"></i></button>

                            </div>

                            <div class="keywords-list"></div>

                            <!-- <div class="clearfix"></div>

                        </div> -->

                    



                    <!-- Hourly Rate -->

                    <!-- <div class="sidebar-widget">

                        <h3>Hourly Rate</h3>

                        <div class="margin-top-55"></div>



                        Range Slider -->

                        <!-- <input class="range-slider" type="text" value="" data-slider-currency="$" data-slider-min="10" data-slider-max="250" data-slider-step="5" data-slider-value="[10,250]"/>

                    </div> -->



                    <!-- Tags -->

                    <!-- <div class="sidebar-widget">

                        <h3>Skills</h3>



                        <div class="tags-container">

                            <div class="tag">

                                <input type="checkbox" id="tag1"/>

                                <label for="tag1">front-end dev</label>

                            </div>

                            <div class="tag">

                                <input type="checkbox" id="tag2"/>

                                <label for="tag2">angular</label>

                            </div>

                            <div class="tag">

                                <input type="checkbox" id="tag3"/>

                                <label for="tag3">react</label>

                            </div>

                            <div class="tag">

                                <input type="checkbox" id="tag4"/>

                                <label for="tag4">vue js</label>

                            </div>

                            <div class="tag">

                                <input type="checkbox" id="tag5"/>

                                <label for="tag5">web apps</label>

                            </div>

                            <div class="tag">

                                <input type="checkbox" id="tag6"/>

                                <label for="tag6">design</label>

                            </div>

                            <div class="tag">

                                <input type="checkbox" id="tag7"/>

                                <label for="tag7">wordpress</label>

                            </div>

                        </div>

                        <div class="clearfix"></div>



                        

                        <div class="keywords-container margin-top-20">

                            <div class="keyword-input-container">

                                <input type="text" class="keyword-input" placeholder="add more skills"/>

                                <button class="keyword-input-button ripple-effect"><i class="icon-material-outline-add"></i></button>

                            </div>

                            <div class="keywords-list"></div>

                            <div class="clearfix"></div>

                        </div>

                    </div> -->

                    <div class="clearfix"></div>



                </div>

            </div>

            <div class="col-xl-11 col-lg-8 content-left-offset">



                <h3 class="page-title">Contractors & Business / LLC</h3>



                

                

                <!-- Freelancers List Container -->

                <div class="freelancers-container freelancers-list-layout compact-list margin-top-35">

                    

                <?php

                    if(isset($thekedar))

                    {

                        foreach($thekedar as $tk)

                        {

                            $id = $tk['u_id'];

							$sql = "SELECT CAST(AVG(rating) AS DECIMAL(10,1)) as hell FROM ratings where u_id = $id";

							if($resu = $conn->query($sql))

							{

							    if($resu->num_rows)

							    {

							        $row = $resu->fetch_assoc();

							        $hell = $row; 

							    }

							}

							else

							{

								echo $conn->error;

							}

                            $bday = '';

                            if($tk['type'] == 2)

                            {

                                $bday = 'Business / LLC';

                            }

                            else

                            {

                                $bday = 'Contractor';

                            }

                            if($tk['f_name'] != NULL)

                            {

                ?>

                    <!--Freelancer -->

                    <div class="freelancer">



                        <!-- Overview -->

                        <div class="freelancer-overview">

                            <div class="freelancer-overview-inner">

                                

                                <!-- Bookmark Icon -->

                                <span class="bookmark-icon"></span>

                                

                                <!-- Avatar -->

                                <div class="freelancer-avatar">

                                    <div class="verified-badge"></div>

                                    <a href="profile?token=<?=$tk['u_id']?>"><img src="<?=$tk['avtar']?>" alt=""></a>

                                </div>



                                <!-- Name -->

                                <div class="freelancer-name">

                                    <h4><a href="#"><?=$tk['f_name']?> <?=$tk['l_name']?></a><img class="flag" src="images/flags/gb.svg" alt="" title="United Kingdom" data-tippy-placement="top"></a></h4>

                                    <span><?=$tk['tagline']?></span>

                                    <br>

                                    <strong><?=$bday?></strong>

                                    <!-- Rating -->

                                    <?php

										if($hell['hell'] == 0)

										{

											?>

												<p><i class="bi bi-star-fill" style="color:gold"></i> No Ratings</p>

											<?php

										}

										else

										{

									?>

										<div class="freelancer-rating">

											<div class="star-rating" data-rating="<?=$hell['hell']?>"></div>

										</div>

									<?php

									

										}

									?>

                                </div>

                            </div>

                        </div>

                        

                        <!-- Details -->

                        <div class="freelancer-details">

                            <div class="freelancer-details-list">

                                <ul>

                                    <!-- <li>Location <strong><i class="icon-material-outline-location-on"></i><?=$tk['address']?></strong></li> -->

                                    <!-- <li>Rate <strong>$60 / hr</strong></li> -->

                                    <!-- <li>Job Success <strong>95%</strong></li> -->

                                </ul>

                            </div>

                            <a href="profile?token=<?=$tk['u_id']?>" class="button button-sliding-icon ripple-effect">View Profile <i class="icon-material-outline-arrow-right-alt"></i></a>

                        </div>

                    </div>

                    <!-- Freelancer / End -->

                    <?php

                            }

                        }

                    }

                                

                    ?>



        

                </div>

                <!-- Freelancers Container / End -->





                <!-- Pagination -->

                <div class="clearfix"></div>

                <div class="row">

                    <div class="col-md-12">

                        <!-- Pagination -->

                        <div class="pagination-container margin-top-40 margin-bottom-60">

                            <nav class="pagination">

                                <ul>

                                <?php

                                    for($page = 1; $page<= $number_of_page; $page++) 

                                    {  

                                        $active = "";

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

                                        ?>

                                            <li><a href="freelancer?page=<?=$page?>" class="<?=$active?> ripple-effect"><?=$page?></a></li>

                                        <?php

                                    

                                    }  

                                

                                ?>

                                    <!-- <li class="pagination-arrow"><a href="#" class="ripple-effect"><i class="icon-material-outline-keyboard-arrow-left"></i></a></li>

                                    <li><a href="#" class="ripple-effect">1</a></li>

                                    <li><a href="#" class="current-page ripple-effect">2</a></li>

                                    <li><a href="#" class="ripple-effect">3</a></li>

                                    <li><a href="#" class="ripple-effect">4</a></li>

                                    <li class="pagination-arrow"><a href="#" class="ripple-effect"><i class="icon-material-outline-keyboard-arrow-right"></i></a></li> -->

                                </ul>

                            </nav>

                        </div>

                    </div>

                </div>

                <!-- Pagination / End -->



            </div>

        </div>

    </div>





    <!-- Footer

    ================================================== -->

  <?php

    require_once 'js-links.php';

    require_once 'footer.php';

  ?>

    <!-- Footer / End -->



