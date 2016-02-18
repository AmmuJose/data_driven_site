<?php 
$errors = array();//initialize an error array 
$flg=0;

if($_SESSION['acess_id'] == 3 && isset($_SESSION['acess_id']) && isset($_GET['id']))
{
 $userid = $_GET['id'];
 $qo="SELECT * FROM address WHERE user_id=$userid AND flag_bs='0'";
 $ro=mysqli_query($dbc, $qo);
 if(mysqli_num_rows($ro)>0)
 {
	echo '<div style="font-weight:bold;margin-left:20px;">Previous Addresses</div>';
	echo '<hr/>';
	echo '<table>';
	echo '<tr>';
	while($row = mysqli_fetch_array($ro, MYSQLI_ASSOC))
	{	
	echo '<td style="padding-left:20px;">';
	echo 'Changed on: '.date('m/d/Y',strtotime($row['adate'])). '<br/>';
	echo $row['firstname']. ' ';		
    echo $row['lastname'].'<br/>';			
	
	echo $row['address1'].'<br/>';
    if($row['address2'] != "")
     echo $row['address2'].'<br/>';	
    echo $row['city'].'<br/>'.$row['state'].', '.$row['zip'].'<br/>';
	echo  'Phone: '.$row['phone'].'<br/>';	
	echo '</td>';
	}
	echo '</tr>';
	echo '</table>';	
	
	echo '<p class="addform"><a href="javascript:history.back();">Back to Search Result</a>.</p>';	
	echo '<hr/>';
 }
}

else
 $userid=$_SESSION['user_id'];

  if(isset($_POST['update']))
	{
    include("includes/validate_address.inc.php");
	
	if(empty($errors))
	{
	 $flg=1;
	 
	 $q ="SELECT address_id ";
	 $q .="FROM address ";
     $q .="WHERE firstname='$fname' AND lastname='$lname' AND address1='$address1' AND address2='$address2' AND city='$city' AND user_id=$userid AND zip=$zipcode AND state='$state' AND phone='$phone' ";
	 
	 $r=mysqli_query($dbc, $q);
	 if(mysqli_num_rows($r)==1)
	  {
	  $row=mysqli_fetch_array($r,MYSQLI_NUM);
	  $_SESSION['nb_id']=$row[0];
	  }
	 
	 else
	  {
	  $q2 = "INSERT INTO address(firstname, lastname, address1, address2, city, state, zip, phone, flag_bs,toaddbook,user_id) ";
	$q2.="VALUES('$fname', '$lname', '$address1', '$address2', '$city', '$state', '$zipcode', '$phone', '1', '1', $userid)";
	  $r2 = mysqli_query($dbc, $q2);	 
	  $_SESSION['nb_id']=mysqli_insert_id($dbc);
	  }
	  
	 if($_SESSION['b_id'] != $_SESSION['nb_id'])	     
	  {
	   if($_SESSION['b_id'] != 0)
		 {
		 $q1="UPDATE address SET flag_bs='0' WHERE address_id={$_SESSION['b_id']}";
		 $r = mysqli_query($dbc, $q1);}			   
			
		 $q2="UPDATE address SET flag_bs='1' WHERE address_id={$_SESSION['nb_id']}";
		 $r = mysqli_query($dbc, $q2);			  
	    }
	 echo '<p class="addform">Address has been successfully updated</p>';
	 
	if($_SESSION['acess_id'] == 3)
	 { echo '<p class="addform"><a href="index.php?pagelet=find_user">Back To Search User</a>.</p>';}
	 
	else
	 { echo '<p class="addform"><a href="index.php?pagelet=my_home">Back To Your Home Page </a>.</p>'; }
	 
	}//end of if empty
	
	else
	display_error($errors);	
	
	}//end if isset	
	if($flg==0)
	{
    ?>
 
  	
  <div style="margin-left:33%;font-weight:bold;">Update Your Address</div>
  <div style="margin:5px 5px 10px 5px;"><div class="chindicates">* Indicates Required field</div></div>
  <div>
	<form method="post" action="" onsubmit="return validateform();" >   
    <?php 
	 $q="SELECT address_id, firstname, lastname, address1, address2, city, state, zip, phone ";
	 $q .="FROM address WHERE user_id=$userid AND flag_bs ='1'";		 
	 $r=mysqli_query($dbc, $q);
	 
	 if(mysqli_num_rows($r)!=1)
	   $_SESSION['b_id'] =0;	   
	  
	 else
	 { $row = mysqli_fetch_array($r, MYSQLI_ASSOC); 
	   $_SESSION['b_id'] =$row['address_id']; } 
	 
	  
	$fn=1; $ln=2; $ad1=3; $ad2=4; $cty=5; $num=6; $zp=7; $ph=8; $s=9;$left='addleft';$right='addright';
	 echo '<div style="height:150px;">';
	 include("includes/edit_address_form.inc.php");
	 echo '</div>';?>
	
    <div style="margin-left:33%;"><input type="submit" name="update" id="update" tabindex="10" value="Update" />
	<?php  
   if($_SESSION['acess_id'] == 3)
	 { echo '&#160; <a href="index.php?pagelet=find_user">Back To Search User</a>.'; }
	 
	else
	 { echo '&#160; <a href="index.php?pagelet=my_home">Back To Your Home Page </a>.'; }

 } ?>
	
	</div>	 
 </form>
</div> 