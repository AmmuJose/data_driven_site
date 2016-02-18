<?php
$errors = array();//initialize an error array
$bg='#d7c47d';

$flag=1;
$display = 3;

if(isset($_GET['rd']))
$resultdis=$_GET['rd'];

else
$resultdis=0;

if(isset($_POST['dssearch']))
{
	  		 $m1=trim($_POST['m1']);
             $m2=trim($_POST['m2']);
			 $d1=trim($_POST['d1']);
			 $d2=trim($_POST['d2']);
			 $y1=trim($_POST['y1']);
			 $y2=trim($_POST['y2']);
			 
			 if(empty($m1) && empty($m2)&& empty($d1)&& empty($d2)&& empty($y1) && empty($y2))
			 $errors[]='Please enter From date and To Date';			 
			
			 else
			 {
				$flag=1;				
			    $from_date = "$y1-$m1-$d1";			  
			    $to_date = "$y2-$m2-$d2";
			    $st=date('Y-m-d', strtotime($from_date));
			    $e=date('Y-m-d', strtotime($to_date));		
			 
			   
			    if($e =='1969-12-31')
			    $errors[] ="Invalid To Date.";
			    if($st =='1969-12-31')
			    $errors[] ="Invalid From Date.";			  
			  
			   if($st !='1969-12-31' && $e !='1969-12-31')
			   {
			   if($st > $e)			   
			   $errors[] = "From Date cannot be larger than To Date.";	
			   }
			 }
			 
			 if(!empty($errors))
				display_error($errors);
			 else
			  $resultdis=1;
}			 

if(empty($errors) && $resultdis==1)
{    
	$flag=0;
	if(isset($_GET['st']) && isset($_GET['e']))
	{	
	$st=$_GET['st'];
	$e=$_GET['e'];}
	
	$from=date('Y-m-d H:i:s',strtotime($st));
	$to=date('Y-m-d 23:59:59',strtotime($e));
	
	$tog='&#38;st='.$st.'&#38;e='.$e .'&#38;rd='.$resultdis;
	
	
	$q= "SELECT orderdate, ostatus, total, fee, ship_method, ship_amount, ship_id, order_id ";
	$q.= "FROM order_tbl AS o, processing_fee AS p, shipping_method AS s, bill_ship_address AS bs, order_status AS os ";
	$q.= "WHERE o.processing_id=p.processing_id AND o.ship_method_id=s.ship_method_id ";
	$q.= "AND o.bill_ship_id=bs.bill_ship_id AND os.status_id=o.status_id ";	
	$q.= "AND orderdate BETWEEN '$from' AND '$to' ";	
	$q.= "AND user_id={$_SESSION['user_id']}";
	
		
	$r=mysqli_query($dbc, $q);
	
	if (isset($_GET['np'])) 
    $num_pages = $_GET['np'];
	
	else
	{
	$num_records=mysqli_num_rows($r);
	
	if ($num_records > $display) 
        $num_pages = ceil ($num_records/$display);
    else 
        $num_pages = 1;}


	
	$link2 = "{$_SERVER['PHP_SELF']}?pagelet=order_history&#38;sort=oda".$tog;
	$link3 = "{$_SERVER['PHP_SELF']}?pagelet=order_history&#38;sort=sa".$tog;		
	

//  Determine the sorting order with all possible options
if (isset($_GET['sort']))  {

    switch ($_GET['sort'])  {
        
        case 'odd';
            $order_by = 'orderdate DESC';
            $link2 ="{$_SERVER['PHP_SELF']}?pagelet=order_history&#38;sort=oda$tog";
            $label = "Order Date - Descending";
            break;
        case 'sa';
            $order_by = 'ostatus ASC';
            $link3 ="{$_SERVER['PHP_SELF']}?pagelet=order_history&#38;sort=sd$tog";
            $label = "Status - Ascending";
            break;        
        case 'oda';
            $order_by = 'orderdate ASC';
            $link2 ="{$_SERVER['PHP_SELF']}?pagelet=order_history&#38;sort=odd$tog";
            $label = "Order Date - Ascending";
            break;
        case 'sd';
            $order_by = 'ostatus DESC';
            $link3 ="{$_SERVER['PHP_SELF']}?pagelet=order_history&#38;sort=sa$tog";
            $label = "Status - Descending";
            break;
        default;
            $order_by = 'ostatus DESC';
            $label = "Status - Descending";
            break;
    }

    //  Append $sort to the pagination links
    $sort = $_GET['sort'];

} else {  // use default sorting order
    $order_by = 'orderdate ASC';
    $sort = 'odd';
    $label = 'Order Date - Ascending';
}

// Determine where in the database to start returning results.
if (isset($_GET['s'])) 
    $start = $_GET['s'];
 else 
    $start = 0;		

 $q.=" ORDER BY $order_by LIMIT $start, $display ";
 $r=mysqli_query($dbc, $q);	
	
	if(mysqli_num_rows($r) >0)
	{
	echo '<div class="bainfo addform"> sorted by: ' . $label . '</div>';
	echo '<div class="addform">Click on OrderDate and Status column headings to sort.</div>'; 
	 echo '<table class="ou">';
	 echo '<tr style="background:'.$bg.'" >';
	 echo '<th><a href="' . $link2 . '">OrderDate</a></th>';
	 echo '<th>Item</th>';
     echo '<th>Fee</th>';
	 echo '<th>OrderTotal</th>';
     echo '<th>ShippingAddress</th>';
	echo '<th><a href="' . $link3 . '">Status</a></th>';
	 while($row=mysqli_fetch_array($r,MYSQLI_ASSOC))  
		{
		$bg = ($bg=='#d7c490'?'#cac490':'#d7c490');
		echo '<tr style="background:'.$bg.'">';
		echo '<td>'.date('m/d/Y',strtotime($row['orderdate'])).'</td>';
			
		$q1="SELECT cart_id FROM order_cart_rel WHERE order_id={$row['order_id']}";
		$r1=mysqli_query($dbc, $q1);
		echo mysqli_error($dbc);
		echo '<td>';
		echo '<div style="width:278px;">';				
				
				while($row1=mysqli_fetch_array($r1,MYSQLI_NUM))
				 {
				 $q2 ="SELECT msgfrom, msgto, msg, quantity,amount, category ";
				 $q2 .="FROM shopping_cart, card_image, card_category ";
				 $q2 .="WHERE card_image.card_img_id=shopping_cart.card_img_id AND card_image.category_id=card_category.category_id AND cart_id={$row1[0]}";
				 
				 $r2=mysqli_query($dbc, $q2);				 
				 $row2=mysqli_fetch_array($r2,MYSQLI_ASSOC);
				 
				 echo '<div style="width:180px;float:left;margin:5px 0px;">';
				 echo 'GiftCard + '.$row2['category'].'<br/>Greeting Card';
				 echo '<br/><br/>From: '.$row2['msgfrom'];
				 echo '<br/>To: '.$row2['msgto'];
				 echo '<br/>Message: '.$row2['msg'].'<br/>';
				 
				 echo '</div>';
				 echo '<div style="width:84px;float:right;margin:5px 0px;">';
				 echo 'OrderID: '.$row['order_id'].'<br/>';
				 echo 'Quantity: '.$row2['quantity'];
				 echo '<br/> Price: '.$row2['amount'];
				 echo '</div>';			 
				 
				 }
				 
		echo '</div>';
		echo '</td>';
		
		echo '<td>Processing Fee: '.$row['fee'];
		echo '<br/>Shipping Fee: '.$row['ship_amount'];
		echo '<br/>'.$row['ship_method'];
		echo '</td>';
		
		echo '<td>'.number_format($row['total'],2).'</td>';
		
		$sq="SELECT * FROM address WHERE address_id={$row['ship_id']}";
		$sr=mysqli_query($dbc, $sq);
		echo mysqli_error($dbc);
		$srow=mysqli_fetch_array($sr, MYSQLI_ASSOC);
		
				echo '<td>';
				echo $srow['firstname']. ' ';
				echo $srow['lastname']. '<br/>';
				echo $srow['address1']. '<br/>';
				if($srow['address2'] != '')
				echo $srow['address2']. '<br/>';
				echo $srow['city']. '<br/>';
				echo $srow['state'].', '.$srow['zip']. '<br/>';
				echo $srow['phone'];
				echo '</td>';	
		echo '<td>'.$row['ostatus'].'</td>';
		echo '</tr>';
		}
		
	$bg='#d7c47d';	
	echo '<tr style="background:'.$bg.'"><td colspan="7" style="padding:2px 20px;text-align:right;">';
	if ($num_pages > 1) 
	{  
    $current_page = ($start/$display) + 1;    
   
    if ($current_page != 1)
        echo '<a class="black" href="index.php?pagelet=order_history'.$tog.'&#38;sort='.$sort.'&#38;s=' . ($start - $display) . '&#38;np=' . $num_pages . '">Previous</a> ';
		
    for ($i = 1; $i <= $num_pages; $i++) {
      if ($i != $current_page) 
       echo '<a class="black" href="index.php?pagelet=order_history'.$tog.'&#38;sort='.$sort.'&#38;s=' . (($display * ($i - 1))) . '&#38;np=' . $num_pages . '">' . $i . '</a> ';
      else 
       echo $i . ' '; } 
  
    if ($current_page != $num_pages) 
        echo '<a class="black" href="index.php?pagelet=order_history'.$tog.'&#38;sort='.$sort.'&#38;s=' . ($start + $display) . '&#38;np=' . $num_pages . '">Next</a>';
   
    
    } // End of links section.

    echo '</td</tr>';
    echo '</table>'; 
	
	}
	else
	echo '<p class="perror">No Order Found!</p>';
    echo '<p class="addform"><a href="javascript:history.back();">Back to Search </a>.</p>';
 }
 

if($flag==1)
{
?>

<br/>
<h4 class="add_user_head">Order Search</h4>

 <div>  
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

<div class="order_search"> <input type="submit" name="dssearch" id="dssearch" tabindex="7" value="Search" /></div>
	
</form><br/>
</div>
<?php } ?>