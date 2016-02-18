<?php 
$bg='#d7c47d';

if(isset($_GET['id']))
{
	$oid=$_GET['id'];

	$q= "SELECT total, fee, ship_method, ship_amount, bill_id, ship_id ";
	$q.= "FROM order_tbl AS o, processing_fee AS p, shipping_method AS s, bill_ship_address AS bs ";
	$q.= "WHERE o.processing_id=p.processing_id AND o.ship_method_id=s.ship_method_id ";
	$q.= "AND o.bill_ship_id=bs.bill_ship_id ";
	$q.= "AND order_id=$oid";
	$r=mysqli_query($dbc, $q);
	echo mysqli_error($dbc);
	if(mysqli_num_rows($r) ==1)
	{
	 $row=mysqli_fetch_array($r, MYSQLI_ASSOC);
	 echo '<table class="ou">';
	 echo '<tr style="background:'.$bg.'" >';
	 echo '<th>BillingAddress</th>';
	 echo '<th>Item</th>';
     echo '<th>Fee</th>';
	 echo '<th>OrderTotal</th>';
     echo '<th>ShippingAddress</th> </tr>';
	
	 $bg = '#cac490';				
	 echo '<tr style="background:'.$bg.'">';
	 
		//fetch billing address
		$bq="SELECT * FROM address WHERE address_id={$row['bill_id']}";
		$br=mysqli_query($dbc, $bq);		
		$brow=mysqli_fetch_array($br, MYSQLI_ASSOC);
		
				echo '<td>';
				echo $brow['firstname']. ' ';
				echo $brow['lastname']. '<br/>';
				echo $brow['address1']. '<br/>';
				if($brow['address2'] != '')
				echo $brow['address2']. '<br/>';
				echo $brow['city']. '<br/>';
				echo $brow['state'].', '.$brow['zip']. '<br/>';
				echo $brow['phone'];				
				echo '</td>';		
		
		
		//fetch items
		$q1="SELECT cart_id FROM order_cart_rel WHERE order_id=$oid";
		$r1=mysqli_query($dbc, $q1);
		
		echo '<td>';
		echo '<div style="width:278px;">';				
				
				while($row1=mysqli_fetch_array($r1,MYSQLI_NUM))
				 {
				 $q2 ="SELECT msgfrom, msgto, msg, quantity,amount, category, card_image.card_img_id ";
				 $q2 .="FROM shopping_cart, card_image, card_category ";
				 $q2 .="WHERE card_image.card_img_id=shopping_cart.card_img_id AND card_image.category_id=card_category.category_id AND cart_id={$row1[0]}";
				
				 
				 $r2=mysqli_query($dbc, $q2);				 
				 $row2=mysqli_fetch_array($r2,MYSQLI_ASSOC);
				 
				 echo '<div style="width:180px;float:left;margin:5px 0px;">';
				 echo 'GiftCard + '.$row2['category'].'<br/>Greeting Card';
				 echo '<br/><br/>From: '.$row2['msgfrom'];
				 echo '<br/>To: '.$row2['msgto'];
				 echo '<br/>Message: '.$row2['msg'].'<br/>';
				 
				 echo '</div>';
				 echo '<div style="width:84px;float:right;margin:5px 0px;">Quantity: '.$row2['quantity'];
				 echo '<br/> Price: '.$row2['amount'];
				 echo '<br/> Card ID: '.$row2['card_img_id'];
				 echo '</div>';			 
				 
				 }
				 
		echo '</div>';
		echo '</td>';
		
		echo '<td>Processing Fee: '.$row['fee'];
		echo '<br/>Shipping Fee: '.$row['ship_amount'];
		echo '<br/>'.$row['ship_method'];
		echo '</td>';
		
		echo '<td>'.number_format($row['total'],2).'</td>';
		
		if($row['ship_id']==$row['bill_id'])
		 echo '<td>Same as <br/>billing address</td>';
		else
		{
		//fetch shipping address
		$sq="SELECT * FROM address WHERE address_id={$row['ship_id']}";
		$sr=mysqli_query($dbc, $sq);		
		$srow=mysqli_fetch_array($sr, MYSQLI_ASSOC);
		
				echo '<td>';
				echo $srow['firstname']. ' ';
				echo $srow['lastname']. '<br/>';
				echo $srow['address1']. '<br/>';
				if($srow['address2'] != '')
				echo $srow['address2']. '<br/>';
				echo $srow['city']. '<br/>';
				echo $srow['state'].', '.$srow['zip']. '<br/>';
				echo $srow['phone'];
				echo '</td>';	
		}
		
	echo '</tr>';

	$bg='#d7c47d';
	echo '<tr style="background:'.$bg.'"><td colspan="5" style="padding:5px;">';			  
	echo '</td</tr>';
    echo '</table>';
	}//end num rows
	echo '<p class="addform"><a href="javascript:history.back();">Back to Search Result</a>.</p>';
}
?>