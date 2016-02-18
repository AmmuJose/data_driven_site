<?php 
function showinfo()
{
 echo '<div style = "padding:20px;color:white;">';
 echo '<h4>SESSION Debugging Info: </h5><pre>';
 echo print_r($_SESSION);
 echo '</pre>';
 echo '<h4>GET Info: </h4><pre>';
 echo print_r($_GET);
 echo '</pre>';
 echo '<h4>POSTInfo: </h4><pre>';
 echo print_r($_POST);
 echo '</pre>';
 echo '</div>';
} ?>

