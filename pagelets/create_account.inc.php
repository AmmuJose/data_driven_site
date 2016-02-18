<?php 
if(isset($_SESSION['agent']) && isset($_SESSION['acess_id']))
 echo '<p class="perror">You are loged in now. Logout to create new account</p>';
 
else
 {
  include("functions/password_validation.inc.php");
	$errors = array();//initialize an error array
	$flag = 0;
  if(isset($_POST['create_account']))
  {
 		 			
     include("functions/email_validation.inc.php");
		
// ------- check pswd and cfm pswd are equal------
		 $pswd =trim($_POST['password']);
		 if($pswd == $_POST['cfmpswd'])
		  {
		   $er=pswd_validation($pswd, 'Password');
	       if($er!=1)
			 $errors[] = $er;
		   else 
			 $pswd = mysqli_real_escape_string($dbc, trim($pswd));	
			 //echo $pswd;	
		  }
		 else
		  $errors[] = "Password and Confirm Password must match.";
//-------- validate address ---------------
    include("includes/validate_address.inc.php");
			
//--------------- display errors ----------------
     if(empty($errors))	
		{
	//----------------Check - email----------------				 
		 $q = "SELECT email FROM registered_users WHERE email = '$email' ";
		 $r= @mysqli_query($dbc, $q);
			 
		 if($r)
			{
			    $num = @mysqli_num_rows($r);
			     if($num>0)
			     $errors[] ='Please enter a different Email Address.';
					
			     else
				    {			     
					 $q = "INSERT INTO registered_users(email, pswd) VALUES('$email', SHA1('$pswd'))";						
			         $r = @mysqli_query($dbc, $q);						  
					    if(mysqli_affected_rows($dbc)==1)
					    {
						 $q = "SELECT user_id, email FROM registered_users WHERE email='$email' AND pswd=SHA1('$pswd')";
						 $r = mysqli_query($dbc, $q);
						 if($r)
						 {
						 $row=mysqli_fetch_array($r, MYSQLI_ASSOC);
						 $_SESSION['email']=$email;
						 $_SESSION['user_id'] = $row['user_id'];
						 $_SESSION['acess_id'] = 1;
						 $_SESSION['agent'] = md5($_SERVER['HTTP_USER_AGENT']);
						 $_SESSION['active']=1;						 
						 }
						 $q2 = "INSERT INTO address(firstname, lastname, address1, address2, city, state, zip, phone, flag_bs,toaddbook,user_id) ";
						 $q2.="VALUES('$fname', '$lname', '$address1', '$address2', '$city', '$state', '$zipcode', '$phone', '1', '1', {$row['user_id']})";
	                     $r2 = mysqli_query($dbc, $q2);
						 
					     $flag = 1;						
		                 echo '<h4 class="addform">Your account has been successfully created.</h4>';
						 echo '<div class="addform">';
						 if( isset($_SESSION['icf']))
						 {
						 header("Refresh: 5; URL=http://" . $_SERVER['HTTP_HOST'] ."/index.php?pagelet=items_cart" . SID);
						 echo '<p>You are being redirected to your Shopping Cart in 5sec.<a href="index.php?pagelet=items_cart" style="color:#600;">&#160;OR Continue </a></p>';
						 echo '<a href="index.php?pagelet=my_home" style="color:#600;">Click here to view Your Account</a><br/>';
						 }
						 
						 else
						 {
						 header("Refresh: 5; URL=http://" . $_SERVER['HTTP_HOST'] ."/index.php?pagelet=my_home" . SID);
						 echo '<p>You are being redirected to Your Account in 5sec.</p>';
						 echo '<a href="index.php?pagelet=my_home" style="color:#600;">OR Continue</a><br/>';
						 }
						 echo '</div>';
							
					    }											 	
					}	//end else																			 
			}// end first $r IF
					
		 else	
			{
			  echo '<p>'. mysqli_error($dbc).	'</p>';	  
			  echo '<h5 class="addform"> System Error </h5> <p> You could not be registered due to a system error. We apologize for any inconvenience.</p>';		
	        }
				 //mysqli_free_result($r);	
		}//End of empty IF
		 
//========== close Data base Connection ===========
     mysqli_close($dbc);		 
		
		 // echo '<p>Please <a href="javascript:history.back();">go back and try again.</a></p>';
		
  }//End isset IF 	
 if($flag==0)
 {
 ?>
 
<h4 class="add_user_head"> Create Account</h4>
<div style="height:315px;">
<p class="chindicates">* Indicates Required field</p>  
<form method="post" action="" onsubmit="return validateform();" >
<div style="height:220px;">
    <div style="width:320px;float:left;">   	
		<div class="pay_info_row"><label for="email" class="log_info_label">* Email:</label>
		<input type="text" name="email" id="email" tabindex="1" maxlength="35" size="20"  value ="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>"/></div>
		
		<div class="pay_info_row"><label for="password" class="log_info_label">* Password:</label>
		<input type="password" name="password" id="password" tabindex="2" maxlength="35" size="20" /></div>
		
		<div class="pay_info_row"><label for="cfmpswd" class="log_info_label">* Confirm Password:</label>
		<input type="password" name="cfmpswd" id="cfmpswd" tabindex="3" maxlength="35" size="20"/> </div><br/>
		<?php
		if(!empty($errors))
		display_error($errors);
		?>
	<div class="createbutton"> <input type="submit" name="create_account" id="create_account" tabindex="12" value="Create Account" /></div>
	</div>
	<div style="width:320px;float:right;margin-right:140px;">
		<?php
		$fn=4; $ln=5; $ad1=6; $ad2=7; $cty=8; $num=9; $zp=10; $ph=11;  
		
		include("includes/address_info.inc.php");		
		 ?>
		
	</div>
</div>	
	
	</form>
</div>
		 


	<?php  }} ?>