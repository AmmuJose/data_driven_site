function validateform()
{ 
 var fname = document.forms[0].fname.value;
 var lname = document.forms[0].lname.value;
 var address1 = document.forms[0].address1.value;	 
 
 var city = document.forms[0].city.value; 
 var states = document.forms[0].state.value; 
 var zipcode = document.forms[0].zipcode.value;
 var phone = document.forms[0].phone.value;
 var shipmethod = document.forms[0].shipmethod.value;
 
				
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
			
if (shipmethod == "")
      {
        alert("Please select a Shipping Method.");
                document.forms[0].shipmethod .focus();
        return false;
      }												
 return true;
}//Endfunction

function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp=false;	
		try{
			xmlhttp=new XMLHttpRequest();
		}
		catch(e)	{		
			try{			
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e1){
					xmlhttp=false;
				}
			}
		}
		 	
		return xmlhttp;
    }


function getaddress(strURL)
{ 
  var req = getXMLHTTP();
  if (req)
  {
        //function to be called when state is changed
        req.onreadystatechange = function()
        {
          //when state is completed i.e 4
          if (req.readyState == 4)
          {
                // only if http status is "OK"
                if (req.status == 200)
				
                {  var a=req.responseText;
				   var ary=new Array();
				    ary=a.split('|');
                        document.getElementById('fname').value=ary[0];
						document.getElementById('lname').value=ary[1];
						document.getElementById('address1').value=ary[2];
						document.getElementById('address2').value=ary[3];
						document.getElementById('city').value=ary[4];
						document.getElementById('state').value=ary[5];
						document.getElementById('phone').value=ary[6];
						document.getElementById('zipcode').value=ary[7];
                }
                else
                {
                        alert("There was a problem while using XMLHTTP:\n" + req.statusText);
                }
          }
        }
        req.open("GET", strURL, true);
        req.send(null);
  }
} 

function clr()
{
 document.getElementById('fname').value='';
 document.getElementById('lname').value='';
 document.getElementById('address1').value='';
 document.getElementById('address2').value='';
 document.getElementById('city').value='';
 document.getElementById('state').value='';
 document.getElementById('phone').value='';
 document.getElementById('zipcode').value='';
}   