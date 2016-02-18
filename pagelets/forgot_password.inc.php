<?php 
if(isset($_SESSION['agent']) && isset($_SESSION['acess_id']))
 echo 'You are loged in now. Logout to create new account';
 
else
 {
 $errors = array();//initialize an error array
 $flag=1;
  if(isset($_POST['submit']))
  {	 
	 include("functions/email_validation.inc.php");	
       //chek email on db			
		if(empty($errors))
		{
		 $q="SELECT user_id FROM registered_users WHERE email= '$email'";
		 $r=mysqli_query($dbc, $q);
		  if($r) 
            {
			if(mysqli_num_rows($r)==1)
			 {
			 $row=mysqli_fetch_array($r, MYSQLI_NUM);
			 $userid=$row[0];
			 mysqli_free_result($r);
			 
			 $p=substr(md5(uniqid(rand(), true)), 3, 10);
			 
			 $q="UPDATE registered_users SET pswd=SHA1('$p') WHERE  user_id=$userid LIMIT 1";
			 $r=@mysqli_query($dbc, $q);
			
			  if(mysqli_affected_rows($dbc)==1)
			   {
			    $flag=0;
				
			    $body="Your password to log into Garroway Restaurant has been temporarily changed to '$p'. Please log in using this password. Then you may change your password to something more familiar.";
				mail($email, 'Your temporary password.', $body, 'From:admin@garroway.com');
				
				echo '<h4 class="confirm">Yor password has been changed. New password has been send to your email address. Once you have logged in with this password, you may change it by clicking on the "Change Password" link.&#160;<a href="index.php?pagelet=login_options">Go to Login page</a></h4>';				
			   }
			  else
			   echo "<p>Error !<br/> Your password could not be changed due to a system error.<br/>We apologize for any inconvenience.</p>";
			 
			 }//end of num rows
			else
			 echo "<p>Error !<br/> The submitted Email address does not match those on file.</p>";	
		    }
		  else
		   echo "<p>Error !<br/> Your password could not be changed due to a system error.<br/>We apologize for any inconvenience. Please try later.</p>";
		   mysqli_close($dbc);
		}
		else
		 display_error($errors);
				  
  }//End isset
  if($flag==1)
  {
	 ?>
 
 <div class="add_user_head"><h4>Enter Your Email Address</h4></div> 
 <div class="addform">
    <form method="post" action="" onsubmit="return validateform();">
     <div class="log_info_row "><label for ="email" class="log_info_label">Email: </label>      
        <input type ="text" name="email" id="email" maxlength="40" size="20" class="logininput" value ="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" tabindex="1"/> <input type="submit" name="submit" value="Submit" /> </div>  
	</form>
 </div>  
 <?php 
 } }//end of flag if
 ?>