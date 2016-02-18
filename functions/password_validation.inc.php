<?php  error_reporting(E_ALL); 
   function pswd_validation($pswd, $pswdname)
   {
    if(strlen($pswd) > 0)
    {
      if(!preg_match("/^[_0-9a-zA-Z]{7,45}$/", $pswd))
			{	       
	     $error = "$pswdname must be at least 7 characters long and contain only digits, letters and underscore.";	
			 return $error;
			}
			return 1;    	
    }//Endif		
    else
		{    
    $error = "Please enter $pswdname.";
		return $error;
		}   
}//End function
 ?>
