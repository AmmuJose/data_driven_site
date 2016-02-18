function validateform()
{
 var category= document.forms[0].category.value;
  if (category == "")
      {
        alert("Please select a Gift Card Category.");
                document.forms[0].category.focus();
        return false;
      }			
 return true;

}//Endfunction
  
