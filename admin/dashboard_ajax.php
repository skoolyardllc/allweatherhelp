<?php

    require_once '../lib/core.php';

    if(isset($_GET['transaction_graph']))
    {
        $response=[];
        $response['msg'] = "ok";
        $sql = "SELECT count(m.id) as amount,month(m.timestamp) as mon from milestones_payment m where m.status='succeeded' GROUP BY month(m.timestamp)";
        if($result=$conn->query($sql))
        {
            $mon=1;
            if($result->num_rows > 0)
            {
                while($row=$result->fetch_assoc())
                { 
                    $data['msg'] = "ok";
                    $data['amount'][]=$row['amount'];
                    $mon = $row['mon'];
                    $data['mon'][]=$row['mon'];
                }
            }
            $key=1;
            $counter=0;
            if(isset($data))
            {
                for($key;$key <= $mon;$key++)
                {
                    if(!in_array("$key",$data['mon']))
                    {
                        // array_unshift($data['amount'],0);
                        // array_insert_before($key,$data['amount'], $key, 0);
                        $data['amount_new'][]=0;
                    } else
                    {
                        $data['amount_new'][]=$data['amount'][$counter];
                        $counter++;
                
                    }
                }
            }
            else
            {
                $data['msg'] = "nothingFound";
            }
            $data['sql'] = $sql;


        }
        else
        {
            echo $conn->error;
        }
        echo json_encode($data);
    }
    
    if(isset($_GET['tasks_graph']))
    {
        $response = [];
        $response['msg'] = "err";
        $sql = "SELECT count(pt.id) as amount,month(pt.time_stamp) as mon from post_task pt GROUP BY month(pt.time_stamp)";
        if($result=$conn->query($sql))
        {
            $mon=1;
            if($result->num_rows > 0)
            {
                while($row=$result->fetch_assoc())
                { 
                    $data['msg'] = "ok";
                    $data['amount'][]=$row['amount'];
                    $mon = $row['mon'];
                    $data['mon'][]=$row['mon'];
                }
            }
            $key=1;
            $counter=0;
            if(isset($data))
            {
                for($key;$key <= $mon;$key++)
                {
                    if(!in_array("$key",$data['mon']))
                    {
                        // array_unshift($data['amount'],0);
                        // array_insert_before($key,$data['amount'], $key, 0);
                        $data['amount_new'][]=0;
                    } else
                    {
                        $data['amount_new'][]=$data['amount'][$counter];
                        $counter++;
                
                    }
                }
            }
            else
            {
                $data['msg'] = "nothingFound";
            }
            $data['sql'] = $sql;


        }
        else
        {
            echo $conn->error;
        }
        echo json_encode($data);
        
    }
    

?>