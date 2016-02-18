<?php 
 $flag=0; 
 $itemtotal=0;
 $ordertotal=0;
 $bg='#d7c47d';
 $qty='';
 $_SESSION['ck3']=0;

if(isset($_POST['update']))
{
//update quantity
	foreach ($_POST['qty'] as $key=> $value)
	{	
		if($value <1 || $value >100 || !preg_match("/^[0-9]{1,3}$/", $value))
		echo '<div class="erdiv perror">* Quantity must be an integer in limit (1 and 100).</div>';
		else
		{
		$q="UPDATE shopping_cart SET quantity=$value WHERE cart_id=$key";
		$r=mysqli_query($dbc,$q);
		}
	}//end of foreach
	  
//Delete items from cart
	if(isset($_POST['delete']))
	{
		foreach ($_POST['delete'] as $key=> $value)
	    {
		$q="DELETE FROM shopping_cart WHERE cart_id=$key";
		$r=mysqli_query($dbc,$q);		
		}//end of foreach
	}//end of isset deletes	 
	
}//end of isset update
	 
echo '<div class="buyhed">Items in Your Chart</div><hr/>'; 
$q="SELECT * FROM shopping_cart WHERE session_id='$sessionid' AND checkout_flag='0'  "; 
$r = @mysqli_query($dbc, $q);
	 
if(mysqli_num_rows($r)>0)
{
	$_SESSION['ck2']=1;
		
	echo '<div><form method="post" action="">';	  
	echo '<table summary="items in your cart" class="itemstbl">';
	echo '<tr style="background:'.$bg.'"><th>Delete</th><th colspan="2">Item</th><th>Price</th><th>Quantity</th><th>Sub Total</th></tr>';
	
	while($row=mysqli_fetch_array($r, MYSQLI_ASSOC))
	   {
	    $q2="SELECT category FROM card_category, card_image WHERE card_category.category_id=card_image.category_id AND card_img_id ={$row['card_img_id']}";
		$r2 = mysqli_query($dbc, $q2);
		$row2=mysqli_fetch_array($r2, MYSQLI_NUM);		
		mysqli_free_result($r2);
		
	    $bg = ($bg=='#d7c490'?'#cac490':'#d7c490');
	    $id=$row['card_img_id'];
		
	    echo '<tr style="background:'.$bg.'">';
		echo "<td><input type=\"checkbox\" name=\"delete[{$row['cart_id']}]\" /></td>";
		echo '<td style="text-align:left;"><img alt="'.$row2[0].' card" src="includes/cartimg.inc.php?id='.$id.'" width="137" height="90"/></td>';			
		echo '<td style="text-align:left;font-size:11px;">Garroway Gift Card <b>With</b><br/>'.$row2[0].' Greeting Card<br/><br/><b>Personalized Message:</b> ';
		echo htmlspecialchars($row['msg'], ENT_QUOTES). '<br/><br/><b>To:</b> ';
		echo htmlspecialchars($row['msgto'], ENT_QUOTES).'<br/><b>From:</b> ';
		echo htmlspecialchars($row['msgfrom'], ENT_QUOTES).'</td>';
		echo '<td> &#36;'.$row['amount'].'</td>';
		echo "<td><input type=\"text\" name=\"qty[{$row['cart_id']}]\" size=\"3\" maxlength=\"3\" value=\"{$row['quantity']}\"/></td>";
		echo '<td> $'.$row['amount']*$row['quantity'].'</td></tr>';
		
		$itemtotal += ($row['amount']*$row['quantity']);
		$qty +=$row['quantity'];
	   }//end while
	   
	   $_SESSION['itemtotal']=$itemtotal;
	   
	    if($qty<20)
		 {$_SESSION['pid']=1;
		 $pfee=0;}
		 
		elseif($qty>20 && $qty<40)
		 {$_SESSION['pid']=2;
		 $pfee=1.95;}
		 
		else
		{$_SESSION['pid']=3;
		 $pfee=3.90;}
		 
		 $_SESSION['pfee']=$pfee;
		
		 $ordertotal=$_SESSION['pfee']+$_SESSION['itemtotal'];
		 $bg='#d7c47d';		
		
		echo '<tr style="background:'.$bg.'">';
		echo '<th colspan="6">';
		echo '<div class="tpdis tpl">'.number_format($_SESSION['itemtotal'],2).'</div>';
		echo '<div class="tpldis tpl">Item Total:</div><br/>';
		echo '<div class="tpdis tpl">'.number_format($_SESSION['pfee'],2).'</div>';
		echo '<div class="tpldis tpl">Processing Fee:</div><br/>';
		echo '<div class="tpdis tpl">'.number_format($ordertotal,2).'</div>';
		echo '<div class="tpldis tpl">Order Total:</div>';
		echo '</th></tr></table>';  	   
	
 ?> 
        
	<div style="padding:20px 35px 20px 60px; height:30px;float:left;"><input type="submit" name="update" id="update" tabindex="2" value="Update"/></div></form></div>
			 
	   <div style="height:50px;">	   
		
		<div style="margin:20px 62px 20px 5px;float:right;">
			   <form method="post" action="index.php?pagelet=shipping_info"><div><input type="submit" name="checkout1" id="checkout1" tabindex="3" value="Checkout"/></div></form></div>
		
		<div style="margin:20px 5px 20px 5px;float:right;">
			 <form method="post" action="index.php?pagelet=buy_now">
			   <div><input type="submit" name="continue" id="continue" tabindex="1" value="Continue shopping"/></div></form></div>	
	   
      </div>
			 
	   
<?php
	
 }
	else
	{
	$_SESSION['ck2']=0;
	echo '<p class="buyindicates">You shopping cart is empty!</p>';
?>   
	<div style="width:150px;margin:10px;float:left;">
	<form method="post" action="index.php?pagelet=buy_now">
	<div><input type="submit" name="continue" id="continue" tabindex="1" value="Continue shopping"/></div></form></div> <?php } ?>