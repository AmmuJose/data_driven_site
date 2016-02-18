function validateform()
{ 
 var fname = document.forms[0].fname.value;
 var lname = document.forms[0].lname.value;
 var address1 = document.forms[0].address1.value;
 var city = document.forms[0].city.value; 
 var states = document.forms[0].state.value; 
 var zipcode = document.forms[0].zipcode.value;
 var phone = document.forms[0].phone.value;
 
 // ---- payment method variables -------
  var cardtype = document.forms[0].cardtype.value;
  var cardnum = document.forms[0].cardnum.value;
  var code = document.forms[0].code.value;
  var nameoncard = document.forms[0].nameoncard.value; 
  var expmonth = document.forms[0].expmonth.value; 
	var expyear = document.forms[0].expyear.value;
				
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

if (phone == "")
      {
        alert("Please fill in your Phone Number.");
                document.forms[0].phone.focus();
        return false;
      }		
			
//-------Payment Method -------------------------
if (cardtype == "")
      {
        alert("Please select a Credit Card Type.");
                document.forms[0].cardtype.focus();
        return false;
      }	

if (cardnum == "")
      {
        alert("Please fill in Credit Card Number.");
                document.forms[0].cardnum.focus();
        return false;
      }	


if (code == "")
      {
        alert("Please fill in Security Code.");
                document.forms[0].code.focus();
        return false;
      }	

if (expmonth == "")
      {
        alert("Please Select an Expiration Month.");
                document.forms[0].expmonth.focus();
        return false;
      }	

if (expyear == "")
      {
        alert("Please Select an Expiration Year.");
                document.forms[0].expyear.focus();
        return false;
      }	
if (nameoncard == "")
      {
        alert("Please Select Name on Card.");
                document.forms[0].nameoncard.focus();
        return false;
      }	
											
 return true;
}//Endfunction
  
