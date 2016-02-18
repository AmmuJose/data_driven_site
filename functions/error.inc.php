<?php 
 function display_error($errors)
 {
    // echo '<p class="perror">Error!</p>';
		 foreach($errors as $msg)
		 echo '<div class="perror">* '. $msg. '</div>';
	}
  ?>