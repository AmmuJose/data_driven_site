<?php  error_reporting(E_ALL);
if(isset($_SERVER['HTTP_REFERER']))
{
if($_SERVER['HTTP_REFERER']== 'http://' . $_SERVER['HTTP_HOST'] .'/index.php?pagelet=items_cart')
 $_SESSION['icf']=1; 
}

include("functions/password_validation.inc.php");
$errors = array();//initialize an error array	

if(isset($_POST['login']))
{	   
	include("functions/email_validation.inc.php");
	 
	$pswd = $_POST['password'];
	 
//call pswd validating function
	$er=pswd_validation($pswd, 'Password');
	if($er!=1)
	 $errors[] = $er;
	else 
	 $pswd = mysqli_real_escape_string($dbc, trim($pswd));		
	 
//chek error array				
	if(empty($errors))
	{
	 $_SESSION['email']=$email;
	 $q = "SELECT user_id, acess_id, active_user FROM registered_users WHERE email='$email' AND pswd=SHA1('$pswd') ";
	 $r = @mysqli_query($dbc, $q);

		if(mysqli_num_rows($r) == 1)
		{		    
		$row=mysqli_fetch_array($r, MYSQLI_ASSOC);
			if($row['active_user']==1)
			{
			$_SESSION['user_id'] = $row['user_id'];
			$_SESSION['acess_id'] = $row['acess_id'];
			$_SESSION['agent'] = md5($_SERVER['HTTP_USER_AGENT']);	
            
				if($_SESSION['acess_id'] == 1)
				{
				if( isset($_SESSION['icf']))
				header("Location: http://" . $_SERVER['HTTP_HOST'] .'/'.$APATH."/index.php?pagelet=items_cart" . SID);
				
				else
				header("Location: http://" . $_SERVER['HTTP_HOST'] .'/'.$APATH."/index.php?pagelet=my_home" . SID);
				
				exit();			  
				}//end of acessid==1
			  
				if($_SESSION['acess_id'] == 2)
				{
				if( isset($_SESSION['icf']))
				header("Location: http://" . $_SERVER['HTTP_HOST'] .'/'.$APATH."/index.php?pagelet=items_cart" . SID);
				
				else
				header("Location: http://" . $_SERVER['HTTP_HOST'] .'/'.$APATH."/index.php?pagelet=my_home" . SID);
				
				exit();		
				}
				
				if($_SESSION['acess_id'] == 3)
				{
			    if( isset($_SESSION['icf']))
				header("Location: http://" . $_SERVER['HTTP_HOST'] .'/'.$APATH."/index.php?pagelet=items_cart" . SID);
				
				else
				header("Location: http://" . $_SERVER['HTTP_HOST'] .'/'.$APATH."/index.php?pagelet=my_home" . SID);
				
				exit();					
				}//end of acessid==3
			   
			}//end of active user 
			 
			else
			echo '<p class="perror">Error!<br/>Your account has been disabled.</p>';
		}//end of if num_rows
		else	                        	
		echo '<p class="perror">No match found.</p>';	
        
	}//end of if empty errors
	else
	echo '<p class="perror">Email / Password combination is not correct.</p>';			  
 }//End isset		   

?>
<!-- signin form -->
<div style="color:#400;float:right;padding-right:40px;"><b> Test Login Accounts:</b><br/>admin@garroway.com/password<br/>manager@garroway.com/password<br/>guest@somewhere.com/password</div>
<div class="returning_cust"><h4> Returning Customer</h4> </div>
<div class="returning_cust">  
	<form method="post" <?php echo "action=\"index.php?pagelet=$pagelet\""?> onsubmit="return validateform();">

     <div class="log_info_row ">
     <label for ="email" class="log_info_label">Email: </label>
     <input type ="text" name="email" id="email" maxlength="40" size="25"  value ="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" tabindex="1" /></div>    
     
     <div class="log_info_row ">
     <label for ="password" class="log_info_label">Password: </label>
     <input type = "password" name="password" id="password" maxlength="40" size="25" class="logininput" tabindex="2"/>  </div>                           
     <div class="loginrc"><input type="submit" name="login" id="login" value="Login" tabindex="3" />
	 <a href="index.php?pagelet=forgot_password" style="margin-left:20px;">Forgot Password?</a></div>
	 
    </form>
    
	<br/>
<!-- Create Account -->
	<h4> New Customer </h4>     
     <form  method="post" action="index.php?pagelet=create_account">
      <div class="loginrc"><input type="submit" name="account" id= "account" value="Create Account" tabindex="4"/></div>
	 </form>     
</div>
