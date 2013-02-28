<?php

	$dir = getcwd();
	
	// Current directory is /modules, so we want to go one directory above that (that's why /../)
	$newDir = dirname(__FILE__) . '/../';
	chdir($newDir);

  /*This file is where all the required functions from various files */
  /* are included                                                    */
  /*----------------------------------------------------------
  /*		Templates
  /*---------------------------------------------------------*/

  
  require_once("sprites/templates/displayAdminTemp.php");
  require_once("sprites/templates/mainTemp.php");
  
  /*----------------------------------------------------------
  /*		Forms
  /*---------------------------------------------------------*/
  
  require_once("sprites/forms/displayLoginForm.php");
  require_once("sprites/forms/displayMessage.php");  
  require_once("sprites/forms/displayAdminHomePage.php");
  require_once("sprites/forms/displayAdminMenus.php");
  require_once("sprites/forms/displayEnterStockItem.php");
  require_once("sprites/forms/displayEnterSales.php");
  require_once("sprites/forms/displayEnterSales2.php");
  require_once("sprites/forms/displayEditStockItem1.php");
  require_once("sprites/forms/displayEditSales1.php");
  require_once("sprites/forms/displayEditSales2.php");
  require_once("sprites/forms/displayEditStockItem2.php");
  require_once("sprites/forms/displayCriticalError.php");
  require_once("sprites/forms/displayStockHome.php");
  require_once("sprites/forms/displaySalesHome.php");
  require_once("sprites/forms/displayInstallmentsHome.php");
  require_once("sprites/forms/displayDownPaymentsHome.php");
  require_once("sprites/forms/displayUsersHome.php");
  require_once("sprites/forms/displayServicesHome.php");
  require_once("sprites/forms/displayExpensesHome.php");
  require_once("sprites/forms/displayReportsHome.php");
  require_once("sprites/forms/displayNewStockDefinition.php");
  require_once("sprites/forms/displayWelcomeMessage.php");
  require_once("sprites/forms/displayEditStockDefinition1.php");
  require_once("sprites/forms/displayEditStockDefinition2.php");
  require_once("sprites/forms/displayViewStockItems.php");  
  require_once("sprites/forms/displayViewSales.php");
  require_once("sprites/forms/displayViewStockDefinitionInfo.php");
  require_once("sprites/forms/displayViewStockItemInfo.php");
  require_once("sprites/forms/displayViewStockDefinitions.php");
  require_once("sprites/forms/displayViewSaleInfo.php");
  require_once("sprites/forms/displayReturnItem.php");
  require_once("sprites/forms/displayEditInstallment2.php");
  require_once("sprites/forms/displayEnterInstallment2.php");
  require_once("sprites/forms/displayEnterInstallment1.php");
  require_once("sprites/forms/displayLastPaymentInstallment1.php");
  require_once("sprites/forms/displayLastPaymentInstallment2.php");
  require_once("sprites/forms/displayViewInstallments.php");
  require_once("sprites/forms/displayCancelInstallment.php");
  require_once("sprites/forms/displayEditInstallment1.php");
  require_once("sprites/forms/displayViewInstallmentInfo.php");
  require_once("sprites/forms/displayEnterDownPayment.php");
  require_once("sprites/forms/displayEditDownPayment1.php");
  require_once("sprites/forms/displayEditDownPayment2.php");
  require_once("sprites/forms/displayLastPaymentDownPayment1.php");
  require_once("sprites/forms/displayLastPaymentDownPayment2.php");
  require_once("sprites/forms/displayViewDownPayments.php");
  require_once("sprites/forms/displayViewDownPaymentInfo.php");
  require_once("sprites/forms/displayCancelDownPayment.php");
  require_once("sprites/forms/displayAddUser.php");
  require_once("sprites/forms/displayViewUsers.php");
  require_once("sprites/forms/displayEditUser.php");
  require_once("sprites/forms/displayViewUserInfo.php");
  require_once("sprites/forms/displayChangePassword.php");
  require_once("sprites/forms/displayDefineExpense.php");
  require_once("sprites/forms/displayEnterExpense.php");
  require_once("sprites/forms/displayViewExpenses.php");
  require_once("sprites/forms/displayEditExpenseDefinition.php");
  require_once("sprites/forms/displayEditExpense.php");
  require_once("sprites/forms/displayViewExpenseInfo.php");
  require_once("sprites/forms/displayEnterService.php");
  require_once("sprites/forms/displayViewServices.php");
  require_once("sprites/forms/displayEditService.php");
  require_once("sprites/forms/displayPaymentServices.php");
  require_once("sprites/forms/displayViewServiceInfo.php");
  require_once("sprites/forms/displayIncomeExpenditure.php");
  require_once("sprites/forms/displayQuatationsHome.php");
  require_once("sprites/forms/displayStockReport.php");
  /*----------------------------------------------------------
  /*		Modules
  /*---------------------------------------------------------*/
  
  require_once("modules/stockItem_modules.php");
  require_once("modules/sales_modules.php");
  require_once("modules/installment_modules.php");
  require_once("modules/downPayments_modules.php");
  require_once("modules/validation_modules.php");  
  require_once("modules/stockDefinition_Modules.php");
  require_once("modules/db_modules.php");
  require_once("modules/users_modules.php");
  require_once("modules/expenses_modules.php");
  require_once("modules/services_modules.php");
  
  chdir($dir);