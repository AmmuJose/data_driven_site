<?php

if(isset($_SESSION['agent']) && isset($_SESSION['acess_id']))
 {
  if($_SESSION['confirm']==1)
  {
    $_SESSION['ck3']=0;
	$_SESSION['ck2']=0;
	$oid=$_SESSION['ordid'];
	
    $body="Thanks for placing order with Garrowy Restaurant.";
	$body .="Your item(s) will be shipped at the earliest.\nYour Order ID is $oid. If You have further questions about this order, please refer this Order ID when contacting customer support.";
	$body .="\n\n Please do not reply to email as it is auto-generated and will not be answered. Please direct questions you may have to services@garroway.com  \n\nSincerely\n\t Manager - Customer Service\n";
	
	$headers="From:admin@garroway.com\r\n";
	$headers.="Bcc:ammugibi@gmail.com\r\n";
	mail($_SESSION['email'], 'Order Confirmation', $body, $headers);	
	
    echo '<div style="margin:50px 2px 2px 20px">We have received your order and purchased items will be shipped as soon as possible.<br/>You will also receive an order confirmation email.</div>';
  }
  else
  echo '<p class="perror"> You have been accessed this page in error!</p>';
 }
 else
	{
	header("Location: http://" . $_SERVER['HTTP_HOST'] ."/index.php?pagelet=login_options");
	exit();
	}//end else 

?>