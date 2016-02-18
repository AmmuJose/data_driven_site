<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
   "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
   <html xmlns="http://www.w3.org/1999/xhtml">

<head> 
	<meta name="keywords" content="<?php echo constant(strtoupper($pagelet).'_KEY'); ?>"/>
    <meta name="description" content="<?php echo constant('META_DEFAULT_DESC').''.constant(strtoupper($pagelet) . '_DESC'); ?>"/>
	<meta name="author" content="<?php echo constant('META_AUTHOR'); ?>"/>  
    <meta name="copyright" content="<?php echo constant('COPY'); ?>"/>
    <meta name="robots" content="<?php echo constant('ROBOTS'); ?>"/>  

    <!-- <link rel="icon" type="image/png" href="fevicon.png"/>	-->
    <link rel="shortcut icon" href="/fevicon.ico" type="image/x-icon" />
    <link href="css/main_nav.css" rel="stylesheet" type="text/css" /> 
    <link href="css/admin.css" rel="stylesheet" type="text/css" />
		<?php 
		   //------------------------ for javascript----------------------------
		      $allowed = array('buy_now', 'forgot_password', 'create_account',  'news_board', 'add_cards', 'find_cards', 'find_user', 'add_user', 'payment_info', 'index', 'shipping_info','login_options','change_address', 'change_password');
			if(in_array($pagelet, $allowed))
		       echo "<script type=\"text/javascript\" src=\"javascripts/$pagelet-validation.js\"></script>" ;			 
				
			  $order = array('order', 'order_history');
			if(in_array($pagelet, $order))
			{
			echo '<link href="css/calendar.css" rel="stylesheet" type="text/css" />	';
		    echo "<script type=\"text/javascript\" src=\"javascripts/calendar.js\"></script>" ;
			echo "<script type=\"text/javascript\" src=\"javascripts/$pagelet-validation.js\"></script>" ;
			}
				
			$menu = array('menu', 'lunch', 'wine');
			   if(in_array($pagelet, $menu))
		       echo "<script type=\"text/javascript\" src=\"javascripts/menu.js\"></script>" ;
				
		?>   
    <title> <?php echo constant("SITENAME"). ": ". constant(strtoupper($pagelet) . '_TITLE'); ?> </title>      
</head>    