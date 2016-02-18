<?php  
error_reporting(E_ALL);
$setflag = TRUE;
$errors = array();//initialize an error array
$card_img_id=array();
$filename=array();
$imgtype=array();
$dis=array();
$cardid="";
 
 foreach($_POST as $key=>$value) 
 $cardid=($value=='Select') ? $key : ''; 
 
 
 //first page
if(isset($_POST['next']))
{  
  if($_POST['amount']=="")
   $errors[] = 'Please select gift card amount.';
 
  if(strlen($_POST['quantity'])<=0)
   $errors[] = 'Please enter Quantity.';
  else 
    {
	$quantity=trim($_POST['quantity']);
    $quantity=ltrim($quantity, '0');	 
	if($quantity <1 || $quantity >100 ||!preg_match("/^[0-9]{1,3}$/", $quantity))
      $errors[] = 'Quantity must be an integer in limit (1 and 100).';   			  
	   	
	}	

 if(empty($errors))
    {
	 $setflag = FALSE;
	 $_SESSION['quantity']=escape_data($quantity);
	 $_SESSION['amount'] = $_POST['amount'];
	}
}//end isset "next" IF 

//secong page
if($cardid!="" )
 { 
  $message=trim($_POST['msg']);
  $msg = escape_data($message);
  $msgfrom = escape_data(trim($_POST['msgfrom']));
  $msgto = escape_data(trim($_POST['msgto'])); 
   
  $l=strlen($message);
  if($l>96)   
   $errors[] = "Your message contains $l characters. Please limit your message to 96 characters.";
   
  if(!empty($errors))    
	$setflag=FALSE;
      
  else
    {
	
	$q="INSERT INTO shopping_cart(session_id, msgfrom, msgto, msg, card_img_id, quantity, amount, checkout_flag) "; 
	$q.="VALUES ('$sessionid', '$msgfrom', '$msgto', '$msg', $cardid, {$_SESSION['quantity']}, {$_SESSION['amount']}, '0')";
	$r = mysqli_query($dbc, $q);
	mysqli_close($dbc); 
    if($r)
     {	
	 header("Location: http://" . $_SERVER['HTTP_HOST'] ."/index.php?pagelet=items_cart" . SID);
	 exit();
	 } 	
   } 
 }
 
if($setflag)
{  
  
?>
<div class="buywrap">
<div class="buyhed">Add gift cards to your shopping chart</div>
<hr/>
<div class="buyl">
   <form method="post" action="index.php?pagelet=buy_now"  onsubmit="return validatelogin();"> 
	<p class="buyindicates">* Indicates required field</p>  
		 <div class="log_info_row"><label for="amount" class="buy_info_label">* Select Gift Card Amount $:</label>			   
			<select name="amount" id="amount" tabindex="1"  style="font-size:11px;">
			<option value ="">Select an Amount</option>
				<?php
				$sticky = (isset($_POST['amount'])? $_POST['amount']:""); 				 
				for($price = 15; $price <= 250; $price=$price+5)
				{				
				 echo "<option value=\"$price\"";
			     if($sticky==$price) echo "selected=\"selected\"";
		         echo ">$price</option>\n";
				} ?>
			</select> </div><?php if(!empty($errors[0])) echo '<div class="erdiv perror">* '.$errors[0].'</div>'; ?>
				
			<div class="log_info_row "><label for="quantity" class="buy_info_label">* Quantity :</label>
		     <input type="text" name="quantity" value= "<?php if (isset($_POST['quantity'])) echo $_POST['quantity']; ?>"
					 id="quantity" tabindex="2" maxlength="3" size="3" /></div>
					 <?php if(!empty($errors[1])) echo '<div class="erdiv perror">* '.$errors[1].'</div>'; ?>
			
		  <div class="buy_next"> <input type="submit" name="next" id="next" tabindex="3" value="Next"/></div>		    
	 </form>   
</div>
<div class="buyr">
 <img src="images/giftcardb.jpg" width="240" height="160" alt="gift card" />
</div>
</div>

<?php }
if(!$setflag)
 {
?>
<br/>
 <div class="buyhed">Include Your Personalized Message on Greeting Card</div>
 <hr/>  
 
   <div>	
    <form method="post" action="index.php?pagelet=buy_now" onsubmit="return validatemsg();">	
	<div class="cust_msg">     
	 <div class="log_info_row "><label for="msgfrom" class="log_info_label">From:</label>
	 <input type="text" name="msgfrom" value= "<?php if (isset($_POST['msgfrom'])) echo $_POST['msgfrom']; ?>" id="msgfrom" tabindex="1" maxlength="30"/></div>
	 <div class="log_info_row "><label for="msgto" class="log_info_label">To:</label>
	 <input type="text" name="msgto" value= "<?php if (isset($_POST['msgto'])) echo $_POST['msgto']; ?>" id="msgto" tabindex="2" maxlength="30"/></div> 
	
	 <div><label for="msg" class="log_info_label">Message: <br/><small>(max 96 characters)</small></label>
	<textarea name="msg" id="msg" rows="3" cols="25" onkeyup="return validatemsgchar();"  tabindex="3" ><?php if (isset($_POST['msg'])) echo $_POST['msg']; ?> </textarea></div> <?php if(!empty($errors[0])) echo '<div class="erdiv perror">* '.$errors[0].'</div>'; ?>		 
 </div>
<div class="buyhed">Select Your Greeting Card Design</div>
 <hr/>
<!-- Table For card images -->
<?php


 
for($i=1; $i<6; $i++)
{
 $q = "SELECT card_img_id, cardname, filename, imgtype ";
 $q .= "FROM card_image WHERE category_id =$i AND flag_m =1 AND flag_a =1 ";
 $q .= "ORDER BY upload_date DESC LIMIT 1";
 
 $r = mysqli_query($dbc, $q);
 $dis[] =(mysqli_num_rows($r) !=1 ? 0:1);

 $row=mysqli_fetch_array($r, MYSQLI_ASSOC);
 $card_img_id[]=$row['card_img_id'];
 $filename[]=$row['filename'];
 $imgtype[]=$row['imgtype'];
}
mysqli_free_result($r);
mysqli_close($dbc);
?>
<!-- Gift Card Images-->
   <span style="margin-left:60px;">Click images for large view</span>
    <table class="cardtbl">	
	
	<tr><?php if($dis[0]==1){ ?><td><img alt="birthday card" src="includes/cartimg.inc.php?id=<?php echo $card_img_id[0]; ?>" width="167" height="100" onclick= "create_window('<?php echo $filename[0] ?>', '<?php echo $imgtype[0] ?>');" title="Click here to view large image"/><br/>
	        <span>Birthday Greeting Card<br/><input type="submit" name="<?php echo $card_img_id[0]; ?>" id="bday" tabindex="4" value="Select" class="buyselect"/></span></td><?php } ?>
			
	    <?php if($dis[1]==1){ ?><td><img alt="anniversary card" src="includes/cartimg.inc.php?id=<?php echo $card_img_id[1]; ?>" width="167" height="100" onclick= "create_window('<?php echo $filename[1] ?>', '<?php echo $imgtype[1] ?>');" title="Click here to view large image"/><br/>
	        <span>Anniversary Greeting Card<br/><input type="submit" name="<?php echo $card_img_id[1]; ?>" id="anni" tabindex="5" value="Select" class="buyselect"/></span></td><?php } ?>
			
		<?php if($dis[2]==1){ ?><td><img alt="than you card" src="includes/cartimg.inc.php?id=<?php echo $card_img_id[2]; ?>" width="167" height="100" onclick= "create_window('<?php echo $filename[2] ?>', '<?php echo $imgtype[2] ?>');" title="Click here to view large image"/><br/>
	        <span>Thank You Greeting Card<br/><input type="submit" name="<?php echo $card_img_id[2]; ?>" id="thanku" tabindex="6" value="Select" class="buyselect"/></span></td><?php } ?></tr>
		
		<tr><?php if($dis[3]==1){ ?><td><img alt="all occation card" src="includes/cartimg.inc.php?id=<?php echo $card_img_id[3]; ?>" width="167" height="100" onclick= "create_window('<?php echo $filename[3] ?>', '<?php echo $imgtype[3] ?>');" title="Click here to view large image"/><br/>
	        <span>All Occation Greeting Card<br/><input type="submit" name="<?php echo $card_img_id[3]; ?>" id="occ" tabindex="7" value="Select" class="buyselect"/></span></td><?php } ?>
		
		<?php if($dis[4]==1){ ?> <td><img alt="seasonal card" src="includes/cartimg.inc.php?id=<?php echo $card_img_id[4]; ?>" width="167" height="100" onclick= "create_window('<?php echo $filename[4] ?>', '<?php echo $imgtype[4] ?>');" title="Click here to view large image"/><br/>
	        <span><?php echo $row['cardname'] ?> Greeting Card<br/><input type="submit" name="<?php echo $card_img_id[4]; ?>" id="seas" tabindex="8" value="Select" class="buyselect"/></span></td> <?php } ?></tr>		
			
	</table>
	
  </form>		
 </div>	

<?php }//End !setflag IF ?>