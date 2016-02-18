function validateform()
{
 var currentpswd = document.forms[0].currentpswd.value;
 var newpswd = document.forms[0].newpswd.value;
 var cfmpswd = document.forms[0].cfmpswd.value;
 
  if (currentpswd == "")
      {
        alert("Please fill in your Current Password.");
                document.forms[0].currentpswd.focus();
        return false;
      }
	
			
  		
  if (newpswd == "")
      {
        alert("Please fill in New Password.");
                document.forms[0].newpswd.focus();
        return false;
      }
			
 if (cfmpswd == "")
       {
        alert("Please fill in Confirm New Password.");
                document.forms[0].cfmpswd.focus();
        return false;
	}
											
 return true;

}//Endfunction
  
