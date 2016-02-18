<?php   
if(isset($_POST['submit']))
{  
  $errors = array();//initialize an error array  
  $content=trim($_POST['content']);
	$heading = trim($_POST['heading']);
	$select_board = $_POST['newsboard'];	
	
	//validate hedding	 
	if(strlen($heading)<=0)
   $errors[] = 'Please Fill in News Boaer Heading';
	
	else
	 $heading = escape_data($heading);
	 
 //validate content 
  if(strlen($content)>255)
   $errors[] = 'Maximum 255 characters are allowed in message box.';
	 
	elseif(strlen($content)<=0)
   $errors[] = 'Please enter the News Board Content.';
	
	else
	 $content = escape_data($content);

  if(!empty($errors))	 
   display_error($errors);
	
	else	 
	  {
		 $q = "UPDATE news_board SET heading='$heading', content='$content' WHERE news_board_name='$select_board'";
	   $r = mysqli_query($dbc, $q);
		 if($r)
		  {
		   if(mysqli_affected_rows($dbc))
			  {		   	  
		    echo '<h5 class="update_msg">News Board on '. $select_board .' has been successfully updated.</h5>';
			  echo '<h5 class="update_msg"><a href="index.php?pagelet=index#news_board"> Go to News Board</a>.</h5>';
				}
			}			  
		 else			
		   echo '<p class="addform"> System Error! </p> <p>News Board could not be Updated due to a system error. We apologize for any inconvenience.</p>';	
		 //  echo '<p>'. mysqli_error($dbc).	'</p>';
		  
		 }//End else
		
mysqli_close($dbc);

}//isset

		?>

<br/>
<h4 class="add_user_head">Edit News Board</h4>
   <div class="addform">	
     <form method="post" action="" onsubmit="return validateform();">
		   <p class="rqd_fields">* Indicates Required Fields</p>	
			 	 	   		
		        <div class="select_height ">Select a News Board:
		         <input type="radio" name="newsboard" id="newsboardl" value = "Left" checked="checked" tabindex="1"  />
						 <label for="newsboardl" >News Board on Left</label></div>
						 <div class="board_right log_info_row">	    
		         <input type="radio" name="newsboard" id="newsboardr" value = "Right" tabindex="2" />
						 <label for="newsboardr">News Board on Right</label></div>
						 					 
			 <div class="log_info_row "><label for="heading" class="log_info_label">* Heading:</label>
		       <input type="text" name="heading" value= "<?php if (isset($_POST['heading'])) echo $_POST['heading']; ?>" id="heading" tabindex="4" maxlength="60" size="25"/></div>
					 
			 <div><label for="content" class="log_info_label">* Content: <small>(max 255 characters)</small></label>			    	   
			      <textarea name="content" id="content" rows="6" cols="35" tabindex="5" onkeyup="return validatemsg();"></textarea></div>
						
			 <div class="rowbutton"> <input type="submit" name="submit" id="submit" tabindex="6" value="Update"/>
			                           <input type="reset" name="reset" id="reset" tabindex="7" value="Reset"/></div>		
			</form>
   </div>			  
	<?php // } ?>