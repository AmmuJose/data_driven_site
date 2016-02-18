<?php

if($_SESSION['acess_id'] == 3)
{
 $d=date('d')-1;
 $ym=date('Y-m');
 
 $yday=$ym.'-'.$d;
 $yday=date('Y-m-d H:i:s', strtotime($yday));
 $q="DELETE FROM shopping_cart WHERE cartdate <'$yday' AND checkout_flag='0'";
 $r=mysqli_query($dbc,$q);}
 
$_SESSION = array();
session_destroy();
setcookie('GarrowayID', '', time()-3600);
header("Location: http://" . $_SERVER['HTTP_HOST'] . "/index.php?pagelet=index" . SID);
exit();
?>