<div class="menuwrapper common"> <!-- *** start menuwrapper ***  -->  
	       <ul id="menubar">
	        <li><a href="index.php?pagelet=index"><?php echo constant("HOME");?> </a></li>
            <li><a href="index.php?pagelet=about_us"><?php echo constant("ABOUT_US");?></a></li>
	  		<li><a class="trigger" href="index.php?pagelet=menu"><?php echo constant("MENU");?></a>
	   	      <ul>
	   	       <li><a href="index.php?pagelet=menu"><?php echo constant("DINNER");?></a></li>
               <li><a href="index.php?pagelet=lunch"><?php echo constant("LUNCH");?></a></li>
	   	       <li><a href="index.php?pagelet=wine"><?php echo constant("WINE");?></a></li>	   
	          </ul></li>	  
	   		<li><a class="trigger" href="index.php?pagelet=gift_cards"><?php echo constant("GIFT_CARDS");?></a>
	 		<ul><li><a href="index.php?pagelet=buy_now"><?php echo constant("BUY_NOW");?></a></li></ul></li> 
	  		<li><a href="index.php?pagelet=contact_us"><?php echo constant("CONTACT_US");?></a></li>	
	      </ul>
		  <?php if(isset($_SESSION['agent']) && $_SESSION['acess_id'])            		  
			    echo '<a href="index.php?pagelet=items_cart"><img src="images/carticon.jpg" width="20" height="19" alt="shopping cart" border="0" style="float:right;margin-right:10px;"/></a>'; ?>
          <br class="clearit"/>
		
 </div> <!-- *** end menuwrapper ***  -->   
  <div class ="wrapper common"><!--	 CONTENT WRAPPER -->