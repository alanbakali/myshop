<?php
require_once("modules/required_modules.php");
session_start();
if (!session_is_registered("userName") || !isset($_SESSION['userName'])){
	displayHeader("Myshop: Home", "Logout");
	displayAdminTemp("Logout");
	displayLoginForm("Log-in first to access the system");
	displayFooter();
	exit;
}
else {
	$errorFlag = false;			$errorArray["frmName"] = "";		$valuesArray["frmName"] ="";
	$message = "";
	if(isset($_GET['p'])){					// a page command was issued through a get request
		switch(rawurldecode($_GET['p'])){	// Process page commannd 
		
			/***************************************************************************************************************************/
			/*****************************************************Admin Home******************************************************/
			/***************************************************************************************************************************/
		
			case "adminHome"			:	displayHeader("Myshop: Admin Home");	
											displayAdminTemp("Home");
											displayAdminHomePage($message);
											displayFooter();  exit;
											
														
			/***************************************************************************************************************************/
			/*****************************************************Stock Items******************************************************/
			/***************************************************************************************************************************/
										
			case "stock"				:	$message = "Enter a search term to browse through  the stock list.";
											$errorType = "info";
											displayHeader("Myshop: Stock");	
											displayAdminTemp("Stock");
											displayStockHome($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											displayFooter();  exit;
										
			case "enterStockItem"		:	displayHeader("Myshop: Stock ");	
											displayAdminTemp("Stock");
											displayEnterStockItem($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											displayFooter();  exit;	
										
			case "editStockItem1"		:	$message = "Enter item ID and click searchTerm to edit a specific stock item.";
											$errorType = "info";
											displayHeader("Myshop: Stock");	
											displayAdminTemp("Stock");
											displayEditStockItem1($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											displayFooter();  exit;
										
			case "viewStockItems"		:	displayHeader("Myshop: Stock");	
											displayAdminTemp("Stock");
											displayViewStockItems($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											displayFooter();  exit;
										
			
			/***************************************************************************************************************************/
			/*****************************************************Services******************************************************/
			/***************************************************************************************************************************/							
			
										
			case "services"				:	$message = "Enter a search term to browse through  the services list.";
											$errorType = "info";
											displayHeader("Myshop: Services");	
											displayAdminTemp("Services");
											displayServicesHome($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											displayFooter();  exit;
			
			case "enterService"			:	displayHeader("Myshop: Services");	
											displayAdminTemp("Services");
											displayEnterService($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											displayFooter();  exit;
											
			case "viewServices"			:	displayHeader("Myshop: Services");	
											displayAdminTemp("Services");
											displayViewServices($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											displayFooter();  exit;
			/***************************************************************************************************************************/
			/*****************************************************Expenses******************************************************/
			/***************************************************************************************************************************/							
			
										
			case "expenses"				:	$message = "Enter a search term to browse through  the expences list.";
											$errorType = "info";
											displayHeader("Myshop: Expenses");	
											displayAdminTemp("Expenses");
											displayExpensesHome($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											displayFooter();  exit;
											
			case "defineExpense"		:	$message = "Expense name can be something like Electricity Bill.";
											$errorType = "info";
											displayHeader("Myshop: Expenses");	
											displayAdminTemp("Expenses");
											displayDefineExpense($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											displayFooter();  exit;
											
			case "enterExpense"			:	$message = "Select Expense name from the drop down list.";
											$errorType = "info";
											displayHeader("Myshop: Expenses");	
											displayAdminTemp("Expenses");
											displayEnterExpense($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											displayFooter();  exit;
											
			case "viewExpenses"			:	displayHeader("Myshop: Expenses");	
											displayAdminTemp("Expenses");
											displayViewExpenses($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											displayFooter();  exit;
											
			/***************************************************************************************************************************/
			/*****************************************************Expenses******************************************************/
			/***************************************************************************************************************************/	
										
			case "quotations"			:	$message = "Enter a search term to browse through existing quatations.";
											$errorType = "info";
											displayHeader("Myshop: Quotations");	
											displayAdminTemp("Quotations");
											displayQuatationsHome($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											displayFooter();  exit;
											
			/***************************************************************************************************************************/
			/*****************************************************Expenses******************************************************/
			/***************************************************************************************************************************/	
										
			case "reports"				:	$message = "Choose what kind of report you want from the list below.";
											$errorType = "info";
											displayHeader("Myshop: Reports");	
											displayAdminTemp("Reports");
											displayReportsHome($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											displayFooter();  exit;
											
			case "stockReport"			:	$message = "Choose either stockID or stock availability or both for your report.";
											$errorType = "info";
											displayHeader("Myshop: Reports");	
											displayAdminTemp("Reports");
											displayStockReport($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											displayFooter();  exit;
											
			case "incomeExpenditure"	:	$message = "Select month from the form below.";
											$errorType = "info";
											displayHeader("Myshop: Reports");	
											displayAdminTemp("Reports");
											displayIncomeExpenditure($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											displayFooter();  exit;
										
			
											
			/***************************************************************************************************************************/
			/*****************************************************Stock Definition******************************************************/
			/***************************************************************************************************************************/								
			case "editStockDefinition1"	:	$message = "Enter stock ID and click searh to edit a specific definition.";
											$errorType = "info";
											displayHeader("Myshop: Stock Definition");	
											displayAdminTemp("Home");
											displayEditStockDefinition1($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											displayFooter();  exit;
										
			case "newStockDefinition"	:	displayHeader("Myshop: Stock Definition");	
											displayAdminTemp("Home");
											displayNewStockDefinition($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											displayFooter();  exit;	
											
			case "editStockDefinition"	:	displayHeader("Myshop: Stock Definition");	
											displayAdminTemp("Home");
											displayEditStockDefinition1($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											displayFooter();  exit;	
										
			case "viewStockDefinitions"	:	displayHeader("Myshop: Stock Definition");	
											displayAdminTemp("Home");
											displayViewStockDefinitions($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											displayFooter();  exit;
												
			/***************************************************************************************************************************/
			/*****************************************************Sales******************************************************/
			/***************************************************************************************************************************/
			case "sales"				:	$message = "Enter a search term to browse through  the sales list.";
											$errorType = "info";
											displayHeader("Myshop: Sales");	
											displayAdminTemp("Sales");
											displaySalesHome($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											displayFooter();  exit;
												
			case "enterSales"		 	:	$message = "Please search for the item you want to sale";
											$errorType = "info";
											displayHeader("Myshop: Sales");	
											displayAdminTemp("Sales");
											displayEnterSales($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											displayFooter();  exit;	
											
			case "editSales"			:	$message = "Enter sale ID and click Go to edit a specific Sale entry.";
											$errorType = "info";
											displayHeader("Myshop: Sales");	
											displayAdminTemp("Sales");
											displayEditSales1($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											displayFooter();  exit;		
																						
			case "viewSales"			:	displayHeader("Myshop: Sales");	
											displayAdminTemp("Sales");
											displayViewSales($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											displayFooter();  exit;
			/***************************************************************************************************************************/
			/*****************************************************Installment******************************************************/
			/***************************************************************************************************************************/
			case "installments"			:	$message = "Enter a search term to browse through  the installments list.";
											$errorType = "info";
											displayHeader("Myshop: Installments");	
											displayAdminTemp("Installments");
											displayInstallmentsHome($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											displayFooter();  exit;
											
			case "newInstallment"		:	$message = "Please search for the item you want to put on installment";
											$errorType = "info";
											displayHeader("Myshop: Installments");	
											displayAdminTemp("Installments");
											displayEnterInstallment1($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											displayFooter();  exit;
											
			case "lastPaymentInstallment"	:	$message = "Enter Installment ID and click Go to enter last payment for a specific installment";
												$errorType = "info";
												displayHeader("Myshop:  Installments");	
												displayAdminTemp("Installments");
												displayLastPaymentInstallment1($message,$errorArray,$valuesArray,$errorFlag,$errorType);
												displayFooter();  exit;
												
			case "editInstallment"			:	$message = "Enter Installment ID and click Go to edit a specific installment";
												$errorType = "info";
												displayHeader("Myshop: Installments");	
												displayAdminTemp("Installments");
												displayEditInstallment1($message,$errorArray,$valuesArray,$errorFlag,$errorType);
												displayFooter();  exit;
												
			case "viewInstallments"			:	displayHeader("Myshop: Installments");	
												displayAdminTemp("Installments");
												displayViewInstallments($message,$errorArray,$valuesArray,$errorFlag,$errorType);
												displayFooter();  exit;
												
			/***************************************************************************************************************************/
			/*****************************************************DownPayments******************************************************/
			/***************************************************************************************************************************/
			case "downpayments"			:	$message = "Enter a search term to browse through  the down payments list.";
											$errorType = "info";
											displayHeader("Myshop: DownPayments");	
											displayAdminTemp("DownPayments");
											displayDownPaymentsHome($message,$errorArray,$valuesArray,$errorFlag,$errorType);
											displayFooter();  exit;
											
			case "newDownPayment"			: 	displayHeader("Myshop: DownPayments");	
												displayAdminTemp("DownPayments");
												displayEnterDownPayment($message,$errorArray,$valuesArray,$errorFlag,$errorType);
												displayFooter();  exit;	
												
			case "editDownPayment"			:	$message = "Enter DownPayment ID and click Go to edit a specific DownPayment Entry";
												$errorType = "info";
												displayHeader("Myshop: Installments");	
												displayAdminTemp("DownPayments");
												displayEditDownPayment1($message,$errorArray,$valuesArray,$errorFlag,$errorType);
												displayFooter();  exit;	
												
			case "lastPaymentDownPayment"	: 	$message = "Enter DownPayment ID and click Go to enter Final Payment for a specific DownPayment";
												$errorType = "info";
												displayHeader("Myshop: DownPayments");	
												displayAdminTemp("DownPayments");
												displayLastPaymentDownPayment1($message,$errorArray,$valuesArray,$errorFlag,$errorType);
												displayFooter();  exit;	
												
			case "viewDownPayments"			: 	displayHeader("Myshop: DownPayments");	
												displayAdminTemp("DownPayments");
												displayViewDownPayments($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		
												displayFooter();  exit;	
			/******************************************************************************************************************************************/										
			/*******************************************************USERS******************************************************************************/
			/******************************************************************************************************************************************/
			
			case "newUser"					 	:  	$message = "After the user has been created, the userName can never be changed.";
													$errorType = "info";
													displayHeader("Myshop: Users");	
													displayAdminTemp("Home");
													displayAddUser($message,$errorArray,$valuesArray,$errorFlag,$errorType);
													displayFooter();  exit;		
													
			case "usersList"					:  	displayHeader("Myshop: Users");	
													displayAdminTemp("Home");
													displayViewUsers($message,$errorArray,$valuesArray,$errorFlag,$errorType);
													displayFooter();  exit;	
			case "changePassword"				:  	displayHeader("Myshop: Users");	
													displayAdminTemp("Home");
													displayChangePassword($message,$errorArray,$valuesArray,$errorFlag,$errorType);
													displayFooter();  exit;	
																																										
			//*************************************************************************************************************************
			//* Include all the links on navigation bar		 *
			//************************************************************************************************************************
			default					: session_start();
									if (session_is_registered("valid_user")){
										displayHeader("Myshop Home");
										displayAdminTemp("Logout");
										displayLoginForm("");
										displayFooter();
										session_unregister("validUser");
										session_destroy();
										exit;
									}
									displayHeader("Myshop: Home");
									displayAdminTemp("Logout");
									displayLoginForm("");
									displayFooter(); 		exit;
		}
	}
	elseif(isset($_POST["frmName"])){		// a form with name = frmName value posted its data 
		switch(rawurldecode($_POST["frmName"])){	// Process posted data based on form name	
		
			/******************************************************************************************************************************************/										
			/*******************************************************Stock Item******************************************************************************/
			/******************************************************************************************************************************************/									
			case "enterStockItem"			: enterStockItem($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			
			case "editStockItem2"			: editStockItem2($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			
			case "editStockItem3"			: editStockItem3($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			
			case "viewStockItems"			: viewStockItems($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			
			/******************************************************************************************************************************************/										
			/*******************************************************Stock Defination******************************************************************************/
			/******************************************************************************************************************************************/
			
			case "newStockDefinition"		: newStockDefinition($message,$errorArray,$valuesArray,$errorFlag,$errorType);
						
			case "editStockDefinition1"		: editStockDefinition1($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			
			case "editStockDefinition2"		: editStockDefinition2($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			
			case "viewStockDefinitions"		: viewStockDefinitions($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			
						
			/******************************************************************************************************************************************/										
			/*******************************************************Installment******************************************************************************/
			/******************************************************************************************************************************************/
			case "enterInstallment"			: enterInstallment2($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			
			case "editInstallment"			: editInstallment1($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			
			case "editInstallment2"			: editInstallment2($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			
			case "viewInstallments"			: viewInstallments($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			
			case "cancelInstallment"		: cancelInstallment2($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			
			case "lastPaymentInstallment"	: lastPaymentInstallment($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			
			case "lastPaymentInstallment2"	: lastPaymentInstallment2($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			
			/******************************************************************************************************************************************/										
			/*******************************************************Sales******************************************************************************/
			/******************************************************************************************************************************************/
			case "enterSales"				: enterSales2($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			
			case "editSales1"				: editSales1($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			
			case "editSales2"				: editSales2($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			
			case "viewSales"				: viewSales($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			
			case "returnItem"				: returnItem2($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			
			/******************************************************************************************************************************************/										
			/*******************************************************Down Payments******************************************************************************/
			/******************************************************************************************************************************************/
			case "enterDownPayment"			: enterDownPayment($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			
			case "editDownPayment1"			: editDownPayment1($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			
			case "editDownPayment2"			: editDownPayment2($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			
			case "lastPaymentDownPayment"	: lastPaymentDownPayment1($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			
			case "lastPaymentDownPayment2"	: lastPaymentDownPayment2($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			
			case "viewDownPayments"			: viewDownPayments($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			
			case "cancelDownPayment"		: cancelDownPayment2($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			
			/******************************************************************************************************************************************/										
			/*******************************************************USERS******************************************************************************/
			/******************************************************************************************************************************************/	
			case "addUser"					: addUser($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			
			case "editUser"					: editUser2($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			
			case "viewUsers"				: viewUsers($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			
			case "changePassword"			: changePassword($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			
			/******************************************************************************************************************************************/										
			/*******************************************************Expenses******************************************************************************/
			/******************************************************************************************************************************************/	
			
			case "defineExpense"			: defineExpense($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			
			case "enterExpense"				: enterExpense($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			
			case "viewExpenses"				: viewExpenses($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			
			case "editExpenseDefinition"	: editExpenseDefinition2($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			
			case "editExpense"				: editExpense2($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			
			case "viewExpenseInfo"			: viewExpenseInfo($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			
			
			/******************************************************************************************************************************************/										
			/*******************************************************Services******************************************************************************/
			/******************************************************************************************************************************************/
			
			case "enterService"				: enterService($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			
			case "editService"				: editService2($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			
			case "viewServices"				: viewServices($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			
			case "paymentServices"			: paymentServices2($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		}	
	}
}
?>
