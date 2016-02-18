<?php  error_reporting(E_ALL); 
 
 $id=$_SESSION['user_id'];   
 $errors = array();//initialize an error array
 
 include("functions/password_validation.inc.php");

    if(isset($_POST['update']))
    {
		/* ------ 	variables		------- */
	$currentpswd =$_POST['currentpswd'];
	$cfmpswd = $_POST['cfmpswd'];   
	$newpswd = $_POST['newpswd']; 

	//------ validate password ----		
		  $er = pswd_validation($currentpswd, "Current Password");		 
		  if($er!=1)
			$errors[] = $er;		 
		  else
		   $currentpswd=mysqli_real_escape_string($dbc, $currentpswd);
		 
		   
	   if($newpswd == $cfmpswd)
		 {		 
		  $er = pswd_validation($newpswd, "New Password and Confirm Password"); //call function
			if($er!=1)
			 $errors[] = $er;
            else
		    $newpswd= mysqli_real_escape_string($dbc, $newpswd);			
		 }
	    
	   else	  
	    $errors[] = 'The New Password and Confirmation Password must match.';	   
		 
		//chek error array				
		if(empty($errors))
		 {		 
		  $q="SELECT * FROM registered_users WHERE (user_id=$id AND pswd=SHA1('$currentpswd'))"; 
		  $r=mysqli_query($dbc,$q);
		  if(mysqli_num_rows($r) ==1)	
           {
			$q="UPDATE registered_users SET pswd=SHA1('$newpswd') WHERE user_id=$id";
			$r=mysqli_query($dbc,$q);
			if($r)
			{
			if(mysqli_affected_rows($dbc) ==1)
		    echo '<h4 class="addform chindicates">Your password has been successfully updated</h4>';
			else
			echo '<p class="perror">You didn\'t change your password<p>';
			}
			else
			echo '<p class="perror"> System Error!<br/> Password could not be changed due to a system error. We apologize for any inconvenience.</p>';
           }		   
		  else
		   echo '<p class="perror">Error!<br/>Your current password doesn\'t match those on record.</p>';
		 }//end of empty errors
		else
		 display_error($errors);
		 
	}//end isset   
 ?>

<!-- Start Form -->
<br/>
<div class="addform">   
   <form method="post" action="" onsubmit="return validateform();" >	 
	   <p class="chindicates">* Indicates Required field</p>
		<div class="log_info_row "><label for="currentpswd" class="log_info_label">* Current Password:</label>
		<input type="password" name="currentpswd" id="currentpswd" tabindex="1" maxlength="30" size="22" value= "<?php if(isset($_POST['currentpswd'])) echo $_POST['currentpswd']; ?>"/></div>
		
		<div class="log_info_row "><label for="newpswd" class="log_info_label">* New Password:</label>
		<input type="password" name="newpswd" id="newpswd" tabindex="2" maxlength="30" size="22" /></div>
		
		<div class="log_info_row "><label for="cfmpswd" class="log_info_label">* Confirm New Password:</label>
		<input type="password" name="cfmpswd" id="cfmpswd" tabindex="3" maxlength="30" size="22"/> </div><br/>		 
		
		<div class="loginrc"> <input type="submit" name="update" id="update" tabindex="4" value="Update" />
		      <input type="reset" name="cancel" id="cancel" tabindex="5" value="Cancel" /></div>
		</form>
</div>	