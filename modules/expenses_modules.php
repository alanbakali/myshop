<?php

/*---------------------------------------------------------------------------
/* This function process all the validatins for New Stock Definition Entry and Edit     */
/*----------------------------------------------------------------------------*/
function expenseVal(&$message,&$errorArray,&$valuesArray,&$errorFlag){
	$errorFlag =false;
	foreach ($_POST  as $key => $value){
		if($key == "frmName"|| ($key == "expenseID") ){
			$errorArray["$key"] = "";
			$valuesArray["$key"] = $value;
		}
		else{
			if(isset($key) && ($value =="") && (($key == "description") || ($key == "expenseName") || ($key == "comment"))){
				$errorArray["$key"] = "*";
				$valuesArray["$key"] = "";
				$errorFlag = true;
			}
			else{
				$errorArray["$key"] = "";
				$valuesArray["$key"] = $value;
			}
		
			
			if($key == "amount"){
				$value = str_replace(" ", "", $value);
				if(!(is_numeric($value)) || ($value == 0) ){
					$errorArray["$key"] = "*";
					$valuesArray["$key"] = "";
					$errorFlag = true;
				}
				else{
					$errorArray["$key"] = "";
					$valuesArray["$key"] = $value;
				}
			}
			if(($key == "month")|| ($key == "year")){
				if($value ==""){
					$errorArray["month"] = "*";
					$valuesArray["$key"] = "";
					$errorFlag = true;
					}
				else{
					$errorArray["month"] = "";
					$valuesArray["$key"] = $value;
				}
			}
			
		}
	}
	return !($errorFlag);
}

/*---------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------
/* This function process the entry of a new stock Definition				  */
/*----------------------------------------------------------------------------*/
function defineExpense($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	$expenseName 		= $_POST["expenseName"];
	$description 		= $_POST["description"];
	
	
	if(!$expenseName &&  !$description ){//check if the user is viewing this page from the right page
		$errorFlag = false;
		displayHeader("Myshop: Expenses");	
		displayAdminTemp("Expenses");
		displayDefineExpense($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}

	$valid = expenseVal($message,$errorArray,$valuesArray,$errorFlag);
	if($valid == true){
		$expenseName = addslashes($expenseName);
		$description = addslashes($description);
		
		// Check if the item already exist in the database before inserting
		$query = "SELECT * FROM expenseDefinition WHERE expenseName ='".$expenseName."'";
		$result = sql_query($query, $message);
	
		if(mysql_num_rows($result) > 0 ) {
			$message = "Expense Definition name ".$expenseName." already entered. Please enter a different expenseName."; 
			$errorType = "error";
			$errorArray["expenseName"] = "*";
			$valuesArray["$expenseName"] = "";
			displayHeader("Myshop: Expenses");	
			displayAdminTemp("Expenses");
			displayDefineExpense($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();
			exit;
		}
		else { 
			//Insert values into database
			$query = "INSERT INTO expenseDefinition (expenseName, description) ";
			$query .= "VALUES ('".$expenseName."','".$description."')";
			
			$result = sql_query($query, $message);
			
			$message = "Successfully saved";
			$errorType = "success";
			$valuesArray["query"] = "SELECT * FROM expenseDefinition WHERE expenseName ='".$expenseName."'";
			displayHeader("Myshop: Expenses");	
			displayAdminTemp("Expenses");
			displayDefineExpense($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();
			exit;
		}
	}
	else{
		$message = "Please make sure that the marked fields are propery filled.";
		$errorType = "error";
		displayHeader("Myshop: Expenses");	
		displayAdminTemp("Expenses");
		displayDefineExpense($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}	
}

/*-----------------------------------------------------------------------------------------------*/

function enterExpense($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	$expenseName 		= $_POST["expenseName"];
	$expenseID 			= $_POST["expenseID"];
	$comment	 		= $_POST["comment"];
	$amount 			= $_POST["amount"];
	$month	 			= $_POST["month"];
	$year 				= $_POST["year"];
	
	$user			=$_SESSION['userName'];
	$date			= date("Y-m-d");
	$time			= date("H:i.s");	
	
	if(!$expenseName &&  !$comment &&  !$amount &&  !$month &&  !$year ){//check if the user is viewing this page from the right page
		$errorFlag = false;
		$message = "Select Expense name from the drop down list.";
		$errorType = "info";
		displayHeader("Myshop: Expenses");	
		displayAdminTemp("Expenses");
		displayEnterExpense($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}

	$valid = expenseVal($message,$errorArray,$valuesArray,$errorFlag);
	if($valid == true){
		$expenseName = addslashes($expenseName);
		$expenseID	 = addslashes($expenseID);
		$comment 	= addslashes($comment);
		$amount 	= addslashes($amount);
		$month 		= addslashes($month);
		$year 		= addslashes($year);
		
		$user			= addslashes($user);
		$date 			= addslashes($date);
		$time			= addslashes($time);
		// Check if the item already exist in the database before inserting
		
		//Insert values into database
		$query = "INSERT INTO expenses (expenseName, comment, amount, month, year, user, date, time) ";
		$query .= "VALUES ('".$expenseName."','".$comment."','".$amount."','".$month."','".$year."','".$user."','".$date."','".$time."')";
		
		$result = sql_query($query, $message);
		
		$message = "Successfully saved";
		$errorType = "success";
		$valuesArray["query"] = "SELECT * FROM expenses ORDER BY expenseID DESC LIMIT 0,1";
		displayHeader("Myshop: Expenses");	
		displayAdminTemp("Expenses");
		displayViewExpenses($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}
	else{
		$message = "Please make sure that the marked fields are propery filled.";
		$errorType = "error";
		displayHeader("Myshop: Expenses");	
		displayAdminTemp("Expenses");
		displayEnterExpense($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}	
}

/********************************************************************************************************************/
function editExpenseDefinition1($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	//Retrieve the posted itemID first
	$expenseName = $valuesArray["expenseName"];		
	$expenseName 		= addslashes($expenseName);
	
	echo $$expenseName;
	// Check if the item realy exist in the database before inserting
	$query = "SELECT * FROM expenseDefinition WHERE expenseName ='".$expenseName."'";
	$result = sql_query($query, $message);
	
	if(mysql_num_rows($result) == 0) {
		$message = "Expense name ".$expenseName." doesn't exit."; 
		$errorType = "error";
		displayHeader("Myshop: Expenses");	
		displayAdminTemp("Expenses");
		displayViewExpenses($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}
	else {
		$errorFlag=true;
		$row = mysql_fetch_array($result);
		$valuesArray["expenseName"]= htmlspecialchars(stripslashes($row["expenseName"]));
		$valuesArray["description"]= htmlspecialchars(stripslashes($row["description"]));
	
		
		$message = "After changing the Expense Name, it will also be changed in all related expenses.";
		$errorType = "info";
		displayHeader("Myshop: Expenses");	
		displayAdminTemp("Expenses");
		displayEditExpenseDefinition($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}	
}
/*-------------------------------------------------------------------------------------------------------*/

function editExpenseDefinition2($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	$expenseName 				= $_POST["expenseName"];
	$initialExpenseName 		= $_POST["initialExpenseName"];
	$description 				= $_POST["description"];
	
	
	if(!$expenseName &&  !$description ){//check if the user is viewing this page from the right page
		$errorFlag = false;
		displayHeader("Myshop: Expenses");	
		displayAdminTemp("Expenses");
		displayEditExpenseDefinition($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}

	$valid = expenseVal($message,$errorArray,$valuesArray,$errorFlag);
	if($valid == true){
		$expenseName 		= addslashes($expenseName);
		$description 		= addslashes($description);
		
		// Check if the item already exist in the database before inserting
		
		//Insert values into database
		$query = "UPDATE expenseDefinition SET expenseName ='".$expenseName."',description ='".$description;
		$query .= "' WHERE	expenseName ='".$initialExpenseName."'";
		
		$query2 = "UPDATE expenses SET expenseName ='".$expenseName;
		$query2 .= "' WHERE	expenseName ='".$initialExpenseName."'";
		
		$result = sql_query($query, $message);
		$result2 = sql_query($query2, $message);
		
		$message = "Successfully saved";
		$errorType = "success";
		$valuesArray["query"] = "SELECT * FROM expenses WHERE expenseName ='".$expenseName."'";
		displayHeader("Myshop: Expenses");	
		displayAdminTemp("Expenses");
		displayViewExpenses($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}
	else{
		$message = "Please make sure that the marked fields are propery filled.";
		$errorType = "error";
		displayHeader("Myshop: Expenses");	
		displayAdminTemp("Expenses");
		displayEditExpenseDefinition($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}	
}

/*-----------------------------------------------------------------------------------------------*/
function editExpense1($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	//Retrieve the posted itemID first
	$expenseID = $valuesArray["expenseID"];		
	$expenseID 		= addslashes($expenseID);
	
	// Check if the item realy exist in the database before inserting
	$query = "SELECT * FROM expenses WHERE expenseID ='".$expenseID."'";
	$result = sql_query($query, $message);
	
	if(mysql_num_rows($result) == 0) {
		$message = "Expense name ".$expenseName." doesn't exit."; 
		$errorType = "error";
		displayHeader("Myshop: Expenses");	
		displayAdminTemp("Expenses");
		displayViewExpenses($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}
	else {
		$errorFlag=true;
		$row = mysql_fetch_array($result);
		$valuesArray["expenseName"]= htmlspecialchars(stripslashes($row["expenseName"]));
		$valuesArray["expenseID"]= htmlspecialchars(stripslashes($row["expenseID"]));
		$valuesArray["comment"]= htmlspecialchars(stripslashes($row["comment"]));
		$valuesArray["amount"]= htmlspecialchars(stripslashes($row["amount"]));
		$valuesArray["month"]= htmlspecialchars(stripslashes($row["month"]));
		$valuesArray["year"]= htmlspecialchars(stripslashes($row["year"]));
		
		
		displayHeader("Myshop: Expenses");	
		displayAdminTemp("Expenses");
		displayEditExpense($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}	
}
/*-------------------------------------------------------------------------------------------------------*/

function editExpense2($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	$expenseName 				= $_POST["expenseName"];
	$expenseID		 			= $_POST["expenseID"];
	$comment	 				= $_POST["comment"];
	$amount		 				= $_POST["amount"];
	$year		 				= $_POST["year"];
	$month		 				= $_POST["month"];

	$user			=$_SESSION['userName'];
	$date			= date("Y-m-d");
	$time			= date("H:i.s");	
	
	if(!$expenseName &&  !$description ){//check if the user is viewing this page from the right page
		$errorFlag = false;
		displayHeader("Myshop: Expenses");	
		displayAdminTemp("Expenses");
		displayEditExpenseDefinition($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}

	$valid = expenseVal($message,$errorArray,$valuesArray,$errorFlag);
	if($valid == true){
		$expenseName 		= addslashes($expenseName);
		$expenseID 			= addslashes($expenseID);
		$initialExpenseName = addslashes($initialExpenseName);
		$comment			= addslashes($comment);
		$amount		 		= addslashes($amount);
		$year				= addslashes($year);
		$month		 		= addslashes($month);
		
		$user			= addslashes($user);
		$date 			= addslashes($date);
		$time			= addslashes($time);
		// Check if the item already exist in the database before inserting
		
		//Insert values into database
		$query = "UPDATE expenses SET expenseName ='".$expenseName."',comment ='".$comment."',amount ='".$amount."'";
		$query .= ",year ='".$year."',month ='".$month."',user ='".$user."',date ='".$date."',time ='".$time;
		$query .= "' WHERE	expenseID ='".$expenseID."'";
		
		$result = sql_query($query, $message);
		$valuesArray["expenseName"]		="";
		$valuesArray["year"]			="";
		$valuesArray["month"]			="";
		
		$message = "Successfully saved";
		$errorType = "success";
		$valuesArray["query"] = "SELECT * FROM expenses WHERE expenseID ='".$expenseID."'";
		displayHeader("Myshop: Expenses");	
		displayAdminTemp("Expenses");
		displayViewExpenses($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}
	else{
		
		$message = "Please make sure that the marked fields are propery filled.";
		$errorType = "error";
		displayHeader("Myshop: Expenses");	
		displayAdminTemp("Expenses");
		displayEditExpense($message,$errorArray,$valuesArray,$errorFlag,$errorType);
		displayFooter();
		exit;
	}	
}

/*-------------------------------------------------------------------------------------------------------*/

function deleteExpense($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	$expenseID = $valuesArray["expenseID"];		
	$expenseID 		= addslashes($expenseID);
	// Check if the item realy exist in the database before inserting
	$query = "DELETE  FROM expenses WHERE expenseID ='".$expenseID."'";
	$result = sql_query($query, $message);
	
	$valuesArray["expenseID"]		="";
	$valuesArray["year"]		="";
	$valuesArray["month"]		="";
	
	$message = "Successfully deleted";
	$errorType = "success";
	displayHeader("Myshop: Expenses");	
	displayAdminTemp("Expenses");
	displayViewExpenses($message,$errorArray,$valuesArray,$errorFlag,$errorType);
	displayFooter();
	exit;

}

/*-----------------------------------------------------------------------------------------------*/

/******************************************************************************************/

function viewExpenseInfo($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	
	$valuesArray["searchTerm"]	=stripslashes($valuesArray["searchTerm"]);
	$valuesArray["expenseID"]		=stripslashes($valuesArray["expenseID"]);
	$valuesArray["year"]		=stripslashes($valuesArray["year"]);
	$valuesArray["month"]		=stripslashes($valuesArray["month"]);
	$valuesArray["lowerLimit"] = $valuesArray["lowerLimit"];
//Retrieve the posted itemID first
	$expenseID = addslashes($valuesArray["expenseID"]);		
	// Check if the item realy exist in the database before inserting
	$query = "SELECT * FROM expenses WHERE expenseID ='".$expenseID."'";
	$result = sql_query($query, $message);
	
	$errorFlag=true;
	$row = mysql_fetch_array($result);
	$valuesArray["expenseName"]= htmlspecialchars(stripslashes($row["expenseName"]));
	$valuesArray["comment"]= htmlspecialchars(stripslashes($row["comment"]));
	$valuesArray["amount"]= htmlspecialchars(stripslashes($row["amount"]));
	$valuesArray["month"]= htmlspecialchars(stripslashes($row["month"]));
	$valuesArray["year"]= htmlspecialchars(stripslashes($row["year"]));
	
	$valuesArray["user"]		= htmlspecialchars(stripslashes($row["user"]));
	$valuesArray["date"]		= htmlspecialchars(stripslashes($row["date"]));
	$valuesArray["time"]		= htmlspecialchars(stripslashes($row["time"]));
	
	displayHeader("Myshop: Expenses");	
	displayAdminTemp("Expenses");
	displayViewExpenseInfo($message,$errorArray,$valuesArray,$errorFlag,$errorType);
	displayFooter();
	exit;
}

function viewExpenses($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	//Retrieve the posted itemID first 
		$searchTerm 		= $_POST["searchTerm"];
		$month		 		= $_POST["month"];
		$year 				= $_POST["year"];
		$actualFormName 	= $_POST["actualFormName"];
		if(!$searchTerm ){
			$valuesArray["month"]= $month;
			$valuesArray["year"]= $year;
			if($actualFormName == "expensesHome"){
				$message = "Enter a search term to browse through  the expences list.";
				$errorType = "info";
				displayHeader("Myshop: Expenses");	
				displayAdminTemp("Expenses");
				displayExpensesHome($message,$errorArray,$valuesArray,$errorFlag,$errorType);
				displayFooter();  exit;
				}
			else {
				displayHeader("Myshop: Expenses");	
				displayAdminTemp("Expenses");
				displayViewExpenses($message,$errorArray,$valuesArray,$errorFlag,$errorType);
				displayFooter();  exit;
			}					
		}
		else {
			$errorFlag=true;
			$valuesArray["searchTerm"]= stripslashes($searchTerm);
			$valuesArray["month"]= $month;
			$valuesArray["year"]= $year;
			displayHeader("Myshop: Expenses");	
			displayAdminTemp("Expenses");
			displayViewExpenses($message,$errorArray,$valuesArray,$errorFlag,$errorType);
			displayFooter();
			exit;
		}
}


/******************************************************************************************/
function nextExpenses($message,$errorArray,$valuesArray,$errorFlag,$errorType){
		
	$errorFlag=true;
	$valuesArray["searchTerm"]	=stripslashes($valuesArray["searchTerm"]);
	$valuesArray["year"]		=stripslashes($valuesArray["year"]);
	$valuesArray["month"]		=stripslashes($valuesArray["month"]);
	$valuesArray["lowerLimit"] = $valuesArray["lowerLimit"];
	
	displayHeader("Myshop: Expenses");	
	displayAdminTemp("Expenses");
	displayViewExpenses($message,$errorArray,$valuesArray,$errorFlag,$errorType);
	displayFooter();
	exit;
}

function previousExpenses($message,$errorArray,$valuesArray,$errorFlag,$errorType){
	$errorFlag=true;
	$valuesArray["searchTerm"]	=stripslashes($valuesArray["searchTerm"]);
	$valuesArray["year"]		=stripslashes($valuesArray["year"]);
	$valuesArray["month"]		=stripslashes($valuesArray["month"]);
	$valuesArray["lowerLimit"] = $valuesArray["lowerLimit"];
	
	displayHeader("Myshop: Expenses");	
	displayAdminTemp("Expenses");
	displayViewExpenses($message,$errorArray,$valuesArray,$errorFlag,$errorType);
	displayFooter();
	exit;
}

?>