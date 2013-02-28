<?php

/*---------------------------------------------------------------------------
/* This function process all the validatins for Stock Item Entry and Edit     */
/*----------------------------------------------------------------------------*/
function downPaymentVal(&$message,&$errorArray,&$valuesArray,&$errorFlag){
	$errorFlag =false;
	foreach ($_POST  as $key => $value){
		if(($key == "frmName") || ($key == "address") || ($key == "initialQuantity")  || ($key == "serial")){
			$errorArray["$key"] = "";
			$valuesArray["$key"] = $value;
		}
		else{
			if(isset($key) && ($value =="") && (($key == "customerName") || ($key == "title") || ($key == "reason") || ($key == "description"))){
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
			
			
			if(($key == "firstPayment") || ($key == "recieptNumber") || ($key == "quantity") || ($key == "downPaymentID") || ($key == "amount") || ($key == "price")){
				$value = str_replace(" ", "", $value);
				if(!(is_numeric($value)) || ($value == 0) ){
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
			if(($key == "lastPayment")){
				$value = trim(str_replace(" ", "", $value));
				if($value ==""){}
				else 
					if(!(is_numeric($value)) ){
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
			if(($key == "recieptNumber2")){
				$value = trim(str_replace(" ", "", $value));
				if($_POST["lastPayment"] == ""){}
				else 
					if(!(is_numeric($value)) ){
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
			
			if(($key == "balance") || ($key == "totalCostPrice") || ($key == "lastBalance")){
				$errorArray["$key"] = "";
				$valuesArray["$key"] = $value;
			}
		}
		if(($_POST["title"] !="Mr") && ($_POST["title"] !="Mrs") && ($_POST["title"] !="Miss")){
			$errorArray["title"] = "<font color=\"#EE2020\">*</font>";
			$valuesArray["$title"] = "";
			$errorFlag = true;
		}
		
	}
	return !($errorFlag);
}
/*---------------------------------------------------------------------------
/* This function process the entry of a new stock item into the database*/
/*----------------------------------------------------------------------------*/

/*---------------------------------------------------------------------------
/* This function process the entry of a new stock item into the database*/
/*----------------------------------------------------------------------------*/
function enterDownPayment($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	$description 		= trim($_POST["description"]);
	$price 				= trim($_POST["price"]);
	
	$title 				= trim($_POST["title"]);
	$customerName 		= trim($_POST["customerName"]);
	$address 			= trim($_POST["address"]);
	$phone 				= trim($_POST["phone"]);
	$email 				= trim($_POST["email"]);
	
	$downPaymentID 		= trim($_POST["downPaymentID"]);
	$quantity 			= trim($_POST["quantity"]);
	$totalCostPrice	 	= trim($_POST["totalCostPrice"]);
	$firstPayment 		= trim($_POST["firstPayment"]);
	$balance 			= trim($_POST["balance"]);
	$recieptNumber 		= trim($_POST["recieptNumber"]);
	
	$user				=$_SESSION['userName'];
	$date				= date("Y-m-d");
	$time				= date("H:i.s");
	
	
	
	if(!$downPaymentID && !$title && !$customerName && !$address && !$phone && !$email && !$firstPayment  && !$totalCostPrice && !$balance && !$recieptNumber){
		
		displayHeader("Myshop: DownPayments");	
		displayAdminTemp("DownPayments");
		displayEnterDownPayment($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}
	
	$valid = downPaymentVal($message,$errorArray,$valuesArray,$errorFlag);
	if($valid == true){
		$itemID 			= addslashes($itemID);
		$price 				= addslashes($price);
		$description 		= addslashes($description);
		
		$title 				= addslashes($title);
		$customerName 		= addslashes($customerName);
		$address	 		= addslashes($address);
		$phone 				= addslashes(str_replace(" ", "", $phone));
		$email 				= addslashes($email);
		
		$downPaymentID 		= addslashes(str_replace(" ", "", $downPaymentID));
		$quantity 			= addslashes(str_replace(" ", "", $quantity));
		$totalCostPrice	 	= $price * $quantity;
		$firstPayment 		= addslashes(str_replace(" ", "", $firstPayment));
		$balance			= $totalCostPrice - $firstPayment;
		$recieptNumber		= addslashes(str_replace(" ", "", $recieptNumber));
		
		$user				= addslashes($user);
		$date 				= addslashes($date);
		$time				= addslashes($time);
		
		// Check if there are enough items in stock
		$query = "SELECT * FROM downpayments WHERE downPaymentID ='".$downPaymentID."'";
		$result = sql_query($query, $message);
		
		if(mysql_num_rows($result) > 0) {
			$message = "Down payment with ID '$downPaymentID' already entered. Please enter a different ID"; 
			$errorType = "error";
			$errorArray["downPaymentID"] = "*";
			$valuesArray["$downPaymentID"] = "";
			displayHeader("Myshop: DownPayments");	
			displayAdminTemp("DownPayments");
			displayEnterDownPayment($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();
			exit;
		}
	
		$query = "INSERT INTO downpayments (downPaymentID, quantity, price, totalCostPrice, firstPayment, lastPayment, balance, recieptNumber, title,";
		$query .= "customerName, address, phone, email, description, user, date, time) ";
		$query .= "VALUES ('".$downPaymentID."','".$quantity."','".$price."','".$totalCostPrice."','".$firstPayment."','".$lastPayment;
		$query .= "','".$balance."','".$recieptNumber;		
		$query .= "','".$title."','".$customerName."','".$address."','".$phone."','".$email."','".$description."','".$user."','".$date."','".$time."')";
		
		$result = sql_query($query, $message);
		
		$message = "Successfully saved";
		$errorType = "success";
		$valuesArray["query"] = "SELECT * FROM downpayments WHERE downPaymentID ='".$downPaymentID."'";
		displayHeader("Myshop: DownPayments");	
		displayAdminTemp("DownPayments");
		displayViewDownPayments($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}
		
	else {				
		$errorFlag=true;
		$message = "Please make sure that the marked fields are propery filled.";
		$errorType = "error";
		displayHeader("Myshop: DownPayments");	
		displayAdminTemp("DownPayments");
		displayEnterDownPayment($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}	
}


/*-----------------------------------------------------------------------------------------------------------------
/*This function is the firrst processe of editing of a particular stock item given a particular stock ID
/*----------------------------------------------------------------------------------------------------------------*/

function editDownPayment1($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	//Retrieve the posted itemID first
		if($valuesArray["downPaymentID"] == ""){
		$downPaymentID 		= $_POST["downPaymentID"];
		}
		else{$downPaymentID = $valuesArray["downPaymentID"];}
		
		
		if(!$downPaymentID){
			$message = "Enter down payment ID and click Go to edit a specific down payment entry.";
			$errorType = "info";
			displayHeader("Myshop: DownPayments");	
			displayAdminTemp("DownPayments");
			displayEditDownPayment1($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();  exit;
		}
		$downPaymentID = str_replace(" ", "", $downPaymentID);
		if(is_numeric($downPaymentID)){
			$downPaymentID 			= addslashes($downPaymentID);
			// Check if the item realy exist in the database before inserting
			$query = "SELECT * FROM downpayments WHERE downPaymentID ='".$downPaymentID."'";
			$result = sql_query($query, $message);
			
			if(mysql_num_rows($result) == 0) {
				$message = "DownPayment entry with ID '$downPaymentID' doesnt exit. Please enter a valid down payment ID"; 
				$errorType = "error";
				displayHeader("Myshop: DownPayments");	
				displayAdminTemp("DownPayments");
				displayEditDownPayment1($message,$errorArray,$valuesArray,$errorFlag,$errorType);
				displayFooter();
				exit;
			}
			
				$errorFlag=true;
				$row = mysql_fetch_array($result);
				
				$valuesArray["description"]		= htmlspecialchars(stripslashes($row["description"]));
				$valuesArray["price"]			= htmlspecialchars(stripslashes($row["price"]));
				$valuesArray["serial"]			= htmlspecialchars(stripslashes($row["serial"]));
				
				$valuesArray["customerName"]		= htmlspecialchars(stripslashes($row["customerName"]));
				$valuesArray["address"]				= htmlspecialchars(stripslashes($row["address"]));
				$valuesArray["title"]				= htmlspecialchars(stripslashes($row["title"]));
				$valuesArray["phone"]				= htmlspecialchars(stripslashes($row["phone"]));
				$valuesArray["email"]				= htmlspecialchars(stripslashes($row["email"]));
				
				$valuesArray["downPaymentID"]		= htmlspecialchars(stripslashes($row["downPaymentID"]));
				$valuesArray["firstPayment"]		= htmlspecialchars(stripslashes($row["firstPayment"]));
				$valuesArray["lastPayment"]			= htmlspecialchars(stripslashes($row["lastPayment"]));
				$valuesArray["totalCostPrice"]		= htmlspecialchars(stripslashes($row["totalCostPrice"]));
				$valuesArray["balance"]				= htmlspecialchars(stripslashes($row["balance"]));
				$valuesArray["recieptNumber"]		= htmlspecialchars(stripslashes($row["recieptNumber"]));
				$valuesArray["recieptNumber2"]		= htmlspecialchars(stripslashes($row["recieptNumber2"]));
				$valuesArray["quantity"]			= htmlspecialchars(stripslashes($row["quantity"]));
				
				
				$message = "You can not change the down payment ID";
				$errorType = "warning";
				displayHeader("Myshop: Edit DownPayment");	
				displayAdminTemp("DownPayments");
				DisplayEditDownPayment2($message,$errorArray,$valuesArray,$errorFlag,$errorType);
				displayFooter();
				exit;
		}
		else{
			$errorFlag = true;
			$message = "Please make sure you have entered a valid down payment ID.";
			$errorType = "error";
			displayHeader("Myshop: DownPayments");	
			displayAdminTemp("DownPayments");
			DisplayEditDownPayment1($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();
			exit;
		
		}
}
/*-------------------------------------------------------------------------------------------------------
/*--------------------------------------------------------------------------------------------------------
/**This function is the firrst processe of editing of a particular stock item given a particular stock ID
/*--------------------------------------------------------------------------------------------------------*/
function editDownPayment2($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	$description 		= trim($_POST["description"]);
	$price 				= trim($_POST["price"]);
	$serial 				= trim($_POST["serial"]);
	
	$title 				= trim($_POST["title"]);
	$customerName 		= trim($_POST["customerName"]);
	$address 			= trim($_POST["address"]);
	$phone 				= trim($_POST["phone"]);
	$email 				= trim($_POST["email"]);
	
	$downPaymentID 		= trim($_POST["downPaymentID"]);
	$quantity 			= trim($_POST["quantity"]);
	$totalCostPrice	 	= trim($_POST["totalCostPrice"]);
	$firstPayment 		= trim($_POST["firstPayment"]);
	$lastPayment 		= trim($_POST["lastPayment"]);
	$balance 			= trim($_POST["balance"]);
	$lastBalance 		= trim($_POST["lastBalance"]);
	$recieptNumber 		= trim($_POST["recieptNumber"]);
	$recieptNumber2		= trim($_POST["recieptNumber2"]);
	
	$user				=$_SESSION['userName'];
	$date				= date("Y-m-d");
	$time				= date("H:i.s");
	
	
	
	if(!$downPaymentID && !$title && !$customerName && !$address && !$phone && !$email && !$firstPayment  && !$totalCostPrice && !$balance && !$recieptNumber
	&& !$serial && !$price  && !$description && !$lastPayment && !$recieptNumber2){
		
		displayHeader("Myshop: DownPayments");	
		displayAdminTemp("DownPayments");
		displayEditDownPayment2($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}
	
	$valid = downPaymentVal($message,$errorArray,$valuesArray,$errorFlag);
	if($valid == true){
		$serial 			= addslashes($serial);
		$price 				= addslashes($price);
		$description 		= addslashes($description);
		
		$title 				= addslashes($title);
		$customerName 		= addslashes($customerName);
		$address	 		= addslashes($address);
		$phone 				= addslashes(str_replace(" ", "", $phone));
		$email 				= addslashes($email);
		
		$downPaymentID 		= addslashes(str_replace(" ", "", $downPaymentID));
		$quantity 			= addslashes(str_replace(" ", "", $quantity));
		$totalCostPrice	 	= $price * $quantity;
		$firstPayment 		= addslashes(str_replace(" ", "", $firstPayment));
		$lastPayment 		= addslashes(str_replace(" ", "", $lastPayment));
		$balance			= $totalCostPrice - $lastPayment - $firstPayment;
		$recieptNumber		= addslashes(str_replace(" ", "", $recieptNumber));
		$recieptNumber2		= addslashes(str_replace(" ", "", $recieptNumber2));
		
		$user				= addslashes($user);
		$date 				= addslashes($date);
		$time				= addslashes($time);
		
		if($balance < 0 ){
			$message = "Please make sure either first or final payment is collect.";
			$errorType = "error";
			displayHeader("Myshop: DownPayments");	
			displayAdminTemp("DownPayments");
			displayEditDownPayment2($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();
			exit;
		}	
		
		// Check if there are enough items in stock
		$query = "SELECT * FROM downpayments WHERE downPaymentID ='".$downPaymentID."'";
		$result = sql_query($query, $message);
		
		$query = "UPDATE downpayments SET downPaymentID ='".$downPaymentID."',price ='".$price."',quantity ='".$quantity."',totalCostPrice ='";
		$query .= $totalCostPrice."',firstPayment ='".$firstPayment."',lastPayment ='".$lastPayment."',description ='".$description."',balance ='";
		$query .= $balance."',recieptNumber ='".$recieptNumber."',recieptNumber2 ='".$recieptNumber2."',title ='".$title."',customerName ='";
		$query .= $customerName."',address ='".$address."',phone ='".$phone."',serial ='".$serial."',email ='".$email; 
		$query .= "' WHERE downPaymentID ='".$downPaymentID."'";
		
		
		$result = sql_query($query, $message);
	
		$message = "Successfully saved";
		$errorType = "success";
		$valuesArray["query"] = "SELECT * FROM downpayments WHERE downPaymentID ='".$downPaymentID."'";
		displayHeader("Myshop: DownPayments");	
		displayAdminTemp("DownPayments");
		displayViewDownPayments($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}
		
	else {	
		$errorFlag=true;				
		$message = "Please make sure that the marked fields are propery filled.";
		$errorType = "error";
		displayHeader("Myshop: DownPayments");	
		displayAdminTemp("DownPayments");
		displayEditDownPayment2($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}	
}


/*-----------------------------------------------------------------------------------------------------------------/

/******************************************************************************************/

function viewDownPaymentInfo($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	
	$valuesArray["searchTerm"]	= stripslashes($valuesArray["searchTerm"]);
	$valuesArray["lowerLimit"] 	= $valuesArray["lowerLimit"];
	$downPaymentID 				= addslashes($valuesArray["downPaymentID"]);

	// Check if the item realy exist in the database before inserting
	$query = "SELECT * FROM downpayments WHERE downPaymentID ='".$downPaymentID."'";
	$result = sql_query($query, $message);

	$row = mysql_fetch_array($result);
	$valuesArray["serial"]			= htmlspecialchars(stripslashes($row["serial"]));
	$valuesArray["description"]		= htmlspecialchars(stripslashes($row["description"]));
	$valuesArray["price"]			= htmlspecialchars(stripslashes($row["price"]));
	
	$valuesArray["customerName"]		= htmlspecialchars(stripslashes($row["customerName"]));
	$valuesArray["address"]				= htmlspecialchars(stripslashes($row["address"]));
	$valuesArray["title"]				= htmlspecialchars(stripslashes($row["title"]));
	$valuesArray["phone"]				= htmlspecialchars(stripslashes($row["phone"]));
	$valuesArray["email"]				= htmlspecialchars(stripslashes($row["email"]));
	
	$valuesArray["downPaymentID"]		= htmlspecialchars(stripslashes($row["downPaymentID"]));
	$valuesArray["firstPayment"]		= htmlspecialchars(stripslashes($row["firstPayment"]));
	$valuesArray["lastPayment"]			= htmlspecialchars(stripslashes($row["lastPayment"]));
	$valuesArray["totalCostPrice"]		= htmlspecialchars(stripslashes($row["totalCostPrice"]));
	$valuesArray["balance"]				= htmlspecialchars(stripslashes($row["balance"]));
	$valuesArray["recieptNumber"]		= htmlspecialchars(stripslashes($row["recieptNumber"]));
	$valuesArray["recieptNumber2"]		= htmlspecialchars(stripslashes($row["recieptNumber2"]));
	$valuesArray["quantity"]		= htmlspecialchars(stripslashes($row["quantity"]));
	
	$valuesArray["user"]		= htmlspecialchars(stripslashes($row["user"]));
	$valuesArray["date"]		= htmlspecialchars(stripslashes($row["date"]));
	$valuesArray["time"]		= htmlspecialchars(stripslashes($row["time"]));
	
	displayHeader("Myshop: DownPayments");	
	displayAdminTemp("DownPayments");
	displayViewDownPaymentInfo($message,$errorArray,$valuesArray,$errorFlag,$errorType);
	displayFooter();
	exit;
}

/**********************************************************************************************************************/
function lastPaymentDownPayment1($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	if($valuesArray["downPaymentID"] == ""){
		$downPaymentID 		= $_POST["downPaymentID"];
		}
		else{$downPaymentID = $valuesArray["downPaymentID"];}
		
		if(!$downPaymentID){
			$message = "Enter down payment ID and click Go to enter last payment for a specific down payment.";
			$errorType = "info";
			displayHeader("Myshop:  DownPayments");	
			displayAdminTemp("DownPayments");
			displayLastPaymentDownPayment1($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();  exit;
		}
		$downPaymentID = str_replace(" ", "", $downPaymentID);
		if(is_numeric($downPaymentID)){
			$downPaymentID 			= addslashes($downPaymentID);
			// Check if the item realy exist in the database before inserting
			$query = "SELECT * FROM downpayments WHERE downPaymentID ='".$downPaymentID."'";
			$result = sql_query($query, $message);
			
			if(mysql_num_rows($result) == 0) {
				$message = "Down payment entry with ID '$downPaymentID' doesnt exit. Please enter a valid down payment ID"; 
				$errorType = "error";
				displayHeader("Myshop:  DownPayments");	
				displayAdminTemp("DownPayments");
				displayLastPaymentDownPayment1($message,$errorArray,$valuesArray,$errorFlag,$errorType);
				displayFooter();
				exit;
			}
			$errorFlag=true;
			$row = mysql_fetch_array($result);
			
			$lastPayment= htmlspecialchars(stripslashes($row["lastPayment"]));
			$firstPayment= htmlspecialchars(stripslashes($row["firstPayment"]));
			$totalCostPrice= htmlspecialchars(stripslashes($row["totalCostPrice"]));
					
					
			if( $totalCostPrice == ($lastPayment + $firstPayment)){
				$message = "Final payment for down payment entry with ID '$downPaymentID' has already been paid. "; 
				$message .= "Please enter a different down payment ID.";
				$errorType = "error";
				displayHeader("Myshop: DownPayments");	
				displayAdminTemp("DownPayments");
				displayLastPaymentDownPayment1($message,$errorArray,$valuesArray,$errorFlag,$errorType);
				displayFooter();
				exit; 
			}
					
			$errorFlag=true;
			
			$valuesArray["itemID"]			= htmlspecialchars(stripslashes($row["itemID"]));
			$valuesArray["description"]		= htmlspecialchars(stripslashes($row["description"]));
			$valuesArray["price"]			= htmlspecialchars(stripslashes($row["price"]));
			$valuesArray["stockQuantity"]	= htmlspecialchars(stripslashes($row["quantity"]));
			
			$valuesArray["customerName"]		= htmlspecialchars(stripslashes($row["customerName"]));
			$valuesArray["address"]				= htmlspecialchars(stripslashes($row["address"]));
			$valuesArray["title"]				= htmlspecialchars(stripslashes($row["title"]));
			$valuesArray["phone"]				= htmlspecialchars(stripslashes($row["phone"]));
			$valuesArray["email"]				= htmlspecialchars(stripslashes($row["email"]));
			
			$valuesArray["downPaymentID"]		= htmlspecialchars(stripslashes($row["downPaymentID"]));
			$valuesArray["firstPayment"]		= htmlspecialchars(stripslashes($row["firstPayment"]));
			$valuesArray["totalCostPrice"]		= htmlspecialchars(stripslashes($row["totalCostPrice"]));
			$valuesArray["balance"]				= htmlspecialchars(stripslashes($row["balance"]));
			$valuesArray["recieptNumber"]		= htmlspecialchars(stripslashes($row["recieptNumber"]));
			$valuesArray["initialQuantity"]		= htmlspecialchars(stripslashes($row["quantity"]));
			$valuesArray["quantity"]			= htmlspecialchars(stripslashes($row["quantity"]));
			
			
			displayHeader("Myshop: DownPayments");	
			displayAdminTemp("DownPayments");
			displayLastPaymentDownPayment2($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();
			exit;
		}
		else {
			$errorFlag = true;
			$message = "Please make sure you have entered a valid down payment ID.";
			$errorType = "error";
			displayHeader("Myshop: DownPayments");	
			displayAdminTemp("DownPayments");
			displayLastPaymentDownPayment1($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();
			exit;
		
		}
}


function lastPaymentDownPayment2($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	$description 		= trim($_POST["description"]);
	$price 				= trim($_POST["price"]);
	$serial 			= trim($_POST["serial"]);
	
	$title 				= trim($_POST["title"]);
	$customerName 		= trim($_POST["customerName"]);
	$address 			= trim($_POST["address"]);
	$phone 				= trim($_POST["phone"]);
	$email 				= trim($_POST["email"]);
	
	$downPaymentID 		= trim($_POST["downPaymentID"]);
	$quantity 			= trim($_POST["quantity"]);
	$totalCostPrice	 	= trim($_POST["totalCostPrice"]);
	$firstPayment 		= trim($_POST["firstPayment"]);
	$lastPayment 		= trim($_POST["lastPayment"]);
	$balance 			= trim($_POST["balance"]);
	$lastBalance 		= trim($_POST["lastBalance"]);
	$recieptNumber 		= trim($_POST["recieptNumber"]);
	$recieptNumber2		= trim($_POST["recieptNumber2"]);
	
	$user				=$_SESSION['userName'];
	$date				= date("Y-m-d");
	$time				= date("H:i.s");
	
	
	if(!$downPaymentID && !$title && !$customerName && !$address && !$phone && !$email && !$firstPayment  && !$totalCostPrice && !$balance && !$recieptNumber
	&& !$serial && !$price  && !$description && !$lastPayment && !$recieptNumber2){
		$valuesArray["description"] 	= $description;
		$valuesArray["price"] 			= $price;
		$valuesArray["serial"] 			= $stockQuantity;
		
		$valuesArray["title"] 			= $title;
		$valuesArray["customerName"]	= $customerName;
		$valuesArray["address"]			= $address;
		$valuesArray["phone"] 			= $phone;
		$valuesArray["email"] 			= $email;
		
		$valuesArray["downPaymentID"]	= $downPaymentID;
		$valuesArray["quantity"]		= $quantity;
		$valuesArray["totalCostPrice"]	= $totalCostPrice;
		$valuesArray["firstPayment"] 	= $firstPayment;
		$valuesArray["lastPayment"] 	= $lastPayment;
		$valuesArray["balance"] 		= $balance;
		$valuesArray["lastBalance"] 	= $lastBalance;
		$valuesArray["recieptNumber"] 	= $recieptNumber;
		$valuesArray["recieptNumber2"] 	= $recieptNumber2;
		
		$errorFlag = true;
		displayHeader("Myshop: DownPayments");	
		displayAdminTemp("DownPayments");
		displayLastPaymentDownPayment2($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}
	
	$valid = downPaymentVal($message,$errorArray,$valuesArray,$errorFlag);
	if($valid == true){
		$price 				= addslashes($price);
		$description 		= addslashes($description);
		$serial 			= addslashes($serial);
		
		$title 				= addslashes($title);
		$customerName 		= addslashes($customerName);
		$address	 		= addslashes($address);
		$phone 				= addslashes(str_replace(" ", "", $phone));
		$email 				= addslashes($email);
		
		$downPaymentID 		= addslashes(str_replace(" ", "", $downPaymentID));
		$quantity 			= addslashes(str_replace(" ", "", $quantity));
		$totalCostPrice	 	= addslashes(str_replace(" ", "", $totalCostPrice));
		$firstPayment 		= addslashes(str_replace(" ", "", $firstPayment));
		$lastPayment 		= addslashes(str_replace(" ", "", $lastPayment));
		$balance			= addslashes(str_replace(" ", "", $balance));
		$lastBalance		= addslashes(str_replace(" ", "", $lastBalance));
		$recieptNumber		= addslashes(str_replace(" ", "", $recieptNumber));
		$recieptNumber2		= addslashes(str_replace(" ", "", $recieptNumber2));
		
		$user				= addslashes($user);
		$date 				= addslashes($date);
		$time				= addslashes($time);
		
		if($lastPayment != $balance){
			echo $lastBalance;
			$valuesArray["lastPayment"] 	= "";
			$errorArray["lastPayment"]		= "*";
			$valuesArray["lastBalance"] 	= "";
			
			$errorFlag = true;
			$message = "Please make sure the Final Payment equals Balance.";
			$errorType = "error";
			displayHeader("Myshop: DownPayments");	
			displayAdminTemp("DownPayments");
			displayLastPaymentDownPayment2($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();
			exit;
		}
		$balance = $balance - $lastPayment;
		$query = "UPDATE downpayments SET balance ='".$balance."',recieptNumber2 ='".$recieptNumber2."',lastPayment ='".$lastPayment."',lastDate ='".$date;
		$query .= "' WHERE downPaymentID ='".$downPaymentID."'";
	
		$result = sql_query($query, $message);
		
		$message = "Successfully saved";
		$errorType = "success";
		$valuesArray["query"] = "SELECT * FROM downpayments WHERE downPaymentID ='".$downPaymentID."'";
		displayHeader("Myshop: DownPayments");	
		displayAdminTemp("DownPayments");
		displayViewDownPayments($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}
		
	else {	
			
		$errorFlag = true;
		$message = "Please make sure that the marked fields are propery filled.";
		$errorType = "error";
		displayHeader("Myshop: DownPayments");	
		displayAdminTemp("DownPayments");
		displayLastPaymentDownPayment2($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}	
}


/******************************************************************************************/
function nextDownPayments($message,$errorArray,$valuesArray,$errorFlag,$errorType){
		
	$errorFlag=true;
	$valuesArray["searchTerm"]	=stripslashes($valuesArray["searchTerm"]);
	$valuesArray["year"]		=stripslashes($valuesArray["year"]);
	$valuesArray["month"]		=stripslashes($valuesArray["month"]);
	
	$valuesArray["lowerLimit"] = $valuesArray["lowerLimit"];
	displayHeader("Myshop: DownPayments");	
	displayAdminTemp("DownPayments");
	displayViewDownPayments($message,$errorArray,$valuesArray,$errorFlag,$errorType);
	displayFooter();
	exit;
}

function previousDownPayments($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	$errorFlag=true;
	$valuesArray["searchTerm"]	=stripslashes($valuesArray["searchTerm"]);
	$valuesArray["year"]		=stripslashes($valuesArray["year"]);
	$valuesArray["month"]		=stripslashes($valuesArray["month"]);
	
	$valuesArray["lowerLimit"] = $valuesArray["lowerLimit"];
	displayHeader("Myshop: DownPayments");	
	displayAdminTemp("DownPayments");
	displayViewDownPayments($message,$errorArray,$valuesArray,$errorFlag,$errorType);
	displayFooter();
	exit;
}

/*****************************************************************************************************/

function cancelDownPayment($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	$valuesArray["searchTerm"]	=stripslashes($valuesArray["searchTerm"]);
	$valuesArray["year"]		=stripslashes($valuesArray["year"]);
	$valuesArray["month"]		=stripslashes($valuesArray["month"]);
	$valuesArray["lowerLimit"] 	= $valuesArray["lowerLimit"];
	$downPaymentID 				= addslashes($valuesArray["downPaymentID"]);
	
	// Check if the item realy exist in the database before inserting
	$query = "SELECT * FROM downpayments WHERE downPaymentID ='".$downPaymentID."'";
	$result = sql_query($query, $message);
	
	if(mysql_num_rows($result) == 0) {
		$message = "Down payment entry with ID '$downPaymentID' doesnt exit. Please enter a valid down payment ID"; 
		$errorType = "error";
		displayHeader("Myshop: DownPayment");	
		displayAdminTemp("DownPayments");
		displayViewDownPayments($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}
	else{
		$errorFlag=true;
		$row = mysql_fetch_array($result);
		
		$valuesArray["serial"]			= htmlspecialchars(stripslashes($row["serial"]));
		$valuesArray["description"]		= htmlspecialchars(stripslashes($row["description"]));
		$valuesArray["price"]			= htmlspecialchars(stripslashes($row["price"]));
		
		$valuesArray["customerName"]		= htmlspecialchars(stripslashes($row["customerName"]));
		$valuesArray["address"]				= htmlspecialchars(stripslashes($row["address"]));
		$valuesArray["title"]				= htmlspecialchars(stripslashes($row["title"]));
		$valuesArray["phone"]				= htmlspecialchars(stripslashes($row["phone"]));
		$valuesArray["email"]				= htmlspecialchars(stripslashes($row["email"]));
		
		$valuesArray["downPaymentID"]		= htmlspecialchars(stripslashes($row["downPaymentID"]));
		$valuesArray["firstPayment"]		= htmlspecialchars(stripslashes($row["firstPayment"]));
		$valuesArray["lastPayment"]			= htmlspecialchars(stripslashes($row["lastPayment"]));
		$valuesArray["totalCostPrice"]		= htmlspecialchars(stripslashes($row["totalCostPrice"]));
		$valuesArray["balance"]				= htmlspecialchars(stripslashes($row["balance"]));
		$valuesArray["recieptNumber"]		= htmlspecialchars(stripslashes($row["recieptNumber"]));
		$valuesArray["recieptNumber2"]		= htmlspecialchars(stripslashes($row["recieptNumber2"]));
		$valuesArray["initialQuantity"]		= htmlspecialchars(stripslashes($row["quantity"]));
		
		
		$message = "There must be a valid reason to cancel down payment or return down payment Item.";
		$errorType = "warning";
		displayHeader("Myshop: DownPayments");	
		displayAdminTemp("DownPayments");
		displayCancelDownPayment($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}
}
/*****************************************************************************************************/


function viewDownPayments($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	//Retrieve the posted itemID first
		$searchTerm 		= $_POST["searchTerm"];
		$month		 		= $_POST["month"];
		$year 				= $_POST["year"];
		$actualFormName 	= $_POST["actualFormName"];
		if((!$searchTerm)){
			$valuesArray["month"]= $month;
			$valuesArray["year"]= $year;
			if($actualFormName == "downPaymentsHome"){
				$message = "Enter a search term to browse through  the down payments list.";
				$errorType = "info";
				displayHeader("Myshop: DownPayments");	
				displayAdminTemp("DownPayments");
				displayDownPaymentsHome($message,$errorArray,$valuesArray,$errorFlag,$errorType);
				displayFooter();  exit;
			}
			else {
				displayHeader("Myshop: DownPayments");	
				displayAdminTemp("DownPayments");
				displayViewDownPayments($message,$errorArray,$valuesArray,$errorFlag,$errorType);
				displayFooter();  exit;
			}
		}
		else {
				$errorFlag=true;
				$valuesArray["month"]= $month;
				$valuesArray["year"]= $year;
				$valuesArray["searchTerm"]= stripslashes($searchTerm);
				displayHeader("Myshop: DownPayments");	
				displayAdminTemp("DownPayments");
				displayViewDownPayments($message,$errorArray,$valuesArray,$errorFlag,$errorType);
				displayFooter();
				exit;
		}
	
}

/******************************************************************************************************************/

function cancelDownPayment2($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	$downPaymentID 		= trim($_POST["downPaymentID"]);
	$reason 			= trim($_POST["reason"]);
	$initialQuantity 		= trim($_POST["initialQuantity"]);//The number of items initially bought
	$quantity 			= trim($_POST["quantity"]); //The number of items returned
	$amount 			= trim($_POST["amount"]); // The amount of money returned to the customer
	
	$user				=$_SESSION['userName'];
	$date				= date("Y-m-d");
	$time				= date("H:i.s");
	
	$serial 				= trim($_POST["serial"]);
	$description 			= trim($_POST["description"]);
	$price 					= trim($_POST["price"]);
	
	$title 					= trim($_POST["title"]);
	$customerName 			= trim($_POST["customerName"]);
	$address 				= trim($_POST["address"]);
	$phone 					= trim($_POST["phone"]);
	
	$totalCostPrice 		= trim($_POST["totalCostPrice"]);
	$firstPayment 			= trim($_POST["firstPayment"]);
	$balance 				= trim($_POST["balance"]);
	$recieptNumber 			= trim($_POST["recieptNumber"]);
	
	
	$valid = downPaymentVal($message,$errorArray,$valuesArray,$errorFlag);
	if($valid == true){
		$reason 			= addslashes($reason);
		$initialQuantity 		= addslashes($initialQuantity);
		$downPaymentID 			= addslashes(str_replace(" ", "", $downPaymentID));
		$itemID 			= addslashes(str_replace(" ", "", $itemID));

		
		$quantity 			= addslashes(str_replace(" ", "", $quantity));
		$amount 			= addslashes(str_replace(" ", "", $amount));
		$price	 			= addslashes(str_replace(" ", "", $price));
		
		$user				= addslashes($user);
		$date 				= addslashes($date);
		$time				= addslashes($time);
		
		
		
		$query = "SELECT * FROM downpayments WHERE downPaymentID ='".$downPaymentID."'";
		$result = sql_query($query, $message);
		
		$row = mysql_fetch_array($result);
		$downPaymentQuantity = htmlspecialchars(stripslashes($row["quantity"]));
		if(($quantity < 1) || ($quantity > $downPaymentQuantity)){
			
			$valuesArray["serial"] 			= $serial;
			$valuesArray["description"] 		= $description;
			$valuesArray["reason"] 			= $reason;
			$valuesArray["initialQuantity"] 	= $initialQuantity;
			$valuesArray["amount"] 			= $amount;
			
			$valuesArray["customerName"]		= htmlspecialchars(stripslashes($row["customerName"]));
			$valuesArray["title"]			= htmlspecialchars(stripslashes($row["title"]));
			$valuesArray["phone"]			= htmlspecialchars(stripslashes($row["phone"]));
			$valuesArray["email"]			= htmlspecialchars(stripslashes($row["email"]));
			
			$valuesArray["downPaymentID"]		= htmlspecialchars(stripslashes($row["downPaymentID"]));
			$valuesArray["totalCostPrice"]		= htmlspecialchars(stripslashes($row["totalCostPrice"]));
			$valuesArray["firstPayment"]		= htmlspecialchars(stripslashes($row["firstPayment"]));
			$valuesArray["balance"]				= htmlspecialchars(stripslashes($row["balance"]));
			$valuesArray["recieptNumber"]		= htmlspecialchars(stripslashes($row["recieptNumber"]));
			
			
			if($quantity < 1 ){ $message = "Quantity should be greater than or equal to 1";}
			if($quantity > $downPaymentQuantity) { $message = "Make sure the quantity is within that on down payment";}
			
			$valuesArray["quantity"] 		= "";
			$errorArray["quantity"] 		= "*";
			$errorType 						= "error";
			$errorFlag = true;
			displayHeader("Myshop: DownPayments");	
			displayAdminTemp("DownPayments");
			displayCancelDownPayment($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();
			exit;
		}
			//Insert values into database
		$newQuantity			 = $downPaymentQuantity - $quantity;
		$totalCostPrice	 	 	 = $price * $newQuantity;
		if($balance == 0){
			$firstPayment		 = ($firstPayment - ($amount/2));
			$lastPayment		 = ($lastPayment - ($amount/2));
		}
		else{
			$firstPayment		 = $firstPayment - $amount;
			$lastPayment		 =  0;
			$balance 			 = $totalCostPrice	- $firstPayment;
		}
		if(($downPaymentQuantity - $quantity) == 0){$returned = "Yes";}
		else {$returned = "No";}
		
		$query = "INSERT INTO cancelleddownpayments (downPaymentID, quantity, amount, reason, user, date, time) ";
		$query .= "VALUES ('".$downPaymentID."','".$quantity."','".$amount."','".$reason;		
		$query .= "','".$user."','".$date."','".$time."')";
		
		$query1 = "UPDATE downpayments SET quantity ='".$newQuantity."',firstPayment ='".$firstPayment."',balance ='".$balance;
		$query1 .= "',lastPayment ='".$lastPayment."',totalCostPrice ='".$totalCostPrice."',returned ='";
		$query1 .= $returned."' WHERE downPaymentID ='".$downPaymentID."'";
	
		
		$result = sql_query($query, $message);
		$result1 = sql_query($query1, $message);
		
		$message = "Successfully saved";
		$errorType = "success";
		$valuesArray["query"] = "SELECT * FROM downpayments WHERE downPaymentID ='".$downPaymentID."'";
		displayHeader("Myshop: DownPayments");	
		displayAdminTemp("DownPayments");
		displayViewDownPayments($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}
		
	else {			
		
		$message = "Please make sure that the marked fields are propery filled.";
		$errorType = "error";
		$errorFlag = true;
		displayHeader("Myshop: DownPayments");	
		displayAdminTemp("DownPayments");
		displayCancelDownPayment($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}	
}


/*-----------------------------------------------------------------------------------------------------------------*/
?>