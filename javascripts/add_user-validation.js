function validateform()
{
var acessgroup = document.forms[0].acessgroup.value;
 var email = document.forms[0].email.value;
 var password = document.forms[0].password.value;
 var cfmpswd = document.forms[0].cfmpassword.value;
 var fname = document.forms[0].fname.value;
 var lname = document.forms[0].lname.value;
 var address1 = document.forms[0].address1.value;
 var city = document.forms[0].city.value; 
 var states = document.forms[0].state.value; 
 var zipcode = document.forms[0].zipcode.value;
 var phone = document.forms[0].phone.value;
 
 if (acessgroup == "")
      {
        alert("Please fill in Acess Group.");
                document.forms[0].acessgroup.focus();
        return false;
      }
 
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
	
var pexp=/^[_0-9a-zA-Z]{7,45}$/	
 if (password.search(pexp) == -1)
      {
		alert("Password must be at least 7 characters long and contain only digits, letters and underscore.");
		document.forms[0].password.focus();
		return false;
      }
if (cfmpswd.search(pexp) == -1)
        {
		alert("Password must be at least 7 characters long and contain only digits, letters and underscore.");
		document.forms[0].password.focus();
		return false;
      }
if(cfmpswd != password)
	 {
        alert("Password and Confirm Password must match.");
                document.forms[0].cfmpswd.focus();
        return false;
      }  
	  
	  if (fname == "")
      {
        alert("Please fill in your First Name.");
                document.forms[0].fname.focus();
        return false;
      }	

if (lname == "")
      {
        alert("Please fill in your Last Name.");
                document.forms[0].lname.focus();
        return false;
      }	

if (address1 == "")
      {
        alert("Please fill in Address1.");
                document.forms[0].address1.focus();
        return false;
      }	


if (city == "")
      {
        alert("Please fill in City.");
                document.forms[0].city.focus();
        return false;
      }	

if (states == 0)
      {
        alert("Please Select a State.");
                document.forms[0].state.focus();
        return false;
      }	

if (zipcode == "")
      {
        alert("Please fill in Zip Code.");
                document.forms[0].zipcode.focus();
        return false;
      }	
var zexp=/^[0-9]{5}$/
if(zipcode.search(zexp) == -1)
	{
	alert("Please enter a valid Zipcode.");
	document.forms[0].zipcode.focus();
	return false;
	}

var ph=/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/
if (phone == "")
      {
        alert("Please fill in your Phone Number.");
                document.forms[0].phone.focus();
        return false;
      }	
if(phone.search(ph) == -1)
	{
	alert("Please enter a valid Phone Number.");
	document.forms[0].phone.focus();
	return false;
	}	  
			
return true;
}

