<?php

if(isset($_POST['dashboard']))
{
    $sql="SELECT count(id) as sale,MONTH(time_statmpts) as month FROM orders  GROUP BY MONTH(time_statmpts)";
    $result=$conn->query($sql);
    if($result->num_rows>0){
        while($row=$result->fetch_assoc())
        {
            $graphdata[]=$row;

        }
    }
    echo json_encode($graphdata);
}

?>