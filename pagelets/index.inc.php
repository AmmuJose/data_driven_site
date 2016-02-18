<img src="images/moving1.jpg"  alt="food image" width="240" height="158" id="adBanner" class="moving_img"/>

 <h4 class="welcome">Welcome!</h4>
 <div style="margin:0px 30px 0px 30px;">
 <p class="para">Whether you're having an intimate dinner, a private party or a business event, Garroway Restaurant is the perfect place for you and your guests. 
    Garroway Restaurant features the finest in Caribbean style that will exceed all expectations.Our goal is to give you great food at reasonable prices. 
		Come unwind and dine with courteous and friendly service, in the original Caribbean style.</p>	 

  <p class="para adblist"> Open six days a week, Tuesday through Sunday, with Carry-Out service or Fine Dinning in spacious dinning rooms for lunch or dinner. </p>
</div>
	<a id="news_board"></a>
	<!-- Gift Giving Made Easy
       Garroway Restaurant's gift card is a perfect gift for every one. Great for BirthDay, Anniversaries and other special occasions.
			 NEW Lobster & Shrimp Quesadilla Chicken and Fresh Vegetable
         Steamed lobster and shrimp with spinach and cheese, served with tomato salsa and sour cream. -->
	<?php	
	$q = "SELECT heading, content FROM news_board ORDER BY news_board_name ASC";
	$r =@mysqli_query($dbc, $q);	     
	 
	 echo '<table summary="News Board" border="0" cellspacing ="25" class="newsbrd"><tr>';
	while($row = mysqli_fetch_array($r, MYSQLI_ASSOC))		
	 echo '<td style="width:300px;"><p class = "hed">'.htmlspecialchars($row['heading'], ENT_QUOTES) . '</p> <p class="cont">'. htmlspecialchars($row['content'], ENT_QUOTES). '</p></td>'; 
	 mysqli_close($dbc);
	 echo '</tr></table>';
	?>