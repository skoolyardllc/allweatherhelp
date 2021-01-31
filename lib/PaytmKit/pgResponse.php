<?php
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");
require_once '../core.php';
// following files need to be included
require_once("./lib/config_paytm.php");
require_once("./lib/encdec_paytm.php");

$paytmChecksum = "";
$paramList = array();
$isValidChecksum = "FALSE";

$paramList = $_POST;
$paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg

//Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application�s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
$isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.
 

if($isValidChecksum == "TRUE") {
	 

	if (isset($_POST) && count($_POST)>0 )
	{ 
        $status = $_POST['STATUS'];
        $txnid = $_POST['TXNID'];
        $order_id = $_POST['ORDERID'];
        $txnAmt = $_POST['TXNAMOUNT'];
        $sql="update transactions set txn_id='$txnid',status='$status' where order_id='$order_id'";
        $conn->query($sql);
        $sql ="select amt,u_id from transactions where order_id='$order_id'";
        $result=$conn->query($sql);
        $TXN_DATA = $result->fetch_assoc();
        $USER_ID = $TXN_DATA['u_id'];
        $amt = $TXN_DATA['amt'];
        if($status=='TXN_SUCCESS' && $amt==$txnAmt)
        {
             
            $sql="select staff_name,id,tawk_api from staff where type=1";
            $result =  $conn->query($sql);
            if($result->num_rows)
            {
                while($row = $result->fetch_assoc())
                {  
                  $staff_detail[$row['id']] = $row; 
                  $sql = "select count(id) as pending from instant_query where status=0 and alloted_to=".$row['id'];
                  $res = $conn->query($sql);
                  $staff_detail[$row['id']]['pending'] = $res->fetch_assoc()['pending'];  
                } 
                usort($staff_detail, function($a, $b) 
                {
                  return $a['pending'] <=> $b['pending'];
                }); 
            }
            $STAFF_ID=$staff_detail[0]['id'];
            $STAFF_TAWK_API = $staff_detail[0]['tawk_api'];
            
            $sql = "insert into instant_query(u_id,alloted_to,status) values($USER_ID,$STAFF_ID,'Pending')";
            if($conn->query($sql))
            {
                $query_id = $conn->insert_id;
            ?>
                <form method="post" action="../../livechat" id="successForm">
                    <input type="hidden" name="tawk_api" value="<?=$STAFF_TAWK_API?>">
                    <input type="hidden" name="query_id" value="<?=$query_id?>"/> 
                </form>
                <script>
                    document.getElementById("successForm").submit();
                </script>
            <?php    
            }
            
            
            foreach($_POST as $paramName => $paramValue) {
				echo "<br/>" . $paramName . " = " . $paramValue;
		    }
        }
		
	}
	

}
else {
	echo "<b>Checksum mismatched.</b>";
	//Process transaction as suspicious.
}

?>