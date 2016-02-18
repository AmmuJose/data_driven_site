  <br/>
</div><!-- *** end wrapper ***  -->
<!-- ********* Footer *********  -->
<div class="footer1 common">
     <a href="http://validator.w3.org/check?uri=referer" class="symbol"><img style="border:0;" src="http://www.w3.org/Icons/valid-xhtml11" alt="Valid XHTML 1.1" height="16" width="60"/></a></div>
                  <div class="footernav common">
       						<a href = "index.php?pagelet=index"> Home </a> &#124;
   								<a href = "index.php?pagelet=about_us"> About Us </a> &#124;
   								<a href = "index.php?pagelet=menu"> Menu </a> &#124;
   								<a href = "index.php?pagelet=gift_cards"> Gift Cards </a> &#124;
   								<a href = "index.php?pagelet=contact_us"> Contact Us </a> &#124;
									<a href = "index.php?pagelet=buy_now"> Order Gift Cards </a></div>   
		 <div class="footer common">		            
          <?php echo constant("COPY");					     					     
								echo " Last updated on " . date( "F d, Y.", getlastmod() ) ;
								echo "<br/>";  
					      echo constant("CONTACT"); ?>    
     </div> 
</body>
</html>