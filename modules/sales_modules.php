<?php

/*---------------------------------------------------------------------------
/* This function process all the validatins for Stock Item Entry and Edit     */
/*----------------------------------------------------------------------------*/
function salesVal(&$message,&$errorArray,&$valuesArray,&$errorFlag){
	$errorFlag =false;
	foreach ($_POST  as $key => $value){
		if(($key == "frmName") || ($key == "description") || ($key == "itemID") || ($key == "price") || ($key == "stockQuantity")){
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
			
			
			if(($key == "sellingPrice") || ($key == "recieptNumber") || ($key == "quantity") || ($key == "saleID") || ($key == "amount")){
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
			
			if(($key == "discount") || ($key == "totalCostPrice")){
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
function enterSales($message,$errorArray,$valuesArray,$errorFlag,$errorType){
		
	$valuesArray["searchTerm"]= stripslashes($valuesArray["searchTerm"]);
	$valuesArray["lowerLimit"] = $valuesArray["lowerLimit"] + 10;
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
	
	
	displayHeader("Myshop: Sales");	
	displayAdminTemp("Sales");
	displayEnterSales2($message,$errorArray,$valuesArray,$errorFlag,$errorType);
	displayFooter();
	exit;
}

/*---------------------------------------------------------------------------
/* This function process the entry of a new stock item into the database*/
/*----------------------------------------------------------------------------*/
function enterSales2($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	$itemID 			= trim($_POST["itemID"]);
	$description 		= trim($_POST["description"]);
	$price 				= trim($_POST["price"]);
	$stockQuantity 		= trim($_POST["stockQuantity"]);
	
	$title 				= trim($_POST["title"]);
	$customerName 		= trim($_POST["customerName"]);
	$phone 				= trim($_POST["phone"]);
	$email 				= trim($_POST["email"]);
	
	$saleID 			= trim($_POST["saleID"]);
	$quantity 			= trim($_POST["quantity"]);
	$totalCostPrice 	= trim($_POST["totalCostPrice"]);
	$sellingPrice 		= trim($_POST["sellingPrice"]);
	$discount 			= trim($_POST["discount"]);
	$recieptNumber 		= trim($_POST["recieptNumber"]);
	
	$user				=$_SESSION['userName'];
	$date				= date("Y-m-d");
	$time				= date("H:i.s");

	
	$valid = salesVal($message,$errorArray,$valuesArray,$errorFlag);
	if($valid == true){
		$itemID 			= addslashes($itemID);
		$price 				= addslashes($price);
		$description 		= addslashes($description);
		$stockQuantity 		= addslashes($stockQuantity);
		
		$title 				= addslashes($title);
		$customerName 		= addslashes($customerName);
		$phone 				= addslashes(str_replace(" ", "", $phone));
		$email 				= addslashes($email);
		
		$saleID 			= addslashes(str_replace(" ", "", $saleID));
		$quantity 			= addslashes(str_replace(" ", "", $quantity));
		$totalCostPrice 	= addslashes(str_replace(" ", "", $totalCostPrice));
		$sellingPrice 		= addslashes(str_replace(" ", "", $sellingPrice));
		$discount			= $totalCostPrice - $sellingPrice;
		$recieptNumber		= addslashes(str_replace(" ", "", $recieptNumber));
		
		$user				= addslashes($user);
		$date 				= addslashes($date);
		$time				= addslashes($time);
		
		$totalCostPrice 	= $price * $quantity;
		$discount			= $totalCostPrice - $sellingPrice;
		// Check if there are enough items in stock
		$query = "SELECT * FROM stockitems WHERE itemID ='".$itemID."'";
		$result = sql_query($query, $message);
		
		$row = mysql_fetch_array($result);
		$stockQuantity = htmlspecialchars(stripslashes($row["quantity"]));
		if(($quantity < 1) || ($quantity > $stockQuantity)){
			
			$valuesArray["itemID"] 			= $itemID;
			$valuesArray["description"] 		= $description;
			$valuesArray["price"] 			= $price;
			$valuesArray["stockQuantity"] 		= $stockQuantity;
			
			$valuesArray["title"] 			= $title;
			$valuesArray["customerName"]		= $customerName;
			$valuesArray["phone"] 			= $phone;
			$valuesArray["email"] 			= $email;
			
			$valuesArray["saleID"]			= $saleID;
			$valuesArray["quantity"]		= $quantity;
			$valuesArray["totalCostPrice"]		= $totalCostPrice;
			$valuesArray["sellingPrice"] 		= $sellingPrice;
			$valuesArray["discount"] 		= $discount;
			$valuesArray["recieptNumber"] 		= $recieptNumber;
			
			if($stockQuantity < 1){
				$message = "There are no more ".$description." in stock";
			}
			if($quantity < 1 ){ $message = "Quantity should be greater than or equal to 1";}
			if($quantity > $stockQuantity) { $message = "There are only ".$stockQuantity." ". $description."s in stock";}
			
			$valuesArray["quantity"] 		= "";
			$errorArray["quantity"] 		= "*";
			$errorType 						= "error";
			$errorFlag = true;
			displayHeader("Myshop: Sales");	
			displayAdminTemp("Sales");
			displayEnterSales2($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();
			exit;
		}
			//Insert values into database
		$newQuantity = $stockQuantity - $quantity;
		if(($stockQuantity - $quantity) == 0){$sold = "Yes";}
		else {$sold = "No";}
		
		$query = "INSERT INTO sales (saleID, itemID, quantity, totalCostPrice, sellingPrice, discount, recieptNumber, title,";
		$query .= "customerName, phone, email, description, user, date, time) ";
		$query .= "VALUES ('".$saleID."','".$itemID."','".$quantity."','".$totalCostPrice."','".$sellingPrice."','".$discount."','".$recieptNumber;		
		$query .= "','".$title."','".$customerName."','".$phone."','".$email."','".$description."','".$user."','".$date."','".$time."')";
		
		$query2 = "UPDATE stockitems SET quantity ='".$newQuantity."',sold ='".$sold."' WHERE itemID ='".$itemID."'";
		
		$result = sql_query($query, $message);
		$result2 = sql_query($query2, $message);
		
		$message = "Successfully saved";
		$errorType = "success";
		$valuesArray["query"] = "SELECT * FROM sales WHERE saleID ='".$saleID."'";
		displayHeader("Myshop: Sales");	
		displayAdminTemp("Sales");
		displayViewSales($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}
		
	else {	
		$message = "Please make sure that the marked fields are propery filled.";
		$errorType = "error";
		displayHeader("Myshop: Sales");	
		displayAdminTemp("Sales");
		displayEnterSales2($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}	
}


/*-----------------------------------------------------------------------------------------------------------------
/*This function is the firrst processe of editing of a particular stock item given a particular stock ID
/*----------------------------------------------------------------------------------------------------------------*/

function editSales1($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	//Retrieve the posted itemID first
		if($valuesArray["saleID"] == ""){
		$saleID 		= $_POST["saleID"];
		}
		else{$saleID = $valuesArray["saleID"];}
		
		
		if(!$saleID){
			$message = "Enter Sale ID and click search to edit a specific sale entry.";
			$errorType = "info";
			displayHeader("Myshop: Sales");	
			displayAdminTemp("Sales");
			displayEditSales1($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();  exit;
		}
		$saleID = str_replace(" ", "", $saleID);
		if(is_numeric($saleID)){
			$saleID 			= addslashes($saleID);
			// Check if the item realy exist in the database before inserting
			$query = "SELECT * FROM sales WHERE saleID ='".$saleID."'";
			$result = sql_query($query, $message);
			if(mysql_num_rows($result) == 0) {
				$message = "Sale entry With ID \"$saleID\" doesnt exit. Please enter a valid Sale ID"; 
				$errorType = "error";
				displayHeader("Myshop: Sales");	
				displayAdminTemp("Sales");
				displayEditSales1($message,$errorArray,$valuesArray,$errorFlag,$errorType);
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
					$message = "Sale entry With ID \"$saleID\" doesnt exit. Please enter a valid Sale ID"; 
					$errorType = "error";
					displayHeader("Myshop: Sales");	
					displayAdminTemp("Sales");
					displayEditSales1($message,$errorArray,$valuesArray,$errorFlag,$errorType);
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
					$valuesArray["title"]				= htmlspecialchars(stripslashes($row["title"]));
					$valuesArray["phone"]				= htmlspecialchars(stripslashes($row["phone"]));
					$valuesArray["email"]				= htmlspecialchars(stripslashes($row["email"]));
					
					$valuesArray["saleID"]				= htmlspecialchars(stripslashes($row["saleID"]));
					$valuesArray["quantity"]			= htmlspecialchars(stripslashes($row["quantity"]));
					$valuesArray["sellingPrice"]		= htmlspecialchars(stripslashes($row["sellingPrice"]));
					$valuesArray["totalCostPrice"]		= htmlspecialchars(stripslashes($row["totalCostPrice"]));
					$valuesArray["discount"]			= htmlspecialchars(stripslashes($row["discount"]));
					$valuesArray["recieptNumber"]		= htmlspecialchars(stripslashes($row["recieptNumber"]));
					$valuesArray["initialSaleQuantity"]	= htmlspecialchars(stripslashes($row["quantity"]));
					
					
					$message = "You can not change the Sale ID";
					$errorType = "warning";
					displayHeader("Myshop: Sales");	
					displayAdminTemp("Sales");
					displayEditSales2($message,$errorArray,$valuesArray,$errorFlag,$errorType);
					displayFooter();
					exit;
				}
			}
		}
		else{
			$errorFlag = true;
			$message = "Please make sure you have entered a valid Sale ID.";
			$errorType = "error";
			displayHeader("Myshop: Sales");	
			displayAdminTemp("Sales");
			displayEditSales1($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();
			exit;
		
		}
}
/*-------------------------------------------------------------------------------------------------------
/*--------------------------------------------------------------------------------------------------------
/**This function is the firrst processe of editing of a particular stock item given a particular stock ID
/*--------------------------------------------------------------------------------------------------------*/
function editSales2($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	$itemID 				= trim($_POST["itemID"]);
	$description 			= trim($_POST["description"]);
	$price 					= trim($_POST["price"]);
	$stockQuantity 			= trim($_POST["stockQuantity"]);
	
	$title 					= trim($_POST["title"]);
	$customerName 			= trim($_POST["customerName"]);
	$phone 					= trim($_POST["phone"]);
	$email 					= trim($_POST["email"]);
	
	$saleID 				= trim($_POST["saleID"]);
	$quantity 				= trim($_POST["quantity"]);
	$totalCostPrice 		= trim($_POST["totalCostPrice"]);
	$sellingPrice 			= trim($_POST["sellingPrice"]);
	$discount 				= trim($_POST["discount"]);
	$recieptNumber 			= trim($_POST["recieptNumber"]);
	$initialSaleQuantity 	= trim($_POST["initialSaleQuantity"]);
	
	$user				=$_SESSION['userName'];
	$date				= date("Y-m-d");
	$time				= date("H:i.s");

	$valid = salesVal($message,$errorArray,$valuesArray,$errorFlag);
	if($valid == true){
		$itemID 			= addslashes($itemID);
		$price 				= addslashes($price);
		$description 		= addslashes($description);
		$stockQuantity 		= addslashes($stockQuantity);
		
		$title 				= addslashes($title);
		$customerName 		= addslashes($customerName);
		$phone 				= addslashes(str_replace(" ", "", $phone));
		$email 				= addslashes($email);
		
		$saleID 			= addslashes($saleID);
		$quantity 			= addslashes($quantity);
		$totalCostPrice 	= addslashes(str_replace(" ", "", $totalCostPrice));
		$sellingPrice 		= addslashes(str_replace(" ", "", $sellingPrice));
		$discount			= $totalCostPrice - $sellingPrice;
		$recieptNumber		= addslashes(str_replace(" ", "", $recieptNumber));
		
		$user				= addslashes($user);
		$date 				= addslashes($date);
		$time				= addslashes($time);
		$totalCostPrice 	= $price * $quantity;
		$discount			= $totalCostPrice - $sellingPrice;
		
		$query = "SELECT * FROM stockitems WHERE itemID ='".$itemID."'";
		$result = sql_query($query, $message);
		
		$row = mysql_fetch_array($result);
		$stockQuantity = htmlspecialchars(stripslashes($row["quantity"]));
		if(($quantity < 1) || ($quantity - $initialSaleQuantity) > $stockQuantity){
					
			if($stockQuantity < 1){
				$message = "There are no more ".$description." in stock";
			}
			else{ $message = "There are only ".$stockQuantity." ". $description." in stock";}
			
			$valuesArray["quantity"] 		= "";
			$errorArray["quantity"] 		= "*";
			$errorType 						= "error";
			$errorFlag = true;
			displayHeader("Myshop: Sales");	
			displayAdminTemp("Sales");
			displayEditSales2($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();
			exit;
		}
			//Insert values into database
		$newQuantity = $stockQuantity - ($quantity - $initialSaleQuantity);
		if($stockQuantity == $quantity){$sold = "Yes";}
		else {$sold = "No";}
		
		$query = "UPDATE sales SET saleID ='".$saleID."',itemID ='".$itemID."',quantity ='".$quantity."',totalCostPrice ='".$totalCostPrice."',sellingPrice ='";
		$query .= $sellingPrice."',description ='".$description."',discount ='".$discount."',recieptNumber ='".$recieptNumber."',title ='";
		$query .= $title."',customerName ='".$customerName."',phone ='".$phone."',email ='".$email; 
		$query .= "' WHERE saleID ='".$saleID."'";
		
		$query2 = "UPDATE stockitems SET quantity ='".$newQuantity."',sold ='".$sold."' WHERE itemID ='".$itemID."'";
		
		$result = sql_query($query, $message);
		
		$result2 = sql_query($query2, $message);
		
		$message = "Successfully saved";
		$errorType = "success";
		$valuesArray["query"] = "SELECT * FROM sales WHERE saleID ='".$saleID."'";
		displayHeader("Myshop: Sales");	
		displayAdminTemp("Sales");
		displayViewSales($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}
		
	else {				
			$message = "Please make sure that the marked fields are propery filled.";
			$errorType = "error";			
			
			$message = "Please make sure that the marked fields are propery filled.";
			$errorType = "error";
			displayHeader("Myshop: Sales");	
			displayAdminTemp("Sales");
			displayEditSales2($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();
			exit;
		}	
}


/******************************************************************************************/

function viewSaleInfo($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	
	$valuesArray["searchTerm"]	=stripslashes($valuesArray["searchTerm"]);
	$valuesArray["year"]		=stripslashes($valuesArray["year"]);
	$valuesArray["month"]		=stripslashes($valuesArray["month"]);
	$valuesArray["lowerLimit"] 	= $valuesArray["lowerLimit"] + 10;
	$saleID 					= addslashes($valuesArray["saleID"]);

	// Check if the item realy exist in the database before inserting
	$query = "SELECT * FROM sales WHERE saleID ='".$saleID."'";
	$result = sql_query($query, $message);
	
	$errorFlag=true;
	$row = mysql_fetch_array($result);
	$valuesArray["itemID"]			= htmlspecialchars(stripslashes($row["itemID"]));
	
	$itemID = $valuesArray["itemID"];
	$query2 = "SELECT * FROM stockitems WHERE itemID ='".$itemID."'";
	$result2 = sql_query($query2, $message);
	
	$row2 = mysql_fetch_array($result2);
	$valuesArray["description"]		= htmlspecialchars(stripslashes($row["description"]));
	$valuesArray["price"]			= htmlspecialchars(stripslashes($row2["price"]));
	$valuesArray["stockQuantity"]	= htmlspecialchars(stripslashes($row2["quantity"]));
	
	$valuesArray["customerName"]		= htmlspecialchars(stripslashes($row["customerName"]));
	$valuesArray["title"]				= htmlspecialchars(stripslashes($row["title"]));
	$valuesArray["phone"]				= htmlspecialchars(stripslashes($row["phone"]));
	$valuesArray["email"]				= htmlspecialchars(stripslashes($row["email"]));
	
	$valuesArray["saleID"]				= htmlspecialchars(stripslashes($row["saleID"]));
	$valuesArray["quantity"]			= htmlspecialchars(stripslashes($row["quantity"]));
	$valuesArray["sellingPrice"]		= htmlspecialchars(stripslashes($row["sellingPrice"]));
	$valuesArray["totalCostPrice"]		= htmlspecialchars(stripslashes($row["totalCostPrice"]));
	$valuesArray["discount"]			= htmlspecialchars(stripslashes($row["discount"]));
	$valuesArray["recieptNumber"]		= htmlspecialchars(stripslashes($row["recieptNumber"]));
	$valuesArray["initialSaleQuantity"]	= htmlspecialchars(stripslashes($row["quantity"]));
	
	$valuesArray["user"]		= htmlspecialchars(stripslashes($row["user"]));
	$valuesArray["date"]		= htmlspecialchars(stripslashes($row["date"]));
	$valuesArray["time"]		= htmlspecialchars(stripslashes($row["time"]));
	
	displayHeader("Myshop: Sales");	
	displayAdminTemp("Sales");
	displayViewSaleInfo($message,$errorArray,$valuesArray,$errorFlag,$errorType);
	displayFooter();
	exit;
}

function nextSales($message,$errorArray,$valuesArray,$errorFlag,$errorType){
		
	$errorFlag=true;
	$valuesArray["searchTerm"]	=stripslashes($valuesArray["searchTerm"]);
	$valuesArray["year"]		=stripslashes($valuesArray["year"]);
	$valuesArray["month"]		=stripslashes($valuesArray["month"]);
	
	$valuesArray["lowerLimit"] = $valuesArray["lowerLimit"];
	displayHeader("Myshop: Sales");	
	displayAdminTemp("Sales");
	displayViewSales($message,$errorArray,$valuesArray,$errorFlag,$errorType);
	displayFooter();
	exit;
}

function previousSales($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	$errorFlag=true;
	$valuesArray["searchTerm"]	=stripslashes($valuesArray["searchTerm"]);
	$valuesArray["year"]		=stripslashes($valuesArray["year"]);
	$valuesArray["month"]		=stripslashes($valuesArray["month"]);
	
	$valuesArray["lowerLimit"] = $valuesArray["lowerLimit"];
	displayHeader("Myshop: Sales");	
	displayAdminTemp("Sales");
	displayViewSales($message,$errorArray,$valuesArray,$errorFlag,$errorType);
	displayFooter();
	exit;
}

/*****************************************************************************************************/

function returnItem($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	$valuesArray["searchTerm"]	=stripslashes($valuesArray["searchTerm"]);
	$valuesArray["year"]		=stripslashes($valuesArray["year"]);
	$valuesArray["month"]		=stripslashes($valuesArray["month"]);
	$valuesArray["lowerLimit"] 	= $valuesArray["lowerLimit"] + 10;
	$saleID 					= addslashes($valuesArray["saleID"]);
	
	// Check if the item realy exist in the database before inserting
	$query = "SELECT * FROM sales WHERE saleID ='".$saleID."'";
	$result = sql_query($query, $message);
	
	if(mysql_num_rows($result) == 0) {
		$message = "Please make sure you have entered a valid Sale ID"; 
		$errorType = "error";
		displayHeader("Myshop: Sales");	
		displayAdminTemp("Sales");
		displayViewSales($message,$errorArray,$valuesArray,$errorFlag,$errorType);
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
			$message = "Please make sure you have entered a valid Sale ID"; 
			$errorType = "error";
			displayHeader("Myshop: Sales");	
			displayAdminTemp("Sales");
			displayViewSales($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();
			exit;
		}
		else {
			$errorFlag=true;
			$row2 = mysql_fetch_array($result2);
			
			$valuesArray["itemID"]				= htmlspecialchars(stripslashes($row["itemID"]));
			$valuesArray["description"]			= htmlspecialchars(stripslashes($row2["description"]));
			$valuesArray["stockQuantity"]			= htmlspecialchars(stripslashes($row2["quantity"]));
			
			$valuesArray["customerName"]			= htmlspecialchars(stripslashes($row["customerName"]));
			$valuesArray["title"]				= htmlspecialchars(stripslashes($row["title"]));
			$valuesArray["phone"]				= htmlspecialchars(stripslashes($row["phone"]));
			$valuesArray["email"]				= htmlspecialchars(stripslashes($row["email"]));
			
			$valuesArray["saleID"]				= htmlspecialchars(stripslashes($row["saleID"]));
			$valuesArray["sellingPrice"]			= htmlspecialchars(stripslashes($row["sellingPrice"]));
			$valuesArray["totalCostPrice"]			= htmlspecialchars(stripslashes($row["totalCostPrice"]));
			$valuesArray["discount"]			= htmlspecialchars(stripslashes($row["discount"]));
			$valuesArray["recieptNumber"]			= htmlspecialchars(stripslashes($row["recieptNumber"]));
			$valuesArray["initialQuantity"]			= htmlspecialchars(stripslashes($row["quantity"]));
			$valuesArray["costPrice"]			= $valuesArray["totalCostPrice"] / $valuesArray["initialQuantity"];
			
			
			$message = "There must be a valid reason to return this item";
			$errorType = "warning";
			displayHeader("Myshop: Sales");	
			displayAdminTemp("Sales");
			displayReturnItem($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();
			exit;
		}
	}
}
/*****************************************************************************************************/


function viewSales($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	//Retrieve the posted itemID first
		$searchTerm 		= $_POST["searchTerm"];
		$month		 		= $_POST["month"];
		$year 				= $_POST["year"];
		$actualFormName 	= $_POST["actualFormName"];
		if((!$searchTerm)){
			$valuesArray["month"]= $month;
			$valuesArray["year"]= $year;
			if($actualFormName == "salesHome"){
				$message = "Enter a search term to browse through  the sales list.";
				$errorType = "info";
				displayHeader("Myshop: Sales");	
				displayAdminTemp("Sales");
				displaySalesHome($message,$errorArray,$valuesArray,$errorFlag,$errorType);
				displayFooter();  exit;
			}
			else {
				displayHeader("Myshop: Sales");	
				displayAdminTemp("Sales");
				displayViewSales($message,$errorArray,$valuesArray,$errorFlag,$errorType);
				displayFooter();  exit;
			}
		}
		else {
				$errorFlag=true;
				$valuesArray["month"]= $month;
				$valuesArray["year"]= $year;
				$valuesArray["searchTerm"]= stripslashes($searchTerm);
				displayHeader("Myshop: Sales");	
				displayAdminTemp("Sales");
				displayViewSales($message,$errorArray,$valuesArray,$errorFlag,$errorType);
				displayFooter();
				exit;
		}
	
}

/******************************************************************************************************************/

function returnItem2($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	$saleID 			= trim($_POST["saleID"]);
	$reason 			= trim($_POST["reason"]);
	$initialQuantity 		= trim($_POST["initialQuantity"]);//The number of items initially bought
	$costPrice 			= trim($_POST["costPrice"]);//The price of single item
	$quantity 			= trim($_POST["quantity"]); //The number of items returned
	$amount 			= trim($_POST["amount"]); // The amount of money returned to the customer
	
	$user				=$_SESSION['userName'];
	$date				= date("Y-m-d");
	$time				= date("H:i.s");
	
	$itemID 				= trim($_POST["itemID"]);
	$description 			= trim($_POST["description"]);
	
	$title 					= trim($_POST["title"]);
	$customerName 			= trim($_POST["customerName"]);
	$phone 					= trim($_POST["phone"]);
	
	$totalCostPrice 		= trim($_POST["totalCostPrice"]);
	$sellingPrice 			= trim($_POST["sellingPrice"]);
	$discount 				= trim($_POST["discount"]);
	$recieptNumber 			= trim($_POST["recieptNumber"]);
	
	
	$valid = salesVal($message,$errorArray,$valuesArray,$errorFlag);
	if($valid == true){
		$reason 			= addslashes($reason);
		$initialQuantity 		= addslashes($initialQuantity);
		$saleID 			= addslashes(str_replace(" ", "", $saleID));
		$costPrice 			= addslashes(str_replace(" ", "", $costPrice));
		$itemID 			= addslashes(str_replace(" ", "", $itemID));

		
		$quantity 			= addslashes(str_replace(" ", "", $quantity));
		$amount 			= addslashes(str_replace(" ", "", $amount));
		
		$user				= addslashes($user);
		$date 				= addslashes($date);
		$time				= addslashes($time);
		
		
		// Check if there are enough items in stock
		$query = "SELECT * FROM sales WHERE saleID ='".$saleID."'";
		$result = sql_query($query, $message);
	
		$row = mysql_fetch_array($result);
		$saleQuantity = htmlspecialchars(stripslashes($row["quantity"]));
		if(($quantity < 1) || ($quantity > $saleQuantity)){
			
			$valuesArray["itemID"] 				= $itemID;
			$valuesArray["description"] 			= $description;
			$valuesArray["reason"] 				= $reason;
			$valuesArray["initialQuantity"] 		= $initialQuantity;
			$valuesArray["costPrice"] 			= $costPrice;
			
			$valuesArray["amount"] 				= $amount;
			$valuesArray["customerName"]			= htmlspecialchars(stripslashes($row["customerName"]));
			$valuesArray["title"]				= htmlspecialchars(stripslashes($row["title"]));
			$valuesArray["phone"]				= htmlspecialchars(stripslashes($row["phone"]));
			$valuesArray["email"]				= htmlspecialchars(stripslashes($row["email"]));
			
			$valuesArray["saleID"]				= htmlspecialchars(stripslashes($row["saleID"]));
			$valuesArray["sellingPrice"]			= htmlspecialchars(stripslashes($row["sellingPrice"]));
			$valuesArray["totalCostPrice"]			= htmlspecialchars(stripslashes($row["totalCostPrice"]));
			$valuesArray["discount"]			= htmlspecialchars(stripslashes($row["discount"]));
			$valuesArray["recieptNumber"]			= htmlspecialchars(stripslashes($row["recieptNumber"]));
			
			
			if($quantity < 1 ){ $message = "Quantity should be greater than or equal to 1";}
			if($quantity > $saleQuantity) { $message = "You can not return more than what you bought";}
			
			$valuesArray["quantity"] 		= "";
			$errorArray["quantity"] 		= "*";
			$errorType 				= "error";
			$errorFlag = true;
			displayHeader("Myshop: Sales");	
			displayAdminTemp("Sales");
			displayReturnItem($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();
			exit;
		}
			//Insert values into database
		$newQuantity 		= $saleQuantity - $quantity;
		$newSellingPrice    	= $sellingPrice - $amount;
		$totalCostPrice 	= $costPrice * $newQuantity;
		$discount 		= $totalCostPrice - $newSellingPrice;

		if(($saleQuantity - $quantity) == 0){$returned = "Yes";}
		else {$returned = "No";}
		$sold = "No";
		$query = "INSERT INTO returneditems (saleID, itemID, quantity, amount, reason, user, date, time) ";
		$query .= "VALUES ('".$saleID."','".$itemID."','".$quantity."','".$amount."','".$reason;		
		$query .= "','".$user."','".$date."','".$time."')";
		
		$query1 = "UPDATE sales SET quantity ='".$newQuantity."',totalCostPrice  ='".$totalCostPrice."',discount  ='".$discount."',sellingPrice ='".$newSellingPrice."',returned ='".$returned."' WHERE saleID ='".$saleID."'";
		
		$query2 = "UPDATE stockitems SET quantity = quantity + '".$quantity."',sold ='".$sold."' WHERE itemID ='".$itemID."'";
		
		$result = sql_query($query, $message);
		$result1 = sql_query($query1, $message);
		$result2 = sql_query($query2, $message);
		
		$message = "Successfully returned";
		$errorType = "success";
		$valuesArray["query"] = "SELECT * FROM sales WHERE saleID ='".$saleID."'";
		displayHeader("Myshop: Sales");	
		displayAdminTemp("Sales");
		displayViewSales($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}
		
	else {	
			$errorFlag=true;
			$message = "Please make sure that the marked fields are propery filled.";
			$errorType = "error";
			displayHeader("Myshop: Sales");	
			displayAdminTemp("Sales");
			displayReturnItem($message,$errorArray,$valuesArray,$errorFlag,$errorType);  
			displayFooter();
			exit;
		}	
}


/*-----------------------------------------------------------------------------------------------------------------*/
?>