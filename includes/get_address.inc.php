<?php
if(isset($_GET['add_id']) && isset($_SESSION['user_id']) && isset($_SESSION['acess_id']))
{
$aid=$_GET['add_id'];

$q="SELECT firstname, lastname, address1, address2, city, state, phone, zip  FROM address WHERE (user_id={$_SESSION['user_id']} AND toaddbook=1 AND address_id=$aid)";
$r=mysqli_query($dbc, $q);
 if(mysqli_num_rows($r)==1)
 {
 $row=mysqli_fetch_array($r, MYSQLI_ASSOC);
 echo $row['firstname'];
 echo '|'.$row['lastname'];
 echo '|'.$row['address1'];
 echo '|'.$row['address2'];
 echo '|'.$row['city'];
 echo '|'.$row['state'];
 echo '|'.$row['phone'];
 echo '|'.$row['zip']; 
 }
 else
 echo '<p>You have been accessed this page in error</p>';
 }
else
 echo '<p>You have been accessed this page in error</p>';

?>