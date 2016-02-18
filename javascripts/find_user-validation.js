function validateform()
{
  var email = document.forms[0].email.value;
  var fname = document.forms[0].fname.value;
  var lname = document.forms[0].lname.value;
  
  if(fname == "" && lname == "" && email=="")
      {			
        alert("Please fill in First name OR Last Name OR both OR Email.");
                document.forms[0].fname.focus();
        return false;
      }
  
	if(!email=="")
	{
		var eexp=/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/
		if(email.search(eexp) == -1)
		{
		alert("Please enter a valid Email address.");
		document.forms[0].email.focus();
		return false;
		}
	}
									
 return true;

}//Endfunction  
