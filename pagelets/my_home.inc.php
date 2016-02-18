<?php

if(isset($_SESSION['agent']) && isset($_SESSION['acess_id']))
{
if($_SESSION['acess_id'] == 3) 
{ ?>

<div class ="adminmenu">
 <ul class = "admin_nav">
	<li><a href="index.php?pagelet=index">Home</a></li>
    <li><a href="index.php?pagelet=about_us">About Us</a></li>
	<li><a href="index.php?pagelet=menu">Menu</a></li>  	
	<li><a href="index.php?pagelet=gift_cards">Gift Cards</a></li>  
	<li><a href="index.php?pagelet=contact_us">Contact Us</a></li>	
 </ul>
</div>
<?php
}
 $q="SELECT firstname, lastname, address1, address2, city, state, zip, phone  FROM address WHERE user_id={$_SESSION['user_id']} AND flag_bs='1'";
 $r=@mysqli_query($dbc, $q);
 
  echo '<br/>';
  echo '<div style="width:200px;float:right;margin-right:30px;">';
  echo '<br/><div style="font-weight:bold;margin:10px 0px 3px 0px;">Address</div>';
 
 if(mysqli_num_rows($r)==1)
 {
  $row=mysqli_fetch_array($r, MYSQLI_NUM);
  $user= $row[0];
  
  echo $row[0]. ' ';
  echo $row[1]. '<br/>';
  echo $row[2]. '<br/>';
  if(!empty($row[3]))
  echo $row[3]. '<br/>';
  
  echo $row[4]. '<br/>';
  echo $row[5].' '.$row[6]. '<br/>';
  echo 'Phone: '.$row[7];
  
 }
 
  if($_SESSION['acess_id'] == 3) 
   echo '<br/><a href="index.php?pagelet=change_address&#38;id='.$_SESSION['user_id'].'"><img src="images/edit.gif" width="43" height="13" alt="Edit" style="border:0;margin:3px 0px;"/></a>';
   
 echo '</div>';
 echo '<div class="wl">';
 
 
 if($_SESSION['acess_id'] == 2) 
 {
  echo 'Welcome '. $user;
  echo '<br/> You are now Logged in as Manager.';
 }
 
 if($_SESSION['acess_id'] == 1) 
  {
  echo 'Welcome '. $user;
  echo '<br/> You are now Logged in.';
  } 
 

 if($_SESSION['acess_id'] == 3) 
  {
  
  echo 'Welcome '. $user;
  echo '<br/> You are now Logged in as Admin.';  
  }
 echo '</div>';
}//end of if agent
	
else
{
  header("Location: http://" . $_SERVER['HTTP_HOST'] ."/index.php?pagelet=login_options");
  exit();
}
?>