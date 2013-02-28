<?php
/*---------------------------------------------------------------------------
/* This function process all the validatins for Stock Item Entry and Edit     */
/*----------------------------------------------------------------------------*/
function stockItemVal(&$message,&$errorArray,&$valuesArray,&$errorFlag){
	$errorFlag = false;
	foreach ($_POST  as $key => $value){
		if(isset($key)&&($value == "") && ($key !="serial") && ($key !="searchTerm") && ($key !="lowerLimit")){
			$errorArray["$key"] = "*";
			$valuesArray["$key"] = "";
			$errorFlag = true;
		}
		else{
			$errorArray["$key"] = "";
			$valuesArray["$key"] = $value;
		}
		if($key == "serial" && $value ==""){
			$errorArray["$key"] = "";
			$valuesArray["$key"] = $value;
		}
		
		if($key == "description" && $value ==""){
				$errorArray["$key"] = "*";
				$valuesArray["$key"] = "";
				$errorFlag = true;
		}
	
		else{
				$errorArray["$key"] = "";
				$valuesArray["$key"] = $value;
		}
		if(($key == "itemID") || ($key == "stockID") || ($key == "price") || ($key == "quantity")){
			$value = str_replace(" ", "", $value);
			if(!(is_numeric($value))){
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
	return !($errorFlag);
}

/*---------------------------------------------------------------------------
/* This function process the entry of a new stock item into the database*/
/*----------------------------------------------------------------------------*/
function enterStockItem($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	$stockID 		= trim($_POST["stockID"]);
	$itemID 		= trim($_POST["itemID"]);
	$serial 		= trim($_POST["serial"]);
	$description 	= trim($_POST["description"]);
	$quantity 		= trim($_POST["quantity"]);
	$price 			= trim($_POST["price"]);
	$user			=$_SESSION['userName'];
	$date			= date("Y-m-d");
	$time			= date("H:i.s");
	
	if(!$stockID && !$serial && !$description && !$quantity && !$price){//check if the user is viewing this page from the right page
		$errorFlag = false;
		displayHeader("Myshop: Stock Items");	
		displayAdminTemp("Stock");
		displayEnterStockItem($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}

	$valid = stockItemVal($message,$errorArray,$valuesArray,$errorFlag);
	if($valid == true){
		$stockID 		= addslashes($stockID);
		$itemID 		= addslashes($itemID);
		$serial 		= addslashes($serial);
		$description 	= addslashes($description);
		$quantity 		= addslashes($quantity);
		$price 			= addslashes($price);
		$user			= addslashes($user);
		$date 			= addslashes($date);
		$time			= addslashes($time);
		
		if($serial  ==""){ $serial ="-";}
		
		// Check if the item already exist in the database before inserting
		$query = "SELECT * FROM stockitems WHERE itemID ='".$itemID."'";
		$result = sql_query($query, $message);
		
		if(mysql_num_rows($result) == 1) {
			$message = "Item With ID \"$itemID\" already entered. Please enter a different item ID"; 
			$errorType = "error";
			$errorArray["itemID"] = "*";
			$valuesArray["$itemID"] = "";
			displayHeader("Myshop: Stock Items");	
			displayAdminTemp("Stock");
			displayEnterStockItem($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();
			exit;
		}
		else { 
			//Insert values into database
			$query = "INSERT INTO stockitems (stockID, itemID, serial, description, quantity, price, user, date, time) ";
			$query .= "VALUES ('".$stockID."','".$itemID."','".$serial."','".$description."','".$quantity."','".$price;
			$query .= "','".$user."','".$date."','".$time."')";
			
			$result = sql_query($query, $message);
			
			if($_POST["Save"] == "Add"){
				$message = "Successfully saved";
				$errorType = "success";
				$valuesArray["query"] = "SELECT * FROM stockitems WHERE itemID ='".$itemID."'";
				displayHeader("Myshop: Stock Items");	
				displayAdminTemp("Stock");
				displayViewStockItems($message,$errorArray,$valuesArray,$errorFlag,$errorType);
				displayFooter();
				exit;
			}
			else{
				$errorFlag = true;
				$valuesArray["itemID"] = $itemID + 1; 
				$valuesArray["serial"] ="";
				$valuesArray["description"]= "";
				$valuesArray["quantity"]= "";
				$valuesArray["price"]= "";
		
				$message = $quantity." ".$description."  successfully added into stock";
				$errorType = "success";
				displayHeader("Myshop: Stock Items");	
				displayAdminTemp("Stock");
				displayEnterStockItem($message,$errorArray,$valuesArray,$errorFlag,$errorType);
				displayFooter();
				exit;
			}
		}
	}
	else{
		$errorFlag = true;
		$message = "Please make sure that the marked fields are propery filled.";
		$errorType = "error";
		displayHeader("Myshop: Stock Items");	
		displayAdminTemp("Stock");
		displayEnterStockItem($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}	
}


/*-----------------------------------------------------------------------------------------------------------------
/*This function is the firrst processe of editing of a particular stock item given a particular stock ID
/*----------------------------------------------------------------------------------------------------------------*/

function editStockItem2($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	//Retrieve the posted itemID first
	if($valuesArray["itemID"] == ""){
	$itemID 		= $_POST["itemID"];
	}
	else{$itemID = $valuesArray["itemID"];}
	
	if(!$itemID){
		$message = "Enter item ID and click search to edit a specific stock item.";
		$errorType = "info";
		displayHeader("Myshop: Stock Items");	
		displayAdminTemp("Stock");
		displayEditStockItem1($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();  exit;
	}
	$itemID = addslashes($itemID);			
	// Check if the item realy exist in the database before inserting
	$query = "SELECT * FROM stockitems WHERE itemID ='".$itemID."'";
	$result = sql_query($query, $message);
	
	if(mysql_num_rows($result) == 0) {
		$message = "Item With ID \"$itemID\" doesnt exit. Please enter a valid item ID"; 
		$errorType = "error";
		displayHeader("Myshop: Stock Items");	
		displayAdminTemp("Stock");
		displayEditStockItem1($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}
	else {
		$errorFlag=true;
		$row = mysql_fetch_array($result);
		
		
		echo $searchTerm;
		$valuesArray["stockID"]= htmlspecialchars(stripslashes($row["stockID"]));
		$valuesArray["itemID"]= htmlspecialchars(stripslashes($row["itemID"]));
		$valuesArray["serial"]= htmlspecialchars(stripslashes($row["serial"]));
		$valuesArray["description"]= htmlspecialchars(stripslashes($row["description"]));
		$valuesArray["quantity"]= htmlspecialchars(stripslashes($row["quantity"]));
		$valuesArray["price"]= htmlspecialchars(stripslashes($row["price"]));
		
		$message = "You can not change the item ID";
		$errorType = "warning";
		displayHeader("Myshop: Stock Items");	
		displayAdminTemp("Stock");
		displayEditStockItem2($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}
}
/*-------------------------------------------------------------------------------------------------------
/*--------------------------------------------------------------------------------------------------------
/**This function is the firrst processe of editing of a particular stock item given a particular stock ID
/*--------------------------------------------------------------------------------------------------------*/
function editStockItem3($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	$stockID 		= trim($_POST["stockID"]);
	$itemID 		= trim($_POST["itemID"]);
	$serial 		= trim($_POST["serial"]);
	$description 	= trim($_POST["description"]);
	$quantity 		= trim($_POST["quantity"]);
	$price 			= trim($_POST["price"]);
	$user			=$_SESSION['userName'];
	$date			= date("Y-m-d");
	$time			= date("H:i.s");
	
	$searchTerm 		= trim($_POST["searchTerm"]);
	$lowerLimit 		= trim($_POST["lowerLimit"]);
	if(!$stockID && !$serial && !$description && !$quantity && !$price){//check if the user is viewing this page from the right page
		$errorFlag = false;
		displayHeader("Myshop: Stock Items");	
		displayAdminTemp("Stock");
		displayEditStockItem2($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}
	$valid = stockItemVal($message,$errorArray,$valuesArray,$errorFlag);
	if($valid == true){
		$stockID 		= addslashes($stockID);
		$itemID 		= addslashes($itemID);
		$serial 		= addslashes($serial);
		$description 	= addslashes($description);
		$quantity 		= addslashes($quantity);
		$price 			= addslashes($price);
		$user			= addslashes($user);
		$date 			= addslashes($date);
		$time			= addslashes($time);
		
		
		// Check if the item really exist in the database before updating
		$query = "SELECT * FROM stockitems WHERE itemID ='".$itemID."'";
		$result = sql_query($query, $message);
		
		if(mysql_num_rows($result) == 1) {
		
			$query = "UPDATE stockitems SET stockID ='".$stockID."',itemID ='".$itemID."',serial ='".$serial."',description='";
			$query .= $description."',quantity ='".$quantity."',price='".$price."',user='".$user."',date='".$date."',time='".$time;
			$query .= "' WHERE	itemID ='".$itemID."'";
			
			$query1 = "UPDATE sales SET description ='".$description;
			$query1 .= "' WHERE itemID ='".$itemID."'";
			
			$result = sql_query($query, $message);
			$result1 = sql_query($query1, $message);
			
			$message = "Successfully saved";
			$errorType = "success";
			$valuesArray["query"] = "SELECT * FROM stockitems WHERE itemID ='".$itemID."'";
			$valuesArray["searchTerm"]= $searchTerm;
			$valuesArray["lowerLimit"] = $lowerLimit;
			displayHeader("Myshop: Stock Items");	
			displayAdminTemp("Stock");
			displayViewStockItems($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();
			exit;
		}
		else { 
			//Item doesnt exist in the database
			
			$message = "Item With ID \"$itemID\" doesnt exit. Please enter a different item ID"; 
			$errorType = "error";
			$errorArray["itemID"] = "";
			$valuesArray["$itemID"] = $itemID;
			$errorFlag=true;
			displayHeader("Myshop: Stock Items");	
			displayAdminTemp("Stock");
			displayEditStockItem2($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();
			exit;
		}
	}
	else{
		$message = "Please make sure that the marked fields are propery filled.";
		$errorType = "error";
		displayHeader("Myshop: Stock Items");	
		displayAdminTemp("Stock");
		displayEditStockItem2($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}	
}

/*-----------------------------------------------------------------------------------------------*/

function viewStockItems($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	//Retrieve the posted itemID first 
		$searchTerm 		= $_POST["searchTerm"];
		$stockID 			= $_POST["stockID"];
		$actualFormName 		= $_POST["actualFormName"];
		
		if(!$searchTerm ){
			$valuesArray["searchTerm"]= stripslashes($searchTerm);
			$valuesArray["stockID"]= stripslashes($stockID);
			if($actualFormName == "enterSales"){
				$message = "Please search for the item you want to sale";
				$errorType = "info";
				displayHeader("Myshop: Sales");	
				displayAdminTemp("Sales");
				displayEnterSales($message,$errorArray,$valuesArray,$errorFlag,$errorType);
				displayFooter();  exit;
			}
			else {
				if($actualFormName == "enterInstallment"){
					$message = "Please search for the item you want to put on installment";
					$errorType = "info";
					displayHeader("Myshop: Installments");	
					displayAdminTemp("Installments");
					displayEnterInstallment1($message,$errorArray,$valuesArray,$errorFlag,$errorType);
					displayFooter();  exit;
				}
				else {
					if($actualFormName == "stockItemHome"){
						$message = "Enter a search term to browse through  the stock list.";
						$errorType = "info";
						displayHeader("Myshop: Stock Items");	
						displayAdminTemp("Stock");
						displayStockHome($message,$errorArray,$valuesArray,$errorFlag,$errorType);
						displayFooter();  exit;
					}
					else{
						displayHeader("Myshop: Stock Items");	
						displayAdminTemp("Stock");
						displayViewStockItems($message,$errorArray,$valuesArray,$errorFlag,$errorType);
						displayFooter();  exit;
					}
				}
			}
		}
		else {
				$errorFlag=true;
				$valuesArray["query"]= $query;
				$valuesArray["searchTerm"]= stripslashes($searchTerm);
				$valuesArray["stockID"]= stripslashes($stockID);
				displayHeader("Myshop: Stock Items");	
				displayAdminTemp("Stock");
				displayViewStockItems($message,$errorArray,$valuesArray,$errorFlag,$errorType);
				displayFooter();
				exit;
		}
	
}


/******************************************************************************************/

function viewStockItemInfo($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	
	$valuesArray["searchTerm"]= stripslashes($valuesArray["searchTerm"]);
	$valuesArray["lowerLimit"] = $valuesArray["lowerLimit"] + 10;
//Retrieve the posted itemID first
	$itemID = addslashes($valuesArray["itemID"]);		
	// Check if the item realy exist in the database before inserting
	$query = "SELECT * FROM stockitems WHERE itemID ='".$itemID."'";
	$result = sql_query($query, $message);
	
	$errorFlag=true;
	$row = mysql_fetch_array($result);
	$valuesArray["stockID"]= htmlspecialchars(stripslashes($row["stockID"]));
	$valuesArray["itemID"]= htmlspecialchars(stripslashes($row["itemID"]));
	$valuesArray["serial"]= htmlspecialchars(stripslashes($row["serial"]));
	$valuesArray["description"]= htmlspecialchars(stripslashes($row["description"]));
	$valuesArray["quantity"]= htmlspecialchars(stripslashes($row["quantity"]));
	$valuesArray["price"]= htmlspecialchars(stripslashes($row["price"]));
	
	$valuesArray["user"]		= htmlspecialchars(stripslashes($row["user"]));
	$valuesArray["date"]		= htmlspecialchars(stripslashes($row["date"]));
	$valuesArray["time"]		= htmlspecialchars(stripslashes($row["time"]));

	displayHeader("Myshop: Stock Items");	
	displayAdminTemp("Stock");
	displayViewStockItemInfo($message,$errorArray,$valuesArray,$errorFlag,$errorType);
	displayFooter();
	exit;
}

function nextStockItems($message,$errorArray,$valuesArray,$errorFlag,$errorType){
		
	$errorFlag=true;
	$valuesArray["searchTerm"]= stripslashes($valuesArray["searchTerm"]);
	$valuesArray["stockID"]= stripslashes($valuesArray["stockID"]);
	$valuesArray["lowerLimit"] = $valuesArray["lowerLimit"];
	
	displayHeader("Myshop: Stock Items");	
	displayAdminTemp("Stock");
	displayViewStockItems($message,$errorArray,$valuesArray,$errorFlag,$errorType);
	displayFooter();
	exit;
}

function previousStockItems($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	$errorFlag=true;
	$valuesArray["searchTerm"]= stripslashes($valuesArray["searchTerm"]);
	$valuesArray["stockID"]= stripslashes($valuesArray["stockID"]);
	$valuesArray["lowerLimit"] = $valuesArray["lowerLimit"];
	displayHeader("Myshop: Stock Items");	
	displayAdminTemp("Stock");
	displayViewStockItems($message,$errorArray,$valuesArray,$errorFlag,$errorType);
	displayFooter();
	exit;
}

?>