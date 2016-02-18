<?php 
 $email = trim($_POST['email']);
//email validation    
	 if(strlen($_POST['email'])<=0) 		
		 $errors[] = 'Please enter an Email address.';
	 else
	    {		  
		  if(preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i", $email))		 
            $email = escape_data($email);		  	 
		  else			 
			$errors[] = 'Your Email address is not valid.';	
		}//End else			
		
  ?>