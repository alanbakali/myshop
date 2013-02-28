<?php
require_once("modules/required_modules.php");
session_start();
if (!session_is_registered("userName") || !isset($_SESSION['userName'])){
	displayHeader("Myshop: Home");
	displayAdminTemp("Logout");
	displayLoginForm("Log-in first to access the system");
	displayFooter();
	exit;
}
else {
	$errorFlag = false;			$errorArray["frmName"] = "";		$valuesArray["frmName"] ="";
	$message = "";
	if(isset($_GET['action']) && isset($_GET['whichForm'])){	
		$itemID 		= rawurldecode($_GET['itemID']);
		$saleID 		= rawurldecode($_GET['saleID']);
		$stockID 		= rawurldecode($_GET['stockID']);
		$expenseName 	= rawurldecode($_GET['expenseName']);
		$expenseID	 	= rawurldecode($_GET['expenseID']);
		$serviceID 		= rawurldecode($_GET['serviceID']);
		$installmentID 	= rawurldecode($_GET['installmentID']);	
		$downPaymentID 	= rawurldecode($_GET['downPaymentID']);	
		$userName 		= rawurldecode($_GET['userName']);	
		$action 		= rawurldecode($_GET['action']);
		$whichForm 		= rawurldecode($_GET['whichForm']);
		$lowerLimit 	= rawurldecode($_GET['lowerLimit']);
		$searchTerm 	= rawurldecode($_GET['searchTerm']);
		$year		 	= rawurldecode($_GET['year']);
		$month 			= rawurldecode($_GET['month']);
		if($whichForm == "frmItems"){
		// a page command was issued through a get request
			switch($action){	// Process page commannd
											 
				case "info"				:	$valuesArray["stockID"] =$stockID;
											$valuesArray["itemID"] =$itemID;
											$valuesArray["lowerLimit"] =$lowerLimit;
											$valuesArray["searchTerm"] =$searchTerm;
											viewStockItemInfo($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											exit;
											
				case "installment"		:	$valuesArray["stockID"] =$stockID;
											$valuesArray["itemID"] =$itemID;
											$valuesArray["lowerLimit"] =$lowerLimit;
											$valuesArray["searchTerm"] =$searchTerm;
											enterInstallment($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											exit;
											
				case "edit"				:	$valuesArray["stockID"] =$stockID;
											$valuesArray["itemID"] =$itemID;
											$valuesArray["lowerLimit"] =$lowerLimit;
											$valuesArray["searchTerm"] =$searchTerm;
											editStockItem2($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											exit;
				case "next"				:	$valuesArray["lowerLimit"] =$lowerLimit;
											$valuesArray["stockID"] =$stockID;
											$valuesArray["searchTerm"] =$searchTerm;
											nextStockItems($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											exit;
				case "previous"			:	$valuesArray["lowerLimit"] =$lowerLimit;
											$valuesArray["stockID"] =$stockID;
											$valuesArray["searchTerm"] =$searchTerm;
											previousStockItems($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											exit;
											
				case "sale"				:	$valuesArray["itemID"] =$itemID;
											$valuesArray["stockID"] =$stockID;
											$valuesArray["lowerLimit"] =$lowerLimit;
											$valuesArray["searchTerm"] =$searchTerm;
											enterSales($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											exit;
			}
		}
		
		if($whichForm == "frmSales"){
		// a page command was issued through a get request
			switch($action){	// Process page commannd
											 
				case "info"				:	$valuesArray["saleID"] =$saleID; 
											$valuesArray["lowerLimit"] =$lowerLimit;
											$valuesArray["searchTerm"] =$searchTerm;
											$valuesArray["year"]	   =$year;
											$valuesArray["month"] 	   =$month;
											viewSaleInfo($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											exit;
											
				case "delete"			:	$valuesArray["saleID"] =$saleID;
											$valuesArray["lowerLimit"] =$lowerLimit;
											$valuesArray["searchTerm"] =$searchTerm;
											$valuesArray["year"]	   =$year;
											$valuesArray["month"] 	   =$month;
											returnItem($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											exit;
											
				case "edit"				:	$valuesArray["saleID"] =$saleID;
											$valuesArray["lowerLimit"] =$lowerLimit;
											$valuesArray["searchTerm"] =$searchTerm;
											$valuesArray["year"]	   =$year;
											$valuesArray["month"] 	   =$month;
											editSales1($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											exit;
				case "next"				:	$valuesArray["lowerLimit"] =$lowerLimit;
											$valuesArray["searchTerm"] =$searchTerm;
											$valuesArray["year"]	   =$year;
											$valuesArray["month"] 	   =$month;
											nextSales($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											exit;
				case "previous"			:	$valuesArray["lowerLimit"] =$lowerLimit;
											$valuesArray["searchTerm"] =$searchTerm;
											$valuesArray["year"]	   =$year;
											$valuesArray["month"] 	   =$month;
											previousSales($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											exit;
											
				
			}
		}
		
		
		if($whichForm == "frmStockDefn"){
		// a page command was issued through a get request
			switch($action){	// Process page commannd
											 
				case "info"				:	$valuesArray["stockID"] =$stockID; 
											$valuesArray["lowerLimit"] =$lowerLimit;
											$valuesArray["searchTerm"] =$searchTerm;
											$valuesArray["year"]	   =$year;
											$valuesArray["month"] 	   =$month;
											viewStockDefinitionInfo($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											exit;
											
				case "edit"				:	$valuesArray["stockID"] = $stockID;
											$valuesArray["lowerLimit"] =$lowerLimit;
											$valuesArray["searchTerm"] =$searchTerm;
											$valuesArray["year"]	   =$year;
											$valuesArray["month"] 	   =$month;
											editStockDefinition1($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											exit;
				case "next"				:	$valuesArray["lowerLimit"] =$lowerLimit;
											$valuesArray["searchTerm"] =$searchTerm;
											$valuesArray["year"]	   =$year;
											$valuesArray["month"] 	   =$month;
											nextStockDefinition($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											exit;
				case "previous"			:	$valuesArray["lowerLimit"] =$lowerLimit;
											$valuesArray["searchTerm"] =$searchTerm;
											$valuesArray["year"]	   =$year;
											$valuesArray["month"] 	   =$month;
											previousStockDefinition($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											exit;
											
				
			}
		}
		
	if($whichForm == "frmInstallments"){
		// a page command was issued through a get request
			switch($action){	// Process page commannd
											 
				case "info"				:	$valuesArray["installmentID"] =$installmentID;
											$valuesArray["lowerLimit"] =$lowerLimit;
											$valuesArray["searchTerm"] =$searchTerm;
											$valuesArray["year"]	   =$year;
											$valuesArray["month"] 	   =$month;
											viewInstallmentInfo($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											exit;
											
				case "lastPayment"		:	$valuesArray["installmentID"] =$installmentID;
											$valuesArray["lowerLimit"] =$lowerLimit;
											$valuesArray["searchTerm"] =$searchTerm;
											$valuesArray["year"]	   =$year;
											$valuesArray["month"] 	   =$month;
											lastPaymentInstallment($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											exit;
											
				case "edit"				:	$valuesArray["installmentID"] =$installmentID;
											$valuesArray["lowerLimit"] =$lowerLimit;
											$valuesArray["searchTerm"] =$searchTerm;
											$valuesArray["year"]	   =$year;
											$valuesArray["month"] 	   =$month;
											editInstallment1($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											exit;
				case "next"				:	$valuesArray["lowerLimit"] =$lowerLimit;
											$valuesArray["searchTerm"] =$searchTerm;
											$valuesArray["year"]	   =$year;
											$valuesArray["month"] 	   =$month;
											nextStockItems($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											exit;
				case "previous"			:	$valuesArray["lowerLimit"] =$lowerLimit;
											$valuesArray["searchTerm"] =$searchTerm;
											$valuesArray["year"]	   =$year;
											$valuesArray["month"] 	   =$month;
											previousStockItems($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											exit;
											
				case "delete"			:	$valuesArray["installmentID"] =$installmentID;
											$valuesArray["lowerLimit"] =$lowerLimit;
											$valuesArray["searchTerm"] =$searchTerm;
											$valuesArray["year"]	   =$year;
											$valuesArray["month"] 	   =$month;
											cancelInstallment($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											exit;
			}
		}
		if($whichForm == "frmExpenses"){
		// a page command was issued through a get request
			switch($action){	// Process page commannd
											 
				case "info"				:	$valuesArray["expenseID"] 	=$expenseID;
											$valuesArray["lowerLimit"] =$lowerLimit;
											$valuesArray["searchTerm"] =$searchTerm;
											$valuesArray["year"]	   =$year;
											$valuesArray["month"] 	   =$month;
											viewExpenseInfo($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											exit;
											
				case "editExpenseDefinition":	
											$valuesArray["expenseName"] =$expenseName;
											$valuesArray["lowerLimit"] =$lowerLimit;
											$valuesArray["searchTerm"] =$searchTerm;
											$valuesArray["year"]	   =$year;
											$valuesArray["month"] 	   =$month;
											echo $$expenseName;
											editExpenseDefinition1($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											exit;
												
				case "edit"				:	$valuesArray["expenseID"] =$expenseID;
											$valuesArray["lowerLimit"] =$lowerLimit;
											$valuesArray["searchTerm"] =$searchTerm;
											$valuesArray["year"]	   =$year;
											$valuesArray["month"] 	   =$month;
											editExpense1($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											
				case "delete"			:	$valuesArray["expenseID"] =$expenseID;
											$valuesArray["lowerLimit"] =$lowerLimit;
											$valuesArray["searchTerm"] =$searchTerm;
											$valuesArray["year"]	   =$year;
											$valuesArray["month"] 	   =$month;
											deleteExpense($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											exit;
											
				case "next"				:	$valuesArray["lowerLimit"] =$lowerLimit;
											$valuesArray["searchTerm"] =$searchTerm;
											$valuesArray["year"]	   =$year;
											$valuesArray["month"] 	   =$month;
											nextExpenses($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											exit;
				case "previous"			:	$valuesArray["lowerLimit"] =$lowerLimit;
											$valuesArray["searchTerm"] =$searchTerm;
											$valuesArray["year"]	   =$year;
											$valuesArray["month"] 	   =$month;
											previousExpenses($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											exit;
											
				
			}
		}
		if($whichForm == "frmDownPayments"){
		// a page command was issued through a get request
			switch($action){	// Process page commannd
											 
				case "info"				:	$valuesArray["downPaymentID"] =$downPaymentID;
											$valuesArray["lowerLimit"] =$lowerLimit;
											$valuesArray["searchTerm"] =$searchTerm;
											$valuesArray["year"]	   =$year;
											$valuesArray["month"] 	   =$month;
											viewDownPaymentInfo($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											exit;
											
				case "lastPayment"		:	$valuesArray["downPaymentID"] =$downPaymentID;
											$valuesArray["lowerLimit"] =$lowerLimit;
											$valuesArray["searchTerm"] =$searchTerm;
											$valuesArray["year"]	   =$year;
											$valuesArray["month"] 	   =$month;
											lastPaymentDownPayment1($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											exit;
											
				case "edit"				:	$valuesArray["downPaymentID"] =$downPaymentID;
											$valuesArray["lowerLimit"] =$lowerLimit;
											$valuesArray["searchTerm"] =$searchTerm;
											$valuesArray["year"]	   =$year;
											$valuesArray["month"] 	   =$month;
											editDownPayment1($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											exit;
				case "next"				:	$valuesArray["lowerLimit"] =$lowerLimit;
											$valuesArray["searchTerm"] =$searchTerm;
											$valuesArray["year"]	   =$year;
											$valuesArray["month"] 	   =$month;
											nextStockItems($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											exit;
				case "previous"			:	$valuesArray["lowerLimit"] =$lowerLimit;
											$valuesArray["searchTerm"] =$searchTerm;
											$valuesArray["year"]	   =$year;
											$valuesArray["month"] 	   =$month;
											previousStockItems($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											exit;
											
				case "delete"			:	$valuesArray["downPaymentID"] =$downPaymentID;
											$valuesArray["lowerLimit"] =$lowerLimit;
											$valuesArray["searchTerm"] =$searchTerm;
											$valuesArray["year"]	   =$year;
											$valuesArray["month"] 	   =$month;
											cancelDownPayment($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											exit;
			}
		}
		if($whichForm == "frmUsers"){
		// a page command was issued through a get request
			switch($action){	// Process page commannd
											 
				case "info"				:	$valuesArray["userName"] =$userName;
											$valuesArray["lowerLimit"] =$lowerLimit;
											$valuesArray["searchTerm"] =$searchTerm;
											viewUserInfo($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											exit;
											
				case "reset"			:	$valuesArray["userName"] =$userName;
											$valuesArray["lowerLimit"] =$lowerLimit;
											$valuesArray["searchTerm"] =$searchTerm;
											resetPassword($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											exit;
				
				case "edit"				:	$valuesArray["userName"] =$userName;
											$valuesArray["lowerLimit"] =$lowerLimit;
											$valuesArray["searchTerm"] =$searchTerm;
											editUser1($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											exit;
				case "next"				:	$valuesArray["lowerLimit"] =$lowerLimit;
											$valuesArray["searchTerm"] =$searchTerm;
											nextUsers($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											exit;
				case "previous"			:	$valuesArray["lowerLimit"] =$lowerLimit;
											$valuesArray["searchTerm"] =$searchTerm;
											previousUsers($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											exit;
											
			}
		}
		
		if($whichForm == "frmServices"){
		// a page command was issued through a get request
			switch($action){	// Process page commannd
											 
				case "info"				:	$valuesArray["serviceID"] =$serviceID;
											$valuesArray["lowerLimit"] =$lowerLimit;
											$valuesArray["searchTerm"] =$searchTerm;
											viewServiceInfo($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											exit;
				
				case "edit"				:	$valuesArray["serviceID"] =$serviceID;
											$valuesArray["lowerLimit"] =$lowerLimit;
											$valuesArray["searchTerm"] =$searchTerm;
											editService1($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											exit;
											
				case "payment"			:	$valuesArray["serviceID"] =$serviceID;
											$valuesArray["lowerLimit"] =$lowerLimit;
											$valuesArray["searchTerm"] =$searchTerm;
											paymentServices1($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											exit;
											
				case "next"				:	$valuesArray["lowerLimit"] =$lowerLimit;
											$valuesArray["searchTerm"] =$searchTerm;
											nextServices($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											exit;
				case "previous"			:	$valuesArray["lowerLimit"] =$lowerLimit;
											$valuesArray["searchTerm"] =$searchTerm;
											previousServices($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											exit;
											
			}
		}
	}
}
?>