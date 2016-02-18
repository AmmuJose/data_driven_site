<?php

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

$bg='#d7c47d';
$q = "SELECT registered_users.user_id, regdate, acesstype, active_user, firstname, lastname, phone, address1, address2, city, state, zip ";
$q .="FROM registered_users, address, acess_type WHERE registered_users.user_id = address.user_id AND registered_users.acess_id=acess_type.acess_id ";
$q .="AND flag_bs='1' AND email='{$_SESSION['se']}'";
$r=@mysqli_query($dbc, $q)
 OR die("Error".mysqli_error($dbc));						    	
 if(mysqli_num_rows($r)==1)
   {
	echo '<table class="ou">';
	echo '<tr style="background:'.$bg.'">';
	echo '<th>Reg:Date</th>';
	echo '<th>First Name</th><th>Last Name</th>';
	echo '<th>Email, Phone</th>';	
	echo '<th>Acess Group</th><th>Address</th><th>Disable/Enable</th><th>* Edit</th></tr>';

	$row=mysqli_fetch_array($r, MYSQLI_ASSOC);
	
	$bg = ($bg=='#d7c490'?'#cac490':'#d7c490');
	echo '<tr style="background:'.$bg.'">';	
	echo '<td>'.date('m/d/Y',strtotime($row['regdate'])).'</td>';
	echo '<td>'.$row['firstname'].'</td>';		
    echo '<td>'.$row['lastname'].'</td>';	
	echo '<td>'.$_SESSION['se'].'<br/>';
	echo 'Phone: '.$row['phone'].'</td>';		
	echo '<td>'.$row['acesstype'].'</td>';		
	echo '<td>'.$row['address1'].'<br/>';
    if($row['address2'] != "")
    echo $row['address2'].'<br/>';
    echo $row['city'].'<br/>'.$row['state'].', '.$row['zip'].'</td>';		
    
    echo '<td><form method="post" action="index.php?pagelet=email_search">';
	 
	if($row['active_user']==1 && $_SESSION['user_id'] != $row['user_id'])	
	echo '<input type="submit" value="Disable" name="disable['.$row['user_id'].']" class="bton"/></form></td>';
	
	if($row['active_user']==0)	
	echo '<input type="submit" value="Enable" name="enable['.$row['user_id'].']" class="bton"/></form></td>';
	
	echo '<td><a href="index.php?pagelet=change_address&#38;id='.$row['user_id'].'" >';
	echo '<img src="images/edit1.gif" width="16" height="16" alt="Edit" style="border:0;"/></a></td>';
	echo '</tr>';
	
	$bg='#d7c47d';	
	echo '<tr style="background:'.$bg.'"><td colspan="8" style="padding:2px 20px;text-align:right;"></td></tr>';	
    echo '</table>';
	echo '<p style="padding-left:5%;">* Previous addresses will be shown in the edit page.</p>';
	
    mysqli_free_result($r);}//End IF num_rows
	
  else  
	echo '<h5 class="addform">No user Found</h5>'; 	
 
 
echo '<p class="addform"><a href="index.php?pagelet=find_user">Back to user Search</a>.</p>'; 

?>