function validateform()
{
   var heading = document.getElementById("heading").value.length;	
   var textbox_chra =0;
   textbox_chra= document.getElementById("content").value.length;
	 var newsboard = "Left";
	  if (document.forms[0].newsboard[1].checked == true)
		    newsboard  = "Right";
	 
	 if (heading == "")
      {
        alert("Please fill News Board Heading.");
                document.forms[0].heading.focus();
        return false;
      }
	 if(textbox_chra == 0)
      {
           alert("Please enter the News Board Content.");
					 document.forms[0].content.focus();
	         return false;
					 
      }
	  
    if(textbox_chra >= 255)
      {
           alert("You have reached the maximum allowed characters in the message box.");
					 document.forms[0].content.focus();
	         return false;					 
      }
			
			 var agree=confirm("You are going to update the News Board on "+ newsboard+ ".");
       if (agree)
	       return true ;
       else
	       return false ;

  return true; 
}


function validatemsg()
{
 var textbox_chra=0;
  textbox_chra = document.getElementById("content").value.length; 
  if(textbox_chra > 255)
  {
  alert("You have entered "+ textbox_chra +" characters in message box.\nPlease limit your message in 225 characters");
	document.forms[0].content.focus();
	return false;
  }
  return true;
}