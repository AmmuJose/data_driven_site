<div class="addleft"> <!-- Left side -->	
		<div class="log_info_row "><label for="fname" class="log_info_label">*First Name:</label>
		<input type="text" name="fname" id="fname" tabindex="<?php echo $fn; ?>" maxlength="30" size="20" 
		value="<?php if(isset($_POST['fname'])) echo $_POST['fname']; else{if(isset($row['firstname'])) echo $row['firstname'];} ?>" /></div>

        <div class="log_info_row "><label for="lname" class="log_info_label">*Last Name:</label>
		<input type="text" name="lname" id="lname" tabindex="<?php echo $ln; ?>" maxlength="30"
		value="<?php if(isset($_POST['lname'])) echo $_POST['lname']; else{if(isset($row['lastname'])) echo $row['lastname'];} ?>" size="20" /></div>		
		
		<div class="log_info_row "><label for="address1" class="log_info_label">*Address Line1:</label>
		<input type="text" name="address1" id="address1" tabindex="<?php echo $ad1; ?>" maxlength="30" size="20" 
		value="<?php if(isset($_POST['address1'])) echo $_POST['address1']; else{if(isset($row['address1'])) echo $row['address1'];} ?>"/></div>
		
		<div class="log_info_row "><label for="address2" class="log_info_label">Address Line2:</label>
		<input type="text" name="address2" id="address2" tabindex="<?php echo $ad2; ?>" maxlength="30" size="20" 
		value="<?php if(isset($_POST['address2'])) echo $_POST['address2']; else{if(isset($row['address2'])) echo $row['address2'];} ?>"/></div>
		
		
		<div class="log_info_row "><label for="city" class="log_info_label">*City:</label>
		<input type="text" name="city" id="city" tabindex="<?php echo $cty; ?>" maxlength="30" size="20" 
		value="<?php if(isset($_POST['city'])) echo $_POST['city']; else{if(isset($row['city'])) echo $row['city'];} ?>"/></div>
		
		<div class="log_info_row "><label for="state" class="log_info_label">*State:</label>
		<?php 
	
			 $states = array('AL', 'AK', 'AZ', 'AR', 'CA', 'CO', 'CT', 'DE', 'FL', 'GA', 'HI', 'ID','IL', 
                   'IN', 'IA', 'KS', 'KY', 'LA', 'ME', 'MD', 'MA', 'MI', 'MN', 'MS', 'MO', 'MT',
       	           'NE', 'NV', 'NH', 'NJ', 'NM', 'NY', 'NC', 'ND', 'OH', 'OK', 'OR', 'PA', 'RI',
                   'SC', 'SD', 'TN','TX', 'UT', 'VT', 'VA', 'WA', 'WV', 'WI', 'WY');	
									 								 
 				echo "<select name=\"state\" id=\"state\" tabindex=\"$num\" style=\"font-size:12px;\">"; 
 				echo "<option value=\"\" selected=\"selected\">Select a State</option>\n";	 
 				if(isset($_POST['state']))
				 $sticky =  $_POST['state'];
				 else				
				   $sticky = isset($row['state']) ?$row['state'] : '';
				
 				  foreach($states as $key => $value)
	            {	
		        echo "<option value=\"$value\"";			 
			      if($sticky==$value) echo "selected=\"selected\"";
		        echo ">$value</option>\n";
		        }//End foreach	 	                                                    
	       echo '</select>';
		 ?></div>

        <div class="log_info_row "><label for="phone" class="log_info_label">*Phone:</label>
		<input type="text" name="phone" id="phone" tabindex="<?php echo $ph; ?>" maxlength="12" size="10"
		value="<?php if(isset($_POST['phone'])) echo $_POST['phone']; else{if(isset($row['phone'])) echo $row['phone'];} ?>"/></div>			
		<div class="phonenum">(407-555-5555)</div>

        <div class="log_info_row "><label for="zipcode" class="log_info_label">*Zip Code:</label>
		<input type="text" name="zipcode" id="zipcode" tabindex="<?php echo $zp; ?>" maxlength="5" size="5"
		value="<?php if(isset($_POST['zipcode'])) echo $_POST['zipcode']; else{if(isset($row['zip'])) echo $row['zip'];} ?>"/></div>		
	</div><!-- End left side -->