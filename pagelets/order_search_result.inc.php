<?php
$errors = array();
if(isset($_POST['update']))
{


	if($_POST['status'] !='')
	{
	$sts=$_POST['status'];
	$qs="status_id=$sts ";
	}
	
	if(trim($_POST['comment']) != '')
	{
    $cmnt=escape_data($_POST['comment']);
	if($_POST['status'] !='')	
	$qc=",comments='$cmnt' ";
	else
	$qc="comments='$cmnt' ";
	}

if(isset($_POST['check']))
 {
	foreach ($_POST['check'] as $key=> $value)
	{
	$q="UPDATE order_tbl SET ";
	
	if(isset($qs))
	$q.=$qs;
	
	if(isset($qc))
	$q.=$qc;
	
	$q.="WHERE order_id=$key";
	
	$r=mysqli_query($dbc,$q);	
    //echo mysqli_error($dbc);
  
	}//end of foreach
 }
else
 {
 $errors[]='Please Select an Order ID to Update.';
 if($_POST['status'] =='' && trim($_POST['comment'])=='')
 $errors[]='Please select a Status or enter a Comment to update.';
 
 $l=strlen(trim($_POST['comment']));
  if($l>225)   
   $errors[] = "Your comment contains $l characters. Please limit your comment to 225 characters.";
 }
 
}
 $bg='#d7c47d';
 $tog='';
 
 $cq="SELECT COUNT(*) FROM order_tbl, order_status WHERE ";
 $cq.="order_tbl.status_id = order_status.status_id ";
 
 $q="SELECT order_id, email, orderdate, ostatus, comments FROM order_status, order_tbl, registered_users ";
 $q.="WHERE ";
 $q.="order_tbl.status_id = order_status.status_id AND ";
 $q.="order_tbl.user_id = registered_users.user_id ";
 
if(isset($_GET['oid']) )
{ 
	if(isset($_GET['oid']))
	{
	$q.="AND order_id={$_GET['oid']} ";
	$cq.="AND order_id={$_GET['oid']}";
	$oid=$_GET['oid'];
	$tog='&#38;oid='.$oid;
	}
}
 
elseif(isset($_GET['status']) || (isset($_GET['st']) &&isset($_GET['e'])))
{
	if(isset($_GET['status']))
	{
	$q.="AND order_status.ostatus='{$_GET['status']}' ";
	$cq.="AND order_status.ostatus='{$_GET['status']}' ";
	$status=$_GET['status'];
	$tog='&#38;status='.$status;
	}
	if(isset($_GET['st']) && isset($_GET['e']))
	{
	$from=date('Y-m-d H:i:s',strtotime($_GET['st']));
	$to=date('Y-m-d 23:59:59',strtotime($_GET['e']));
	
	$q.="AND orderdate BETWEEN '$from' AND '$to' ";
	$cq.="AND orderdate BETWEEN '$from' AND '$to'";
	$st=$_GET['st'];
	$e=$_GET['e'];
	$tog.='&#38;st='.$st.'&#38;e='.$e;
	}
	
} 
 
else
{
echo '<p class="perror">* You have been accessed this page in error</p>';
include("$WEB_ROOT/includes/footer.inc.php");
exit();
}
	$display = 10;
 
	if (isset($_GET['np'])) 
   $num_pages = $_GET['np'];
	else 
	{ 
	$result = mysqli_query ($dbc,$cq);
	$row = mysqli_fetch_array ($result, MYSQL_NUM);
	$num_records = $row[0];

    // Calculate the number of pages.
	if ($num_records > $display) 
		$num_pages = ceil ($num_records/$display);
	else 
		$num_pages = 1; 
	}
    $link1 = "{$_SERVER['PHP_SELF']}?pagelet=order_search_result&#38;sort=ea".$tog;
	$link2 = "{$_SERVER['PHP_SELF']}?pagelet=order_search_result&#38;sort=oda".$tog;
	$link3 = "{$_SERVER['PHP_SELF']}?pagelet=order_search_result&#38;sort=sa".$tog;		
	

//  Determine the sorting order with all possible options
if (isset($_GET['sort']))  {

    switch ($_GET['sort'])  {
        case 'ea';
            $order_by = 'email ASC';
            $link1 ="{$_SERVER['PHP_SELF']}?pagelet=order_search_result&#38;sort=ed$tog";
            $label = "Email - Ascending";
            break;
        case 'odd';
            $order_by = 'orderdate DESC';
            $link2 ="{$_SERVER['PHP_SELF']}?pagelet=order_search_result&#38;sort=oda$tog";
            $label = "Order Date - Descending";
            break;
        case 'sa';
            $order_by = 'ostatus ASC';
            $link3 ="{$_SERVER['PHP_SELF']}?pagelet=order_search_result&#38;sort=sd$tog";
            $label = "Status - Ascending";
            break;
        case 'ed';
            $order_by = 'email DESC';
            $label = "Email - Descending";
            $link1 ="{$_SERVER['PHP_SELF']}?pagelet=order_search_result&#38;sort=ea$tog";
            break;
        case 'oda';
            $order_by = 'orderdate ASC';
            $link2 ="{$_SERVER['PHP_SELF']}?pagelet=order_search_result&#38;sort=odd$tog";
            $label = "Order Date - Ascending";
            break;
        case 'sd';
            $order_by = 'ostatus DESC';
            $link3 ="{$_SERVER['PHP_SELF']}?pagelet=order_search_result&#38;sort=sa$tog";
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
 
 $q.="ORDER BY $order_by LIMIT $start, $display ";
 $r=mysqli_query($dbc, $q); 

 
 if(mysqli_num_rows($r) > 0)
 {
    echo '<div class="bainfo addform"> sorted by: ' . $label . '</div>';
	echo '<div class="addform">Click on EmailAddress, OrderDate and Status column headings to sort.</div>'; 
    echo '<div><form method="post" action="">';	
    echo '<table class="ou">';
	echo '<tr style="background:'.$bg.'">';
	echo '<th>Select</th>';
	echo '<th>Order ID</th>';
	echo '<th><a href="' . $link1 . '">EmailAddress</a></th>';
	echo '<th><a href="' . $link2 . '">OrderDate</a></th>';
	echo '<th><a href="' . $link3 . '">Status</a></th>';
	echo '<th>Comment</th>';
	echo '<th>Details</th>';
	echo '</tr>';
	while($row=mysqli_fetch_array($r,MYSQLI_ASSOC))  
	{
	 $bg = ($bg=='#d7c490'?'#cac490':'#d7c490');
	echo '<tr style="background:'.$bg.'">';
	echo "<td><input type=\"checkbox\" name=\"check[{$row['order_id']}]\" /></td>";
	echo '<td>'.$row['order_id'].'</td>';
	echo '<td>'.$row['email'].'</td>';
	echo '<td>'.date('m/d/Y, g:i a',strtotime($row['orderdate'])).'</td>';
	echo '<td>'.$row['ostatus'].'</td>';
	echo '<td>'.htmlspecialchars($row['comments'], ENT_QUOTES).'</td>';	
	echo '<td><a href="index.php?pagelet=order_details&#38;id='.$row['order_id'].'" >Details</a></td>';
	echo '</tr>';
	}
	$bg='#d7c47d';	
	echo '<tr style="background:'.$bg.'"><td colspan="7" style="padding:2px 20px;text-align:right;">';
	if ($num_pages > 1) 
	{  
    $current_page = ($start/$display) + 1;    
   
    if ($current_page != 1)
        echo '<a class="black" href="index.php?pagelet=order_search_result'.$tog.'&#38;sort='.$sort.'&#38;s=' . ($start - $display) . '&#38;np=' . $num_pages . '">Previous</a> ';
		
    for ($i = 1; $i <= $num_pages; $i++) {
      if ($i != $current_page) 
       echo '<a class="black" href="index.php?pagelet=order_search_result'.$tog.'&#38;sort='.$sort.'&#38;s=' . (($display * ($i - 1))) . '&#38;np=' . $num_pages . '">' . $i . '</a> ';
      else 
       echo $i . ' '; } 
  
    if ($current_page != $num_pages) 
        echo '<a class="black" href="index.php?pagelet=order_search_result'.$tog.'&#38;sort='.$sort.'&#38;s=' . ($start + $display) . '&#38;np=' . $num_pages . '">Next</a>';
   
    
    } // End of links section.

    echo '</td</tr>';
    echo '</table>'; 
	if(!empty($errors))
	display_error($errors);
//update status and comments ?>

    <div class="log_info_row"><label for="status" class="log_info_label">Status:</label>
	<select name="status" id="status" tabindex="1">
	<option value="" selected="selected">Select Status</option>
	<?php 
		$group=array(1=>'Processing', 'Shipped', 'Delivered', 'Exception');
		$sticky = (isset($_POST['status']) ? $_POST['status']:"");
		foreach($group as $key => $value)
		{	
		echo "<option value=\"$key\"";
		if($sticky==$key) echo "selected=\"selected\"";
		echo ">$value</option>\n";
		}//End foreach
		
	?>
	</select>
	</div> 
	<div><label for="comment" class="log_info_label">Comment: <br/><small>(max 255 characters)</small></label>
	<textarea name="comment" id="comment" rows="2" cols="45"  tabindex="3" ><?php if (isset($_POST['comment'])) echo $_POST['comment'];?> </textarea></div>
	<div style="padding:20px 1px 10px 160px;"><input type="submit" name="update" id="update" tabindex="2" value="Update"/>&#160; <a href="index.php?pagelet=order">Back to Search</a></div>
<?php 
echo '</form></div>';
}

 else
 echo '<p class="perror">No match found!&#160;  <a href="index.php?pagelet=order">Back to Search</a></p>';

?>