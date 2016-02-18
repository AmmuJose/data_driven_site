<?php 
function escape_data($data)
{
 global $dbc;
 if(ini_get('magic_quotes_gpc'))
   $data = stripslashes($data);
 return mysqli_real_escape_string($dbc,$data);
}//End function
 ?>