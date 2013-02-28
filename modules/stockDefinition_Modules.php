<?php

/*---------------------------------------------------------------------------
/* This function process all the validatins for New Stock Definition Entry and Edit     */
/*----------------------------------------------------------------------------*/
function stockDefinitionVal(&$message,&$errorArray,&$valuesArray,&$errorFlag){
	$errorFlag =false;
	foreach ($_POST  as $key => $value){
		if(isset($key)&&($value == "") && ($key != "day") && ($key != "month") &&  ($key != "year") && ($key != "description")){
			$errorArray["$key"] = "*";
			$valuesArray["$key"] = "";
			$errorFlag = true;
		}
		else{
			$errorArray["$key"] = "";
			$valuesArray["$key"] = $value;
		}
		if($key == "stockID" && $value ==""){
			if(is_numeric($value)){
				$errorArray["$key"] = "";
				$valuesArray["$key"] = $value;
			}
			else{
			$errorArray["$key"] = "*";
			$valuesArray["$key"] = "";
			$errorFlag = true;
			}
		}
		else{
			$errorArray["$key"] = "";
			$valuesArray["$key"] = $value;
		}
		$day 	 		= $_POST["day"];
		$month	 		= $_POST["month"];
		$year 			= $_POST["year"];
		
		
		if(!checkdate($month, $day, $year)){
			$errorArray["year"] = "*";
			$errorFlag = true;
		}
	}
	
	return true;
}

/*---------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------
/* This function process the entry of a new stock Definition				  */
/*----------------------------------------------------------------------------*/
function newStockDefinition($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	$stockID 		= $_POST["stockID"];
	$day 	 		= $_POST["day"];
	$month	 		= $_POST["month"];
	$year 			= $_POST["year"];
	$description 	= $_POST["description"];
	$user			=$_SESSION['userName'];
	$date			= date("Y-m-d");
	$time			= date("H:i.s");
	
	
	if(!$stockID && !$day && !$month && !$description && !$year && !$price){//check if the user is viewing this page from the right page
		$errorFlag = false;
		displayHeader("Myshop: Stock Definitions");	
		displayAdminTemp("Home");
		displayNewStockDefinition($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}

	$valid = stockDefinitionVal($message,$errorArray,$valuesArray,$errorFlag);
	if($valid == true){
		$stockID = addslashes($stockID);
		$stockDate = addslashes($year."-".$month."-".$day);
		$description = addslashes($description);
		
		// Check if the item already exist in the database before inserting
		$query = "SELECT * FROM stock WHERE stockID ='".$stockID."' OR stockDate = '".$stockDate."'";
		$result = sql_query($query, $message);
	
		if(mysql_num_rows($result) == 1) {
			$message = "Stock Definition for specified date already entered. Please enter a different date"; 
			$errorType = "error";
			displayHeader("Myshop: Stock Definitions");	
			displayAdminTemp("Home");
			displayNewStockDefinition($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();
			exit;
		}
		else { 
			//Insert values into database
			$query = "INSERT INTO stock (stockID, stockDate, description, user, date, time) ";
			$query .= "VALUES ('".$stockID."','".$stockDate."','".$description."','".$user."','".$date."','".$time."')";
			
			$result = sql_query($query, $message);
			
			$message = "Stock Definition with ID ".$stockID." saved successfully";
			$errorType = "success";
			displayHeader("Myshop: Stock Definitions");	
			displayAdminTemp("Home");
			displayViewStockDefinitions($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();
			exit;
		}
	}
	else{
		$message = "Please make sure that the marked fields are propery filled.";
		$errorType = "error";
		displayHeader("Myshop: Stock Definitions");	
		displayAdminTemp("Home");
		displayNewStockDefinition($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}	
}

/*-----------------------------------------------------------------------------------------------*/
function editStockDefinition1($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	//Retrieve the posted itemID first
		if($valuesArray["stockID"] ==""){ $stockID 		= $_POST["stockID"];}
		else { $stockID = $valuesArray["stockID"];}
		if(!$stockID){
			$message = "Enter stock ID and click searchTerm to edit a specific stock definition.";
			$errorType = "info";
			displayHeader("Myshop: Stock Definitions");	
			displayAdminTemp("Home");
			displayEditStockDefinition1($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();  exit;
		}
		$valid = stockItemVal($message,$errorArray,$valuesArray,$errorFlag);
		if($valid == true){
			$stockID 		= addslashes($stockID);
			// Check if the item realy exist in the database before inserting
			$query = "SELECT * FROM stock WHERE stockID ='".$stockID."'";
			$result = sql_query($query, $message);
			
			if(mysql_num_rows($result) == 0) {
				$message = "Stock Definition With ID ".$stockID." doesn't exit. Please enter a valid Stock ID"; 
				$errorType = "error";
				displayHeader("Myshop: Stock Definitions");	
				displayAdminTemp("Home");
				displayEditStockDefinition1($message,$errorArray,$valuesArray,$errorFlag,$errorType);
				displayFooter();
				exit;
			}
			else {
				$errorFlag=true;
				$row = mysql_fetch_array($result);
				$valuesArray["stockID"]= htmlspecialchars(stripslashes($row["stockID"]));
				$stockDate= htmlspecialchars(stripslashes($row["stockDate"]));
				$valuesArray["year"]= substr($stockDate, 0 , 4);
				$valuesArray["month"]= substr($stockDate, 5 , 2);
				$valuesArray["day"]= substr($stockDate, 8 , 2);
				$valuesArray["description"]= htmlspecialchars(stripslashes($row["description"]));
			
				
				$message = "You can not change the stock ID";
				$errorType = "warning";
				displayHeader("Myshop: Stock Definitions");	
				displayAdminTemp("Home");
				displayEditStockDefinition2($message,$errorArray,$valuesArray,$errorFlag,$errorType);
				displayFooter();
				exit;
			}
	}
	else{
		$message = "Please make sure that the marked fields are propery filled.";
		$errorType = "error";
		displayHeader("Myshop: Stock Definitions");	
		displayAdminTemp("Home");
		displayEditStockDefinition1($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}	
}
/*-------------------------------------------------------------------------------------------------------*/

function editStockDefinition2($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	$stockID 		= $_POST["stockID"];
	$day 	 		= $_POST["day"];
	$month	 		= $_POST["month"];
	$year 			= $_POST["year"];
	$description 	= $_POST["description"];
	$user			=$_SESSION['userName'];
	$date			= date("Y-m-d");
	$time			= date("H:i.s");
	
	
	if(!$stockID && !$day && !$month && !$description && !$year && !$price){//check if the user is viewing this page from the right page
		$errorFlag = false;
		displayHeader("Myshop: Stock Definition Edit");	
		displayAdminTemp("Home");
		displayNewStockDefinition($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}

	$valid = stockDefinitionVal($message,$errorArray,$valuesArray,$errorFlag);
	if($valid == true){
		$stockID = addslashes($stockID);
		$stockDate = addslashes($year."-".$month."-".$day);
		$description = addslashes($description);
		
		// Check if the item already exist in the database before inserting
			//Insert values into database
			
		$query = "UPDATE stock SET stockID ='".$stockID."',stockDate ='".$stockDate."',description ='".$description."',user='";
		$query .= $user."',date='".$date."',time='".$time;
		$query .= "' WHERE	stockID ='".$stockID."'";
			
		
		$result = sql_query($query, $message);
	
		$message = "Stock Definition with ID ".$stockID." saved successfully";
		$errorType = "success";
		displayHeader("Myshop: Stock Definitions");	
		displayAdminTemp("Home");
		displayViewStockDefinitions($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}

	else{
		$message = "Please make sure that the marked fields are propery filled.";
		$errorType = "error";
		displayHeader("Myshop: Stock Definitions");	
		displayAdminTemp("Home");
		displayEditStockDefinition2($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}	
}

/*-----------------------------------------------------------------------------------------------*/

/******************************************************************************************/

function viewStockDefinitionInfo($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	
	$valuesArray["searchTerm"]	=stripslashes($valuesArray["searchTerm"]);
	$valuesArray["year"]		=stripslashes($valuesArray["year"]);
	$valuesArray["month"]		=stripslashes($valuesArray["month"]);
	$valuesArray["lowerLimit"] = $valuesArray["lowerLimit"] + 10;
//Retrieve the posted itemID first
	$stockID = addslashes($valuesArray["stockID"]);		
	// Check if the item realy exist in the database before inserting
	$query = "SELECT * FROM stock WHERE stockID ='".$stockID."'";
	$result = sql_query($query, $message);
	
	$errorFlag=true;
	$row = mysql_fetch_array($result);
	$valuesArray["stockID"]= htmlspecialchars(stripslashes($row["stockID"]));
	$stockDate= htmlspecialchars(stripslashes($row["stockDate"]));
	$valuesArray["stockDate"] = $stockDate;
	$valuesArray["year"]= substr($stockDate, 0 , 4);
	$valuesArray["month"]= substr($stockDate, 5 , 2);
	$valuesArray["day"]= substr($stockDate, 8 , 2);
	$valuesArray["description"]= htmlspecialchars(stripslashes($row["description"]));
	
	$valuesArray["user"]		= htmlspecialchars(stripslashes($row["user"]));
	$valuesArray["date"]		= htmlspecialchars(stripslashes($row["date"]));
	$valuesArray["time"]		= htmlspecialchars(stripslashes($row["time"]));
	
	
	displayHeader("Myshop: Stock Definitions");	
	displayAdminTemp("Home");
	displayViewStockDefinitionInfo($message,$errorArray,$valuesArray,$errorFlag,$errorType);
	displayFooter();
	exit;
}

function viewStockDefinitions($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	//Retrieve the posted itemID first 
		$searchTerm 		= $_POST["searchTerm"];
		$stockID 			= $_POST["stockID"];
		$actualFormName 		= $_POST["actualFormName"];
		if(!$searchTerm ){
			displayHeader("Myshop: Stock Definitions");	
			displayAdminTemp("Home");
			displayViewStockDefinitions($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();  exit;
					
		}
		else {
			$errorFlag=true;
			$valuesArray["query"]= $query;
			$valuesArray["searchTerm"]= stripslashes($searchTerm);
			$valuesArray["stockID"]= stripslashes($stockID);
			displayHeader("Myshop: Stock Definitions");	
			displayAdminTemp("Home");
			displayViewStockDefinitions($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();
			exit;
		}
}


/******************************************************************************************/
function nextStockDefinition($message,$errorArray,$valuesArray,$errorFlag,$errorType){
		
	$errorFlag=true;
	$valuesArray["searchTerm"]	=stripslashes($valuesArray["searchTerm"]);
	$valuesArray["year"]		=stripslashes($valuesArray["year"]);
	$valuesArray["month"]		=stripslashes($valuesArray["month"]);
	$valuesArray["lowerLimit"] = $valuesArray["lowerLimit"];
	
	displayHeader("Myshop: Stock Definitions");	
	displayAdminTemp("Home");
	displayViewStockDefinitions($message,$errorArray,$valuesArray,$errorFlag,$errorType);
	displayFooter();
	exit;
}

function previousStockDefinition($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	$errorFlag=true;
	$valuesArray["searchTerm"]	=stripslashes($valuesArray["searchTerm"]);
	$valuesArray["year"]		=stripslashes($valuesArray["year"]);
	$valuesArray["month"]		=stripslashes($valuesArray["month"]);
	$valuesArray["lowerLimit"] = $valuesArray["lowerLimit"];
	displayHeader("Myshop: Stock Definitions");	
	displayAdminTemp("Home");
	displayViewStockDefinitions($message,$errorArray,$valuesArray,$errorFlag,$errorType);
	displayFooter();
	exit;
}

?>