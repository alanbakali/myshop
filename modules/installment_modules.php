<?php

/*---------------------------------------------------------------------------
/* This function process all the validatins for Stock Item Entry and Edit     */
/*----------------------------------------------------------------------------*/
function installmentVal(&$message,&$errorArray,&$valuesArray,&$errorFlag){
	$errorFlag =false;
	foreach ($_POST  as $key => $value){
		if(($key == "frmName") || ($key == "description") || ($key == "itemID") || ($key == "price") 
		|| ($key == "address") || ($key == "stockQuantity")  || ($key == "initialQuantity")){
			$errorArray["$key"] = "";
			$valuesArray["$key"] = $value;
		}
		else{
			if(isset($key) && ($value =="") && (($key == "customerName") || ($key == "title") || ($key == "reason"))){
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
			
			
			if(($key == "firstPayment") || ($key == "recieptNumber") || ($key == "quantity") || ($key == "installmentID") || ($key == "amount")){
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
			if(($key == "lastPayment") || ($key == "recieptNumber2")){
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
function enterInstallment($message,$errorArray,$valuesArray,$errorFlag,$errorType){
		
	$valuesArray["searchTerm"]= stripslashes($valuesArray["searchTerm"]);
	$valuesArray["lowerLimit"] = $valuesArray["lowerLimit"];
	$itemID = addslashes($valuesArray["itemID"]);	
	// Check if the item realy exist in the database before inserting
	$query = "SELECT * FROM stockitems WHERE itemID ='".$itemID."'";
	$result = sql_query($query, $message);
	
	$errorFlag=true;
	$row = mysql_fetch_array($result);
	$valuesArray["stockID"]			= htmlspecialchars(stripslashes($row["stockID"]));
	$valuesArray["itemID"]			= htmlspecialchars(stripslashes($row["itemID"]));
	$valuesArray["serial"]			= htmlspecialchars(stripslashes($row["serial"]));
	$valuesArray["description"]		= htmlspecialchars(stripslashes($row["description"]));
	$valuesArray["stockQuantity"]	= htmlspecialchars(stripslashes($row["quantity"]));
	$valuesArray["price"]			= htmlspecialchars(stripslashes($row["price"]));
	
	
	displayHeader("Myshop: Installments");	
	displayAdminTemp("Installments");
	displayEnterInstallment2($message,$errorArray,$valuesArray,$errorFlag,$errorType);
	displayFooter();
	exit;
}

/*---------------------------------------------------------------------------
/* This function process the entry of a new stock item into the database*/
/*----------------------------------------------------------------------------*/
function enterInstallment2($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	$itemID 			= trim($_POST["itemID"]);
	$description 		= trim($_POST["description"]);
	$price 				= trim($_POST["price"]);
	$stockQuantity 		= trim($_POST["stockQuantity"]);
	
	$title 				= trim($_POST["title"]);
	$customerName 		= trim($_POST["customerName"]);
	$address 			= trim($_POST["address"]);
	$phone 				= trim($_POST["phone"]);
	$email 				= trim($_POST["email"]);
	
	$installmentID 		= trim($_POST["installmentID"]);
	$quantity 			= trim($_POST["quantity"]);
	$totalCostPrice	 	= trim($_POST["totalCostPrice"]);
	$firstPayment 		= trim($_POST["firstPayment"]);
	$balance 			= trim($_POST["balance"]);
	$recieptNumber 		= trim($_POST["recieptNumber"]);
	
	$user				=$_SESSION['userName'];
	$date				= date("Y-m-d");
	$time				= date("H:i.s");
	
	
	
	if(!$installmentID && !$itemID && !$title && !$customerName && !$address && !$phone && !$email && !$firstPayment  && !$totalCostPrice && !$balance && !$recieptNumber){
		
		displayHeader("Myshop: Installments");	
		displayAdminTemp("Installments");
		displayEnterInstallment2($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}
	
	$valid = installmentVal($message,$errorArray,$valuesArray,$errorFlag);
	if($valid == true){
		$itemID 			= addslashes($itemID);
		$price 				= addslashes($price);
		$description 		= addslashes($description);
		$stockQuantity 		= addslashes($stockQuantity);
		
		$title 				= addslashes($title);
		$customerName 		= addslashes($customerName);
		$address	 		= addslashes($address);
		$phone 				= addslashes(str_replace(" ", "", $phone));
		$email 				= addslashes($email);
		
		$installmentID 		= addslashes(str_replace(" ", "", $installmentID));
		$quantity 			= addslashes(str_replace(" ", "", $quantity));
		$totalCostPrice	 	= $price * $quantity;
		$firstPayment 		= addslashes(str_replace(" ", "", $firstPayment));
		$balance			= $totalCostPrice - $firstPayment;
		$recieptNumber		= addslashes(str_replace(" ", "", $recieptNumber));
		
		$user				= addslashes($user);
		$date 				= addslashes($date);
		$time				= addslashes($time);
		
		// Check if there are enough items in stock
		$query = "SELECT * FROM stockitems WHERE itemID ='".$itemID."'";
		$result = sql_query($query, $message);
		
		$row = mysql_fetch_array($result);
		$stockQuantity = htmlspecialchars(stripslashes($row["quantity"]));
		if(($quantity < 1) || ($quantity > $stockQuantity)){
			
			
			if($stockQuantity < 1){
				$message = "There are no more ".$description." in stock";
			}
			if($quantity < 1 ){ $message = "Quantity should be greater than or equal to 1";}
			if($quantity > $stockQuantity) { $message = "There is(are) only ".$stockQuantity." ". $description."s in stock";}
			
			$valuesArray["quantity"] 		= "";
			$errorArray["quantity"] 		= "*";
			$errorType 						= "error";
			$errorFlag = true;
			displayHeader("Myshop: Installments");	
			displayAdminTemp("Installments");
			displayEnterInstallment2($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();
			exit;
		}
			//Insert values into database
		$newQuantity = $stockQuantity - $quantity;
		$lastPayment = 0;
		if(($stockQuantity - $quantity) == 0){$installment = "Yes";}
		else {$installment = "No";}
		
		$query = "INSERT INTO installments (installmentID, itemID, quantity, totalCostPrice, firstPayment, lastPayment, balance, recieptNumber, title,";
		$query .= "customerName, address, phone, email, description, user, date, time) ";
		$query .= "VALUES ('".$installmentID."','".$itemID."','".$quantity."','".$totalCostPrice."','".$firstPayment."','".$lastPayment;
		$query .= "','".$balance."','".$recieptNumber;		
		$query .= "','".$title."','".$customerName."','".$address."','".$phone."','".$email."','".$description."','".$user."','".$date."','".$time."')";
		
		$query2 = "UPDATE stockitems SET quantity ='".$newQuantity."',installment ='".$installment."' WHERE itemID ='".$itemID."'";
		
		$result = sql_query($query, $message);
		$result2 = sql_query($query2, $message);
		
		$message = "Successfully saved";
		$errorType = "success";
		$valuesArray["query"] = "SELECT * FROM installments WHERE installmentID ='".$installmentID."'";
		displayHeader("Myshop: Installments");	
		displayAdminTemp("Installments");
		displayViewInstallments($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}
		
	else {	
			
		$message = "Please make sure that the marked fields are propery filled.";
		$errorType = "error";
		displayHeader("Myshop: Installments");	
		displayAdminTemp("Installments");
		displayEnterInstallment2($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}	
}


/*-----------------------------------------------------------------------------------------------------------------
/*This function is the firrst processe of editing of a particular stock item given a particular stock ID
/*----------------------------------------------------------------------------------------------------------------*/

function editInstallment1($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	//Retrieve the posted itemID first
		if($valuesArray["installmentID"] == ""){
		$installmentID 		= $_POST["installmentID"];
		}
		else{$installmentID = $valuesArray["installmentID"];}
		
		
		if(!$installmentID){
			$message = "Enter Installment ID and click Go to edit a specific installment entry.";
			$errorType = "info";
			displayHeader("Myshop: Installments");	
			displayAdminTemp("Installments");
			displayEditInstallment1($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();  exit;
		}
		$installmentID = str_replace(" ", "", $installmentID);
		if(is_numeric($installmentID)){
			$installmentID 			= addslashes($installmentID);
			// Check if the item realy exist in the database before inserting
			$query = "SELECT * FROM installments WHERE installmentID ='".$installmentID."'";
			$result = sql_query($query, $message);
			
			if(mysql_num_rows($result) == 0) {
				$message = "Please make sure you have entered a valid Installment ID"; 
				$errorType = "error";
				displayHeader("Myshop: Installments");	
				displayAdminTemp("Installments");
				displayEditInstallment1($message,$errorArray,$valuesArray,$errorFlag,$errorType);
				displayFooter();
				exit;
			}
			else {
					$errorFlag=true;
					$row = mysql_fetch_array($result);
					
					$itemID= htmlspecialchars(stripslashes($row["itemID"]));
					
					$query2  = "SELECT * FROM stockitems WHERE itemID ='".$itemID."'";
					$result2 = sql_query($query2, $message);
				
					if(mysql_num_rows($result2) == 0) {
						$message = "Please make sure you have entered a valid Installment ID"; 
						$errorType = "error";
						displayHeader("Myshop: Installments");	
						displayAdminTemp("Installments");
						displayEditInstallment1($message,$errorArray,$valuesArray,$errorFlag,$errorType);
						displayFooter();
						exit;
					}
					else {
							$errorFlag=true;
							$row2 = mysql_fetch_array($result2);
							
							$valuesArray["itemID"]			= htmlspecialchars(stripslashes($row["itemID"]));
							$valuesArray["description"]		= htmlspecialchars(stripslashes($row2["description"]));
							$valuesArray["price"]			= htmlspecialchars(stripslashes($row2["price"]));
							$valuesArray["stockQuantity"]	= htmlspecialchars(stripslashes($row2["quantity"]));
							
							$valuesArray["customerName"]		= htmlspecialchars(stripslashes($row["customerName"]));
							$valuesArray["address"]				= htmlspecialchars(stripslashes($row["address"]));
							$valuesArray["title"]				= htmlspecialchars(stripslashes($row["title"]));
							$valuesArray["phone"]				= htmlspecialchars(stripslashes($row["phone"]));
							$valuesArray["email"]				= htmlspecialchars(stripslashes($row["email"]));
							
							$valuesArray["installmentID"]		= htmlspecialchars(stripslashes($row["installmentID"]));
							$valuesArray["firstPayment"]		= htmlspecialchars(stripslashes($row["firstPayment"]));
							$valuesArray["lastPayment"]			= htmlspecialchars(stripslashes($row["lastPayment"]));
							$valuesArray["totalCostPrice"]		= htmlspecialchars(stripslashes($row["totalCostPrice"]));
							$valuesArray["balance"]				= htmlspecialchars(stripslashes($row["balance"]));
							$valuesArray["recieptNumber"]		= htmlspecialchars(stripslashes($row["recieptNumber"]));
							$valuesArray["recieptNumber2"]		= htmlspecialchars(stripslashes($row["recieptNumber2"]));
							$valuesArray["initialQuantity"]		= htmlspecialchars(stripslashes($row["quantity"]));
							$valuesArray["quantity"]			= htmlspecialchars(stripslashes($row["quantity"]));
							
							
							$message = "You can not change the Installment ID";
							$errorType = "warning";
							displayHeader("Myshop: Installments");	
							displayAdminTemp("Installments");
							displayEditInstallment2($message,$errorArray,$valuesArray,$errorFlag,$errorType);
							displayFooter();
							exit;
					}
				}
		}
		else{
			$errorFlag = true;
			$message = "Please make sure you have entered a valid Installment ID.";
			$errorType = "error";
			displayHeader("Myshop: Installments");	
			displayAdminTemp("Installments");
			editInstallment1($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();
			exit;
		
		}
}
/*-------------------------------------------------------------------------------------------------------
/*--------------------------------------------------------------------------------------------------------
/**This function is the firrst processe of editing of a particular stock item given a particular stock ID
/*--------------------------------------------------------------------------------------------------------*/
function editInstallment2($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	$itemID 			= trim($_POST["itemID"]);
	$description 		= trim($_POST["description"]);
	$price 				= trim($_POST["price"]);
	$stockQuantity 		= trim($_POST["stockQuantity"]);
	$initialQuantity 	= trim($_POST["initialQuantity"]);
	
	$title 				= trim($_POST["title"]);
	$customerName 		= trim($_POST["customerName"]);
	$address 			= trim($_POST["address"]);
	$phone 				= trim($_POST["phone"]);
	$email 				= trim($_POST["email"]);
	
	$installmentID 		= trim($_POST["installmentID"]);
	$quantity 			= trim($_POST["quantity"]);
	$totalCostPrice	 	= trim($_POST["totalCostPrice"]);
	$firstPayment 		= trim($_POST["firstPayment"]);
	$lastPayment 		= trim($_POST["lastPayment"]);
	$balance 			= trim($_POST["balance"]);
	$recieptNumber 		= trim($_POST["recieptNumber"]);
	$recieptNumber2		= trim($_POST["recieptNumber2"]);
	
	$user				=$_SESSION['userName'];
	$date				= date("Y-m-d");
	$time				= date("H:i.s");
	
	
	if(!$installmentID && !$itemID && !$title && !$customerName && !$phone && !$email && !$firstPayment  && !$totalCostPrice && !$balance && !$recieptNumber){
		
		displayHeader("Myshop: Installments");	
		displayAdminTemp("Installments");
		displayEditInstallment2($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}
	

	$valid = installmentVal($message,$errorArray,$valuesArray,$errorFlag);
	if($valid == true){
		$itemID 			= addslashes($itemID);
		$price 				= addslashes($price);
		$description 		= addslashes($description);
		$stockQuantity 		= addslashes($stockQuantity);
		$initialQuantity 	= addslashes($initialQuantity);
		
		$title 				= addslashes($title);
		$customerName 		= addslashes($customerName);
		$address	 		= addslashes($address);
		$phone 				= addslashes(str_replace(" ", "", $phone));
		$email 				= addslashes($email);
		
		$installmentID 		= addslashes(str_replace(" ", "", $installmentID));
		$quantity 			= addslashes(str_replace(" ", "", $quantity));
		$totalCostPrice	 	= $price * $quantity;
		$firstPayment 		= addslashes(str_replace(" ", "", $firstPayment));
		$lastPayment 		= addslashes(str_replace(" ", "", $lastPayment));
		$balance			= $totalCostPrice - $firstPayment - $lastPayment;
		$recieptNumber		= addslashes(str_replace(" ", "", $recieptNumber));
		$recieptNumber2		= addslashes(str_replace(" ", "", $recieptNumber2));
		
		$user				= addslashes($user);
		$date 				= addslashes($date);
		$time				= addslashes($time);
		
		$query = "SELECT * FROM stockitems WHERE itemID ='".$itemID."'";
		$result = sql_query($query, $message);
	
		$row = mysql_fetch_array($result);
		$stockQuantity = htmlspecialchars(stripslashes($row["quantity"]));
		if(($quantity < 1) || ($quantity - $initialQuantity) > $stockQuantity){
			
			$valuesArray["itemID"] 			= $itemID;
			$valuesArray["description"] 	= $description;
			$valuesArray["price"] 			= $price;
			$valuesArray["stockQuantity"] 	= $stockQuantity;
			$valuesArray["initialQuantity"] = $initialQuantity;
			
			$valuesArray["title"] 			= $title;
			$valuesArray["customerName"]	= $customerName;
			$valuesArray["address"]			= $address;
			$valuesArray["phone"] 			= $phone;
			$valuesArray["email"] 			= $email;
			
			$valuesArray["installmentID"]	= $installmentID;
			$valuesArray["quantity"]		= $quantity;
			$valuesArray["totalCostPrice"]	= "";
			$valuesArray["firstPayment"] 	= $firstPayment;
			$valuesArray["lastPayment"] 	= $lastPayment;
			$valuesArray["balance"] 		= "";
			$valuesArray["recieptNumber"] 	= $recieptNumber;
			$valuesArray["recieptNumber2"] 	= $recieptNumber2;
			
			if($stockQuantity < 1){
				$message = "There are no more ".$description." in stock";
			}
			else{ $message = "There are only ".$stockQuantity." ". $description." in stock";}
			
			$valuesArray["quantity"] 		= "";
			$errorArray["quantity"] 		= "*";
			$errorType 						= "error"; 
			$errorFlag = true;
			displayHeader("Myshop: Installments");	
			displayAdminTemp("Installments");
			displayEditInstallment2($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();
			exit;
		}
			//Insert values into database
		$newQuantity = $stockQuantity - ($quantity - $initialQuantity);
		if($stockQuantity == $quantity){$installment = "Yes";}
		else {$installment = "No";}

		$query = "UPDATE installments SET installmentID ='".$installmentID."',itemID ='".$itemID."',quantity ='".$quantity."',totalCostPrice ='";
		$query .= $totalCostPrice."',firstPayment ='".$firstPayment."',lastPayment ='".$lastPayment."',description ='".$description."',balance ='";
		$query .= $balance."',recieptNumber ='".$recieptNumber."',recieptNumber2 ='".$recieptNumber2."',title ='".$title."',customerName ='";
		$query .= $customerName."',address ='".$address."',phone ='".$phone."',email ='".$email; 
		$query .= "' WHERE installmentID ='".$installmentID."'";
		
		$query2 = "UPDATE stockitems SET quantity ='".$newQuantity."',installment ='".$installment."' WHERE itemID ='".$itemID."'";
		
		$result = sql_query($query, $message);
		$result2 = sql_query($query2, $message);
			
		$message = "Successfully saved";
		$errorType = "success";
		$valuesArray["query"] = "SELECT * FROM installments WHERE installmentID ='".$installmentID."'";
		displayHeader("Myshop: Installments");	
		displayAdminTemp("Installments");
		displayViewInstallments($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}
		
	else {	

		$errorFlag = true;
		$message = "Please make sure that the marked fields are propery filled.";
		$errorType = "error";
		displayHeader("Myshop: Installments");	
		displayAdminTemp("Installments");
		displayEditInstallment2($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}	
}


/******************************************************************************************/

function viewInstallmentInfo($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	
	$valuesArray["searchTerm"]	=stripslashes($valuesArray["searchTerm"]);
	$valuesArray["year"]		=stripslashes($valuesArray["year"]);
	$valuesArray["month"]		=stripslashes($valuesArray["month"]);
	$valuesArray["lowerLimit"] 	= $valuesArray["lowerLimit"];
	$installmentID 				= addslashes($valuesArray["installmentID"]);

	// Check if the item realy exist in the database before inserting
	$query = "SELECT * FROM installments WHERE installmentID ='".$installmentID."'";
	$result = sql_query($query, $message);

	$errorFlag=true;
	$row = mysql_fetch_array($result);
	$valuesArray["itemID"]			= htmlspecialchars(stripslashes($row["itemID"]));
	
	$itemID = $valuesArray["itemID"];
	$query2 = "SELECT * FROM stockitems WHERE itemID ='".$itemID."'";
	$result2 = sql_query($query2, $message);
	
	$row2 = mysql_fetch_array($result2);
	$valuesArray["itemID"]			= htmlspecialchars(stripslashes($row["itemID"]));
	$valuesArray["description"]		= htmlspecialchars(stripslashes($row2["description"]));
	$valuesArray["price"]			= htmlspecialchars(stripslashes($row2["price"]));
	$valuesArray["stockQuantity"]	= htmlspecialchars(stripslashes($row2["quantity"]));
	
	$valuesArray["customerName"]		= htmlspecialchars(stripslashes($row["customerName"]));
	$valuesArray["address"]				= htmlspecialchars(stripslashes($row["address"]));
	$valuesArray["title"]				= htmlspecialchars(stripslashes($row["title"]));
	$valuesArray["phone"]				= htmlspecialchars(stripslashes($row["phone"]));
	$valuesArray["email"]				= htmlspecialchars(stripslashes($row["email"]));
	
	$valuesArray["installmentID"]		= htmlspecialchars(stripslashes($row["installmentID"]));
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
	
	displayHeader("Myshop: Installments");	
	displayAdminTemp("Installments");
	displayViewInstallmentInfo($message,$errorArray,$valuesArray,$errorFlag,$errorType);
	displayFooter();
	exit;
}

/**********************************************************************************************************************/
function lastPaymentInstallment($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	$valuesArray["searchTerm"]	=stripslashes($valuesArray["searchTerm"]);
	$valuesArray["year"]		=stripslashes($valuesArray["year"]);
	$valuesArray["month"]		=stripslashes($valuesArray["month"]);
	if($valuesArray["installmentID"] == ""){
		$installmentID 		= $_POST["installmentID"];
	}
	else{$installmentID = $valuesArray["installmentID"];}
		
	if(!$installmentID){
		$message = "Enter Installment ID and click Go to enter last payment for a specific installment.";
		$errorType = "info";
		displayHeader("Myshop:  Installments");	
		displayAdminTemp("Installments");
		displayLastPaymentInstallment1($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();  exit;
	}
	$installmentID = str_replace(" ", "", $installmentID);
	if(is_numeric($installmentID)){
		$installmentID 			= addslashes($installmentID);
		// Check if the item realy exist in the database before inserting
		$query = "SELECT * FROM installments WHERE installmentID ='".$installmentID."'";
		$result = sql_query($query, $message);
		
		if(mysql_num_rows($result) == 0) {
			$message = "Please make sure you have entered a valid Installment ID"; 
			$errorType = "error";
			displayHeader("Myshop:  Installments");	
			displayAdminTemp("Installments");
			displayLastPaymentInstallment1($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();
			exit;
		}
		else {
			$errorFlag=true;
			$row = mysql_fetch_array($result);
			
			$lastPayment= htmlspecialchars(stripslashes($row["lastPayment"]));
			$firstPayment= htmlspecialchars(stripslashes($row["firstPayment"]));
			$totalCostPrice= htmlspecialchars(stripslashes($row["totalCostPrice"]));
			
			
			if( $totalCostPrice == ($lastPayment + $firstPayment)){
				$message = "Final Payment for this installment entry has already been paid."; 
				$errorType = "error";
				displayHeader("Myshop: Installments");	
				displayAdminTemp("Installments");
				displayLastPaymentInstallment1($message,$errorArray,$valuesArray,$errorFlag,$errorType);
				displayFooter();
				exit; 
			}
			
			
			$itemID= htmlspecialchars(stripslashes($row["itemID"]));
			
			$query2  = "SELECT * FROM stockitems WHERE itemID ='".$itemID."'";
			$result2 = sql_query($query2, $message);
		
			if(mysql_num_rows($result2) == 0) {
				$message = "Please make sure you have entered a valid Installment ID"; 
				$errorType = "error";
				displayHeader("Myshop:  Installments");	
				displayAdminTemp("Installments");
				displayLastPaymentInstallment1($message,$errorArray,$valuesArray,$errorFlag,$errorType);
				displayFooter();
				exit;
			}
			else {
				$errorFlag=true;
				$row2 = mysql_fetch_array($result2);
				
				$valuesArray["itemID"]			= htmlspecialchars(stripslashes($row["itemID"]));
				$valuesArray["description"]		= htmlspecialchars(stripslashes($row2["description"]));
				$valuesArray["price"]			= htmlspecialchars(stripslashes($row2["price"]));
				$valuesArray["stockQuantity"]	= htmlspecialchars(stripslashes($row2["quantity"]));
				
				$valuesArray["customerName"]		= htmlspecialchars(stripslashes($row["customerName"]));
				$valuesArray["address"]				= htmlspecialchars(stripslashes($row["address"]));
				$valuesArray["title"]				= htmlspecialchars(stripslashes($row["title"]));
				$valuesArray["phone"]				= htmlspecialchars(stripslashes($row["phone"]));
				$valuesArray["email"]				= htmlspecialchars(stripslashes($row["email"]));
				
				$valuesArray["installmentID"]		= htmlspecialchars(stripslashes($row["installmentID"]));
				$valuesArray["firstPayment"]		= htmlspecialchars(stripslashes($row["firstPayment"]));
				$valuesArray["totalCostPrice"]		= htmlspecialchars(stripslashes($row["totalCostPrice"]));
				$valuesArray["balance"]				= htmlspecialchars(stripslashes($row["balance"]));
				$valuesArray["recieptNumber"]		= htmlspecialchars(stripslashes($row["recieptNumber"]));
				$valuesArray["initialQuantity"]		= htmlspecialchars(stripslashes($row["quantity"]));
				$valuesArray["quantity"]			= htmlspecialchars(stripslashes($row["quantity"]));
				
				
				displayHeader("Myshop: Installments");	
				displayAdminTemp("Installments");
				displayLastPaymentInstallment2($message,$errorArray,$valuesArray,$errorFlag,$errorType);
				displayFooter();
				exit;
			}
		}
	}
	else{
		$errorFlag = true;
		$message = "Please make sure you have entered a valid Installment ID.";
		$errorType = "error";
		displayHeader("Myshop: Installments");	
		displayAdminTemp("Installments");
		displayLastPaymentInstallment1($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	
	}
}


function lastPaymentInstallment2($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	$itemID 			= trim($_POST["itemID"]);
	$description 		= trim($_POST["description"]);
	$price 				= trim($_POST["price"]);
	$stockQuantity 		= trim($_POST["stockQuantity"]);
	$initialQuantity 	= trim($_POST["initialQuantity"]);
	
	$title 				= trim($_POST["title"]);
	$customerName 		= trim($_POST["customerName"]);
	$address 			= trim($_POST["address"]);
	$phone 				= trim($_POST["phone"]);
	$email 				= trim($_POST["email"]);
	
	$installmentID 		= trim($_POST["installmentID"]);
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
	
	
	if(!$lastPayment &&  !$recieptNumber2 &&  !$lastBalance){
		$valuesArray["itemID"] 			= $itemID;
		$valuesArray["description"] 	= $description;
		$valuesArray["price"] 			= $price;
		$valuesArray["stockQuantity"] 	= $stockQuantity;
		$valuesArray["initialQuantity"] = $initialQuantity;
		
		$valuesArray["title"] 			= $title;
		$valuesArray["customerName"]	= $customerName;
		$valuesArray["address"]			= $address;
		$valuesArray["phone"] 			= $phone;
		$valuesArray["email"] 			= $email;
		
		$valuesArray["installmentID"]	= $installmentID;
		$valuesArray["quantity"]		= $quantity;
		$valuesArray["totalCostPrice"]	= $totalCostPrice;
		$valuesArray["firstPayment"] 	= $firstPayment;
		$valuesArray["lastPayment"] 	= $lastPayment;
		$valuesArray["balance"] 		= $balance;
		$valuesArray["lastBalance"] 	= $lastBalance;
		$valuesArray["recieptNumber"] 	= $recieptNumber;
		$valuesArray["recieptNumber2"] 	= $recieptNumber2;
		
		displayHeader("Myshop: Installments");	
		displayAdminTemp("Installments");
		displayLastPaymentInstallment2($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}
	
	$valid = installmentVal($message,$errorArray,$valuesArray,$errorFlag);
	if($valid == true){
		$itemID 			= addslashes($itemID);
		$price 				= addslashes($price);
		$description 		= addslashes($description);
		$stockQuantity 		= addslashes($stockQuantity);
		$initialQuantity 	= addslashes($initialQuantity);
		
		$title 				= addslashes($title);
		$customerName 		= addslashes($customerName);
		$address	 		= addslashes($address);
		$phone 				= addslashes(str_replace(" ", "", $phone));
		$email 				= addslashes($email);
		
		$installmentID 		= addslashes(str_replace(" ", "", $installmentID));
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
		if($balance != 0){
			$valuesArray["lastPayment"] 	= "";
			$errorArray["lastPayment"]		= "*";
			
			$valuesArray["balance"] 	= $totalCostPrice - $firstPayment;
			$valuesArray["lastBalance"] = "";
			
			$errorFlag = true;
			$message = "Please make sure the Final Payment equals balance.";
			$errorType = "error";
			displayHeader("Myshop: Installments");	
			displayAdminTemp("Installments");
			displayLastPaymentInstallment2($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();
			exit;
		}
		
		$query = "UPDATE installments SET balance ='".$balance."',recieptNumber2 ='".$recieptNumber2."',lastPayment ='".$lastPayment."',lastDate ='".$date;
		$query .= "' WHERE installmentID ='".$installmentID."'";
	
		$result = sql_query($query, $message);
			
		$message = "Successfully saved";
		$errorType = "success";
		$valuesArray["query"] = "SELECT * FROM installments WHERE installmentID ='".$installmentID."'";
		displayHeader("Myshop: Installments List");	
		displayAdminTemp("Installments");
		displayViewInstallments($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}
		
	else {	
		$errorFlag = true;
		$message = "Please make sure that the marked fields are propery filled.";
		$errorType = "error";
		displayHeader("Myshop: Installments");	
		displayAdminTemp("Installments");
		displayLastPaymentInstallment2($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}	
}


/******************************************************************************************/
function nextInstallments($message,$errorArray,$valuesArray,$errorFlag,$errorType){
		
	$errorFlag=true;
	$valuesArray["searchTerm"]	=stripslashes($valuesArray["searchTerm"]);
	$valuesArray["year"]		=stripslashes($valuesArray["year"]);
	$valuesArray["month"]		=stripslashes($valuesArray["month"]);
	
	$valuesArray["lowerLimit"] = $valuesArray["lowerLimit"];
	displayHeader("Myshop: Installments");	
	displayAdminTemp("Installments");
	displayViewInstallments($message,$errorArray,$valuesArray,$errorFlag,$errorType);
	displayFooter();
	exit;
}

function previousInstallments($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	$errorFlag=true;
	$valuesArray["searchTerm"]	=stripslashes($valuesArray["searchTerm"]);
	$valuesArray["year"]		=stripslashes($valuesArray["year"]);
	$valuesArray["month"]		=stripslashes($valuesArray["month"]);
	
	$valuesArray["lowerLimit"] = $valuesArray["lowerLimit"];
	displayHeader("Myshop: Installments");	
	displayAdminTemp("Installments");
	displayViewInstallments($message,$errorArray,$valuesArray,$errorFlag,$errorType);
	displayFooter();
	exit;
}

/*****************************************************************************************************/

function cancelInstallment($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	$valuesArray["searchTerm"]	=stripslashes($valuesArray["searchTerm"]);
	$valuesArray["year"]		=stripslashes($valuesArray["year"]);
	$valuesArray["month"]		=stripslashes($valuesArray["month"]);
	$valuesArray["lowerLimit"] 	= $valuesArray["lowerLimit"];
	$installmentID 				= addslashes($valuesArray["installmentID"]);
	
	// Check if the item realy exist in the database before inserting
	$query = "SELECT * FROM installments WHERE installmentID ='".$installmentID."'";
	$result = sql_query($query, $message);
	
	if(mysql_num_rows($result) == 0) {
		$message = "Please make sure you have entered a valid Installment ID"; 
		$errorType = "error";
		displayHeader("Myshop: Installments");	
		displayAdminTemp("Installments");
		displayViewInstallments($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}
	else {
		$errorFlag=true;
		$row = mysql_fetch_array($result);
		
		$itemID= htmlspecialchars(stripslashes($row["itemID"]));
		
		$query2  = "SELECT * FROM stockitems WHERE itemID ='".$itemID."'";
		$result2 = sql_query($query2, $message);
		
		if(mysql_num_rows($result2) == 0) {
			$message = "Please make sure you have entered a valid Installment ID";
			$errorType = "error";
			displayHeader("Myshop: Installments");	
			displayAdminTemp("Installments");
			displayViewInstallments($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();
			exit;
		}
		else {
				$errorFlag=true;
				$row2 = mysql_fetch_array($result2);
				
				$valuesArray["itemID"]			= htmlspecialchars(stripslashes($row["itemID"]));
				$valuesArray["description"]		= htmlspecialchars(stripslashes($row2["description"]));
				$valuesArray["price"]			= htmlspecialchars(stripslashes($row2["price"]));
				$valuesArray["stockQuantity"]		= htmlspecialchars(stripslashes($row2["quantity"]));
				
				$valuesArray["customerName"]		= htmlspecialchars(stripslashes($row["customerName"]));
				$valuesArray["address"]			= htmlspecialchars(stripslashes($row["address"]));
				$valuesArray["title"]			= htmlspecialchars(stripslashes($row["title"]));
				$valuesArray["phone"]			= htmlspecialchars(stripslashes($row["phone"]));
				$valuesArray["email"]			= htmlspecialchars(stripslashes($row["email"]));
				
				$valuesArray["installmentID"]		= htmlspecialchars(stripslashes($row["installmentID"]));
				$valuesArray["firstPayment"]		= htmlspecialchars(stripslashes($row["firstPayment"]));
				$valuesArray["lastPayment"]		= htmlspecialchars(stripslashes($row["lastPayment"]));
				$valuesArray["totalCostPrice"]		= htmlspecialchars(stripslashes($row["totalCostPrice"]));
				$valuesArray["balance"]			= htmlspecialchars(stripslashes($row["balance"]));
				$valuesArray["recieptNumber"]		= htmlspecialchars(stripslashes($row["recieptNumber"]));
				$valuesArray["recieptNumber2"]		= htmlspecialchars(stripslashes($row["recieptNumber2"]));
				$valuesArray["initialQuantity"]		= htmlspecialchars(stripslashes($row["quantity"]));
				$valuesArray["costPrice"]		= $valuesArray["totalCostPrice"] / $valuesArray["initialQuantity"];
				
				
				$message = "There must be a valid reason to cancel this installment";
				$errorType = "warning";
				displayHeader("Myshop: Installments");	
				displayAdminTemp("Installments");
				displayCancelInstallment($message,$errorArray,$valuesArray,$errorFlag,$errorType);
				displayFooter();
				exit;
		}
	}
}
/*****************************************************************************************************/


function viewInstallments($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	//Retrieve the posted itemID first
		$searchTerm 		= $_POST["searchTerm"];
		$month		 		= $_POST["month"];
		$year 				= $_POST["year"];
		$actualFormName 	= $_POST["actualFormName"];
		if((!$searchTerm)){
			$valuesArray["month"]= $month;
			$valuesArray["year"]= $year;
			if($actualFormName == "instalmentsHome"){
				$message = "Enter a search term to browse through  the installments list.";
				$errorType = "info";
				displayHeader("Myshop: Installments");	
				displayAdminTemp("Installments");
				displayInstallmentsHome($message,$errorArray,$valuesArray,$errorFlag,$errorType);
				displayFooter();  exit;
			}
			else {
				displayHeader("Myshop: Installments");	
				displayAdminTemp("Installments");
				displayViewInstallments($message,$errorArray,$valuesArray,$errorFlag,$errorType);
				displayFooter();  exit;
			}
		}
		else {
				$errorFlag=true;
				$valuesArray["month"]= $month;
				$valuesArray["year"]= $year;
				$valuesArray["searchTerm"]= stripslashes($searchTerm);
				displayHeader("Myshop: Installments");	
				displayAdminTemp("Installments");
				displayViewInstallments($message,$errorArray,$valuesArray,$errorFlag,$errorType);
				displayFooter();
				exit;
		}
	
}

/******************************************************************************************************************/

function cancelInstallment2($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	$installmentID 			= trim($_POST["installmentID"]);
	$reason 			= trim($_POST["reason"]);
	$costPrice			= trim($_POST["costPrice"]);
	$initialQuantity 		= trim($_POST["initialQuantity"]);//The number of items initially bought
	$quantity 			= trim($_POST["quantity"]); //The number of items returned
	$amount 			= trim($_POST["amount"]); // The amount of money returned to the customer
	
	$user				=$_SESSION['userName'];
	$date				= date("Y-m-d");
	$time				= date("H:i.s");
	
	$itemID 			= trim($_POST["itemID"]);
	$description 			= trim($_POST["description"]);
	
	$title 				= trim($_POST["title"]);
	$customerName 			= trim($_POST["customerName"]);
	$address 			= trim($_POST["address"]);
	$phone 				= trim($_POST["phone"]);
	
	$totalCostPrice 		= trim($_POST["totalCostPrice"]);
	$firstPayment 			= trim($_POST["firstPayment"]);
	$balance 			= trim($_POST["balance"]);
	$recieptNumber 			= trim($_POST["recieptNumber"]);
	
	$valid = installmentVal($message,$errorArray,$valuesArray,$errorFlag);
	if($valid == true){
		$reason 			= addslashes($reason);
		$initialQuantity 		= addslashes($initialQuantity);
		$installmentID 			= addslashes(str_replace(" ", "", $installmentID));
		$itemID 			= addslashes(str_replace(" ", "", $itemID));

		
		$quantity 			= addslashes(str_replace(" ", "", $quantity));
		$amount 			= addslashes(str_replace(" ", "", $amount));
		
		$user				= addslashes($user);
		$date 				= addslashes($date);
		$time				= addslashes($time);
		
		// Check if there are enough items in stock
		$query = "SELECT * FROM installments WHERE installmentID ='".$installmentID."'";
		$result = sql_query($query, $message);

		$row = mysql_fetch_array($result);
		$installmentQuantity = htmlspecialchars(stripslashes($row["quantity"]));
		if(($quantity < 1) || ($quantity > $installmentQuantity)){
			
			$valuesArray["itemID"] 			= $itemID;
			$valuesArray["description"] 		= $description;
			$valuesArray["reason"] 			= $reason;
			$valuesArray["initialQuantity"] 	= $initialQuantity;
			$valuesArray["costPrice"] 		= $costPrice;			
			$valuesArray["amount"] 			= $amount;

			$valuesArray["customerName"]		= htmlspecialchars(stripslashes($row["customerName"]));
			$valuesArray["title"]			= htmlspecialchars(stripslashes($row["title"]));
			$valuesArray["phone"]			= htmlspecialchars(stripslashes($row["phone"]));
			$valuesArray["email"]			= htmlspecialchars(stripslashes($row["email"]));
			
			$valuesArray["installmentID"]		= htmlspecialchars(stripslashes($row["installmentID"]));
			$valuesArray["totalCostPrice"]		= htmlspecialchars(stripslashes($row["totalCostPrice"]));
			$valuesArray["firstPayment"]		= htmlspecialchars(stripslashes($row["firstPayment"]));
			$valuesArray["balance"]			= htmlspecialchars(stripslashes($row["balance"]));
			$valuesArray["recieptNumber"]		= htmlspecialchars(stripslashes($row["recieptNumber"]));
			
			
			if($quantity < 1 ){ $message = "Quantity should be greater than or equal to 1";}
			if($quantity > $installmentQuantity) { $message = "Make sure the quantity is within that on installment";}
			
			$valuesArray["quantity"] 		= "";
			$errorArray["quantity"] 		= "*";
			$errorType 						= "error";
			$errorFlag = true;
			displayHeader("Myshop: Installments");	
			displayAdminTemp("Installments");
			displayCancelInstallment($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();
			exit;
		}
			//Insert values into database
		$newQuantity		 = $installmentQuantity - $quantity;
		$newFirstPayment   	 = $firstPayment - $amount;
		$totalCostPrice          = $costPrice * $newQuantity;
		$balance		 = $totalCostPrice - $newFirstPayment;	
		if(($installmentQuantity - $quantity) == 0){$returned = "Yes";}
		else {$returned = "No";}
		$sold = "No";
		$query = "INSERT INTO cancelledInstallments (installmentID, itemID, quantity, amount, reason, user, date, time) ";
		$query .= "VALUES ('".$installmentID."','".$itemID."','".$quantity."','".$amount."','".$reason;		
		$query .= "','".$user."','".$date."','".$time."')";
		
		$query1 = "UPDATE installments SET quantity ='".$newQuantity."',totalCostPrice  ='".$totalCostPrice."',balance  ='".$balance."',firstPayment ='".$newFirstPayment;
		$query1 .= "',returned ='".$returned."' WHERE installmentID ='".$installmentID."'";
		
		$query2 = "UPDATE stockitems SET quantity = quantity + '".$quantity."',sold ='".$sold."' WHERE itemID ='".$itemID."'";
		
		$result = sql_query($query, $message);
		$result1 = sql_query($query1, $message);
		$result2 = sql_query($query2, $message);
					
		$message = "Successfully saved";
		$errorType = "success";
		$valuesArray["query"] = "SELECT * FROM installments WHERE installmentID ='".$installmentID."'";
		displayHeader("Myshop: Installments");	
		displayAdminTemp("Installments");
		displayViewInstallments($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}
		
	else {	
			$message = "Please make sure that the marked fields are propery filled.";
			$errorType = "error";
			$errorFlag = true;
			displayHeader("Myshop: Installments");	
			displayAdminTemp("Installments");
			displayCancelInstallment($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();
			exit;
		}	
}


/*-----------------------------------------------------------------------------------------------------------------*/
?>