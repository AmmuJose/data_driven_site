<?php
error_reporting(E_ALL);
 $errors = array();//initialize an error array  
 $bg='#d7c47d';
 
 if(isset($_POST['update']))
 {
 
	if($_POST['cardname'] != '')
	$cn=escape_data($_POST['cardname']);
	
	if(isset($_POST['check']))
	{
		foreach ($_POST['check'] as $key=> $value)
		{
		$q="UPDATE card_image SET flag_a=";
	
		if($_POST['status']==1)
		$q.="1 ";
	
		else
		$q.="0, flag_m=0 ";
		
		if(isset($cn))
		$q.=",cardname='$cn' ";
	
		$q.=" WHERE card_img_id=$key";
	
		$r=mysqli_query($dbc,$q);			
		}
	}//end of foreach
	else
    $errors[]='Please Select a Card to Update.';
 }

	
 

 if(isset($_GET['c']))
	{
	  $category =$_GET['c'];
	
	  //getting category id
		$q= "SELECT category_id FROM card_category WHERE category='$category'";
		$r = mysqli_query($dbc, $q);
        if($r)
        {		
	    $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
		$category_id = $row['category_id'];
		
		$q= "SELECT cardname, card_img_id, flag_a FROM card_image WHERE category_id=$category_id";
		$r = mysqli_query($dbc, $q);
		  if($r)
		   {
		    if(mysqli_num_rows($r) >0)
			 {
			  echo '<div><form method="post" action="">';			  
			  echo '<table class="itemstbl">';
		      echo '<tr style="background:'.$bg.'">';
			  echo '<th>Select</th><th>Card Image</th><th>Card ID</th>';
			  echo '<th>CardName</th><th>Card Category</th><th>Status</th></tr>';
			  
			   while($row = mysqli_fetch_array($r, MYSQLI_ASSOC))
				{
				$bg = ($bg=='#d7c490'?'#cac490':'#d7c490');
				echo '<tr style="background:'.$bg.'">';
				echo "<td><input type=\"checkbox\" name=\"check[{$row['card_img_id']}]\" /></td>";
				
				echo '<td style="text-align:left;margin-right:0px;"><img alt="'.$category.'card" src="includes/find_cards_image.inc.php?id='.$row['card_img_id'].'" width="167" height="100"/></td>';
				echo '<td>'.$row['card_img_id'].'</td>';
				echo '<td>'.$row['cardname'].'</td>';
				echo '<td>'.$category.'</td>';		 
				echo '<td style="width:90px;">';
		  
				if($row['flag_a']==1)
				echo 'Active';
				else
				echo 'Inactive';
			
				echo '</td>';				
				echo '</tr>';	  
				}//end of while
				
				$bg='#d7c47d';
		      echo '<tr style="background:'.$bg.'"><td colspan="6"></td</tr>';
			  echo '</table>';
			  echo '<br/>';
			  if(!empty($errors))
               {display_error($errors); echo '<br/>';}
			  echo '<div style="padding-left:20%;"><input type="radio" name="status" id="act" value="1" checked="checked"/><label for="act">Activate</label>';
			  echo '<input type="radio" name="status" id="inact" value="0" /><label for="inact">Inactivate</label></div>';
			  echo '<div class="log_info_row "><label for="cardname" style="padding-left:20%;">Gift Card Name: </label>';
			  echo '<input type="text" name="cardname" id = "cardname" value= "';
			  if(isset($_POST['cardname'])) 
			  echo $_POST['cardname'];
			  echo '" tabindex="2" maxlength="40" />';
			  
			  echo '&#160; <input type="submit" name="update" id="update" tabindex="2" value="Update" /></div>';
			  echo '</form>';
			  echo '</div>';
			  
			 }//end num rows
			 else			  
			   echo '<p> No match found</p>';			   
			  
		   }//end of 2nd $r
		  else
		    echo 'System Error! Gift Cards could not be listed. We apologize for any inconvenience.';
		
		}//end of first $r
		else
		 echo 'System Error! Gift Cards could not be listed. We apologize for any inconvenience.';
	  echo '<p style="padding-left:20%;"><a href="index.php?pagelet=find_cards">Back to Search</a>.</p>';  
	 
    }//End isset IF	 
else
 echo '<p>You have been acessed this in error !</p>';	
?>