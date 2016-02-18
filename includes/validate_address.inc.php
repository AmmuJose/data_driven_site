<?php
//-----address validation------
function address_validation($var)
{
 if(strlen($var)>0)
 return $var;
 
 else
 $var = FALSE;
}

$fname =escape_data(trim($_POST['fname']));
$lname = escape_data(trim($_POST['lname']));
$address1 =escape_data(trim($_POST['address1']));
$address2 = escape_data(trim($_POST['address2'])); 
$city = escape_data(trim($_POST['city']));
$state = escape_data($_POST['state']);
$zipcode = escape_data($_POST['zipcode']);
$phone = escape_data($_POST['phone']);


//-----first name validation------
$fname=address_validation($fname);
if(!$fname)
$errors[] = 'Please Fill in First Name.';

//-----last name validation------
$lname=address_validation($lname);
if(!$lname)
$errors[] = 'Please Fill in Last Name';

//-----address1 validation------
$address1=address_validation($address1);
if(!$address1)
$errors[] = 'Please Fill in Address1';

//-----city validation------
$city=address_validation($city);
if(!$city)
$errors[] = 'Please Fill in City';

//-----statevalidation------
$state=address_validation($state);
if(!$state)
$errors[] = 'Please Fill in State';

//-----zipcode validation------
$zipcode=address_validation($zipcode);
if(!$zipcode)
$errors[] = 'Please Fill in Zip Code.';
else
{
 if(!preg_match("/^[0-9]{5}$/", $zipcode)) 
 $errors[] = 'Zip Code must be a 5-digit number.';		
}

//-----phone number validation------
$phone=address_validation($phone);
if(!$phone)
$errors[] = ' Please Fill in Phone Number';
else
{
 if(!preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $phone))
  $errors[] = 'Phone Number must be in correct format(407-555-5555).'; 
	
}
?>