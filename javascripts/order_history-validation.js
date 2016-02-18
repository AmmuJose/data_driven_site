function validateform()
{
 var m1 = document.forms[0].m1.value;
 var d1 = document.forms[0].d1.value;
 var y1 = document.forms[0].y1.value; 
 
	if(m1 !='' && d1 !='' && y1!='')
	{ 
		var from = m1+'/'+d1+'/'+y1;  
		var from_date=new Date(from);
	}
	else
	{
		alert("Please select a From Date");		
		return false;	
	}
	
 var m2 = document.forms[0].m2.value;
 var d2 = document.forms[0].d2.value;
 var y2 = document.forms[0].y2.value;
 
 	 
   if(m2 !='' && d2 !='' && y2!='')
   {
	var to = m2+'/'+d2+'/'+y2;
	var to_date=new Date(to);	 	
   } 
   else
	{
		alert("Please select a To Date");		
		return false;	
	}
  
 if(from_date > to_date)
 {
	alert("From Date can not be larger than To Date.");
	return false;
 }
 
  
 return true;

}//Endfunction
