<?php 
function displayViewExpenses($message,$errorArray,$valuesArray,$errorFlag,$errorType){
		$perPage = 15;
		if($valuesArray["query"] && $valuesArray["query"] !=""){
			$query1 = $valuesArray["query"];
			$query2 = $valuesArray["query"];
		}
		else{
			if($valuesArray["lowerLimit"] == ""){	$lowerLimit = 0;}
			else {$lowerLimit = $valuesArray["lowerLimit"];}
		
			$searchTerm = $valuesArray["searchTerm"];
			$month 		= $valuesArray["month"];
			$year 		= $valuesArray["year"];
			
			
			if(($year !="") && ($month =="")){
				$yearAndTime = ' AND year='.$year;
			}
			else{
				if(($year =="") && ($month !="")){
				$yearAndTime = ' AND month='.$month;
				}
				else{
					if(($year !="") && ($month !="")){
					$yearAndTime = ' AND (month='.$month.'';
					$yearAndTime .= ' AND year='.$year.')';
					}
					else {$yearAndTime =="";}
				}
			}
			
			if($searchTerm !=""){
				$errorFlag=true;
				$searchTerm = trim(stripslashes($searchTerm));//Removing white spaces from strat and end of search term
				$searchTermArray = explode(" ", $searchTerm);//Splitting multiple word search term into single search terms
				$numberOfSearchTerms = count($searchTermArray);
				for($j = 0; $j < $numberOfSearchTerms; $j++){
					if($j == 0){
						$allSearchTerms = ' (expenseName LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR comment LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR amount LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR year LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR month LIKE "%'.addslashes($searchTermArray[$j]).'%"';
					}
					else {
						$allSearchTerms .= ' OR (expenseName LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR comment LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR amount LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR year LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR month LIKE "%'.addslashes($searchTermArray[$j]).'%"';
					}
				}
				
				// Check if the item realy exist in the database before inserting
				$edited ="No";
				$query1 = 'SELECT * FROM expenses WHERE';
				$query1 .= $allSearchTerms.') AND edited="'.$edited.'"'.$yearAndTime.' ORDER BY expenseID DESC LIMIT '.$lowerLimit.','.$perPage;
				
				$query2 = 'SELECT * FROM expenses WHERE';
				$query2 .= $allSearchTerms.') AND edited="'.$edited.'"'.$yearAndTime.' ORDER BY expenseID  DESC';			
				
				$searchTerm=stripslashes($searchTerm);
				
			}
			else {
				$edited ="No";
				$query1 = 'SELECT * FROM expenses WHERE edited="'.$edited.'"'.$yearAndTime.' ORDER BY expenseID DESC LIMIT '.$lowerLimit.','.$perPage;
				$query2 = 'SELECT * FROM expenses WHERE edited="'.$edited.'"'.$yearAndTime.' ORDER BY expenseID DESC';
				
			}
		}
	/**********************************************************************************************/
	$result2 = sql_query($query2, $message);
	if($result2 == false){ // if connection to database failed disply critical error page
		displayCriticalError($message,$errorType);
		displayFooter();
		exit;
	}
	else { $row2 = mysql_num_rows($result2);}
	
	/********************************************************************************************/
	
	$result1 = sql_query($query1, $message);
	if($result1 == false){ // if connection to database failed disply critical error page
		displayCriticalError($message,$errorType);
		displayFooter();
		exit;
	}
	else if(mysql_num_rows($result1) == 0) {	
			$expensesList .= "<tr  valign =\"top\" id=\"stockItems\">";
			$expensesList .= "<td align =\"center\">No items found</td></tr>"; 
			for($n = 0; $n < 8; $n++){
				$emptyRows .= "<tr  valign =\"top\" id=\"stockItems\">";
				$emptyRows .= "</tr>";
			} 
		}
	else {	
			$row1 = mysql_num_rows($result1);
			/*******************Determining the values of lower limit and limit of result************/
			if((($row1 - $lowerLimit ) < $perPage) && ($row1 - $lowerLimit ) != 0){ $limit = ($row1 % $perPage); }
			else {$limit = 10;}
			
		/*****************Determining if to display Next and  Previous*************************/
		if($row2 > $lowerLimit + $perPage){
			
			$next = "<a href=\"actions.php?action=next&amp;lowerLimit=".($lowerLimit + $perPage)."&amp;searchTerm=$searchTerm&amp;";
			$next .= "year=$year&amp;month=$month&amp;whichForm=frmExpenses\" ";
			$next .= "onmouseover=\"document.next.src =  defaultImage_Next.src;\" ";
			$next .= "onmouseout=\"document.next.src = defaultImage_Next.src;\">";
			$next .= "<img src=\"/Myshop/images/raw/next.png\" name =\"next\" title =\"Next\" /></a>";
			
		}
		else {$next = "<img src=\"/Myshop/images/raw/empty.png\" title =\"Next\"/>&nbsp;";}
		
		if($lowerLimit > 0){
			$previous = "<a href=\"actions.php?action=previous&amp;lowerLimit=".($lowerLimit - $perPage)."&amp;searchTerm=$searchTerm&amp;";
			$previous .= "year=$year&amp;month=$month&amp;whichForm=frmExpenses\" >";
			$previous .= "onmouseover=\"document.previous.src =  defaultImage_Previous.src;\" ";
			$previous .= "onmouseout=\"document.previous.src = defaultImage_Previous.src;\">";
			$previous .= "<img src=\"/Myshop/images/raw/previous.png\" name =\"previous\" /></a>";
			
		}
		else {$previous = "<img src=\"/Myshop/images/raw/empty2.png\" />&nbsp;";}
		//$expensesList .= $row." Results found";
		for($i = 0; $i< $row1; $i++){
			if(($i + 1)%2 == 0){$bgcolor = "#F8FAFA";}
			else{$bgcolor = "#FBFBFB";}
			$expenses 		= mysql_fetch_array($result1);
			$expenseName 	=htmlspecialchars(stripslashes($expenses["expenseName"]));
			$expenseID	 	=htmlspecialchars(stripslashes($expenses["expenseID"]));
			$comment 		=htmlspecialchars(stripslashes($expenses["comment"]));
			$amount 		=number_format(htmlspecialchars(stripslashes($expenses["amount"])), 2, '.', ',');
			$year 			=htmlspecialchars(stripslashes($expenses["year"]));
			$month			=htmlspecialchars(stripslashes($expenses["month"]));			
			
			if($serial == ""){$serial = "-";}
			
			$infoImage = "<img src=\"/Myshop/images/raw/action_info_icon.png\" title =\"Information\"  alt =\"Information\" />";
			$editImage = "<img src=\"/Myshop/images/raw/action_edit_icon.png\" title =\"Edit\"  alt =\"Edit\" />";
			$deleteImage = "<img src=\"/Myshop/images/raw/action_delete_icon.png\" title =\"Delete\"  alt =\"Delete\" />";
			
			/*********************Info List**********************************************************************/
			$infoList = "<a href=\"actions.php?action=info&amp;lowerLimit=$lowerLimit&amp;searchTerm=$searchTerm&amp;";
			$infoList .= "year=$year&amp;month=$month&amp;";
			$infoList .= "expenseID=$expenseID&amp;whichForm=frmExpenses\">";
			$infoList .= $infoImage."</a>";
			
			/***********************Edit List********************************************************************/
			$editList = "<a href=\"actions.php?action=edit&amp;lowerLimit=$lowerLimit&amp;searchTerm=$searchTerm&amp;";
			$editList .= "year=$year&amp;month=$month&amp;expenseID=$expenseID&amp;whichForm=frmExpenses\">";
			$editList .= $editImage."</a>";
			
			/***********************Delete List********************************************************************/
			$deleteList = "<a href=\"actions.php?action=delete&amp;lowerLimit=$lowerLimit&amp;searchTerm=$searchTerm&amp;";
			$deleteList .= "year=$year&amp;month=$month&amp;expenseID=$expenseID&amp;whichForm=frmExpenses\" ";
			$deleteList .= "onclick =\"return window.confirm('Do you real want to delete this expense?');\">";
			$deleteList .= $deleteImage."</a>";
			
			/***********************ExpenseName********************************************************************/
			$expenseNameLink = "<a href=\"actions.php?action=editExpenseDefinition&amp;lowerLimit=$lowerLimit&amp;searchTerm=$searchTerm&amp;";
			$expenseNameLink .= "year=$year&amp;month=$month&amp;expenseName=$expenseName&amp;whichForm=frmExpenses\">".$expenseName."</a>";
			
			/*****************************Providing Certain previledges to super user*********************************************/

			if(!$_SESSION['userGroup']){
				$editList	 = "";
				$deleteList	 = ""; 
			}
			/**********************************************************************************************************************/
			
			$month = convertMonth($month);
			
			$expensesList .= "<tr id=\"stockItems\" bgcolor=\"$bgcolor\" valign =\"top\">";
			$expensesList .= "</td> <td id=\"expensesSerials\">".$expenseNameLink;
			$expensesList .= "</td><td id=\"expensesDescription\">".$comment."</td><td id=\"expensesName\">K".$amount."</td>";
			$expensesList .= "<td id=\"expensesName\">".$month."</td><td id=\"expensesName\">".$year."</td>";
			$expensesList .= "<td id=\"expensesActions\" align =\"center\">".$infoList.$editList.$deleteList."</td></tr>";
			
			
		}
			for($k = 0; $k < ($perPage - $row1); $k++){
				$emptyRows .= "<tr  valign =\"top\" id=\"stockItems\">";
				$emptyRows .= "<td align =\"center\">&nbsp;</td></tr>";
			} 
			$result2 = sql_query($query2, $message);
			if($result2 == false){ // if connection to database failed disply critical error page
				displayCriticalError($message,$errorType);
				displayFooter();
				exit;
			}
			else { $row2 = mysql_num_rows($result2);}
	}
?>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
  <tr>
    <td><table cellpadding="0" cellspacing="0" border="0" id="formHeader" width="100%">
        <tr>
          <td>Expenses - Expenses List</td>
          <?php displayWelcomeMessage();?>
        </tr>
      </table>
  </tr>
  <tr>
  <td valign="top" align="center">
    <?php
    if($message)
    displayMessage($message,$errorType);
    ?>
  </td>
 </tr>
  <tr>
    <td valign="top">
    <table  cellpadding="0" cellspacing="0" border="0" align="left" width="100%">
        <tr>
        	
            <td valign="middle">
          	<form action="/Myshop/administrator.php" method="post" name="viewExpenses" id="viewExpenses">
              <input id="frmName" name="frmName" value="viewExpenses" type="hidden" />
             <div>&nbsp;</div>
             <label id="searchlabel" for="Month">Year:</label>
              <select name="year" size="1" id="searchSelect">
              <option value="">Salect&nbsp;&nbsp;</option>
              <?php $year = date("Y");
				  for($i = 0; $i<=2; $i++){
					$year = date("Y") - $i;
					 echo "<option value=\"$year\" "; if($valuesArray["year"] == $year) echo "selected = selected";
					 echo ">$year</option>";
			}?>
            </select> 
            <label id="searchlabel" for="Month">Month:</label>
            <select name="month" id="searchSelect">
            	<option value="">Salect&nbsp;&nbsp;</option>
                <option value="01" <?php if($valuesArray["month"] == "01") echo "selected = selected"?>>Jan</option>
                <option value="02" <?php if($valuesArray["month"] == "02") echo "selected = selected"?>>Feb</option>
                <option value="03" <?php if($valuesArray["month"] == "03") echo "selected = selected"?>>Mar</option>
                <option value="04" <?php if($valuesArray["month"] == "04") echo "selected = selected"?>>Apr</option>
                <option value="05" <?php if($valuesArray["month"] == "05") echo "selected = selected"?>>May</option>
                <option value="06" <?php if($valuesArray["month"] == "06") echo "selected = selected"?>>Jun</option>
                <option value="07" <?php if($valuesArray["month"] == "07") echo "selected = selected"?>>Jul</option>
                <option value="08" <?php if($valuesArray["month"] == "08") echo "selected = selected"?>>Aug</option>
                <option value="0$perPage" <?php if($valuesArray["month"] == "0$perPage") echo "selected = selected"?>>Sep</option>
                <option value="10" <?php if($valuesArray["month"] == "10") echo "selected = selected"?>>Oct</option>
                <option value="11" <?php if($valuesArray["month"] == "11") echo "selected = selected"?>>Nov</option>
                <option value="12" <?php if($valuesArray["month"] == "12") echo "selected = selected"?>>Dec</option>
              </select>
            	<label id="searchlabel" for="searchTerm">&nbsp;</label>
                <input id="searchTerm" name="searchTerm" type="text" maxlength="30" size="20" style="text-indent:0px;"
				<?php if ($errorFlag == true){ $value = $valuesArray["searchTerm"]; echo "value=\"$value\" "; }?> />
              	&nbsp;&nbsp;
              <input id="searchButtons"type="submit" name="searchButton"value=" &nbsp;  Search &nbsp; &nbsp;"/>
              <input id="searchButtonsPDF"  type="submit" name="searchButton" value="PDF Export"
               onclick="javascript:action='/Myshop/fpdf/Reports.php';   target='_blank';"/>
          	</form>
            </td>
	</tr>
	<tr>
	   <td id="resultCounter" align="right">
	     <?php if($row1 > 0){
       	     echo "Showing: &nbsp; &nbsp;".($lowerLimit + 1)."
       	     &nbsp;&nbsp;-&nbsp;&nbsp;".($lowerLimit + $row1)."&nbsp;&nbsp;:&nbsp;&nbsp;".$row2;
       	     echo "&nbsp; &nbsp;&nbsp; &nbsp;".$previous."&nbsp;  &nbsp; ".$next;
            }
            else {echo "&nbsp;";}
        ?>
        </td></tr>
      </table></td>
  </tr>
  <tr valign="top">
  	<td>
    <table cellpadding="0" cellspacing="0" border="0" align="center" width="100%">
    <tr  id="stockItemsHeader" align="center">
    	<td id="expensesSerials">Expense</td><td id="expensesDescription">Comment</td>
        <td id="expensesName">Amount</td><td id="expensesName">Month</td>
        <td id="expensesName">Year</td><td id="expensesActions">Actions</td>
     </tr>
     </table>
     </td>
     </tr>
   <tr valign="top">
  	<td>
    <table cellpadding="0" cellspacing="0" border="0" align="left" width="100%">  
  <?php echo $expensesList; 
  		
  ?>
  	</table>
    </td>
    </tr>
    
   
</table>
<?php
	 }
	 ?>
