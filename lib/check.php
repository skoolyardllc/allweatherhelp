<?php 
    ini_set('max_execution_time', 1000);
    ini_set('display_errors', 1);
    error_reporting(1);

    require 'simple_html_dom.php';

    $context = stream_context_create(
        array(
            "http" => array(
                "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.141 Safari/537.36"
            )
        )
    );
    //for the database
    $servername = "localhost";
    $username = "u7l4vlai6qmfg";
    $password = "g3;2h@11@@g1";
    $dbname = "db80ktw2cjecdc";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    //functions
    function getPageCount($html,$url,$context,$conn)
    {   
        scrap_content($html,1,$url,$context,$conn);
        try
        {
            return  count($html->find(".page-number-navigation > a.page-number-navigation__link-number")); 
        }
        catch(Exception $e)
        {
            echo $e->getMessage(); 
        }catch (Throwable $e) {

           getPageCount($html,$url,$context,$conn);
        }
       
    }
    function get_html_dom($context,$url)
    { 
        return file_get_html($url,false,$context); 
    }
    function scrap_content($html,$count,$url,$context,$conn)
    {
        $element = $html->find('body div#react-root',0);  
        $ele = $element->next_sibling();
        $stringValue = $ele->innertext; 
        $json = substr(trim(str_replace("(function() {window.APP_DATA =","",$stringValue)),0,-6);
        $myfile = fopen("json/p$count.json", "w");
        fwrite($myfile, $json); 
        fclose($myfile);
        if($json)
        {
            $x = json_decode($json);   
            foreach($x->search->results->main as $content)
            {
                save_content($content,$conn);
            }
            return count($x->search->results->main); 
        }
        else
        {
            scrap_content(get_html_dom($context,$url),$count,$url,$context,$conn); 
        }
        
    }
    function save_content($content,$conn)
    {
        $id = $content->id; 
        $title = $conn->real_escape_string($content->title);
        $description =$conn->real_escape_string($content->description);
        $priceText = $conn->real_escape_string($content->priceText);
        $locationArea = $conn->real_escape_string($content->locationArea);
        $locationState = $conn->real_escape_string($content->locationState);
        $age = $content->age;
        
        $sql = "INSERT INTO scrape_data (title, description, priceText, locationArea, locationState,age) values('$title','$description','$priceText','$locationArea','$locationState','$age')";
        if($conn->query($sql))
        {
            $insert = $conn->insert_id;
            $sql = "INSERT into scrape_images(data_id,image) values";
             $x=0;
            foreach($content->extraImageZoomBaseUrls as $images)
            {
                 $img_id = $insert.$id.$x;
                $mainImageUrl = $conn->real_escape_string($images);
                $image = "img/$img_id.webp";
                $target = $mainImageUrl."s-l800.webp"; 
                if(!copy($target,$image))
                {
                    $image = $target;
                }

              $sql .= "($insert,'$image'),";
                $x++;
            }
            $sql = rtrim($sql,",");
            $conn->query($sql);
            
        }

    }
    function scrape_search_items($html,$item)
    {
        $element = $html->find('body div#react-root',0);  
        $ele = $element->next_sibling();
        $stringValue = $ele->innertext; 
        $json = substr(trim(str_replace("(function() {window.APP_DATA =","",$stringValue)),0,-6);
        $x = json_decode($json);    
        switch($item)
        {
            case 'select':
                $categorys = $x->metadata->categories;
                echo json_encode($categorys);
                break;
        }

    }

    //apis for counting number of pages 
    if(isset($_POST['pageCount']))
    {
        $category = $_POST['category'];
        $location = $_POST['location'];
        $key = $_POST['key'];
        $distance = $_POST['distance'];  
        $page = "/page-1";
        if($category!='')
        {
            $category = "/".$category;
        }
        if($location!='')
        {
            $location = "/".$location;
        }
        if($key!='')
        {
            $key = "/".$key;
        }
        if($distance!='')
        {
            $distance = "/".$distance;
        }
        
        $url="https://www.gumtree.com.au$category$location$key$page/k0c18318l3005561$distance";
        try
        {
            $pageCount = getPageCount(get_html_dom($context,$url),$url,$context,$conn);
            if(!$pageCount)
            {
                $pageCount = getPageCount(get_html_dom($context,$url),$url,$context,$conn);
            }
            echo $pageCount; 
        }
        catch(Exception $e)
        {
            echo $e->getMessage(); 
        }catch (Throwable $e) {

            $pageCount = getPageCount(get_html_dom($context,$url),$url,$context,$conn);
            if(!$pageCount)
            {
                $pageCount = getPageCount(get_html_dom($context,$url),$url,$context,$conn);
            }
            echo $pageCount; 
        }
    }
    
    //fetching other page source codes 
    if(isset($_POST['scrape']))
    {
        $category = $_POST['category'];
        $location = $_POST['location'];
        $key = $_POST['key'];
        $distance = $_POST['distance']; 
        $pageCount = $_POST['pageCount'];
        $page = "/page-$pageCount";
        if($category!='')
        {
            $category = "/".$category;
        }
        if($location!='')
        {
            $location = "/".$location;
        }
        if($key!='')
        {
            $key = "/".$key;
        }
        if($distance!='')
        {
            $distance = "/".$distance;
        }
         
        $url="https://www.gumtree.com.au$category$location$key$page/k0c18318l3005561$distance";
        try
        {
            echo scrap_content(get_html_dom($context,$url),$pageCount,$url,$context,$conn); 
        }
        catch(Exception $e)
        {
            echo $e->getMessage(); 
        }catch (Throwable $e) {
            echo scrap_content(get_html_dom($context,$url),$pageCount,$url,$context,$conn); 
        }  
    }



    if(isset($_POST['select']))
    {
        $url="https://www.gumtree.com.au/s-automotive/walloon-ipswich/car/k0c9299l3005561r10"; 
        try
        {
            scrape_search_items(get_html_dom($context,$url),"select");
        }
        catch(Exception $e)
        {
            echo $e->getMessage(); 
        }catch (Throwable $e) {
            scrape_search_items(get_html_dom($context,$url),"select");
        }  
    }
?>