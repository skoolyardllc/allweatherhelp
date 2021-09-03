<?php

require_once "lib/core.php";

if(isset($_POST['add_note']))
{
    $priority=$_POST['priority'];
    $desc=$_POST['desc'];
    $uid=$_POST['uid'];
    $sql="insert into notes(priority, u_id, description) values('$priority', '$uid', '$desc')";
    if($conn->query($sql))
    {
        $sql="select * from notes where u_id='$uid' ORDER BY time_stamp desc limit 3";
        if($result=$conn->query($sql))
        {
            if($result->num_rows)
            {
                while($row=$result->fetch_assoc())
                { 
                    $notes[]=$row;
                }
            }
        }
    }
    else
    {
        return $errorMember=$conn->error;
    }
    echo json_encode($notes);
}

if(isset($_POST['delnote']))
{
    $id=$_POST['delnoteid'];
    $sql="delete from notes where id='$id'";
    if($conn->query($sql))
    {
        return "success";
    }
    else
    {
        return $errorMember=$conn->error;
    }
}

function array_insert_before($key, array &$array, $new_key, $new_value) {
    if (array_key_exists($key, $array)) {
      $new = array();
      foreach ($array as $k => $value) {
        if ($k === $key) {
          $new[$new_key] = $new_value;
        }
        $new[$k] = $value;
      }
      return $new;
    }
    return FALSE;
  }

if(isset($_POST['chartdata']))
{
    $type=$_POST['type'];
    $uid=$_POST['userid'];
    if($type==5)
    {
       $sql="SELECT SUM(amount) as amount, MONTH(timestamp) as mon FROM milestones_payment where status='succeeded' and user_id='$uid' GROUP BY MONTH(timestamp) order by MONTH(timestamp)";
    }
    else if($type==3 || $type==2)
    {
        $sql="SELECT SUM(amount) as amount, MONTH(timestamp) as mon FROM milestones_transaction where status='1' and contractor_id='$uid' GROUP BY MONTH(timestamp) order by MONTH(timestamp)"; 
    }
    if($result=$conn->query($sql))
    {
        $mon=1;
        if($result->num_rows)
        {
            while($row=$result->fetch_assoc())
            { 
                $data['amount'][]=$row['amount'];
                $mon = $row['mon'];
                $data['mon'][]=$row['mon'];
            }
        }

        $key=1;
        $counter=0;
        for($key;$key<=$mon;$key++)
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
    echo json_encode($data);
}

                // switch($row['mon'])
                // {
                //     case 1: $row['mon']="Jan";
                //         break;
                //     case 2: $row['mon']="Feb";
                //         break;
                //     case 3: $row['mon']="Mar";
                //         break;
                //     case 4: $row['mon']="Apr";
                //         break;
                //     case 5: $row['mon']="May";
                //         break;
                //     case 6: $row['mon']="June";
                //         break;
                //     case 7: $row['mon']="July";
                //         break;
                //     case 8: $row['mon']="Aug";
                //         break;
                //     case 9: $row['mon']="Sept";
                //         break;
                //     case 10: $row['mon']="Oct";
                //         break;
                //     case 11: $row['mon']="Nov";
                //         break;
                //     case 12: $row['mon']="Dec";
                //         break;
                // }

?>


               