	<?php  error_reporting(E_ALL);  
	$errors = array();//initialize an error array
    $addid = array();
	$addbook='';	    

if(isset($_POST['checkout2'])) 
 { 
  $flag=1;
  if(isset($_POST['addbook']))
   $addbook=$_POST['addbook'];   
    
//---------- validate address ------------
  include("includes/validate_address.inc.php");
	
//-------- validate acess group	----------   
  if(empty($_POST['shipmethod']))	
	 $errors[]= 'Please slect a Shipping Method.';
	 
  else
  {
    $_SESSION['smthd_id']=$_POST['shipmethod'];
	switch($_POST['shipmethod'])
	{
	case 1:
	
	 $_SESSION['sfee']=1.95;
	 $_SESSION['smthd']='Standard US Mail';
	 
	 break;
	
	case 2:
	 $_SESSION['sfee']=8.95;
	 $_SESSION['smthd']='UPS SecondDay (2 Business Days)';
	 break;
	 
	case 3:
	 $_SESSION['sfee']=14.95;
	 $_SESSION['smthd']='UPS Overnight (Next Business Day)';
	 break;
	
	}//end switch
  }
    
   if(empty($errors))
    {
	 $_SESSION['bequals'] = (isset($_POST['bs'])) ? 1:0;	 
	 $toaddbook = (isset($_POST['toaddbook'])) ? 1:0;
	 	
	 $q="SELECT address_id FROM address WHERE firstname='$fname' AND lastname='$lname' AND address1='$address1' AND address2='$address2' AND city='$city' AND user_id={$_SESSION['user_id']} AND zip=$zipcode AND state='$state' AND phone='$phone' ";
	 $r=mysqli_query($dbc, $q);
	 
	 if(mysqli_num_rows($r)==1)
	  {
	    $row=mysqli_fetch_array($r,MYSQLI_NUM);
		$_SESSION['ship_add_id']=$row[0];		
	  }
	  else
	  {
		$q = "INSERT INTO address VALUES('', '$fname', '$lname', '$address1', '$address2', '$city', '$state', '$zipcode', '$phone', '2', $toaddbook, {$_SESSION['user_id']}, '')";
	    $r = mysqli_query($dbc, $q);
		$_SESSION['ship_add_id']=mysqli_insert_id($dbc);
	  }	 
	  
	$_SESSION['ck3']=1;  
	header("Location: http://" . $_SERVER['HTTP_HOST'] . "/index.php?pagelet=payment_info" . SID);
	exit();
	  
    }	
  
}//End isset if


 if(isset($_SESSION['agent']) && isset($_SESSION['acess_id']))
 {
  
  if($_SESSION['ck2']==1)
  {
?> 
	 
	<div class="buyhed">Shipping Information</div>
    <hr/>
	
	<?php if(!empty($errors))		 
			display_error($errors);	?>
			
    <div class="shipwrap">
	<p class="buyindicates">* Indicates required field</p>	 
    <form method="post" action="" onsubmit="return validateform();" > 
	
<div class="shipbg">
	 
	  <div class="log_info_row shipbs">
	  <input type="checkbox" name="bs" id="bs" tabindex="2"/><label for="bs">My billing address is the same as Shipping</label></div>
	  
	 <div class="log_info_row adblist"><label for="addbook" class="log_info_label">Address Book:</label>
	
	  <select name="addbook"	id="addbook" style="font-size:12px;" tabindex="1" onchange="if(this.value != '') getaddress('index.php?pagelet=get_address&amp;add_id='+this.value); else clr();">
	  <option value="">Select Ship to Location</option>
		  <?php
          $q="SELECT address_id, firstname, city, zip, state FROM address WHERE toaddbook=1 AND user_id={$_SESSION['user_id']} ORDER BY address_id LIMIT 10"; 
		  $r = mysqli_query($dbc, $q);
	      while($row=mysqli_fetch_array($r, MYSQLI_ASSOC))
		  {
		   $addid[]=$row['address_id'];		   
		   echo '<option value="'.$row['address_id'].'" ';		   
		   if($row['address_id']==$addbook) echo "selected=\"selected\"";
		   echo '>'. $row['firstname'].', '.$row['state'].' '.$row['zip'].'</option>';
		  }//End of while
		 
          ?>
	  </select> </div>	
	  <div class="addwrap1">
		   <?php      
		   $fn=3; $ln=4; $ad1=5; $ad2=6; $cty=7; $num=8; $zp=9; $ph=10; $s=11; $left='addl';$right='addr';
		    include("includes/edit_address_form.inc.php"); ?></div>
				
	 <div class="log_info_row shipbs">
	  <input type="checkbox" name="toaddbook" id="toaddbook" tabindex="12"/><label for="toaddbook">Save to address Book</label></div>
	  
</div>		
<div class="shipbg"> 
	   <div class="log_info_row shipbs"><label for="shipmethod" class="log_info_label shipmthd">*Shipping Method:</label>
	    <select name="shipmethod"	id="shipmethod" style="font-size:12px;" tabindex="13">		   
			  <?php 
				  echo "<option value=\"\" selected=\"selected\">Choose a Shipping Method</option>\n";	
				  $method = array(1=>'Standard US Mail, $1.95','UPS SecondDay (2 Business Days), $8.95','UPS Overnight (Next Business Day), 14.95');
				  $sticky = (isset($_POST['shipmethod'])? $_POST['shipmethod']:"");
					foreach($method as $key => $value)
					{
					  echo "<option value=\"$key\" ";
			         if($sticky==$key) echo "selected=\"selected\"";
		              echo ">$value</option>\n";
					}
				?>
		</select> </div>		
		<div class="shipmsg">ORDERS PLACED BY 2PM EASTERN ARE USUALLY FULFILLED AND SHIPPED SAME BUSINESS DAY.<br/>PLEASE ALLOW 5-7 BUSINESS DAYS FOR STANDARD US MAIL.</div>
</div>		
	 <div style="width:78px;margin:10px 100px 10px 10px;float:right;"><input type="submit" name="checkout2" tabindex="14" value="Checkout" /></div>		  		  	
 </form> 
 
	<div style="height:50px;"> 
	<div style="width:130px;margin:10px 3px 10px 80px;float:left;"><form method="post" action="index.php?pagelet=cancel_shopping"><input type="submit" name="cs" id="cs" tabindex="15" value="Cancel Shopping" /></form></div>
	<div style="width:80px;margin:10px 30px;float:left;"><form method="post" action="index.php?pagelet=items_cart"><input type="submit" name="editcart1" id="editcart1" tabindex="16" value="Edit Cart" /></form> </div>
    </div>
</div><!-- end shipwrap -->
<?php
 }//end of isset agent if
else
 echo '<p class="perror"> You have been accessed this page in error!</p>';
 
}

 else
	{
	header("Location: http://" . $_SERVER['HTTP_HOST'] ."/index.php?pagelet=login_options");
	exit();
	}//end else 

?>