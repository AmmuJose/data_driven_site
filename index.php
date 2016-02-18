<?php

ob_start();

session_name('GarrowayID');
session_start();
$sessionid=session_id();
$WEB_ROOT = getenv("DOCUMENT_ROOT");
$APATH='datadrivenproject';

require_once("functions/show_info.inc.php");

$pagelet = (isset($_GET['pagelet']) ? $_GET['pagelet'] : "index");

//============  Connect Data Base  =============
require_once("C:\db.inc.php");  //include your db config

if($pagelet=='get_address')
include("$WEB_ROOT/$APATH/includes/$pagelet.inc.php");


else
{
require("$WEB_ROOT/$APATH/includes/language.inc.php");

// display error
include("functions/error.inc.php");
	
require_once("functions/escape_data.inc.php");

#index.php                                                                               
//pull in page header
include("$WEB_ROOT/$APATH/includes/header.inc.php");

//pull in navigation bar
include("$WEB_ROOT/$APATH/includes/main_nav.inc.php");

//pull in content
include("$WEB_ROOT/$APATH/pagelets/$pagelet.inc.php");

//pull in footer
include("$WEB_ROOT/$APATH/includes/footer.inc.php");
}
?>