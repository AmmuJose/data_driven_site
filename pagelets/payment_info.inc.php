<?php  error_reporting(E_ALL);
  
	$errors = array();//initialize an error array	
	
	include("functions/password_validation.inc.php");
	
   if(isset($_POST['checkout3']))
    { 
	//-------- validate address ---------------
    include("includes/validate_address.inc.php");
	 
	//-------- Validate credit card type ------	
	    $cardtype=$_POST['cardtype'];
		  if(empty($cardtype))
		  $errors[] = 'Please selsct a card type.';
			
  //------- validate card number	----------
	    $cardnum = trim($_POST['cardnum']);
			if(empty($cardnum))
				$errors[] = 'Please fill in Credit Card Number.';
			else
			{
	      if($cardtype == 1)
			  {	
			   if(!preg_match("/^[0-9]{15}$/", $cardnum)) 
         $errors[] = 'American Express Card Number must be a 15-digit number.';	
			  }	
			  if($cardtype == 2)
			  {	
			   if(!preg_match("/^[0-9]{16}$/", $cardnum)) 
         $errors[] = 'Visa Card Number must be a 16-digit number.';	
			  }	
				if($cardtype == 3)
			  {	
			   if(!preg_match("/^[0-9]{16}$/", $cardnum)) 
         $errors[] = 'Master Card Number must be a 16-digit number.';	
			  }	
			}//End else		
				
	//----------- validate Security code --------
	   $code=trim($_POST['code']);
		 if(empty($code))
		   $errors[] = 'Please fill in Security code.';
		 else
		 {
		    if($cardtype == 1)
			  {	
			   if(!preg_match("/^[0-9]{4}$/", $code)) 
         $errors[] = 'American Express Security code must be a 4-digit number.';	
			  }	
			  if($cardtype == 2)
			  {	
			   if(!preg_match("/^[0-9]{3}$/", $code)) 
         $errors[] = 'Visa Card Security code must be a 3-digit number.';	
			  }	
				if($cardtype == 3)
			  {	
			   if(!preg_match("/^[0-9]{3}$/", $code)) 
         $errors[] = 'Master Card Security code must be a 3-digit number.';	
			  }	
             		 
		 }//End else
		 
	//------------- validate date----------------
	     $expmonth = $_POST['expmonth'] ;
			 $expyear = $_POST['expyear'];
			 
		     if($expmonth == "")
			  $errors[] = 'Please select an expiration month.';
			 
			   if($expyear == "")
			  $errors[] = 'Please select an expiration year.';
				
				$current_month = date("m");
				$current_month +=1;
				$current_year = date("Y"); 
				
				if ($expyear == $current_year)
				{		
			    if ($expmonth < $current_month) 
			    $errors[] = 'Expiration month should be greater than current month';
				}
	
	//------------- Validate Name on card -------
	    $nameoncard= escape_data($_POST['nameoncard']);
	     if(strlen($nameoncard)<=0)
			  $errors[] = 'Please fill in Name on card.';
	
		
		if(empty($errors))
		{
		$q="SELECT address_id FROM address WHERE user_id = {$_SESSION['user_id']} AND flag_bs='1'";
        $r = mysqli_query($dbc, $q);
		if(mysqli_num_rows($r)==1)
		 {
		  $row=mysqli_fetch_array($r,MYSQLI_NUM);
		  $_SESSION['bill_add_id']=$row[0];		
		 }
		else
		 $_SESSION['bill_add_id']=0;
		 
		$q="SELECT address_id FROM address WHERE firstname='$fname' AND lastname='$lname' AND address1='$address1' AND address2='$address2' AND city='$city' AND user_id={$_SESSION['user_id']} AND zip=$zipcode AND state='$state' AND phone='$phone' ";
		$r=mysqli_query($dbc, $q);
		  if(mysqli_num_rows($r)==1)
		  {
		   $row=mysqli_fetch_array($r,MYSQLI_NUM);
		   $_SESSION['new_bill_add_id']=$row[0];
		  }
		
		else
		  {
		   $q2 = "INSERT INTO address VALUES('', '$fname', '$lname', '$address1', '$address2', '$city', '$state', '$zipcode', '$phone', '1', '1', {$_SESSION['user_id']}, '')";
	       $r2 = mysqli_query($dbc, $q2);
		   $_SESSION['new_bill_add_id']=mysqli_insert_id($dbc);
		  }
		  
			if($_SESSION['bill_add_id'] != $_SESSION['new_bill_add_id'])	     
		     {
			  if($_SESSION['bill_add_id'] != 0)
			  {
			  $q1="UPDATE address SET flag_bs='0' WHERE address_id={$_SESSION['bill_add_id']}";
			  $r = mysqli_query($dbc, $q1);}			   
			  
			  $q2="UPDATE address SET flag_bs='1' WHERE address_id={$_SESSION['new_bill_add_id']}";
			  $r = mysqli_query($dbc, $q2);			  
			 }
		    $_SESSION['bill_add_id']=$_SESSION['new_bill_add_id'];
		  
		   
		$q="INSERT INTO bill_ship_address VALUES('', {$_SESSION['bill_add_id']}, {$_SESSION['ship_add_id']})";
		$r = mysqli_query($dbc, $q);
		$bsid= mysqli_insert_id($dbc);
		 
		$q="INSERT INTO order_tbl(user_id, processing_id, ship_method_id, bill_ship_id, total) VALUES({$_SESSION['user_id']}, {$_SESSION['pid']}, {$_SESSION['smthd_id']}, $bsid, '{$_SESSION['ordertotal']}')";
		$r = mysqli_query($dbc, $q);
		$orderid= mysqli_insert_id($dbc);
		$_SESSION['ordid']=$orderid;
		
		$q="SELECT cart_id FROM shopping_cart WHERE session_id='$sessionid' AND checkout_flag='0'";
		$r=mysqli_query($dbc,$q);		
		while($row=mysqli_fetch_array($r, MYSQLI_NUM))
		{		
		$q3="INSERT INTO order_cart_rel VALUES('', $orderid, {$row[0]})";
		$r3=mysqli_query($dbc,$q3);		
		}		
		
		$q="UPDATE shopping_cart SET checkout_flag='1' WHERE session_id='$sessionid'";
		$r=mysqli_query($dbc,$q);
		
		//confirmation
		if($r)
		{
		$_SESSION['confirm']=1;
		header("Location: http://" . $_SERVER['HTTP_HOST'] ."/index.php?pagelet=confirm" . SID);
	    exit();
		}
		}//End of else error empty 
			
	}//End if isset	
	
	

 if(isset($_SESSION['agent']) && isset($_SESSION['acess_id']))
 {
  if($_SESSION['ck3']==1)
  {
 ?>  
	<span class="buyhed">Review Order</span>
    <hr/>
	
	<table summary="this table shows the gift card purchased, its amount shipping info and quantity" class="review">
	<tr style="background-color:#d7c47d;"><th style="text-align:right;">Item</th><th></th><th>Quantity</th><th>Price</th><th>SubTotal</th></tr>
  <?php $q="SELECT * FROM shopping_cart WHERE session_id='$sessionid' AND checkout_flag='0'"; 
	  $r =@mysqli_query($dbc, $q);	 
	  if(mysqli_num_rows($r)>0)
	  {
	    while($row=mysqli_fetch_array($r, MYSQLI_ASSOC))
	    {		
        $q2="SELECT category FROM card_category, card_image WHERE card_category.category_id=card_image.category_id AND card_img_id ={$row['card_img_id']}";
		$r2 = @mysqli_query($dbc, $q2);
		$row2=mysqli_fetch_array($r2, MYSQLI_NUM);		
		mysqli_free_result($r2);
		
		echo '<tr style="background-color:#cac490;text-align:right;"><td> Garroway Gift Card <b>with</b> <br/>'.$row2[0].' Greeting Card </td>';
		echo '<td><b>Personalized Message:</b> ';
		echo htmlspecialchars($row['msg'], ENT_QUOTES). '<br/><b>To:</b> ';
		echo htmlspecialchars($row['msgto'], ENT_QUOTES).'<br/><b>From:</b> ';
		echo htmlspecialchars($row['msgfrom'], ENT_QUOTES).'</td>';
		echo '<td style="text-align:center;">'.$row['quantity'].'</td>';
		echo '<td style="text-align:center;">'.$row['amount'].'</td>';
		echo '<td style="text-align:center;">'.$row['amount']*$row['quantity'].'</td></tr>';
		}//end of while loop
	  }//end of num rows	  
?>	
	</table>
	
	
<div style="height:120px;background-color:#d7c47d;padding:5px 0px;">
	
    <?php 
    $q="SELECT * FROM address WHERE address_id={$_SESSION['ship_add_id']}";
    $r = @mysqli_query($dbc, $q);
    $row=mysqli_fetch_array($r);
	
	
	echo '<div class="addleft">';
	echo '<span class="bainfo"> Shipping Address</span><br/>';
	echo $row['firstname'].' ';
	echo $row['lastname'].'<br/>';
	echo $row['address1'].'<br/>';
	if($row['address2'] !='')
	echo $row['address2'].'<br/>';
	echo $row['city'].', '.$row['state'].' '.$row['zip']. '<br/><br/>';
	echo '<span class="bainfo">Shipping Method: </span>'.$_SESSION['smthd'];
	echo '</div>';
	
	$_SESSION['ordertotal']=$_SESSION['itemtotal']+$_SESSION['pfee']+$_SESSION['sfee'];
	
	echo '<div class="addright">';
	echo '<div class="tpdis tpl">'.number_format($_SESSION['itemtotal'],2).'</div>';
	echo '<div class="tpldis tpl">Item Total:</div><br/>';
	echo '<div class="tpdis tpl">'.number_format($_SESSION['pfee'],2).'</div>';
	echo '<div class="tpldis tpl">Processing Fee:</div><br/>';
	echo '<div class="tpdis tpl">'.number_format($_SESSION['sfee'],2).'</div>';
	echo '<div class="tpldis tpl">Shippinging Fee:</div><br/>';
	echo '<div class="tpdis tpl">'.number_format($_SESSION['ordertotal'],2).'</div>';
	echo '<div class="tpldis tpl">Order Total:</div>';
	echo '</div>';
    ?>	
</div>
<br/>
<?php if(!empty($errors))		 
			display_error($errors);	?>
				
<div style="height:335px;"><!-- start bill&payment wrap -->
   <form method="post" action="" onsubmit="return validateform();" >		
	  
		<?php
		if($_SESSION['bequals']==1)	    
		 $q="SELECT firstname, lastname, address1, address2, city, state, zip, phone  FROM address WHERE address_id = {$_SESSION['ship_add_id']}";
		else		
		 $q="SELECT firstname, lastname, address1, address2, city, state, zip, phone  FROM address WHERE user_id={$_SESSION['user_id']} AND flag_bs ='1'";	
		
		 $r=@mysqli_query($dbc, $q);
		 $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
		 
		 $fn=1; $ln=2; $ad1=3; $ad2=4; $cty=5; $num=6; $zp=7; $ph=8; $s=9; 
		   include("includes/billadd_payment.inc.php"); ?>	 	    
			
		 
		<div style="margin:10px 80px 10px 2px;float:right;"><input type="submit" name="checkout3" id="checkout3" tabindex="15" value="Checkout" /></div>		     
   </form>
   <div style="margin:15px 3px 10px 170px;float:left;"><form method="post" action="index.php?pagelet=cancel_shopping"><input type="submit" name="cs" id="cs" tabindex="15" value="Cancel Shopping" /></form></div>    
	 
</div> <!--End form wrap-->

<?php
 }//end of isset agent if
 
else
 echo '<p class="perror"> You have been accessed this page in error!</p>';
 }
 else
	{
	header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/index.php?pagelet=login_options" . SID);
	exit();
	}//end else 


?>