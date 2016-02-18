<?php $account = array('index', 'about_us','contact_us', 'gift_cards','buy_now', 'menu','lunch','wine', 'items_cart', 'payment_info', 'shipping_info','confirm', 'forgot_password'); ?>

	<body <?php if($pagelet == 'index') echo 'onload="rotate()"';?> >
	<div class = "headerwrap common" > <!-- *** start headerwrap ***  -->              
	<img class="headerimg" src = "images/head.jpg" alt = "food img" height = "78" width ="118"/>
	<a href = "index.php?pagelet=index" class = "head"> <img src="images/logo.gif" style = "border:0" alt="Garoway logo"/> </a>
	
<?php
	if(in_array($pagelet, $account))	
	{
		if(isset($_SESSION['agent']))
		{ 			
		if($_SESSION['acess_id'] == 3)               		  
		echo '<a href="index.php?pagelet=my_home" class ="accountnav" >'. constant("LOGIN").'</a>';
			   
		if($_SESSION['acess_id'] == 2)               		  
		echo '<a href="index.php?pagelet=my_home" class ="accountnav" >'. constant("LOGIN").'</a>';
			   
		if($_SESSION['acess_id'] == 1)               		  
		echo '<a href="index.php?pagelet=my_home" class ="accountnav" >'. constant("LOGIN").'</a>';
		}//end of if agent
			  
		else								
		echo '<a href="index.php?pagelet=login_options" class ="accountnav" >'. constant("LOGIN").'</a>';
			  
    }//end of if array			 
?>				
	</div> <!-- end headerwrap  -->	  
	  
			
<?php
	$allowed = array('index', 'about_us', 'menu', 'contact_us', 'gift_cards', 'buy_now','menu','lunch','wine', 'login_options', 'forgot_password', 'create_account', 'items_cart', 'logout', 'shipping_info', 'payment_info','confirm', 'cancel_shopping'); 
	   
	if(in_array($pagelet, $allowed))
	include('includes/nav.inc.php');

	else
	{
		if(isset($_SESSION['agent']) && isset($_SESSION['acess_id']))
		{
			switch($_SESSION['acess_id'])
			{
			case 1:
		    {
				$customer = array('my_home', 'order_history', 'order_search', 'change_address', 'change_password');
				if(in_array($pagelet, $customer))
				{
				include('includes/nav.inc.php');
?>
				<div class = "customer_nav">				                
				<a href = "index.php?pagelet=my_home">My Home</a> &#124;
   				<a href = "index.php?pagelet=order_history"> Order history</a> &#124;
   				<a href = "index.php?pagelet=change_address"> Change Address</a> &#124;
   				<a href = "index.php?pagelet=change_password"> Change Password </a>&#124;
   				<a href = "index.php?pagelet=logout"> Logout</a>
				</div>				
			    <?php  }
			  	
				else
				{
			    header("Location: http://" . $_SERVER['HTTP_HOST'] ."/index.php?pagelet=index" . SID);
			    exit();
				}
			   
				break;			
			}//end case1
			
			case 2:
		    {
				$manager = array('my_home', 'list_card', 'change_address', 'change_password', 'news_board');
				if(in_array($pagelet, $manager))
				{
			    include('includes/nav.inc.php');?>
				<div class = "customer_nav">
				<a href = "index.php?pagelet=my_home">My Home</a> &#124;
   				<a href = "index.php?pagelet=news_board"> News Board</a> &#124;
				<a href = "index.php?pagelet=list_card"> List&#47;Remove Cards</a> &#124;
   				<a href = "index.php?pagelet=change_address"> Change Address</a> &#124;
   				<a href = "index.php?pagelet=change_password"> Change Password </a>&#124;
   				<a href = "index.php?pagelet=logout"> Logout</a>
				</div>			
			    <?php  }
			  
				else
			    {
			    header("Location: http://" . $_SERVER['HTTP_HOST'] ."/index.php?pagelet=index" . SID);
			    exit();
			    }
			    break;			   
		    }//end case2
			
			case 3:
		    {
				$admin =array('my_home', 'add_user', 'find_user', 'order', 'find_cards', 'add_cards', 'change_password', 'edit','user_search_result', 'edit_card','card_search_result','order_details','change_address','email_search', 'order_search_result');
				if(in_array($pagelet, $admin))
				{ ?>
				<div class="menuwrapper common"> <!-- *** start menuwrapper ***  -->  
	            <ul id="menubar">
					<li><a href="index.php?pagelet=my_home">My Home</a></li>           
					<li><a class="trigger" href="index.php?pagelet=find_user">Users</a>
					<ul><li><a href="index.php?pagelet=find_user">Find User</a></li>
					<li><a href="index.php?pagelet=add_user">Add User</a></li>	   	  
					</ul></li>
					<li><a href="index.php?pagelet=order">Orders</a></li>	  
					<li><a class="trigger" href="index.php?pagelet=find_cards">Cards</a>
					<ul>
					<li><a href="index.php?pagelet=find_cards">Find Gift Cards</a></li>
					<li><a href="index.php?pagelet=add_cards">Add Gift Cards</a></li>	  
					</ul></li>
					<li><a href="index.php?pagelet=change_password">Change Password</a></li> 	  
					<li><a href="index.php?pagelet=logout">Logout</a></li>	
	            </ul>
                <br class="clearit"/>
		        </div><!-- *** end menuwrapper ***  --> 
				<div class ="wrapper common"><!--	 CONTENT WRAPPER -->
				<?php  }		  
			  
				else
				{
			    header("Location: http://" . $_SERVER['HTTP_HOST'] . "/index.php?pagelet=index" . SID);
			    exit();
				}
				break;			   
			}//end case3
			
			default:			 
			header("Location: http://" . $_SERVER['HTTP_HOST'] ."/index.php?pagelet=index" . SID);
			exit();
			
			}//end switch
		
		}//end elseif
		
		else
		{
		header("Location: http://" . $_SERVER['HTTP_HOST'] . "/index.php?pagelet=login_options");
		exit();
		}//end else 
	
	} ?>
<br/>