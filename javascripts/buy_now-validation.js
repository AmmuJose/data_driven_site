function validatelogin()
{
		var amount=document.getElementById("amount").value;
		var quantity =document.getElementById("quantity").value;
			
		if(amount=="")
		{
		 alert("Please Select an Amount.");
                 document.forms[0].amount.focus();
		 return false;
		}	
		var expquantity=/^\d{1,3}$/
		if(quantity<1 || quantity>100 ||quantity.search(expquantity)==-1 )
		{
		 alert("Quantity must be an integer value from 1 to 100.");
		 document.forms[0].quantity.focus();
		 return false;
		}
  return true;  
}//end of function validatlogin


function validatemsgchar()
{
 var textbox_chra = document.getElementById("msg").value.length; 
 if(textbox_chra >= 96)
 {
  alert("You have reached the maximum allowed characters in the Message Box.");
  document.forms[0].msg.focus();
  return false;
 }
  return true;
 
}//end of function validatemsgchar

function validatemsg()
{
 var textbox_chra = document.getElementById("msg").value.length; 
  if(textbox_chra > 96)
  {
  alert("You have entered "+ textbox_chra +" characters in Message Box.\nPlease limit your Message to 96 Characters.");
  document.forms[0].msg.focus();
  return false;
  }
 return true;
 
}//end of function validatemsg

function create_window(filename, type)
{  
 if(window.popup && !window.popup.closed)
  {
   window.popup.resizeTO(455, 285);   
  }
  
  var specs = "location=no,  scrollbars=no, menubars=no, toolbars=no, resizable=no, left=100, top=200, width = 455,height = 285";
  var url = "/includes/img.inc.php?filename="+filename+"&type="+type;
  popup = window.open(url, "ImageWindow", specs);
  popup.focus();
}