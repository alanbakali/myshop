<?php 
function displayViewDownPayments($message,$errorArray,$valuesArray,$errorFlag,$errorType){
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
						$allSearchTerms = ' (serial LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR (downPaymentID LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR description LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR customerName LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR address LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR phone LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR email LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR quantity LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR firstPayment LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR lastPayment LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR totalCostPrice LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR recieptNumber LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR balance LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR date LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR time LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR user LIKE "%'.addslashes($searchTermArray[$j]).'%")';
					}
					else {
						$allSearchTerms .= ' OR (serial LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR downPaymentID LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR description LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR customerName LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR address LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR phone LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR email LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR quantity LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR firstPayment LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR lastPayment LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR totalCostPrice LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR recieptNumber LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR balance LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR date LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR time LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR user LIKE "%'.addslashes($searchTermArray[$j]).'%")';
					}
				}
				
				// Check if the item realy exist in the database before inserting
				$returned ="No";
				$query1 = 'SELECT * FROM downpayments WHERE';
				$query1 .= $allSearchTerms.') AND returned="'.$returned.'"'.$yearAndTime.' ORDER BY downPaymentID DESC LIMIT '.$lowerLimit.','.$perPage;
				
				$query2 = 'SELECT * FROM downpayments WHERE';
				$query2 .= $allSearchTerms.') AND returned="'.$returned.'"'.$yearAndTime.' ORDER BY downPaymentID DESC';			
				
				$searchTerm=stripslashes($searchTerm);
				
			}
			else {
				$returned ="No";
				$query1 = 'SELECT * FROM downpayments WHERE returned="'.$returned.'"'.$yearAndTime.' ORDER BY downPaymentID DESC LIMIT '.$lowerLimit.','.$perPage;
				$query2 = 'SELECT * FROM downpayments WHERE returned="'.$returned.'"'.$yearAndTime.' ORDER BY downPaymentID DESC';
				
			}
		}
	/**********************************************************************************************/
	$result2 = sql_query($query2, $message);
	$row2 = mysql_num_rows($result2);
	
	/********************************************************************************************/
	
	$result1 = sql_query($query1, $message);
	if(mysql_num_rows($result1) == 0) {	
			$downPaymentsList .= "<tr  valign =\"top\" id=\"stockItems\">";
			$downPaymentsList .= "<td align =\"center\">No items found</td></tr>"; 
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
			$next .= "year=$year&amp;month=$month&amp;whichForm=frmDownPayments\" ";
			$next .= "onmouseover=\"document.next.src =  defaultImage_Next.src;\" ";
			$next .= "onmouseout=\"document.next.src = defaultImage_Next.src;\">";
			$next .= "<img src=\"/Myshop/images/raw/next.png\" name =\"next\" title =\"Next\" /></a>";
			
		}
		else {$next = "<img src=\"/Myshop/images/raw/empty.png\" title =\"Next\"/>&nbsp;";}
		
		if($lowerLimit > 0){
			$previous = "<a href=\"actions.php?action=previous&amp;lowerLimit=".($lowerLimit + $perPage)."&amp;searchTerm=$searchTerm&amp;";
			$previous .= "year=$year&amp;month=$month&amp;whichForm=frmDownPayments\" >";
			$previous .= "onmouseover=\"document.previous.src =  defaultImage_Previous.src;\" ";
			$previous .= "onmouseout=\"document.previous.src = defaultImage_Previous.src;\">";
			$previous .= "<img src=\"/Myshop/images/raw/previous.png\" name =\"previous\" /></a>";
			
		}
		else {$previous = "<img src=\"/Myshop/images/raw/empty2.png\" />&nbsp;";}
		//$downPaymentsList .= $row." Results found";
		for($i = 0; $i< $row1; $i++){
			if(($i + 1)%2 == 0){$bgcolor = "#F8FAFA";}
			else{$bgcolor = "#FBFBFB";}
			$downPayments 		= mysql_fetch_array($result1);
			$downPaymentID 		=htmlspecialchars(stripslashes($downPayments["downPaymentID"]));
			$serial 			=htmlspecialchars(stripslashes($downPayments["serial"]));
			$customerName 		=htmlspecialchars(stripslashes($downPayments["customerName"]));
			$title 				=htmlspecialchars(stripslashes($downPayments["title"]));
			$description 		=htmlspecialchars(stripslashes($downPayments["description"]));
			$quantity 			=htmlspecialchars(stripslashes($downPayments["quantity"]));
			$totalCostPrice 	=number_format(htmlspecialchars(stripslashes($downPayments["totalCostPrice"])), 2, '.', ',');
			$firstPayment		=number_format(htmlspecialchars(stripslashes($downPayments["firstPayment"])), 2, '.', ',');
			$lastPayment		=number_format(htmlspecialchars(stripslashes($downPayments["lastPayment"])), 2, '.', ',');
			$balance 			=number_format(htmlspecialchars(stripslashes($downPayments["balance"])), 2, '.', ',');
			$user				=htmlspecialchars(stripslashes($downPayments["user"]));
			$date				=convertDate(htmlspecialchars(stripslashes($downPayments["date"])));
			$time				=htmlspecialchars(stripslashes($downPayments["time"]));
			$returned			=htmlspecialchars(stripslashes($downPayments["returned"]));
			
			
			if($serial == ""){$serial = "-";}
			
			$infoImage = "<img src=\"/Myshop/images/raw/action_info_icon.png\" title =\"Information\"  alt =\"Information\" />";
			$editImage = "<img src=\"/Myshop/images/raw/action_edit_icon.png\" title =\"Edit\"  alt =\"Edit\" />";
			$deleteImage = "<img src=\"/Myshop/images/raw/action_delete_icon.png\" title =\"Return/Cancel\"  alt =\"Return/Cancel\" />";
			$lastPaymentImage = "<img src=\"/Myshop/images/raw/action_lastPayment_icon.png\" title =\"Final Payment\" alt =\"Final Payment\" />";
			$lastPaymentImage2 = "<img src=\"/Myshop/images/raw/action_lastPayment_icon2.png\" />";
			
			/********************************Delete List*************************************************/
			$deleteList = "<a href=\"actions.php?action=delete&amp;lowerLimit=$lowerLimit&amp;searchTerm=$searchTerm&amp;";
			$deleteList .= "year=$year&amp;month=$month&amp;downPaymentID=$downPaymentID&amp;whichForm=frmDownPayments\" ";
			$deleteList .= "onclick =\"return window.confirm('Do you real want to cancel this downPayment ');\">";
			$deleteList .= $deleteImage."</a>";
			
			/*********************Info List**********************************************************************/
			$infoList = "<a href=\"actions.php?action=info&amp;lowerLimit=$lowerLimit&amp;searchTerm=$searchTerm&amp;";
			$infoList .= "year=$year&amp;month=$month&amp;downPaymentID=$downPaymentID&amp;whichForm=frmDownPayments\">";
			$infoList .= $infoImage."</a>";
			
			/*********************Info List**********************************************************************/
			$lastPaymentList = "<a href=\"actions.php?action=lastPayment&amp;lowerLimit=$lowerLimit&amp;searchTerm=$searchTerm&amp;";
			$lastPaymentList .= "year=$year&amp;month=$month&amp;downPaymentID=$downPaymentID&amp;whichForm=frmDownPayments\">";
			$lastPaymentList .= $lastPaymentImage."</a>";
			
			if(htmlspecialchars(stripslashes($downPayments["balance"])) == 0){$lastPaymentList = $lastPaymentImage2;}
			
			/***********************Edit List********************************************************************/
			$editList = "<a href=\"actions.php?action=edit&amp;lowerLimit=$lowerLimit&amp;searchTerm=$searchTerm&amp;";
			$editList .= "downPaymentID=$downPaymentID&amp;whichForm=frmDownPayments\">";
			$editList .= $editImage."</a>";
			
			/*****************************Providing Certain previledges to super user*********************************************/

			if($_SESSION['userGroup'] != "Administrator"){
				$editList	 = "";
				$deleteList	 = ""; 
			}
			/**********************************************************************************************************************/
			
			$downPaymentsList .= "<tr id=\"stockItems\" bgcolor=\"$bgcolor\" valign =\"top\">";
			$downPaymentsList .= "<td id=\"downPaymentID\">".$downPaymentID."</td><td id=\"downPaymentDescription\">".$description;
			$downPaymentsList .= "</td> <td id=\"downPaymentSerials\">".$title.". ".$customerName;
			$downPaymentsList .= "</td><td id=\"downPaymentQuantity\">".$quantity."</td><td id=\"downPaymentName\">K".$totalCostPrice."</td>";
			$downPaymentsList .= "<td id=\"downPaymentName\">K".$firstPayment;
			$downPaymentsList .= "</td><td id=\"downPaymentName\">K".$lastPayment."</td><td id=\"downPaymentName\">K".$balance."</td>";
			$downPaymentsList .= "<td id=\"downPaymentActions\" align=\"center\">".$infoList.$editList.$deleteList.$lastPaymentList."</td></tr>";
			
			
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
          <td>DownPayment - DownPayments List</td>
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
          	<form action="/Myshop/administrator.php" method="post" name="viewDownPayments" id="viewDownPayments">
              <input id="frmName" name="frmName" value="viewDownPayments" type="hidden" />
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
	      <input id="searchButtonsPDF"  type="submit" name="searchButton" value=" PDF Export"
               onclick="javascript:action='/Myshop/fpdf/Reports.php';   target='_blank';"/>
      
        
              </form>
            </td>
	</tr>
	<tr>
	    <td id="resultCounter" align="right"> <div>&nbsp;
		   <?php if($row1 > 0){
       		 echo ($lowerLimit + 1)."
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
    <tr  id="stockItemsHeader" align="center"><td id="downPaymentID">DownPayment ID</td>
    	<td id="downPaymentDescription">Item Description</td><td id="downPaymentSerials">Customer Name</td>
        <td id="downPaymentQuantity">Quantity</td><td id="downPaymentName">Total Cost</td><td id="downPaymentName">First Payment</td>
        <td id="downPaymentName">Final Payment</td><td id="downPaymentName">Balance</td><td id="downPaymentActions">Actions</td>
     </tr>
     </table>
     </td>
     </tr>
   <tr valign="top">
  	<td>
    <table cellpadding="0" cellspacing="0" border="0" align="left" width="100%">  
  <?php echo $downPaymentsList; 
  	
  ?>
  	</table>
    </td>
    </tr>
    
    
</table>
<?php
	 }
	 ?>
