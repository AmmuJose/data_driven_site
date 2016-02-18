function validateform()
{
 var email = document.forms[0].email.value;
 var password = document.forms[0].password.value;
 
 if (email == "")
      {
        alert("Please fill in your Email address.");
                document.forms[0].email.focus();
        return false;
      }
	  
var eexp=/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/
if(email.search(eexp) == -1)
	{
	alert("Please enter a valid Email address.");
	document.forms[0].email.focus();
	return false;
	}
			
  if (password == "")
      {
        alert("Please fill in Password.");
                document.forms[0].password.focus();
        return false;
      }
	  		
return true;
}

