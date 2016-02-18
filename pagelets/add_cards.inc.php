<?php 
error_reporting(E_ALL);
$errors = array();//initialize an error array

   if(isset($_POST['add']))
    {     
     $cardname=trim($_POST['cardname']);
	 $category =$_POST['category'];	
    		
//----------- check box--------------
  if(isset($_POST['activate']))
	  $chkbox=1;
  else
	  $chkbox=0;

//-----card category validation------

   if($_POST['category']=="")
    $errors[]= 'Please select a gift card Category.';
	
//-----card name validation------

  if(!strlen($cardname)>0) 
   $errors[]= 'Please Fill in Gift Card Name';	
	
  else
	 $cardname = escape_data($cardname);
	
//----------- validating image --------------

$allowedfiles = array("image/gif", "image/jpeg", "image/jpg", "image/pjpeg");

   $size=@getimagesize($_FILES['cardimage']['tmp_name']); 
   
 //==========================original image  ========================
	if(($_FILES['cardimage']['size'] ==0))
		$errors[]= 'Please choose an image to upload.';  
	
    elseif (!(in_array(strtolower($_FILES['cardimage']['type']),$allowedfiles))) 
    $errors[]= 'You can only upload jpg or gif image files.';	
 
    elseif(($_FILES['cardimage']['size'] >204800))
    $errors[]= 'Image size can be only upto 200Kb.';
	
	elseif($size[0] > 500 || $size[1] > 320)
	$errors[]=  'Image height and/or width are too big!';
	
	elseif (file_exists("/home/student315/uploads/" . $_FILES["cardimage"]["name"])) 
	$errors[]= 'File "'. $_FILES["cardimage"]["name"] . '" already exists.';
	
	else
	  {
	  if($_FILES['cardimage']['error'] > 0)
	  {
		 switch($_FILES['cardimage']['error'])
		 {
		    case 3:
			 $errors[]= 'The file was only partialy uploaded.';
			 break;
			 
			case 6:
			 $errors[]= 'No temporary folder was available.';
			 break;
			 
			case 7:
			 $errors[]= 'Unable to write to disk.';
			 break;
			 
			case 8:
			 $errors[]= 'File uploaded stopped.';
			 break;
			  
			default:
			 $errors[]= 'System error! We apologize for any inconvenience.';
			 break;
			 }//End switch 
		  }//end if file error
		 }//end else       
         
  
	if(!empty($errors))
     { display_error($errors);}
	
	if(empty($errors)) 
	 {  
	    $file_path= "/home/student315/uploads/{$_FILES['cardimage']['name']}";
	    //move original image to afolder
		move_uploaded_file($_FILES['cardimage']['tmp_name'], $file_path);
		
	//create thump nail
		$tn_width=167; 
		$tn_height=100;		
		
		if((strtolower($size['mime'])) == "image/gif")
		{
		$source=imagecreatefromgif($file_path);
		$width=imagesx($source); 
        $height=imagesy($source); 
        $newimage=imagecreatetruecolor($tn_width,$tn_height);
		imagecopyresized($newimage,$source,0,0,0,0,$tn_width,$tn_height,$width,$height);       
		ob_start();  
		imageGIF($newimage);
		$thumbnail = ob_get_contents(); 
		ob_end_clean();		
		}
		
		if((strtolower($size['mime'])) == "image/jpeg" || (strtolower($size['mime'])) == "image/jpg")
		{
		$source=imagecreatefromjpeg($file_path);
		$width=imagesx($source); 
        $height=imagesy($source); 
        $newimage=imagecreatetruecolor($tn_width,$tn_height);
		imagecopyresized($newimage,$source,0,0,0,0,$tn_width,$tn_height,$width,$height);       
		ob_start();  
		imagejpeg($newimage);
		$thumbnail = ob_get_contents(); 
		ob_end_clean();		
		}
       
	    $thumbnail= addslashes($thumbnail);
		
	    $q = "SELECT category_id FROM card_category WHERE category = '$category'";
		$r = mysqli_query($dbc, $q)
		     OR die("Error: ". mysqli_error($dbc));
			 
		$row = mysqli_fetch_array($r, MYSQLI_ASSOC);
		  $category_id = $row['category_id'];	
		  
	   $q = "INSERT INTO card_image (category_id, cardname, imgtype, cardimg, filename, flag_a) VALUES ($category_id, '$cardname','{$size['mime']}','$thumbnail','{$_FILES['cardimage']['name']}', $chkbox)";
		$r = mysqli_query($dbc, $q);
		   if($r)
             echo '<h4 class="addform chindicates">Image has been successfully uploaded.</h4>';
		   else
		     echo '<p>System error! Image could not be uploaded. We apologize for any inconvenience.</p>'. mysqli_error($dbc);;
		
	 }
		
mysqli_close($dbc);
}//End isset IF	

?> 

<h3 class="add_user_head"> Add a Gift Card </h3>
<div class="addform">
   <form method="post" action="" enctype="multipart/form-data"  onsubmit="return validateform();" >  
	 <p class="buyindicates">* Indicates required field</p>
	  <div class="log_info_row "><label for="category" class="log_info_label">*Category:</label>	
		   <select name="category" id="category" tabindex="1">	
		  <?php 
			  $categoryarray = array(1=>"Birthday", "Anniversary", "Thank You", "All Occation","Seasonal");	
			 echo "<option value=\"\" selected=\"selected\">Select a Category</option>\n";
			   $sticky = (isset($_POST['category'])? $_POST['category']:"");
 				 foreach($categoryarray as $key => $value)
					{
					  echo "<option value=\"$value\" ";
			      if($sticky==$value) echo "selected=\"selected\"";
		        echo ">$value</option>\n";
					}
      ?></select></div>		  
		
		<div class="log_info_row "><label for="cardname" class="log_info_label">*Card Name:</label>
		   <input type="text" name="cardname" value= "<?php if (isset($_POST['cardname'])) echo $_POST['cardname']; ?>"
					 id="cardname" tabindex="2" maxlength="40" /></div>						 
	   
		<div class="log_info_row2"><label for="cardimage" class="log_info_label">*Gift Card Image:<small>(Max file size: 200K, File types: gif / jpg, Max width:500, height:320)</small></label>
		    <input type="file" name="cardimage" id="cardimage" tabindex="3" /></div>
		
		<div class="log_info_row"><label for="activate" class="checkboxlabel"> &#160; Activate this card</label>
		   <input type="checkbox" name="activate" id="activate" tabindex="4"  class="checkbox"  value="yes"/></div>		
		
		<div class="rowbutton"> <input type="submit" name="add" id="add" tabindex="5" value="Add Gift Card"/></div>			
   </form>	
</div>
