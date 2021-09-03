<?php
require_once 'lib/core.php';

if(isset($_POST['update']))
{

    $m_fname=$_POST['m_fname'];
    $m_lname=$_POST['m_lname'];
    $m_email=$_POST['m_email'];
    $m_ph_no=$_POST['m_ph_no'];
    $m_username=$_POST['m_username'];
    $m_pass=$_POST['m_pass'];
    $USER_ID = $_POST['userid'];
    $sql = "update adm set fir_name='$m_fname', las_name='$m_lname', email='$m_email',ph_no='$m_ph_no',username='$m_username',pass='$m_pass' where u_id='$USER_ID' and adm=00";

    $a_fname=$_POST['a_fname'];
    $a_lname=$_POST['a_lname'];
    $a_email=$_POST['a_email'];
    $a_ph_no=$_POST['a_ph_no'];
    $a_username=$_POST['a_username'];
    $a_pass=$_POST['a_pass'];
    $sqll = "update adm set fir_name='$a_fname', las_name='$a_lname', email='$a_email',ph_no='$a_ph_no',username='$a_username',pass='$a_pass' where u_id='$USER_ID' and adm=01";
    if($conn->query($sql) && $conn->query($sqll))
    {
        echo "updated"; 
    }
    else
    {
        echo $conn->error; 
    }
}

?>