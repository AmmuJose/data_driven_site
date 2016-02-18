<?php
error_reporting(E_ALL);
$errors = array();//initialize an error array


function name_validation($var)
  {  
  if(strlen($var)<=0)
  return FALSE;	
  return $var; 
  }
if(isset($_POST['search']))
{
  //------- variables --------------
  $fname=trim($_POST['fname']);
  $lname=trim($_POST['lname']);
  $email=trim($_POST['email']); 
	 
  $fname=name_validation($fname);
  $lname=name_validation($lname);
  $email=name_validation($email);
  
  $_SESSION['sfn']=escape_data($fname);
  $_SESSION['sln']=escape_data($lname);
  $_SESSION['se']=escape_data($email);
 
  if(!$fname && !$lname && !$email)  
   echo '<p class="perror">* Please fill in Email or First Name or Last Name or First Name &amp; Last Name.</p>';  
 
  else 
	{ 
	 if($email)
	  { 
	   include("functions/email_validation.inc.php");
	   
	   if(!empty($errors))
		 display_error($errors);

//==============================Email Search ===================================		 
	   else
		{
		header("Location: http://" . $_SERVER['HTTP_HOST'] . "/index.php?pagelet=email_search" . SID);		
   		include("includes/footer.inc.php");
  		exit();
		}
//==============================EndEmail Search ===================================			
	 }
	 else
	  {
	    header("Location: http://" . $_SERVER['HTTP_HOST'] ."/index.php?pagelet=user_search_result" . SID);
		exit();
	   
	  }
	   
	}//End else
}//end of isset
?>
<h3 class="add_user_head">Search  User </h3>
<div class="addform">
   <form method="post" action="" onsubmit="return validateform();" >	 
	
		<div class="pay_info_row "><label for="fname" class="log_info_label">First Name:</label>
		<input type="text" name="fname" value= "<?php if (isset($_POST['fname'])) echo $_POST['fname']; ?>"
					 id="fname" tabindex="1" maxlength="30" size="25" /></div>		
		
		<div class="pay_info_row "><label for="lname" class="log_info_label">Last Name:</label>
		<input type="text" name="lname" value= "<?php if (isset($_POST['lname'])) echo $_POST['lname']; ?>"
					 id="lname" tabindex="2" maxlength="30" size="25" /> </div>	
		
		<!-- <div class="or"> OR </div> -->
		
		<div class="pay_info_row "><label for="email" class="log_info_label">Email:</label>
		<input type="text" name="email" value= "<?php if (isset($_POST['email'])) echo $_POST['email']; ?>"
					 id="email" tabindex="3" maxlength="40" size="25" /></div>			
	  
		<div class="createbutton"> <input type="submit" name="search" id="search" tabindex="4" value="Search" /></div>		
		      
	</form>
</div>
