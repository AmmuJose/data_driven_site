<?php
$errors = array();
if(isset($_POST['search']))
	{ 	
	  $category =$_POST['category'];
	  
      if($_POST['category']=="")
         $errors[]= 'Please select a gift card Category.';	 	   
	   
	  if(!empty($errors))
         display_error($errors);
	  else
	  {
	  header("Location: http://" . $_SERVER['HTTP_HOST'] ."/index.php?pagelet=card_search_result&c=$category" . SID);
	  exit();
	  }
	}

?>

<h3 class="add_user_head"> &#160; Gift Card Search </h3>
<div class="addform">
 <p class="buyindicates">* Indicates required field</p>
   <form method="post" action="" onsubmit="return validateform();" > 
	  
	    <div class="log_info_row "><label for="category" class="log_info_label">* Category:</label>	
		   <select name="category" id="category" tabindex="2">	
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
        
        <div class="createbutton"> <input type="submit" name="search" id="search" tabindex="4" value="Search" /></div>				
	</form>
</div>	