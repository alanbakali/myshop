<?php

/*---------------------------------------------------------------------------
/* This function process all the validatins for Stock Item Entry and Edit     */
/*----------------------------------------------------------------------------*/
function serviceVal(&$message,&$errorArray,&$valuesArray,&$errorFlag){
	$errorFlag =false;
	foreach ($_POST  as $key => $value){
		if(($key == "frmName") || ($key == "serial") || ($key == "address") || ($key == "diagnosis") || ($key == "initialAmount") || ($key == "serviceID")){
			$errorArray["$key"] = "";
			$valuesArray["$key"] = $value;
		}
		else{
			if(isset($key) && ($value =="") && (($key == "customerName") || ($key == "title") || ($key == "problem") || ($key == "recieptNumber") || ($key == "item"))){
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
			
			
			if(($key == "charges") || ($key == "amount") || ($key == "payment") || ($key == "serviceID")){
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
		}
		if(($_POST["title"] !="Mr") && ($_POST["title"] !="Mrs") && ($_POST["title"] !="Miss")){
			$errorArray["title"] = "<font color=\"#EE2020\">*</font>";
			$valuesArray["$title"] = "";
			$errorFlag = true;
		}
		
	}
	return !($errorFlag);
}

/*---------------------------------------------------------------------------/
/* This function process the entry of a service provided to a customer*********/
/*----------------------------------------------------------------------------*/
function enterService($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	$serviceID	 		= trim($_POST["serviceID"]);
	$item	 			= trim($_POST["item"]);
	$serial 			= trim($_POST["serial"]);
	$problem 			= trim($_POST["problem"]);
	$diagnosis 			= trim($_POST["diagnosis"]);
	$charges	 		= trim($_POST["charges"]);
	
	$title 				= trim($_POST["title"]);
	$customerName 		= trim($_POST["customerName"]);
	$address 			= trim($_POST["address"]);
	$phone 				= trim($_POST["phone"]);
	$email 				= trim($_POST["email"]);
	
	
	$user				=$_SESSION['userName'];
	$date				= date("Y-m-d");
	$time				= date("H:i.s");
	
	
	
	if(!$item && !$serial && !$title && !$customerName && !$address && !$phone && !$email && !$problem  && !$charges){
		
		displayHeader("Myshop: Services");	
		displayAdminTemp("Services");
		displayEnterService($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}
	
	$valid = serviceVal($message,$errorArray,$valuesArray,$errorFlag);
	if($valid == true){
		$serviceID			= addslashes($serviceID);
		$item 				= addslashes($item);
		$serial 			= addslashes($serial);
		$problem 			= addslashes($problem);
		$diagnosis 			= addslashes($diagnosis);
		$charges 			= addslashes($charges);
		
		$title 				= addslashes($title);
		$customerName 		= addslashes($customerName);
		$address	 		= addslashes($address);
		$phone 				= addslashes(str_replace(" ", "", $phone));
		$email 				= addslashes($email);
		
		
		$user				= addslashes($user);
		$date 				= addslashes($date);
		$time				= addslashes($time);
		
		// Check if already entered
		$query1 = "SELECT * FROM services WHERE serviceID ='".$serviceID."'";
		
		$result = sql_query($query1, $message);
		if(mysql_num_rows($result) > 0 ) {
			$message = "Item already entered";
			$errorType = "error";
			displayHeader("Myshop: Services");	
			displayAdminTemp("Services");
			displayEnterService($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();
			exit;
		}
		else {
				//Insert values into database
					
			$query = "INSERT INTO services (serviceID, item, serial, problem, diagnosis, charges, title,";
			$query .= "customerName, address, phone, email, user, date, time) ";
			$query .= "VALUES ('".$serviceID."','".$item."','".$serial."','".$problem."','".$diagnosis."','".$charges;
			$query .= "','".$title."','".$customerName."','".$address."','".$phone."','".$email."','".$user."','".$date."','".$time."')";
				
			$result = sql_query($query, $message);
			
			$message = "Successfully saved";
			$errorType = "success";
			$valuesArray["query"] = $query1;
			displayHeader("Myshop: Services");	
			displayAdminTemp("Services");
			displayViewServices($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();
			exit;
		}
	}
		
	else {	
			
		$message = "Please make sure that the marked fields are propery filled.";
		$errorType = "error";
		displayHeader("Myshop: Services");	
		displayAdminTemp("Services");
		displayEnterService($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}	
}


/*-----------------------------------------------------------------------------------------------------------------
/*This function is the firrst processe of editing of a particular stock item given a particular stock ID
/*----------------------------------------------------------------------------------------------------------------*/

function editService1($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	//Retrieve the posted item first
		if($valuesArray["serviceID"] == ""){
		$serviceID 		= $_POST["serviceID"];
		}
		else{$serviceID = $valuesArray["serviceID"];}
		
		
		if(!$serviceID){
			$message = "Enter Service ID and click Go to edit a specific service entry.";
			$errorType = "info";
			displayHeader("Myshop: Services");	
			displayAdminTemp("Services");
			displayViewServices($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();  exit;
		}
		$serviceID = str_replace(" ", "", $serviceID);
		if(is_numeric($serviceID)){
			$serviceID 	= addslashes($serviceID);
			// Check if the item realy exist in the database before inserting
			$query = "SELECT * FROM services WHERE serviceID ='".$serviceID."'";
			$result = sql_query($query, $message);
			
			if(mysql_num_rows($result) == 0) {
				$message = "Please make sure you have entered a valid Service ID"; 
				$errorType = "error";
				displayHeader("Myshop: Services");	
				displayAdminTemp("Services");
				displayViewServices($message,$errorArray,$valuesArray,$errorFlag,$errorType);
				displayFooter();
				exit;
			}
			else {
				$errorFlag = true;	
				$row = mysql_fetch_array($result);
				
				$valuesArray["serviceID"]			= htmlspecialchars(stripslashes($row["serviceID"]));
				$valuesArray["item"]				= htmlspecialchars(stripslashes($row["item"]));
				$valuesArray["serial"]				= htmlspecialchars(stripslashes($row["serial"]));
				$valuesArray["problem"]				= htmlspecialchars(stripslashes($row["problem"]));
				$valuesArray["diagnosis"]			= htmlspecialchars(stripslashes($row["diagnosis"]));
				$valuesArray["charges"]				= htmlspecialchars(stripslashes($row["charges"]));
				
				$valuesArray["customerName"]		= htmlspecialchars(stripslashes($row["customerName"]));
				$valuesArray["title"]				= htmlspecialchars(stripslashes($row["title"]));
				$valuesArray["phone"]				= htmlspecialchars(stripslashes($row["phone"]));
				$valuesArray["email"]				= htmlspecialchars(stripslashes($row["email"]));
				$valuesArray["address"]				= htmlspecialchars(stripslashes($row["address"]));
								
				$message = "You can not change the Service ID";
				$errorType = "warning";
				displayHeader("Myshop: Services");	
				displayAdminTemp("Services");
				displayEditService($message,$errorArray,$valuesArray,$errorFlag,$errorType);
				displayFooter();
				exit;
			}
		}
		else{
			$errorFlag = true;
			$message = "Please make sure you have entered a valid Service ID.";
			$errorType = "error";
			displayHeader("Myshop: Services");	
			displayAdminTemp("Services");
			displayViewServices($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();
			exit;
		
		}
}
/*-------------------------------------------------------------------------------------------------------
/*--------------------------------------------------------------------------------------------------------
/**This function is the firrst processe of editing of a particular stock item given a particular stock ID
/*--------------------------------------------------------------------------------------------------------*/
function editService2($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	$serviceID 			= trim($_POST["serviceID"]);
	$item	 			= trim($_POST["item"]);
	$serial 			= trim($_POST["serial"]);
	$problem 			= trim($_POST["problem"]);
	$charges	 		= trim($_POST["charges"]);
	
	$title 				= trim($_POST["title"]);
	$customerName 		= trim($_POST["customerName"]);
	$address 			= trim($_POST["address"]);
	$phone 				= trim($_POST["phone"]);
	$email 				= trim($_POST["email"]);
	
	
	$user				=$_SESSION['userName'];
	$date				= date("Y-m-d");
	$time				= date("H:i.s");
	
	
	
	if(!$item && !$serial && !$title && !$customerName && !$address && !$phone && !$email && !$problem  && !$charges){
		displayHeader("Myshop: Services");	
		displayAdminTemp("Services");
		displayEditService($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}
	
	$valid = serviceVal($message,$errorArray,$valuesArray,$errorFlag);
	if($valid == true){
		$serviceID 			= addslashes($serviceID);
		$item 				= addslashes($item);
		$serial 			= addslashes($serial);
		$problem 			= addslashes($problem);
		$charges 			= addslashes($charges);
		
		$title 				= addslashes($title);
		$customerName 		= addslashes($customerName);
		$address	 		= addslashes($address);
		$phone 				= addslashes(str_replace(" ", "", $phone));
		$email 				= addslashes($email);
		
		
		$user				= addslashes($user);
		$date 				= addslashes($date);
		$time				= addslashes($time);
		
		// Check if already entered
		$query1 = "SELECT * FROM services WHERE serviceID ='".$serviceID."'";
		
		$result = sql_query($query1, $message);
		if(mysql_num_rows($result) != 1 ) {
			$message = "Please make sure you have entered a valid service ID.";
			$errorType = "error";
			displayHeader("Myshop: Services");	
			displayAdminTemp("Services");
			displayEditService($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();
			exit;
		}
		else {
				//Insert values into database
			
			//Insert values into database
			$query = "UPDATE services SET serviceID ='".$serviceID."',item ='".$item."',serial ='".$serial."',problem ='".$problem."',diagnosis ='".$diagnosis;
			$query .= "',charges ='".$charges."',title ='".$title."',customerName ='".$customerName."',address ='".$address;
			$query .= "',phone ='".$phone."',email ='".$email."',user ='".$user."',date ='".$date."',time ='".$time;
			$query .= "' WHERE	serviceID ='".$serviceID."'";		
			
						
			$result = sql_query($query, $message);
						
			$message = "Successfully saved";
			$errorType = "success";
			$valuesArray["query"] = $query1;
			displayHeader("Myshop: Services");	
			displayAdminTemp("Services");
			displayViewServices($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();
			exit;
		}
	}
		
	else {	
			
		$message = "Please make sure that the marked fields are propery filled.";
		$errorType = "error";
		displayHeader("Myshop: Services");	
		displayAdminTemp("Services");
		displayEnterService($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}	
}


/******************************************************************************************/

function viewServiceInfo($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	
	$valuesArray["searchTerm"]	=stripslashes($valuesArray["searchTerm"]);
	$valuesArray["year"]		=stripslashes($valuesArray["year"]);
	$valuesArray["month"]		=stripslashes($valuesArray["month"]);
	$valuesArray["lowerLimit"] 	= $valuesArray["lowerLimit"];
	$serviceID 				= addslashes($valuesArray["serviceID"]);

	// Check if the item realy exist in the database before inserting
	$query = "SELECT * FROM services WHERE serviceID ='".$serviceID."'";
	$result = sql_query($query, $message);

	$errorFlag=true;
	$row = mysql_fetch_array($result);
	
	$valuesArray["serviceID"]			= htmlspecialchars(stripslashes($row["serviceID"]));
	$valuesArray["item"]				= htmlspecialchars(stripslashes($row["item"]));
	$valuesArray["serial"]				= htmlspecialchars(stripslashes($row["serial"]));
	$valuesArray["problem"]				= htmlspecialchars(stripslashes($row["problem"]));
	$valuesArray["diagnosis"]			= htmlspecialchars(stripslashes($row["diagnosis"]));
	$valuesArray["charges"]				= htmlspecialchars(stripslashes($row["charges"]));
	
	$valuesArray["customerName"]		= htmlspecialchars(stripslashes($row["customerName"]));
	$valuesArray["title"]				= htmlspecialchars(stripslashes($row["title"]));
	$valuesArray["phone"]				= htmlspecialchars(stripslashes($row["phone"]));
	$valuesArray["email"]				= htmlspecialchars(stripslashes($row["email"]));
	$valuesArray["address"]				= htmlspecialchars(stripslashes($row["address"]));
	
	$valuesArray["user"]		= htmlspecialchars(stripslashes($row["user"]));
	$valuesArray["date"]		= htmlspecialchars(stripslashes($row["date"]));
	$valuesArray["time"]		= htmlspecialchars(stripslashes($row["time"]));
	
	displayHeader("Myshop: Services");	
	displayAdminTemp("Services");
	displayViewServiceInfo($message,$errorArray,$valuesArray,$errorFlag,$errorType);
	displayFooter();
	exit;
}

/**********************************************************************************************************************/
function paymentServices1($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	$valuesArray["searchTerm"]	=stripslashes($valuesArray["searchTerm"]);
	$valuesArray["year"]		=stripslashes($valuesArray["year"]);
	$valuesArray["month"]		=stripslashes($valuesArray["month"]);
	$serviceID 					= stripslashes($valuesArray["serviceID"]);
	
	if(is_numeric($serviceID)){
		$serviceID 			= addslashes($serviceID);
	
		$query  = "SELECT * FROM services WHERE serviceID ='".$serviceID."'";
		$result = sql_query($query, $message);
	
		if(mysql_num_rows($result) == 0) {
			$message = "Please make sure you have entered a valid Service ID"; 
			$errorType = "error";
			displayHeader("Myshop:  Services");	
			displayAdminTemp("Services");
			displayViewServices($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();
			exit;
		}
		else {
			$errorFlag=true;
			$row = mysql_fetch_array($result);
			
			$valuesArray["item"]			= htmlspecialchars(stripslashes($row["item"]));
			
			$valuesArray["customerName"]		= htmlspecialchars(stripslashes($row["customerName"]));
			$valuesArray["address"]				= htmlspecialchars(stripslashes($row["address"]));
			$valuesArray["title"]				= htmlspecialchars(stripslashes($row["title"]));
			$valuesArray["phone"]				= htmlspecialchars(stripslashes($row["phone"]));
			$valuesArray["email"]				= htmlspecialchars(stripslashes($row["email"]));
			
			$valuesArray["serviceID"]			= htmlspecialchars(stripslashes($row["serviceID"]));
			$valuesArray["charges"]				= htmlspecialchars(stripslashes($row["charges"]));
			$valuesArray["balance"]				= htmlspecialchars(stripslashes($row["balance"]));
			$valuesArray["initialAmount"]		= htmlspecialchars(stripslashes($row["amount"]));
			
			
			displayHeader("Myshop: Services");	
			displayAdminTemp("Services");
			displayPaymentServices($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();
			exit;
		}
	}
	else{
		$errorFlag = true;
		$message = "Please make sure you have entered a valid Service ID.";
		$errorType = "error";
		displayHeader("Myshop: Services");	
		displayAdminTemp("Services");
		displayViewServices($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	
	}
}


function paymentServices2($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	$item 			= trim($_POST["item"]);
	$charges 		= trim($_POST["charges"]);
	$initialAmount	= trim($_POST["initialAmount"]);
	
	$title 				= trim($_POST["title"]);
	$customerName 		= trim($_POST["customerName"]);
	$address 			= trim($_POST["address"]);
	$phone 				= trim($_POST["phone"]);
	$email 				= trim($_POST["email"]);
	
	$serviceID 			= trim($_POST["serviceID"]);
	$payment 			= trim($_POST["payment"]);
	$lastPayment 		= trim($_POST["lastPayment"]);
	$recieptNumber 		= trim($_POST["recieptNumber"]);
	
	$user				=$_SESSION['userName'];
	$date				= date("Y-m-d");
	
	
	if(!$payment &&  !$recieptNumber){
		$valuesArray["item"] 			= $item;
		$valuesArray["charges"] 	= $charges;
		$valuesArray["initialAmount"] = $initialAmount;
		
		$valuesArray["title"] 			= $title;
		$valuesArray["customerName"]	= $customerName;
		$valuesArray["address"]			= $address;
		$valuesArray["phone"] 			= $phone;
		$valuesArray["email"] 			= $email;
		
		$valuesArray["serviceID"]		= $serviceID;
		$valuesArray["payment"]			= $payment;
		$valuesArray["recieptNumber"] 	= $recieptNumber;
		
		displayHeader("Myshop: Services");	
		displayAdminTemp("Services");
		displayPaymentServices($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}
	
	if(serviceVal($message,$errorArray,$valuesArray,$errorFlag)){
		$item 				= addslashes($item);
		$charges 			= addslashes($charges);
		$initialAmount	 	= addslashes($initialAmount);
		
		$title 				= addslashes($title);
		$customerName 		= addslashes($customerName);
		$address	 		= addslashes($address);
		$phone 				= addslashes(str_replace(" ", "", $phone));
		$email 				= addslashes($email);
		
		$serviceID 			= addslashes(str_replace(" ", "", $serviceID));
		$payment 			= addslashes(str_replace(" ", "", $payment));
		$recieptNumber		= addslashes(str_replace(" ", "", $recieptNumber));
		
		$user				= addslashes($user);
		$date 				= addslashes($date);
		
		
		$query = "UPDATE services SET amount ='".$payment."',recieptNumber ='".$recieptNumber."',status ='Successful',paymentDate ='".$date;
		$query .= "' WHERE serviceID ='".$serviceID."'";
	
		$result = sql_query($query, $message);
		
		$message = "Succeesfully saved";
		
		$errorType = "success";
		$valuesArray["query"] = "SELECT * FROM services WHERE serviceID ='".$serviceID."'";
		displayHeader("Myshop: Services List");	
		displayAdminTemp("Services");
		displayViewServices($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}
		
	else {	
		$errorFlag = true;
		$message = "Please make sure that the marked fields are propery filled.";
		$errorType = "error";
		displayHeader("Myshop: Services");	
		displayAdminTemp("Services");
		displayPaymentServices($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}	
}


/******************************************************************************************/
function nextServices($message,$errorArray,$valuesArray,$errorFlag,$errorType){
		
	$errorFlag=true;
	$valuesArray["searchTerm"]	=stripslashes($valuesArray["searchTerm"]);
	$valuesArray["year"]		=stripslashes($valuesArray["year"]);
	$valuesArray["month"]		=stripslashes($valuesArray["month"]);
	
	$valuesArray["lowerLimit"] = $valuesArray["lowerLimit"];
	displayHeader("Myshop: Services");	
	displayAdminTemp("Services");
	displayViewServices($message,$errorArray,$valuesArray,$errorFlag,$errorType);
	displayFooter();
	exit;
}

function previousServices($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	$errorFlag=true;
	$valuesArray["searchTerm"]	=stripslashes($valuesArray["searchTerm"]);
	$valuesArray["year"]		=stripslashes($valuesArray["year"]);
	$valuesArray["month"]		=stripslashes($valuesArray["month"]);
	
	$valuesArray["lowerLimit"] = $valuesArray["lowerLimit"];
	displayHeader("Myshop: Services");	
	displayAdminTemp("Services");
	displayViewServices($message,$errorArray,$valuesArray,$errorFlag,$errorType);
	displayFooter();
	exit;
}

/*****************************************************************************************************/

function cancelService($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	$valuesArray["searchTerm"]	=stripslashes($valuesArray["searchTerm"]);
	$valuesArray["year"]		=stripslashes($valuesArray["year"]);
	$valuesArray["month"]		=stripslashes($valuesArray["month"]);
	$valuesArray["lowerLimit"] 	= $valuesArray["lowerLimit"];
	$serviceID 				= addslashes($valuesArray["serviceID"]);
	
	// Check if the item realy exist in the database before inserting
	$query = "SELECT * FROM services WHERE serviceID ='".$serviceID."'";
	$result = sql_query($query, $message);
	
	if(mysql_num_rows($result) == 0) {
		$message = "Please make sure you have entered a valid Service ID."; 
		$errorType = "error";
		displayHeader("Myshop: Services");	
		displayAdminTemp("Services");
		displayViewServices($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}
	else {
		$errorFlag=true;
		$row = mysql_fetch_array($result);
		
		$item= htmlspecialchars(stripslashes($row["item"]));
		
		$query2  = "SELECT * FROM stockItems WHERE item ='".$item."'";
		$result2 = sql_query($query2, $message);
		
		if(mysql_num_rows($result2) == 0) {
			$message = "Please make sure you have entered a valid Service ID.";
			$errorType = "error";
			displayHeader("Myshop: Services");	
			displayAdminTemp("Services");
			displayViewServices($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();
			exit;
		}
		else {
				$errorFlag=true;
				$row2 = mysql_fetch_array($result2);
				
				$valuesArray["item"]			= htmlspecialchars(stripslashes($row["item"]));
				$valuesArray["problem"]		= htmlspecialchars(stripslashes($row2["problem"]));
				$valuesArray["serial"]			= htmlspecialchars(stripslashes($row2["serial"]));
				$valuesArray["charges"]	= htmlspecialchars(stripslashes($row2["quantity"]));
				
				$valuesArray["customerName"]		= htmlspecialchars(stripslashes($row["customerName"]));
				$valuesArray["address"]				= htmlspecialchars(stripslashes($row["address"]));
				$valuesArray["title"]				= htmlspecialchars(stripslashes($row["title"]));
				$valuesArray["phone"]				= htmlspecialchars(stripslashes($row["phone"]));
				$valuesArray["email"]				= htmlspecialchars(stripslashes($row["email"]));
				
				$valuesArray["serviceID"]		= htmlspecialchars(stripslashes($row["serviceID"]));
				$valuesArray["firstPayment"]		= htmlspecialchars(stripslashes($row["firstPayment"]));
				$valuesArray["lastPayment"]			= htmlspecialchars(stripslashes($row["lastPayment"]));
				$valuesArray["totalCostPrice"]		= htmlspecialchars(stripslashes($row["totalCostPrice"]));
				$valuesArray["balance"]				= htmlspecialchars(stripslashes($row["balance"]));
				$valuesArray["recieptNumber"]		= htmlspecialchars(stripslashes($row["recieptNumber"]));
				$valuesArray["recieptNumber2"]		= htmlspecialchars(stripslashes($row["recieptNumber2"]));
				$valuesArray["initialQuantity"]		= htmlspecialchars(stripslashes($row["quantity"]));
				
				
				$message = "There must be a valid reason to cancel this service";
				$errorType = "warning";
				displayHeader("Myshop: Services");	
				displayAdminTemp("Services");
				displayCancelService($message,$errorArray,$valuesArray,$errorFlag,$errorType);
				displayFooter();
				exit;
		}
	}
}
/*****************************************************************************************************/


function viewServices($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	//Retrieve the posted item first
		$searchTerm 		= $_POST["searchTerm"];
		$month		 		= $_POST["month"];
		$year 				= $_POST["year"];
		$actualFormName 	= $_POST["actualFormName"];
		if((!$searchTerm)){
			$valuesArray["month"]= $month;
			$valuesArray["year"]= $year;
			if($actualFormName == "servicesHome"){
				$message = "Enter a search term to browse through  the services list.";
				$errorType = "info";
				displayHeader("Myshop: Services");	
				displayAdminTemp("Services");
				displayServicesHome($message,$errorArray,$valuesArray,$errorFlag,$errorType);
				displayFooter();  exit;
			}
			else {
				displayHeader("Myshop: Services");	
				displayAdminTemp("Services");
				displayViewServices($message,$errorArray,$valuesArray,$errorFlag,$errorType);
				displayFooter();  exit;
			}
		}
		else {
				$errorFlag=true;
				$valuesArray["month"]= $month;
				$valuesArray["year"]= $year;
				$valuesArray["searchTerm"]= stripslashes($searchTerm);
				displayHeader("Myshop: Services");	
				displayAdminTemp("Services");
				displayViewServices($message,$errorArray,$valuesArray,$errorFlag,$errorType);
				displayFooter();
				exit;
		}
	
}

/******************************************************************************************************************/

function cancelService2($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	$serviceID 		= trim($_POST["serviceID"]);
	$reason 			= trim($_POST["reason"]);
	$initialQuantity 	= trim($_POST["initialQuantity"]);//The number of items initially bought
	$quantity 			= trim($_POST["quantity"]); //The number of items returned
	$amount 			= trim($_POST["amount"]); // The amount of money returned to the customer
	
	$user				=$_SESSION['userName'];
	$date				= date("Y-m-d");
	$time				= date("H:i.s");
	
	$item 				= trim($_POST["item"]);
	$problem 			= trim($_POST["problem"]);
	
	$title 					= trim($_POST["title"]);
	$customerName 			= trim($_POST["customerName"]);
	$address 				= trim($_POST["address"]);
	$phone 					= trim($_POST["phone"]);
	
	$totalCostPrice 		= trim($_POST["totalCostPrice"]);
	$firstPayment 			= trim($_POST["firstPayment"]);
	$balance 				= trim($_POST["balance"]);
	$recieptNumber 			= trim($_POST["recieptNumber"]);
	
	if(!$serviceID && !$reason && !$initialQuantity && !$quantity && !$amount){
		
		displayHeader("Myshop: Services");	
		displayAdminTemp("Services");
		displayCancelService($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}
	
	$valid = serviceVal($message,$errorArray,$valuesArray,$errorFlag);
	if($valid == true){
		$reason 			= addslashes($reason);
		$initialQuantity 	= addslashes($initialQuantity);
		$serviceID 		= addslashes(str_replace(" ", "", $serviceID));
		$item 			= addslashes(str_replace(" ", "", $item));

		
		$quantity 			= addslashes(str_replace(" ", "", $quantity));
		$amount 			= addslashes(str_replace(" ", "", $amount));
		
		$user				= addslashes($user);
		$date 				= addslashes($date);
		$time				= addslashes($time);
		
		$newFirstPayment    = $firstPayment - $amount;
		
		// Check if there are enough items in stock
		$query = "SELECT * FROM services WHERE serviceID ='".$serviceID."'";
		$result = sql_query($query, $message);

		$row = mysql_fetch_array($result);
		$serviceQuantity = htmlspecialchars(stripslashes($row["quantity"]));
		if(($quantity < 1) || ($quantity > $serviceQuantity)){
			
			$valuesArray["item"] 			= $item;
			$valuesArray["problem"] 	= $problem;
			$valuesArray["reason"] 			= $reason;
			$valuesArray["initialQuantity"] = $initialQuantity;
			
			$valuesArray["amount"] 			= $amount;
			$valuesArray["customerName"]		= htmlspecialchars(stripslashes($row["customerName"]));
			$valuesArray["title"]				= htmlspecialchars(stripslashes($row["title"]));
			$valuesArray["phone"]				= htmlspecialchars(stripslashes($row["phone"]));
			$valuesArray["email"]				= htmlspecialchars(stripslashes($row["email"]));
			
			$valuesArray["serviceID"]		= htmlspecialchars(stripslashes($row["serviceID"]));
			$valuesArray["totalCostPrice"]		= htmlspecialchars(stripslashes($row["totalCostPrice"]));
			$valuesArray["firstPayment"]		= htmlspecialchars(stripslashes($row["firstPayment"]));
			$valuesArray["balance"]				= htmlspecialchars(stripslashes($row["balance"]));
			$valuesArray["recieptNumber"]		= htmlspecialchars(stripslashes($row["recieptNumber"]));
			
			
			if($quantity < 1 ){ $message = "Quantity should be greater than or equal to 1";}
			if($quantity > $serviceQuantity) { $message = "Make sure the quantity is within that on service";}
			
			$valuesArray["quantity"] 		= "";
			$errorArray["quantity"] 		= "*";
			$errorType 						= "error";
			$errorFlag = true;
			displayHeader("Myshop: Services");	
			displayAdminTemp("Services");
			displayCancelService($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();
			exit;
		}
			//Insert values into database
		$newQuantity = $serviceQuantity - $quantity;
		if(($serviceQuantity - $quantity) == 0){$returned = "Yes";}
		else {$returned = "No";}
		$sold = "No";
		$query = "INSERT INTO cancelledServices (serviceID, item, quantity, amount, reason, user, date, time) ";
		$query .= "VALUES ('".$serviceID."','".$item."','".$quantity."','".$amount."','".$reason;		
		$query .= "','".$user."','".$date."','".$time."')";
		
		$query1 = "UPDATE services SET quantity ='".$newQuantity."',firstPayment ='".$newFirstPayment;
		$query1 .= "',returned ='".$returned."' WHERE serviceID ='".$serviceID."'";
		
		$query2 = "UPDATE stockItems SET quantity = quantity + '".$quantity."',sold ='".$sold."' WHERE item ='".$item."'";
		
		$result = sql_query($query, $message);
		$result1 = sql_query($query1, $message);
		$result2 = sql_query($query2, $message);
					
		$message = $quantity." ".$problem." returnrd by <b>".$title.". ".$customerName.".&nbsp;&nbsp;Phone:&nbsp;&nbsp;";
		
		if($phone !=""){$phone = "Phone:".$phone;}
		else{$phone = "";}
		if($email !=""){$email = ", E-mail:".$email;}
		else{$email = "";}
		
		$message = "".$quantity." ".$problem." returned by";
		$message .= $title.". ".$customerName."&nbsp;".$phone."&nbsp;".$email;
		
		$errorType = "success";
		displayHeader("Myshop: Services");	
		displayAdminTemp("Services");
		displayViewServices($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}
		
	else {	
			$message = "Please make sure that the marked fields are propery filled.";
			$errorType = "error";
			$errorFlag = true;
			displayHeader("Myshop: Services");	
			displayAdminTemp("Services");
			displayCancelService($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();
			exit;
		}	
}


/*-----------------------------------------------------------------------------------------------------------------*/
?>