<?php
session_start();
// include function files for this application
require_once("modules/required_modules.php");

if (session_is_registered("userName") || (isset($_SESSION['userName']))){
	unset($_POST["frmName"]);
	unset($_GET['p']);
	session_unregister("userName");
	unset($_SESSION['userName']);
	session_destroy();
	
	$message = "Unable to log you out";
	
	// if they were logged in and are now logged out
	displayHeader("Myshop: Home");
	displayAdminTemp("Logout");
	displayLoginForm("");
	displayFooter();

}

else
{
	displayHeader("Myshop: Home");
	displayAdminTemp("Logout");
	displayLoginForm("");
	displayFooter();
}

global $link;
mysql_close($link);
?>