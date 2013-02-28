<?php 
function displayViewServices($message,$errorArray,$valuesArray,$errorFlag,$errorType){
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
				$yearAndTime = ' AND year(date)='.$year;
			}
			else{
				if(($year =="") && ($month !="")){
				$yearAndTime = ' AND month(date)='.$month;
				}
				else{
					if(($year !="") && ($month !="")){
					$yearAndTime = ' AND (month(date)='.$month.'';
					$yearAndTime .= ' AND year(date)='.$year.')';
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
						$allSearchTerms = ' (serviceID LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR item LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR problem LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR customerName LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR phone LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR email LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR address LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR serial LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR charges LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR balance LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR date LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR time LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR user LIKE "%'.addslashes($searchTermArray[$j]).'%")';
					}
					else {
						$allSearchTerms .= ' OR (serviceID LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR item LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR problem LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR customerName LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR phone LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR email LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR address LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR serial LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR charges LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR balance LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR date LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR time LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR user LIKE "%'.addslashes($searchTermArray[$j]).'%")';
					}
				}
				
				// Check if the item realy exist in the database before inserting
				$returned ="No";
				$query1 = 'SELECT * FROM services WHERE';
				$query1 .= $allSearchTerms.') AND returned="'.$returned.'"'.$yearAndTime.' ORDER BY serviceID DESC LIMIT '.$lowerLimit.','.$perPage;
				
				$query2 = 'SELECT * FROM services WHERE';
				$query2 .= $allSearchTerms.') AND returned="'.$returned.'"'.$yearAndTime.' ORDER BY serviceID DESC';			
				
				$searchTerm=stripslashes($searchTerm);
				
			}
			else {
				$returned ="No";
				$query1 = 'SELECT * FROM services WHERE returned="'.$returned.'"'.$yearAndTime.' ORDER BY serviceID DESC LIMIT '.$lowerLimit.','.$perPage;
				$query2 = 'SELECT * FROM services WHERE returned="'.$returned.'"'.$yearAndTime.' ORDER BY serviceID DESC';
				
			}
		}
	/**********************************************************************************************/
	$result2 = sql_query($query2, $message);
	$row2 = mysql_num_rows($result2);
	
	/********************************************************************************************/
	
	$result1 = sql_query($query1, $message);
	if(mysql_num_rows($result1) == 0) {	
		$servicesList .= "<tr  valign =\"top\" id=\"stockItems\">";
		$servicesList .= "<td align =\"center\">No items found</td></tr>"; 
		for($n = 0; $n < 8; $n++){
			$emptyRows .= "<tr  valign =\"top\" id=\"stockItems\">";
			$emptyRows .= "</tr>";
		} 
	}
	else {	
			$row1 = mysql_num_rows($result1);
			/*******************Determining the values of lower limit and limit of result************/
			if((($row1 - $lowerLimit ) < $perPage) && ($row1 - $lowerLimit ) != 0){ $limit = ($row1 % $perPage); }
			else {$limit = $perPage;}
			
		/*****************Determining if to display Next and  Previous*************************/
		if($row2 > $lowerLimit + $perPage){
			
			$next = "<a href=\"actions.php?action=next&amp;lowerLimit=".($lowerLimit + $perPage)."&amp;searchTerm=$searchTerm&amp;";
			$next .= "year=$year&amp;month=$month&amp;whichForm=frmServices\" ";
			$next .= "onmouseover=\"document.next.src =  defaultImage_Next.src;\" ";
			$next .= "onmouseout=\"document.next.src = defaultImage_Next.src;\">";
			$next .= "<img src=\"/Myshop/images/raw/next.png\" name =\"next\" title =\"Next\" /></a>";
			
		}
		else {$next = "<img src=\"/Myshop/images/raw/empty.png\" title =\"Next\"/>&nbsp;";}
		if($lowerLimit > 0){
			$previous = "<a href=\"actions.php?action=previous&amp;lowerLimit=".($lowerLimit - $perPage)."&amp;searchTerm=$searchTerm&amp;";
			$previous .= "year=$year&amp;month=$month&amp;whichForm=frmServices\" ";
			$previous .= "onmouseover=\"document.previous.src =  defaultImage_Previous.src;\" ";
			$previous .= "onmouseout=\"document.previous.src = defaultImage_Previous.src;\">";
			$previous .= "<img src=\"/Myshop/images/raw/previous.png\" name =\"previous\" /></a>";
			
		}
		else {$previous = "<img src=\"/Myshop/images/raw/empty2.png\" />&nbsp;";}
		//$servicesList .= $row." Results found";
		
		for($i = 0; $i< $row1; $i++){
			if(($i + 1)%2 == 0){$bgcolor = "#F8FAFA";}
			else{$bgcolor = "#FBFBFB";}
			$stockItems 		= mysql_fetch_array($result1);
			$serviceID 			=htmlspecialchars(stripslashes($stockItems["serviceID"]));
			$item				=htmlspecialchars(stripslashes($stockItems["item"]));
			$customerName 		=htmlspecialchars(stripslashes($stockItems["customerName"]));
			$title 				=htmlspecialchars(stripslashes($stockItems["title"]));
			$problem	 		=htmlspecialchars(stripslashes($stockItems["problem"]));
			$balance			= htmlspecialchars(stripslashes($stockItems["charges"]))  -  htmlspecialchars(stripslashes($stockItems["amount"]));
			$charges 			=number_format(htmlspecialchars(stripslashes($stockItems["charges"])), 2, '.', ',');
			$amount				=number_format(htmlspecialchars(stripslashes($stockItems["amount"])), 2, '.', ',');
			
			$balance			=number_format($balance, 2, '.', ',');
			$user				=htmlspecialchars(stripslashes($stockItems["user"]));
			$date				=convertDate(htmlspecialchars(stripslashes($stockItems["date"])));
			$time				=htmlspecialchars(stripslashes($stockItems["time"]));
			$status				=htmlspecialchars(stripslashes($stockItems["status"]));
			$installment		=htmlspecialchars(stripslashes($stockItems["installment"]));
			
			
			if($serial == ""){$serial = "-";}
			
			$infoImage = "<img src=\"/Myshop/images/raw/action_info_icon.png\" title =\"Information\"  alt =\"Information\" />";
			$editImage = "<img src=\"/Myshop/images/raw/action_edit_icon.png\" title =\"Edit\"  alt =\"Edit\" />";
			$paymentImage = "<img src=\"/Myshop/images/raw/action_Payment_icon.png\" title =\"Payment\"  alt =\"Payment\" />";
			
			/*********************Info List**********************************************************************/
			$infoList = "<a href=\"actions.php?action=info&amp;lowerLimit=$lowerLimit&amp;searchTerm=$searchTerm&amp;";
			$infoList .= "year=$year&amp;month=$month&amp;serviceID=$serviceID&amp;whichForm=frmServices\">";
			$infoList .= $infoImage."</a>";
			
			/*********************Payment List**********************************************************************/
			$paymentList = "<a href=\"actions.php?action=payment&amp;lowerLimit=$lowerLimit&amp;searchTerm=$searchTerm&amp;";
			$paymentList .= "year=$year&amp;month=$month&amp;serviceID=$serviceID&amp;whichForm=frmServices\">";
			$paymentList .= $paymentImage."</a>";
			
			/***********************Edit List********************************************************************/
			$editList = "<a href=\"actions.php?action=edit&amp;lowerLimit=$lowerLimit&amp;searchTerm=$searchTerm&amp;";
			$editList .= "year=$year&amp;month=$month&amp;serviceID=$serviceID&amp;whichForm=frmServices\">";
			$editList .= $editImage."</a>";
			
			/*****************************Providing Certain previledges to super user*********************************************/

			if($_SESSION['userGroup'] != "Administrator"){
				$editList	 = "";
				$deleteList	 = ""; 
			}
			/**********************************************************************************************************************/
			
			$servicesList .= "<tr id=\"stockItems\" bgcolor=\"$bgcolor\" valign =\"top\">";
			$servicesList .= "<td id=\"servicesDescription\">".$item."</td><td id=\"servicesSerials\">".$title.". ".$customerName;
			$servicesList .= "</td><td id=\"servicesName\">".$charges."</td><td id=\"servicesName\">K".$amount."</td><td id=\"servicesName\">".$status;
			$servicesList .= "</td><td id=\"servicesName\">".$user."</td><td id=\"servicesName\">".$date."</td>";
			$servicesList .= "<td id=\"servicesActions\" align =\"center\">".$infoList.$editList.$paymentList."</td></tr>";
			
			
		}
			for($k = 0; $k < ($perPage - $row1); $k++){
				$emptyRows .= "<tr  valign =\"top\" id=\"stockItems\">";
				$emptyRows .= "<td align =\"center\">&nbsp;</td></tr>";
			} 
			$result2 = sql_query($query2, $message);
			$row2 = mysql_num_rows($result2);
	}
	
?>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
  <tr>
    <td><table cellpadding="0" cellspacing="0" border="0" id="formHeader" width="100%">
        <tr>
          <td>Services - Services List</td>
          <?php displayWelcomeMessage(); ?>
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
          	<form action="/Myshop/administrator.php" method="post" name="viewServices">
              <input id="frmName" name="frmName" value="viewServices" type="hidden" />
             <div>&nbsp;</div>
             <label id="searchlabel" for="year">Year:</label>
              <select name="year" size="1" id="searchSelect">
              <option value="">Salect&nbsp;&nbsp;</option>
              <?php echo $valuesArray["year"];
			  	  $year = date("Y"); 
				  for($i = 0; $i<=2; $i++){
					$year = date("Y") - $i;
					 echo "<option value=\"$year\" "; if($valuesArray["year"] == $year) echo "selected = selected";
					 echo ">$year</option>";
			}?>
            </select> 
            <label id="searchlabel" for="month">Month:</label>
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
              <input id="searchButtons"type="submit" name="searchButton"value=" &nbsp;  Search &nbsp; &nbsp;" />
              <div>&nbsp;</div>
          	</form>
            </td><td id="resultCounter" align="right"> <div>&nbsp;</div>  <div>&nbsp;</div>
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
    <tr  id="stockItemsHeader" align="center"><td id="servicesDescription">Item</td>
        <td id="servicesSerials">Customer Name</td><td id="servicesName">Charges</td><td id="servicesName">Amount Paid</td> 
        <td id="servicesName">Status</td><td id="servicesName">User</td><td id="servicesName">Date</td><td id="servicesActions">Actions</td>
     </tr>
     </table>
     </td>
     </tr>
   <tr valign="top">
  	<td>
    <table cellpadding="0" cellspacing="0" border="0" align="left" width="100%">  
  <?php echo $servicesList; 
  		
  ?>
 
  	</table>
    </td>
    </tr>
    
    
</table>
<?php
	 }
	 ?>
