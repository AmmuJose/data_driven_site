<?php
//============  Connect Data Base  =============
	require_once("C:\db.inc.php");
	
	$id=$_GET['id'];
	$q = "SELECT imgtype, cardimg FROM card_image WHERE card_img_id =$id";
	$r = mysqli_query($dbc, $q)
	OR die("Error: ". mysqli_error($dbc));
	if(mysqli_num_rows($r)==1)
	{
	 $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
    
	 header('Content-type:'. $row['imgtype']);		
	 echo $row['cardimg'];
	 
	}
	else
	echo '<p>System Error!<br/>Gift Card images could not be displayed due to a system error. Sorry for any inconvenience.</p>';
		 
?>
