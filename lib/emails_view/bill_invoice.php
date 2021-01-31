<?php
    require_once '../core.php';
    if(isset($_POST["order_id"]))
        $order_id=$_POST["order_id"];
?>
<html>
<body>
<br/><br/><br/><br/>
	
<?php

		
		$sql="select o.order_amount,o.time_statmpts,up.f_name,up.l_name,c.email from orders as o, users as c,user_profiles as up where o.id=$order_id and c.id=o.u_id AND up.u_id = o.u_id";
		$res=$conn->query($sql);
		$details=$res->fetch_assoc();
		if(isset($details))
		{
            $time=strtotime($details['time_statmpts']);
            $time=strftime("%d %B ,%Y",$time);
?>
	
	<tr>
		Name: <?=$details['f_name']." ".$details['l_name'];?>
        <br>
		Email: <?=$details['email'];?><br>
		Date: <?=$time;?><br>
<table align="center" border="1" width="80%">
	<tr>
		<td> Name</td>
		<td>Price</td>
		<td> Quantity</td>
		<td>Amount</td>
	</tr>
<?php			
		}
		$sql="select * from products as p where p.id in(select distinct(p_id) from order_items where o_id=$order_id)";
		$res=$conn->query($sql);
		while($row=$res->fetch_assoc())
		{
			$data[]=$row;
		}
		$total=0;
		foreach($data as $data)
		{
			$price=$data['price'];
			$amt=0;
			$product_id=$data['id'];
			$sql="select product_quantity from order_items where o_id=$order_id and p_id=$product_id";
			$res=$conn->query($sql);
			$row=$res->fetch_assoc();
			$sql="select * from taxes where id in (select tax_id from product_taxes where product_id=$product_id)";
           
			$res=$conn->query($sql);
			while($value=$res->fetch_assoc())
			{
				$taxes[]=$value['tax'];
				$percentage[]=$value['percentage'];
			}
			$total+=$price*$row['product_quantity'];
			$amt=$price*$row['quantity'];
?>
	
	<tr>
		<td><?=$data['name']?></td>
		<td><?=$price;?></td>
		<td><?=$row['product_quantity'];?></td>
		<td><?=$price*$row['product_quantity'];?></td>
	</tr>
<?php	
			$tax_percentage=0;
			for($i=0;$i<sizeof($taxes);$i++)
			{
				$tax_percentage+=$percentage[$i];
				//$amt+=$amount[$i];
			}
			$actual_value=$amt/(1+($tax_percentage/100));
			for($i=0;$i<sizeof($taxes);$i++)
			{
?>
	
<?php
			}
			unset($taxes);
			unset($amount);
			unset($percentage);
?>

<?php
		}
?>
	<tr>
		<td></td>
		<td></td>
		<td>Total Billing Amount</td>
		<td><?=$total;?></td>
	</tr>
</table>
</body>
</html>