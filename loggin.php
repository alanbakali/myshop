<?php
session_start();
require_once("modules/required_modules.php");
$valid = loginValidation($message);

if($valid == true){
	$userName = addslashes($_POST["userName"]);
	$password = addslashes($_POST["password"]);
	$query = "SELECT * FROM users WHERE userName ='".$userName."' AND password ='".sha1($password)."'";
	$result = sql_query($query, $message);

	if((mysql_num_rows($result))== 0){
		displayHeader("Myshop: Home");
		displayAdminTemp("Logout");
		displayLoginForm("Incorrect username or password.");
		displayFooter();
		exit;
	}
	else{	
		
		$rows = mysql_fetch_array($result);
		
		$status = htmlspecialchars(stripslashes($rows["status"]));
		if($status != "Active"){
			displayHeader("Myshop: Home");
			displayAdminTemp("Logout");
			displayLoginForm("Your account has been deactivated.");
			displayFooter();
			exit;
		}
		$_SESSION['fName']= htmlspecialchars(stripslashes($rows["fName"]));
		$_SESSION['lName']= htmlspecialchars(stripslashes($rows["lName"]));
		$_SESSION['userName'] = htmlspecialchars(stripslashes($rows["userName"]));
		$_SESSION['userGroup'] = htmlspecialchars(stripslashes($rows["userGroup"]));
		$_SESSION['status'] = htmlspecialchars(stripslashes($rows["status"]));
		$_SESSION['passwordChanged']  = htmlspecialchars(stripslashes($rows["passwordChanged"]));
		 
		
		$date			= date("Y-m-d");
		$time			= date("H:i.s");
		
		$query = "UPDATE users SET lastDate ='".$date."',time ='".$time; 
		$query .= "' WHERE userName ='".$userName."'";
					
		$result = sql_query($query, $message);
		
		if($_SESSION['passwordChanged'] != "Yes"){
			$message = "Change your password first.";
			$errorType = "warning";
			displayHeader("Myshop: Users");	
			displayAdminTemp("Home");
			displayChangePassword($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();  exit;
		}
		else {
			displayHeader("Myshop:  Admin Home");	
			displayAdminTemp("Home");
			displayAdminHomePage($welcomeMessage);
			displayFooter();  exit;
		}	
	}
}	
else{
	displayHeader("Myshop: Home");
	displayAdminTemp("Logout");
	displayLoginForm("");
	displayFooter();
	exit;
}	


		
?>
