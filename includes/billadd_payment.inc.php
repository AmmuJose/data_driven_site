<div class="buyhed">Billing &#38; Payment Info</div>
<hr/>

<div style="height:248px;">
<p class="buyindicates">* Indicates required field</p>
<div class="addleft"> <!-- Left side -->
    <?php
    	
    include("address_info.inc.php");	
    	
    ?>	
		
</div><!-- End left side -->
	
	
	<div class="addright"><!--Right side -->
	
	  <div class="pay_info_row "><label for="cardtype" class="log_info_label">*Credit Card Type:</label>
	  <select name="cardtype" id="cardtype" tabindex="9">		
			<?php 
				  echo "<option value=\"\" selected=\"selected\">Select Card Type</option>\n";	
				  $type = array(1=>'American Express', 'Visa', 'Master Card');				  
				  
				   $sticky = isset($_POST['cardtype']) ? $_POST['cardtype']:'';
				 
					foreach($type as $key => $value)
					{
					  echo "<option value=\"$key\" ";
			         if($sticky==$key) echo "selected=\"selected\"";
		              echo ">$value</option>\n";
					}
				?>
		</select></div>
		
		<div class="pay_info_row "><label for="cardnum" class="log_info_label">*Card Number:</label>
		<input type="text" name="cardnum" id="cardnum" tabindex="10" maxlength="16"
					 value="<?php if(isset($_POST['cardnum'])) echo $_POST['cardnum']; ?>" size="16" /></div>
					 	
		<div class="pay_info_row "><label for="code" class="log_info_label">*Security Code:</label>
		<input type="text" name="code" id="code" tabindex="11" maxlength="4"
					 value="<?php if(isset($_POST['code'])) echo $_POST['code']; ?>" size="4" /><small> (cvv code)</small></div>
					 	
		<div class="pay_info_row "><label for="expmonth" class="log_info_label">*Expiration Date:</label>
	   <select name="expmonth" id="expmonth" tabindex="12">
		  <option value="" selected="selected">month</option> 
	         <?php	$month =array(1=>'01', '02', '03', '04', '05','06','07', '08','09','10', '11', '12');
			        
					 $sticky = (isset($_POST['expmonth'])? $_POST['expmonth']:"");
					 
 				       foreach($month as $key => $value)
	 						  {	
		  					   echo "<option value=\"$key\" ";
			 				   if($sticky==$key) echo "selected=\"selected\"";
							   echo ">$value</option>\n";
							  }//End foreach	
					 ?>
      </select>
			
		<select name="expyear" id="expyear" tabindex="13">
		  <option value="" selected="selected">year</option> 
	         <?php	   
			  
			         $sticky = isset($_POST['expyear'])? $_POST['expyear']:"";
					 $y = date('Y');
					 $y10 = $y+10;
					 for ($y; $y<$y10; $y++)
					{ 
					 echo "<option value=\"$y\" ";
					 if($sticky==$y) echo "selected=\"selected\"";
					 echo ">$y</option>\n";
					} ?>
      </select> </div>
			
		<div class="pay_info_row "><label for="nameoncard" class="log_info_label">*Name on Card:</label>
		<input type="text" name="nameoncard" id="nameoncard" tabindex="14" maxlength="30"
					 value="<?php if(isset($_POST['nameoncard'])) echo $_POST['nameoncard']; ?>" size="20" /></div>
	</div><!-- end right -->
</div>