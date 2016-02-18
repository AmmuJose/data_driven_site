<?php 
$errors = array();//initialize an error array
$flag=0;
$m1=$m2=$d1=$d2=$y1=$y2='';
if(isset($_POST['oidsearch']))
{
	if(!empty($_POST['orderid']))
	{
	$oid=trim($_POST['orderid']);
	if(preg_match("/^[5-9][0-9]{3,11}$/",$oid))
	{
	header("Location: http://" . $_SERVER['HTTP_HOST'] ."/index.php?pagelet=order_search_result&oid=$oid" . SID);
	exit();
	}
	else
	echo '<p class="perror">* Invalid Order ID.</p>';	
	}//end ifset orderid
	else
	echo '<p class="perror">* Please enter an Order ID.</p>';
}//End isset IF

if(isset($_POST['dssearch']))
{
	  		 $m1=trim($_POST['m1']);
             $m2=trim($_POST['m2']);
			 $d1=trim($_POST['d1']);
			 $d2=trim($_POST['d2']);
			 $y1=trim($_POST['y1']);
			 $y2=trim($_POST['y2']);
			 
			 if(empty($m1) && empty($m2)&& empty($d1)&& empty($d2)&& empty($y1) && empty($y2))
			 $flag=0;			 
			
			 else
			 {
				$flag=1;				
			    $from_date = "$y1-$m1-$d1";			  
			    $to_date = "$y2-$m2-$d2";
			    $s=date('Y-m-d', strtotime($from_date));
			    $e=date('Y-m-d', strtotime($to_date));		
			 
			   
			    if($e =='1969-12-31')
			    $errors[] ="Invalid To Date.";
			    if($s =='1969-12-31')
			    $errors[] ="Invalid From Date.";			  
			  
			   if($s !='1969-12-31' && $e !='1969-12-31')
			   {
			   if($s > $e)			   
			   $errors[] = "From Date cannot be larger than To Date.";	
			   }
			 }
			
			
			if($flag==0)
			{
			 if(empty($_POST['status']))
			 echo '<p class="perror">* Please select a Date and/or Status.</p>';
			 else
			 {
			 $tos='&status='.$_POST['status'];
			 header("Location: http://" . $_SERVER['HTTP_HOST'] ."/index.php?pagelet=order_search_result".$tos. SID);
			 exit();
			 }
			}
			else
			{
			 if(!empty($errors))
			 display_error($errors);
			 else
			 {
			  $tos='&st='.$s.'&e='.$e;
			  if(!empty($_POST['status']))
			  $tos .='&status='.$_POST['status'];
			  
			  header("Location: http://" . $_SERVER['HTTP_HOST'] ."/index.php?pagelet=order_search_result".$tos. SID);
			  exit();
			  
			 }
			}

}//End isset IF

?> 
 
<h3 class="add_user_head">Order Search</h3>
<div> <!-- first form -->
	<form method="post" action="" onsubmit="return validateorderid();">
	<div style="margin-left:20px;font-weight:bold;font-size:11px;">Search By Order ID: </div>
    
	<div class="log_info_row "><label for="orderid" class="log_info_label">Order ID: </label><input name="orderid" id="orderid" type="text" value="<?php if(isset($_POST['orderid'])) echo $_POST['orderid']; ?>" size="11" maxlength="11" tabindex="7" /><input type="submit" name="oidsearch" id="oidsearch" tabindex="7" value="Search" /></div><br/>
	
	</form>
</div><!-- end first form -->
<br/>
<div><!-- 2nd form --> 
<div style="margin-left:20px;font-weight:bold;font-size:11px;">Search By Order Date/Order Status: </div>
   
	<form method="post" action="" onsubmit="return validateform();">		
	<div class="order_date">
	<div style="float:left;">From Date:
	<input id="Field10-1" name="m1" type="text"  value="<?php if(isset($_POST['m1'])) echo $_POST['m1'] ;?>" size="2" maxlength="2" tabindex="7" />
    <input id="Field10-2" name="d1" type="text"  value="<?php if(isset($_POST['d1'])) echo $_POST['d1'];?>" size="2" maxlength="2" tabindex="8" />      
    <input id="Field10" name="y1" type="text"  value="<?php if(isset($_POST['y1'])) echo $_POST['y1']; ?>" size="4" maxlength="4" tabindex="9" />
    <span id="cal10"><img id="pick10" src="images/calender.jpg" width="18" height="15"  alt="Pick a date." /></span>
	
<script type="text/javascript">
Calendar.setup({
inputField : "Field10",
displayArea  : "cal10",
button : "pick10",
ifFormat : "%B %e, %Y",
onSelect : selectDate
});
</script> </div>

	<div style="float:left;"> &#160; &#160;To Date: 
	<input id="Field20-1" name="m2" type="text"  value="<?php if(isset($_POST['m2'])) echo $_POST['m2']; ?>" size="2" maxlength="2" tabindex="7" />
    <input id="Field20-2" name="d2" type="text"  value="<?php if(isset($_POST['d2'])) echo $_POST['d2']; ?>" size="2" maxlength="2" tabindex="8" />     
    <input id="Field20" name="y2" type="text"  value="<?php if(isset($_POST['y2'])) echo $_POST['y2']; ?>" size="4" maxlength="4" tabindex="9" />
    <span id="cal20"><img id="pick20" src="images/calender.jpg" width="18" height="15"  alt="Pick a date." /></span> 
	
<script type="text/javascript">
Calendar.setup({
inputField : "Field20",
displayArea  : "cal20",
button : "pick20",
ifFormat : "%B %e, %Y",
onSelect : selectDate
});
</script>&#160; &#160;<small>(MM-DD-YYYY)</small></div>
</div>
    
	
	<div class="log_info_row"><label for="status" class="log_info_label">Status:</label>
	<select name="status" id="status" tabindex="1">
	<option value="" selected="selected">Select Status</option>
	<?php 
		$group=array(1=>'Processing', 'Shipped', 'Delivered', 'Exception');
		$sticky = (isset($_POST['status'])? $_POST['status']:"");
		foreach($group as $key => $value)
		{	
		echo "<option value=\"$value\"";
		if($sticky==$value) echo "selected=\"selected\"";
		echo ">$value</option>\n";
		}//End foreach
		
	?>
	</select>
	</div> 
	
	<div class="order_search"> <input type="submit" name="dssearch" id="dssearch" tabindex="7" value="Search" /></div>
	
	</form><br/>
</div>