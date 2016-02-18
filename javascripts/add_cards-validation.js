function validateform()

{
var cardimage = document.forms[0].cardimage.value;
var cardname = document.forms[0].cardname.value;
var category = document.forms[0].category.value;
 if(category=="")
 {
  alert("Please fill in gift card category");
	document.forms[0].category.focus();
  return false;
 }
 if(cardname=="")
 {
  alert("Please fill in gift card name");
	document.forms[0].cardname.focus();
  return false;
 }

 if(cardimage=="")
 {
  alert("Please choose an image to upload.");
	document.forms[0].cardimage.focus();
  return false;
 }
 
return true;
}//End function