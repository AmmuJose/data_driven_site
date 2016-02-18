<?php

if(isset($_POST['cs']))
{
$q="DELETE FROM shopping_cart WHERE session_id='$sessionid' AND checkout_flag='0'";
$r=mysqli_query($dbc,$q);
header("Location: http://" . $_SERVER['HTTP_HOST'] . "/index.php?pagelet=buy_now" . SID);
 exit();
}
else
 echo '<p class="perror"> You have been accessed this page in error!</p>';

?>