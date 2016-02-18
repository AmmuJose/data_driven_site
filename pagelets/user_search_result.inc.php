<?php error_reporting(E_ALL);
$bg='#d7c47d';

if(isset($_POST['enable']))
{
 foreach($_POST['enable'] as $key=> $value)
 {
  $q="UPDATE registered_users SET active_user=1  WHERE user_id=$key ";
  $r=mysqli_query($dbc, $q);
 }
}
if(isset($_POST['disable']))
{
 foreach($_POST['disable'] as $key=> $value)
 {
  $q="UPDATE registered_users SET active_user=0  WHERE user_id=$key ";
  $r=mysqli_query($dbc, $q);
 }
}

$display = 8;
 
if (isset($_GET['np'])) 
   $num_pages = $_GET['np'];

else { 
    $query = "SELECT COUNT(*) FROM address WHERE flag_bs='1' AND firstname LIKE'{$_SESSION['sfn']}%' AND lastname LIKE '{$_SESSION['sln']}%'";
    $result = mysqli_query ($dbc,$query);
    $row = mysqli_fetch_array ($result, MYSQL_NUM);
    $num_records = $row[0];

    // Calculate the number of pages.
    if ($num_records > $display) 
        $num_pages = ceil ($num_records/$display);
    else 
        $num_pages = 1;    
    
} // End of np IF.

// Default Column Links
$link1 = "{$_SERVER['PHP_SELF']}?pagelet=user_search_result&#38;sort=lna";
$link2 = "{$_SERVER['PHP_SELF']}?pagelet=user_search_result&#38;sort=fna";
$link3 = "{$_SERVER['PHP_SELF']}?pagelet=user_search_result&#38;sort=aga";

//  Determine the sorting order with all possible options
if (isset($_GET['sort']))  {

    switch ($_GET['sort'])  {
        case 'lna';
            $order_by = 'lastname ASC';
            $link1 ="{$_SERVER['PHP_SELF']}?pagelet=user_search_result&#38;sort=lnd";
            $label = "Last Name - Ascending";
            break;
        case 'lnd';
            $order_by = 'lastname DESC';
            $link1 ="{$_SERVER['PHP_SELF']}?pagelet=user_search_result&#38;sort=lna";
            $label = "Last Name - Descending";
            break;
        case 'fna';
            $order_by = 'firstname ASC';
            $link2 ="{$_SERVER['PHP_SELF']}?pagelet=user_search_result&#38;sort=fnd";
            $label = "First Name - Ascending";
            break;
        case 'fnd';
            $order_by = 'firstname DESC';
            $label = "First Name - Descending";
            $link2 ="{$_SERVER['PHP_SELF']}?pagelet=user_search_result&#38;sort=fna";
            break;
        case 'aga';
            $order_by = 'acesstype ASC';
            $link3 ="{$_SERVER['PHP_SELF']}?pagelet=user_search_result&#38;sort=agd";
            $label = "Acess Group - Ascending";
            break;
        case 'agd';
            $order_by = 'acesstype DESC';
            $link3 ="{$_SERVER['PHP_SELF']}?pagelet=user_search_result&#38;sort=aga";
            $label = "Acess Group - Descending";
            break;
        default;
            $order_by = 'acesstype DESC';
            $label = "Acess Group - Descending";
            break;
    }

    //  Append $sort to the pagination links
    $sort = $_GET['sort'];

} else {  // use default sorting order
    $order_by = 'firstname ASC';
    $sort = 'fnd';
    $label = 'First Name - Ascending';
}

// Determine where in the database to start returning results.
if (isset($_GET['s'])) 
    $start = $_GET['s'];
 else 
    $start = 0;

 
$q = "SELECT registered_users.user_id, regdate, active_user, acesstype, active_user,firstname,lastname, email, phone, address1, address2, city, state, zip ";
$q .="FROM registered_users, address, acess_type ";
$q .="WHERE registered_users.user_id = address.user_id AND registered_users.acess_id=acess_type.acess_id ";
$q .="AND flag_bs='1' AND firstname LIKE'{$_SESSION['sfn']}%' AND lastname LIKE '{$_SESSION['sln']}%' ORDER BY $order_by LIMIT $start, $display ";
$r = mysqli_query($dbc, $q);
	
if(mysqli_num_rows($r)>0)
   {
    echo '<div class="bainfo addform"> sorted by: ' . $label . '</div>';
    echo '<div class="addform">Click on First Name, Last Name and Access Group column headings to sort.</div>'; 
    
	
	echo '<table class="ou">';
	echo '<tr style="background:'.$bg.'">';
	echo '<th>Reg:Date</th>';
	echo '<th><a href="' . $link2 . '"> First Name </a> </th>';
	echo '<th><a href="' . $link1 . '"> Last Name </a> </th>';
	echo '<th>Email, Phone</th>';	
	echo '<th> <a href="' . $link3 . '">AccessGroup </a></th>';
	echo '<th>Address</th><th>Enable/Disable</th><th>*Edit</th></tr>';

	while($row = mysqli_fetch_array($r, MYSQLI_ASSOC))
    {
    $bg = ($bg=='#d7c490'?'#cac490':'#d7c490');
	echo '<tr style="background:'.$bg.'">';	
	echo '<td>'.date('m/d/Y',strtotime($row['regdate'])).'</td>';
	echo '<td>'.$row['firstname'].'</td>';		
    echo '<td>'.$row['lastname'].'</td>';
	echo '<td>'.$row['email'].'<br/>';
	echo  'Phone: '.$row['phone'].'</td>';		
	echo '<td>'.$row['acesstype'].'</td>';		
	echo '<td>'.$row['address1'].'<br/>';
    if($row['address2'] != "")
     echo $row['address2'].'<br/>';	
    echo $row['city'].'<br/>'.$row['state'].', '.$row['zip'].'</td>';
	
	echo '<td><form method="post" action="index.php?pagelet=user_search_result">';
	 
	if($row['active_user']==1 && $_SESSION['user_id'] != $row['user_id'])
	echo '<div><input type="submit" value="Disable" name="disable['.$row['user_id'].']" class="bton"/></div></form></td>';
	
	if($row['active_user']==0)	
	echo '<input type="submit" value="Enable" name="enable['.$row['user_id'].']" class="bton"/></form></td>';
	
	echo '<td><a href="index.php?pagelet=change_address&#38;id='.$row['user_id'].'" >';
	echo '<img src="images/edit1.gif" width="16" height="16" alt="Edit" style="border:0;"/></a></td>';
	echo '</tr>';
	}
	$bg='#d7c47d';	
	echo '<tr style="background:'.$bg.'"><td colspan="8" style="padding:2px 20px;text-align:right;">';
	
	
	if ($num_pages > 1) 
	{  
    $current_page = ($start/$display) + 1;    
   
    if ($current_page != 1)
        echo '<a class="black" href="index.php?pagelet=user_search_result&#38;sort='.$sort.'&s=' . ($start - $display) . '&np=' . $num_pages . '">Previous</a> ';
		
    for ($i = 1; $i <= $num_pages; $i++) {
      if ($i != $current_page) 
       echo '<a class="black" href="index.php?pagelet=user_search_result&#38;sort='.$sort.'&s=' . (($display * ($i - 1))) . '&np=' . $num_pages . '">' . $i . '</a> ';
      else 
       echo $i . ' '; } 
  
    if ($current_page != $num_pages) 
        echo '<a class="black" href="index.php?pagelet=user_search_result&#38;sort='.$sort.'&s=' . ($start + $display) . '&np=' . $num_pages . '">Next</a>';
   
    
    } // End of links section.

    echo '</td</tr>';
    echo '</table>';
	echo '<p style="padding-left:5%;">* Previous addresses will be shown in the edit page.</p>';
	echo '<p class="addform"><a href="index.php?pagelet=find_user">Back to user Search</a>.</p>';
    }//End IF num_rows
	
	else
	{
	echo '<p class="perror">No user Found.</p>';
	echo '<p class="addform"><a href="javascript:history.back();">Back to user Search</a>.</p>';	  					 
	} 
	// Make the links to other pages, if necessary.

	?>