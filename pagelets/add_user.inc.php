<?php  error_reporting(E_ALL);
  include("functions/password_validation.inc.php");
	$errors = array();//initialize an error array
	$flag = 1; 
		 
//--------------- Validate Add Login Information Form -------------------
		
if(isset($_POST['adduser'])) 
 { 
   //-------------- variables ---------
   $acessgroup = $_POST['acessgroup'];
   $email = trim($_POST['email']);
   $password = $_POST['password'];
   $cfmpassword = $_POST['cfmpassword']; 



//----- validate acess group	------   
  if(!strlen($acessgroup) > 0)	
	 $errors[]= 'Please select an acess group.';


//----- validate email	------
  include("functions/email_validation.inc.php");	 
	
//------ validate password ----
	if($password == $cfmpassword)
	  {
	   $er=pswd_validation($password, "Password"); //call function	
		 if($er!=1)
			$errors[] = $er;
		 else 
			 $pswd = mysqli_real_escape_string($dbc, trim($password));		 
	   }
	else	
	 $errors[] = 'The Password and Confirmation Password must match.';	
	 
//-------- validate address ---------------
    include("includes/validate_address.inc.php");
				
		
	if(empty($errors))
	  {  // checking email 
		$q = "SELECT email FROM registered_users WHERE email = '$email' ";
		$r= @mysqli_query($dbc, $q);
			   // OR die("Error: ".mysqli_error($dbc));
				
		if($r)
		{ 
		 $num = @mysqli_num_rows($r);
		 if($num>0)						
			$errors[]='Please enter a different Email Address.';						 			 
			
		 else
		 {
			//getting acess id
			$q ="SELECT acess_id FROM acess_type WHERE acesstype = '$acessgroup' ";
			$r= @mysqli_query($dbc, $q);				      
			$row =mysqli_fetch_array($r, MYSQLI_NUM);
			mysqli_free_result($r);
							 
			//inserting login info
			$q = "INSERT INTO registered_users(email, pswd, acess_id) VALUES('$email', SHA1('$pswd'), $row[0])";
			$r=@mysqli_query($dbc, $q); 
			$uid=mysqli_insert_id($dbc);
														
			$q= "INSERT INTO address(firstname, lastname, address1, address2, city, state, zip, phone, flag_bs,toaddbook,user_id) "; 
			$q.="VALUES('$fname', '$lname', '$address1', '$address2', '$city', '$state', '$zipcode', '$phone', '1', '1', $uid)";
			$r=@mysqli_query($dbc, $q);
								   
			if($r)								 
			 {
				$flag = 0;
				if($acessgroup != 'Admin')
				echo '<h5 class="addform">'.$fname.' '.$lname.' '.'has been successfully added as a '. $acessgroup.' </h5><br/>';
				
				else
				echo '<h5 class="addform">'.$fname.' '.$lname.' '.'has been successfully added as an '. $acessgroup.' </h5><br/>';
				
				 echo '<div class="addform"><a href="index.php?pagelet=add_user">back to Add User.</a></div>';}								  
		 }//End isset active
		}					
		
	
         else	
			{
			    echo '<p>'. mysqli_error($dbc).	'</p>';	  
			    echo '<h5 class="addform"> System Error </h5> <p> New User could not be added due to a system error. We apologize for any inconvenience.</p>';		
	        }
        }
 //========== close Data base Connection ===========
      mysqli_close($dbc);	 
}//End isset if
if($flag==1)
{   
?> 
<h3 class="add_user_head">Add User</h3>
<div style="height:315px;">
<p class="chindicates">* Indicates Required field</p>  
<form method="post" action="" onsubmit="return validateform();" >
<div style="height:220px;">
    <div style="width:320px;float:left;">  		
		 
		  <div class="pay_info_row"><label for="acessgroup" class="log_info_label">Acess Group:</label>
	         <select name="acessgroup" id="acessgroup" tabindex="1" style="font-size:12px;">
		         <option value="" selected="selected">Select an Acess Group</option>
			       <?php 
			       $group=array(1=>'Customer', 'Manager', 'Admin');
			       $sticky = (isset($_POST['acessgroup'])? $_POST['acessgroup']:"");
 				      foreach($group as $key => $value)
	              {	
		 						 echo "<option value=\"$value\"";
			 					  if($sticky==$value) echo "selected=\"selected\"";
									echo ">$value</option>\n";
								}//End foreach
			        ?>
		        </select></div>
		
		   <div class="pay_info_row"><label for="email" class="log_info_label">Email:</label>
		          <input type="text" name="email" value= "<?php if (isset($_POST['email'])) echo $_POST['email']; ?>"
					    id="email" tabindex="2" maxlength="40"  /></div>
		
		   <div class="pay_info_row"><label for="password" class="log_info_label">Password:</label>
		          <input type="password" name="password" id="password" tabindex="3" maxlength="30" /></div>
		
		  <div class="pay_info_row"><label for="cfmpassword" class="log_info_label">Confirm Password:</label>
		          <input type="password" name="cfmpassword" id="cfmpassword" tabindex="4" maxlength="30"  /></div>
		<?php
		if(!empty($errors))
		display_error($errors);
		?>

	</div>
	
	<div style="width:320px;float:right;margin-right:140px;">
		<?php
		$fn=5; $ln=6; $ad1=7; $ad2=8; $cty=9; $num=10; $zp=11; $ph=12; 
		
		include("includes/address_info.inc.php");		
		 ?>
		
	</div>
	<div class="createbutton"> <input type="submit" name="adduser" id="adduser" tabindex="13" value="Add User" /></div>
</div>	
	
	</form>
</div>
 <?php  } ?> 