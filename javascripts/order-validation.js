function validateorderid()
{
var orderid = document.forms[0].orderid.value;
oexp=/^[5-9][0-9]{3,11}$/
if(orderid =="")
 	{ 
 	 alert("Please enter an Order ID.");
	 document.forms[0].orderid.focus();
	  return false;
 	}
	if(orderid.search(oexp) == -1)
	{
	alert("Please enter a valid Order ID.");
	document.forms[0].orderid.focus();
	return false;
	}	  

return true;
}//Endfunction  

function validateform()
{
 var m1 = document.forms[1].m1.value;
 var d1 = document.forms[1].d1.value;
 var y1 = document.forms[1].y1.value;
 var m2 = document.forms[1].m2.value;
 var d2 = document.forms[1].d2.value;
 var y2 = document.forms[1].y2.value;
 var status=document.forms[1].status.value;
	if(m1 ==0 && d1 ==0 && y1==0 && m2 ==0 && d2 ==0 && y2==0 && status=="")
 	 { 
		alert("Please select Date and/or Status.");
		document.forms[1].status.focus();
		return false;
 	 }
 return true;

}//Endfunction
