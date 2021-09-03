<?php

    require_once 'lib/core.php';



    if (isset($_POST['sorting_changes'])){

        $location = $_POST['location'];

        $min_price = $_POST['min_price'];

        $max_price = $_POST['max_price'];

        $add_skills = json_decode($_POST['add_skills']);

        $skills =  "'".implode("','",$add_skills)."'";

        $add_categories = json_decode($_POST['catagories']);

        $category =  "'".implode("','",$add_categories)."'";

        $aajkadin = date("Y-m-d");

        $userType = $_POST['userType'];

        $catagoryquery='';

        $locationquery='';

        $min_pricequery='';

        $max_pricequery='';

        $skillsquery='';



        if(!empty($location))

        {

            $locationquery = " pt.location='$location' and";

        }

        if(!empty($add_categories))

        {

            $catagoryquery = " tc.category in ($category) and";

        }

        if(!empty($min_price))

        {

            $min_pricequery = " pt.min_salary <= '$min_price' and";

        }

        if(!empty($max_price))

        {

            $max_pricequery = " pt.max_salary <= '$max_price' and";

        }

        if(!empty($add_skills))

        {

            $skillsquery = " st.skills in($skills) and";

        }

        if(isset($skillsquery))

        {

            if($userType == '3')

            {

                $sql="select pt.* from post_task pt ,task_category tc where pt.end_date >= '$aajkadin'  and tc.id=pt.t_catagory and pt.cat_type = '1' and$locationquery$catagoryquery$min_pricequery$max_pricequery$skillsquery";

            }

            else

            {

                $sql="select pt.* from post_task pt ,task_category tc where pt.end_date >= '$aajkadin'  and tc.id=pt.t_catagory  and$locationquery$catagoryquery$min_pricequery$max_pricequery$skillsquery";

            }

        }

        else

        {

            if($userType == '3')

            {

                $sql="select pt.* from post_task pt ,task_category tc where pt.end_date >= '$aajkadin'  and tc.id=pt.t_catagory and pt.cat_type = '1' and$locationquery$catagoryquery$min_pricequery$max_pricequery$skillsquery";

            }

            else

            {

                $sql="select pt.* from post_task pt ,task_category tc where pt.end_date >= '$aajkadin'  and tc.id=pt.t_catagory  and$locationquery$catagoryquery$min_pricequery$max_pricequery$skillsquery";

            }

        }

        $ajax_response =[];

        $sql = trim($sql);

        $sql = substr($sql, 0, -3);

        $sql .= " group by pt.id";

        // echo $sql;



        if($resu = $conn->query($sql))

        {

            $insertId = $conn->insert_id;

            $noofRows = $resu->num_rows;

            $results_per_page = 10;  

            $number_of_page = ceil ($noofRows  / $results_per_page);

            if(isset($_POST['page'])&& !empty($_POST['page']))

            {

                $page = $_POST['page'];

            }

            else

            {

                $page = 1;

            }

            $page_first_result = ($page-1) * $results_per_page;

            

            $sql .= " limit $page_first_result , $results_per_page";

            $result = $conn->query($sql);

            if($result->num_rows)

            {

                $inhtml='';

                $noofrows=$result->num_rows;

                for($page = 1; $page<= $number_of_page; $page++) 

                {  

                    $active = "";

                    if(isset($_POST['page']) && $page == $_POST['page'] )

                    {

                        $active = "current-page";

                    }

                    else if(!isset($_POST['page']) && $page == 1)

                    {

                        $active = "current-page";

                    }

                    else

                    {

                        $active = "";

                    }

                    $pagebutton .=	"<li><a href='javascript:;' onclick='sortResults($page)' class='$active ripple-effect'>$page</a></li> &nbsp;";

                

                }  

                $ajax_response['pages'] = $pagebutton;

                while($row=$result->fetch_assoc())

                {

                    $taskDetail = $row;

                    $task_id = $taskDetail["id"];

                    $t_name = $taskDetail["t_name"];

                    $time_stamp = $taskDetail["time_stamp"];

                    $location = $taskDetail["location"]; 

                    $date = date('Y-m-d H:i:s');

                    $presentTime = new DateTime($date);

                    $postedTime =new DateTime($time_stamp);

                    $interval = $postedTime->diff($presentTime);

                    $time = $interval->format('%d days %H hours %i minutes');

                    $pagebutton .=	"<li><a href='javascript:;' onclick='pagination($page)' class='$active ripple-effect'>$page</a></li> &nbsp;";



                    $inhtml .= "<a href=\"bid_task?token=$task_id\" class=\"task-listing\">



                    <!-- Job Listing Details -->

                    <div class=\"task-listing-details\">



                        <!-- Details -->

                        <div class=\"task-listing-description\">

                            <h3 class=\"task-listing-title\">$t_name</h3>

                            <ul class=\"task-icons\">

                                

                                    

                                

                                <li><i class=\"icon-material-outline-location-on\"></i>$location

                                </li>

                                <li><i class=\"icon-material-outline-access-time\"></i>

                                $time ago</li>

                            </ul>

                            <p class=\"task-listing-text\">Leverage agile frameworks to provide a robust synopsis for

                                high level overviews. Iterative approaches to corporate strategy foster.</p>

                            <div class=\"task-tags\">

                                <input type=\"hidden\" value=\"$task_id\" id=\"t_id$counter\">";



                    $taskDetails[$row["id"]] = $row;

                      $sql = "select * from skill_tasks where t_id=".$row["id"];

                    if($res =$conn->query($sql))

                    {

                        if($res->num_rows)

                        {

                            while($row1=$res->fetch_assoc())

                            {

                                

                                  $skill = $row1['skills'];

                                $inhtml .=" <span>$skill</span>";



                            }

                        }

                    }

                      $inhtml .="  </div>

                      </div>



                  </div>



                  <div class=\"task-listing-bid\">

                      <div class=\"task-listing-bid-inner\">

                          <div class=\"task-offers\">";

                               

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

                              

                              $t_minSallary=$taskDetail['min_salary'];

                              $t_maxSallary=$taskDetail['max_salary'];    

                              $inhtml .="<strong>$$t_minSallary- $$t_maxSallary</strong>

                              <span>$pay_type</span>

                          </div>

                          <span class=\"button button-sliding-icon ripple-effect\">Bid Now <i

                                  class=\"icon-material-outline-arrow-right-alt\"></i></span>

                      </div>

                  </div>

              </a>"  ;



                }

            } 

            

            $ajax_response['msg']='success';

            $ajax_response['rows']=$noofrows;

            $ajax_response['inhtml']=$inhtml;



            

         

            

        }else

        {

            $ajax_response['msg']='error';

            $ajax_response['error']=$conn->error;



        }

        



        echo json_encode($ajax_response);

            

    }



?>