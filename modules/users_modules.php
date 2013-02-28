<?php
/*---------------------------------------------------------------------------
/* This function process all the validatins for Stock Item Entry and Edit     */
/*----------------------------------------------------------------------------*/
function userVal(&$message,&$errorArray,&$valuesArray,&$errorFlag){
	$errorFlag =false;
	foreach ($_POST  as $key => $value){
		if($key == "frmName"){
			$errorArray["$key"] = "";
			$valuesArray["$key"] = $value;
		}
		else{
			if(isset($key) && ($value =="") && (($key == "fName") || ($key == "lName") || ($key == "userName") || ($key == "password") || ($key == "userGroup"))){
				$errorArray["$key"] = "*";
				$valuesArray["$key"] = "";
				$errorFlag = true;
			}
			else{
				$errorArray["$key"] = "";
				$valuesArray["$key"] = $value;
			}
		
			if(($key == "phone") && ($value !="")){
				$value = str_replace(" ", "", $value);
				if(!checkPhoneNumber($value)){
					$errorArray["$key"] = "*";
					$valuesArray["$key"] = "";
					$errorFlag = true;
				}
				else{
					$_POST["$key"] = $value;
					$errorArray["$key"] = "";
					$valuesArray["$key"] = $value;
				}
			}
			
			if(($key == "email") && ($value !="")){
				if(!validEmail($value)){
					$errorArray["$key"] = "*";
					$valuesArray["$key"] = "";
					$errorFlag = true;
				}
				else{
					$errorArray["$key"] = "";
					$valuesArray["$key"] = $value;
				}
			}
		}
			
		if(($_POST["status"] !="Active") && ($_POST["status"] !="Inactive")){
			$errorArray["status"] = "<font color=\"#EE2020\">*</font>";
			$valuesArray["$status"] = "";
			$errorFlag = true;
		}
		
	}
	return !($errorFlag);
}
/*---------------------------------------------------------------------------
/* This function process the entry of a new stock item into the database*/
/*----------------------------------------------------------------------------*/
function addUser($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	$fName 			= trim($_POST["fName"]);
	$lName 			= trim($_POST["lName"]);
	$phone 			= trim($_POST["phone"]);
	$email 			= trim($_POST["email"]);
	
	$userName 		= trim($_POST["userName"]);
	$userGroup 		= trim($_POST["userGroup"]);
	$status	 		= trim($_POST["status"]);
	
	$date			= date("Y-m-d");
	$time			= date("H:i.s");
	
	
	
	if(!$fName && !$lName && !$phone && !$email && !$userName  && !$password && !$status && !$userGroup){
		$errorFlag 	= false;
		displayHeader("Myshop: Users");	
		displayAdminTemp("Home");
		displayAddUser($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}
	
	$valid = userVal($message,$errorArray,$valuesArray,$errorFlag);
	if($valid == true){
		$fName 				= addslashes($fName);
		$lName 				= addslashes($lName);
		$phone 				= addslashes(str_replace(" ", "", $phone));
		$email 				= addslashes($email);
		
		$userName 			= addslashes(str_replace(" ", "", $userName));
		$password 			= addslashes(sha1($userName));
		$userGroup	 		= addslashes($userGroup);
		
		
		// Check if there are enough items in stock
		$query = "SELECT * FROM users WHERE userName ='".$userName."'";
		$result = sql_query($query, $message);
		
		$row = mysql_num_rows($result);
		if($row > 0){
			$valuesArray["userName"] 		= "";
			$errorArray["userName"] 		= "*";
			
			$message 	="The specified user already exist. Please enter a different userName.";
			$errorType 	= "error";
			
			$errorFlag 	= true;
			displayHeader("Myshop: Users");	
			displayAdminTemp("Home");
			displayAddUser($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();
			exit;
		}
			//Insert values into database
		else{
		
			$query = "INSERT INTO users (fName, lName, phone, email, userName, password, userGroup, status) ";
			$query .= "VALUES ('".$fName."','".$lName."','".$phone."','".$email."','".$userName."','".$password;
			$query .= "','".$userGroup."','".$status."')";
			
			$result = sql_query($query, $message);
			
			$message = "Successfully saved";
			$valuesArray["query"] = "SELECT * FROM users WHERE userName ='".$userName."'";			
			$errorType = "success";
			displayHeader("Myshop: Users");	
			displayAdminTemp("Home");
			displayViewUsers($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();
			exit;
		}
	}
		
	else {	
			
		$message = "Please make sure that the marked fields are propery filled.";
		$errorType = "error";
		$errorFlag 	= true;
		displayHeader("Myshop: Users");	
		displayAdminTemp("Home");
		displayAddUser($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}	
}


/*-----------------------------------------------------------------------------------------------------------------
/*This function is the first processe of editing user information given 
/*----------------------------------------------------------------------------------------------------------------*/

function editUser1($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	//Retrieve the posted itemID first
		if($valuesArray["userName"] == ""){
		$userName 		= $_POST["userName"];
		}
		else{$userName = $valuesArray["userName"];}
		
		
		$userName 			= addslashes($userName);
		// Check if the item realy exist in the database before inserting
		$query = "SELECT * FROM users WHERE userName ='".$userName."'";
		$result = sql_query($query, $message);
		
		if(mysql_num_rows($result) == 0) {
			$message = "User  With UserName \"$userName\" doesnt exit. Please enter a valid UserName"; 
			$errorType = "error";
			displayHeader("Myshop: Users");	
			displayAdminTemp("Home");
			displayViewUsers($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();
			exit;
		}
		else {
			$errorFlag=true;
			$row = mysql_fetch_array($result);
			
			$valuesArray["userID"]				= htmlspecialchars(stripslashes($row["userID"]));
			$valuesArray["userName"]			= htmlspecialchars(stripslashes($row["userName"]));
			$valuesArray["userGroup"]			= htmlspecialchars(stripslashes($row["userGroup"]));
			$valuesArray["status"]				= htmlspecialchars(stripslashes($row["status"]));
			
			$valuesArray["fName"]				= htmlspecialchars(stripslashes($row["fName"]));
			$valuesArray["lName"]				= htmlspecialchars(stripslashes($row["lName"]));
			$valuesArray["phone"]				= htmlspecialchars(stripslashes($row["phone"]));
			$valuesArray["email"]				= htmlspecialchars(stripslashes($row["email"]));
		
			
			$message = "You can not change the userName of any particular user.";
			$errorType = "info";
			displayHeader("Myshop: Users");	
			displayAdminTemp("Home");
			displayEditUser($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();
			exit;
		}
		
}
/*--------------------------------------------------------------------------------------------------------
/**This function is the firrst processe of editing of a particular stock item given a particular stock ID
/*--------------------------------------------------------------------------------------------------------*/
function editUser2($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	$fName 			= trim($_POST["fName"]);
	$lName 			= trim($_POST["lName"]);
	$phone 			= trim($_POST["phone"]);
	$email 			= trim($_POST["email"]);
	
	$userID 		= trim($_POST["userID"]);
	$userName 		= trim($_POST["userName"]);
	$userGroup 		= trim($_POST["userGroup"]);
	$status	 		= trim($_POST["status"]);
	
	$date			= date("Y-m-d");
	$time			= date("H:i.s");
	
	if($status == "Inactive"){
		$passwordChanged = "No";
		$passwordChanged = "',passwordChanged ='".$passwordChanged;
	}
	else{$passwordChanged = "";} 
	
	if(!$fName && !$lName && !$phone && !$email && !$userName  && !$password && !$status && !$userGroup){
		
		displayHeader("Myshop: Users");	
		displayAdminTemp("Home");
		displayEditUser($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}
	

	$valid = userVal($message,$errorArray,$valuesArray,$errorFlag);
	if($valid == true){
		$fName 				= addslashes($fName);
		$lName 				= addslashes($lName);
		$phone 				= addslashes(str_replace(" ", "", $phone));
		$email 				= addslashes($email);
		
		$userID 			= addslashes(str_replace(" ", "", $userID));
		$userName 			= addslashes(str_replace(" ", "", $userName));
		$password 			= addslashes(sha1($userName));
		$userGroup	 		= addslashes($userGroup);
		$status		 		= addslashes($status);
		
		$query = "SELECT * FROM users WHERE userName ='".$userName."'";
		$result = sql_query($query, $message);
		
		$row = mysql_num_rows($result);
		if($row == 0){
			$valuesArray["userName"] 		= "";
			$errorArray["userName"] 		= "*";
			
			$message 	="The specified user doesn't exist. Please enter a different userName.";
			$errorType 	= "error";
			
			$errorFlag 	= true;
			displayHeader("Myshop: Users");	
			displayAdminTemp("Home");
			displayEditUser($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();
			exit;
		}
		else{
			$query = "UPDATE users SET fName ='".$fName."',lName ='".$lName."',phone ='".$phone."',email ='";
			$query .= $email."',userName ='".$userName."',userGroup ='".$userGroup."',status ='".$status.$passwordChanged; 
			$query .= "' WHERE userID ='".$userID."'";
						
			$result = sql_query($query, $message);
			
			$message = "Successfully saved";
			$valuesArray["query"] = "SELECT * FROM users WHERE userName ='".$userName."'";
			$errorType = "success";
			displayHeader("Myshop: Users");	
			displayAdminTemp("Home");
			displayViewUsers($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();
			exit;
		}
	}
		
	else {	

		$errorFlag = true;
		$message = "Please make sure that the marked fields are propery filled.";
		$errorType = "error";
		displayHeader("Myshop: Users");	
		displayAdminTemp("Home");
		displayEditUser($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}	
}
function viewUsers($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	//Retrieve the posted itemID first 
		$searchTerm 		= $_POST["searchTerm"];
		$userName 			= $_POST["userName"];
		$userGroup 			= $_POST["userGroup"];
		
		$valuesArray["searchTerm"]= stripslashes($searchTerm);
		$valuesArray["lowerLimit"] 	= $valuesArray["lowerLimit"];
		$valuesArray["userGroup"]= stripslashes($userGroup);
		if(!$userGroup ){
			displayHeader("Myshop: Users");	
			displayAdminTemp("Home");
			displayViewUsers($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();  exit;
		}
		else {
			$errorFlag=true;
			$valuesArray["userGroup"]= stripslashes($userGroup);
			displayHeader("Myshop: Users");	
			displayAdminTemp("Home");
			displayViewUsers($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();
			exit;
		}
}


/******************************************************************************************/

/******************************************************************************************/

function viewUserInfo($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	
	$valuesArray["searchTerm"]	=stripslashes($valuesArray["searchTerm"]);
	$valuesArray["lowerLimit"] 	= $valuesArray["lowerLimit"];
	$userName 				= addslashes($valuesArray["userName"]);

	// Check if the item realy exist in the database before inserting
	$query = "SELECT * FROM users WHERE userName ='".$userName."'";
	$result = sql_query($query, $message);

	$errorFlag=true;
	$row = mysql_fetch_array($result);
	
	$valuesArray["fName"]		= htmlspecialchars(stripslashes($row["fName"]));
	$valuesArray["lName"]		= htmlspecialchars(stripslashes($row["lName"]));
	$valuesArray["phone"]				= htmlspecialchars(stripslashes($row["phone"]));
	$valuesArray["email"]				= htmlspecialchars(stripslashes($row["email"]));
	
	$valuesArray["userName"]		= htmlspecialchars(stripslashes($row["userName"]));
	$valuesArray["userGroup"]		= htmlspecialchars(stripslashes($row["userGroup"]));
	$valuesArray["status"]			= htmlspecialchars(stripslashes($row["status"]));
	$valuesArray["lastDate"]		= htmlspecialchars(stripslashes($row["lastDate"]));
	
	displayHeader("Myshop: Users");	
	displayAdminTemp("Home");
	displayViewUserInfo($message,$errorArray,$valuesArray,$errorFlag,$errorType);
	displayFooter();
	exit;
}


function resetPassword($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	//Retrieve the posted itemID first
		if($valuesArray["userName"] == ""){
		$userName 		= $_POST["userName"];
		}
		else{$userName = $valuesArray["userName"];}
		
		
		$userName 			= addslashes($userName);
		// Check if the item realy exist in the database before inserting
		$query = "SELECT * FROM users WHERE userName ='".$userName."'";
		$result = sql_query($query, $message);
		
		if(mysql_num_rows($result) == 0) {
			$message = "User  With UserName \"$userName\" doesnt exit. Please enter a valid UserName"; 
			$errorType = "error";
			displayHeader("Myshop: Users");	
			displayAdminTemp("Home");
			displayViewUsers($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();
			exit;
		}
		else{
			$passwordChanged = "No";
			$query = "UPDATE users SET password ='".sha1($userName)."',passwordChanged ='".$passwordChanged;
			$query .= "' WHERE userName ='".$userName."'";
						
			$result = sql_query($query, $message);
			
			$message = "Password for user ".$userName.", reset successfully.";
			
			$errorType = "success";
			displayHeader("Myshop: Users");	
			displayAdminTemp("Home");
			displayViewUsers($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();
			exit;
		}
}
/*-------------------------------------------------------------------------------------------------------*/

function nextUsers($message,$errorArray,$valuesArray,$errorFlag,$errorType){
		
	$errorFlag=true;
	$valuesArray["searchTerm"]	=stripslashes($valuesArray["searchTerm"]);

	$valuesArray["lowerLimit"] = $valuesArray["lowerLimit"];
	displayHeader("Myshop: Users");	
	displayAdminTemp("Home");
	displayViewUsers($message,$errorArray,$valuesArray,$errorFlag,$errorType);
	displayFooter();
	exit;
}

function previousUsers($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	$errorFlag=true;
	$valuesArray["searchTerm"]	=stripslashes($valuesArray["searchTerm"]);

	$valuesArray["lowerLimit"] = $valuesArray["lowerLimit"];
	displayHeader("Myshop: Users");	
	displayAdminTemp("Home");
	displayViewUsers($message,$errorArray,$valuesArray,$errorFlag,$errorType);
	displayFooter();
	exit;
}


/*-----------------------------------------------------------------------------------------------------------------*/

function changePassword($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	
	$userName 			= $_POST["userName"];
	$currentPassword 	= $_POST["currentPassword"];
	$newPassword	 	= $_POST["newPassword"];
	$confirmPassword	= $_POST["confirmPassword"];
	
	if(!$currentPassword && !$newPassword && !$confirmPassword){
		$message = "Please make sure that you have entered all the required fields";
		$errorType = "error";
		displayHeader("Myshop: Users");	
		displayAdminTemp("Home");
		displayChangePassword($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}
	
	
	$userName 			= addslashes($userName);
	$currentPassword 	= addslashes($currentPassword);
	$newPassword	 	= addslashes($newPassword);
	$confirmPassword	= addslashes($confirmPassword);
	
	if(strcmp($newPassword, $confirmPassword) != 0){
		$message = "The new password and the confirmed password doesn't match. Please try again!"; 
		$valuesArray["currentPassword"] 		= "";
		$errorArray["currentPassword"] 			= "*";
		
		$valuesArray["newPassword"] 			= "";
		$errorArray["newPassword"] 				= "*";
		
		$valuesArray["confirmPassword"] 		= "";
		$errorArray["confirmPassword"] 			= "*";
		
		$errorType = "error";
		displayHeader("Myshop: Users");	
		displayAdminTemp("Home");
		displayChangePassword($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}
	$query = "SELECT * FROM users WHERE userName='".$userName."' AND password='".sha1($currentPassword)."'";
	$result = sql_query($query, $message);
	
	$row = mysql_num_rows($result);
	if($row == 0){
		$valuesArray["userName"] 		= "";
		$errorArray["userName"] 		= "*";
		
		$message 	="The current password specified doesn't match your password. Please try again!";
		$errorType 	= "error";
		
		$errorFlag 	= true;
		displayHeader("Myshop: Users");	
		displayAdminTemp("Home");
		displayChangePassword($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}
	else{
		$passwordChanged = "Yes";
		$query = "UPDATE users SET password ='".sha1($newPassword)."',passwordChanged ='".$passwordChanged; 
		$query .= "' WHERE userName ='".$userName."'";
					
		$result = sql_query($query, $message);
		
		$message = "Your password has been changed.";
		$valuesArray["query"] = "SELECT * FROM users WHERE userName ='".$userName."'";
		$errorType = "success";
		displayHeader("Myshop: Users");	
		displayAdminTemp("Home");
		displayViewUsers($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}

}

?>