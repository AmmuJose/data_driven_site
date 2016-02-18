<?php  
    
	if (isset($_GET['filename']) && isset($_GET['type']))
	{
	$path = "/home/student315/uploads/".$_GET['filename'];
	header("Content-type:".$_GET['type']."\n");		
	header("Content-Disposition: inline; filename=".$_GET['filename']."\n");
	readfile($path);
	}	
	else
	echo '<p> you have been accessed this pade in error !. </p>'
?>
