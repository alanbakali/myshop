<?php 
function displayViewStockDefinitions($message,$errorArray,$valuesArray,$errorFlag,$errorType){
		$perPage = 15;
		if($valuesArray["query"] && $valuesArray["query"] !=""){
			$query1 = $valuesArray["query"];
			$query2 = $valuesArray["query"];
		}
		else{
			if($valuesArray["lowerLimit"] == ""){	$lowerLimit = 0;}
			else {$lowerLimit = $valuesArray["lowerLimit"];}
		
			$searchTerm = $valuesArray["searchTerm"];
			
			if($searchTerm !=""){
				$errorFlag=true;
				$searchTerm = trim(stripslashes($searchTerm));//Removing white spaces from strat and end of search term
				$searchTermArray = explode(" ", $searchTerm);//Splitting multiple word search term into single search terms
				$numberOfSearchTerms = count($searchTermArray);
				for($j = 0; $j < $numberOfSearchTerms; $j++){
					if($j == 0){
						$allSearchTerms  = ' (stockID LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR description LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR stockDate LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR date LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR time LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR user LIKE "%'.addslashes($searchTermArray[$j]).'%"';
					}
					else {
						$allSearchTerms .= ' OR stockID LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR description LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR stockDate LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR date LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR time LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR user LIKE "%'.addslashes($searchTermArray[$j]).'%"';
					}
				}
				
				// Check if the item realy exist in the database before inserting
				$query1 = 'SELECT * FROM stock WHERE';
				$query1 .= $allSearchTerms.') ORDER BY stockID DESC LIMIT '.$lowerLimit.','.$perPage;
				
				$query2 = 'SELECT * FROM stock WHERE';
				$query2 .= $allSearchTerms.') ORDER BY stockID DESC';			
				
				$searchTerm=stripslashes($searchTerm);
			}
			else {
				$query1 = 'SELECT * FROM stock ORDER BY stockID DESC LIMIT '.$lowerLimit.','.$perPage;
				$query2 = 'SELECT * FROM stock ORDER BY stockID DESC';
				
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
			$stockItemsList .= "<tr  valign =\"top\" id=\"stockItems\">";
			$stockItemsList .= "<td align =\"center\">No items found</td></tr>"; 
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
			
			$next = "<a href=\"actions.php?action=next&amp;lowerLimit=".($lowerLimit + $perPage)."&amp;searchTerm=$searchTerm&amp;whichForm=frmStockDefn\" ";
			$next .= "onmouseover=\"document.next.src =  defaultImage_Next.src;\" ";
			$next .= "onmouseout=\"document.next.src = defaultImage_Next.src;\">";
			$next .= "<img src=\"/Myshop/images/raw/next.png\" name =\"next\" title =\"Next\" /></a>";
			
		}
		else {$next = "<img src=\"/Myshop/images/raw/empty.png\" title =\"Next\"/>&nbsp;";}
		
		if($lowerLimit > 0){
			$previous = "<a href=\"actions.php?action=previous&amp;lowerLimit=".($lowerLimit - $perPage)."&amp;searchTerm=$searchTerm&amp;whichForm=frmStockDefn\" >";
			$$previous .= "onmouseover=\"document.previous.src =  defaultImage_Previous.src;\" ";
			$$previous .= "onmouseout=\"document.previous.src = defaultImage_Previous.src;\">";
			$previous .= "<img src=\"/Myshop/images/raw/previous.png\" name =\"previous\" /></a>";
			
		}
		else {$previous = "<img src=\"/Myshop/images/raw/empty2.png\" />&nbsp;";}
		//$stockItemsList .= $row." Results found";
		for($i = 0; $i< $row1; $i++){
			if(($i + 1)%2 == 0){$bgcolor = "#F8FAFA";}
			else{$bgcolor = "#FBFBFB";}
			$stockItems 		= mysql_fetch_array($result1);
			$stockID 			=htmlspecialchars(stripslashes($stockItems["stockID"]));
			$description 		=htmlspecialchars(stripslashes($stockItems["description"]));
			$stockDate			=convertDate(htmlspecialchars(stripslashes($stockItems["stockDate"])));
			$user				=htmlspecialchars(stripslashes($stockItems["user"]));
			$date				=convertDate(htmlspecialchars(stripslashes($stockItems["date"])));
			$time				=htmlspecialchars(stripslashes($stockItems["time"]));
			
			
			if($description == ""){$description = "-";}
			
			$infoImage = "<img src=\"/Myshop/images/raw/action_info_icon.png\" title =\"Information\"  alt =\"Information\" />";
			$editImage = "<img src=\"/Myshop/images/raw/action_edit_icon.png\" title =\"Edit\"  alt =\"Edit\" />";
			/*********************Info List**********************************************************************/
			$infoList = "<a href=\"actions.php?action=info&amp;lowerLimit=$lowerLimit&amp;searchTerm=$searchTerm&amp;stockID=$stockID&amp;whichForm=frmStockDefn\">";
			$infoList .= $infoImage."</a>";
			
			/***********************Edit List********************************************************************/
			$editList = "<a href=\"actions.php?action=edit&amp;lowerLimit=$lowerLimit&amp;searchTerm=$searchTerm&amp;stockID=$stockID&amp;whichForm=frmStockDefn\">";
			$editList .= $editImage."</a>";
			
			/*****************************Providing Certain previledges to super user*********************************************/

			if($_SESSION['userGroup'] != "Administrator"){
				$editList	 = "<img src=\"/Myshop/images/raw/action_edit_icon2.png\" title =\"Disabled\"  alt =\"Disabled\" />";
				$deleteList	 = "<img src=\"/Myshop/images/raw/action_delete_icon2.png\" title =\"Disabled\"  alt =\"Disabled\" />"; 
			}
			/**********************************************************************************************************************/
			
			$stockItemsList .= "<tr id=\"stockItems\" bgcolor=\"$bgcolor\" valign =\"top\">";
			$stockItemsList .= "<td id=\"namesUsers\">".$stockID;
			$stockItemsList .= "</td><td id=\"descrpitionsUsers\">".$description;
			$stockItemsList .= "</td><td id=\"namesUsers\">".$stockDate."</td><td id=\"namesUsers\">".$user."</td><td id=\"namesUsers\">".$date;
			$stockItemsList .= "</td><td id=\"namesUsers\">".$time."</td>";
			$stockItemsList .= "</td><td id=\"actionsUsers\">".$infoList.$editList."</td></tr>";
			
			
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
          <td>Stock Definition - Stock Definition List</td>
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
   <table  cellpadding="0" cellspacing="0" border="0" width="100%">
        <tr>
          <td align="left"><form action="/Myshop/administrator.php" method="post" name="viewStockDefinitions">
		<div>&nbsp;</div>
              <input id="frmName" name="frmName" value="viewStockDefinitions" type="hidden" />
              <?php
              $query = "SELECT DISTINCT stockID FROM stock ORDER BY stockID DESC LIMIT 0,3";
				$resultStockIDs = sql_query($query, $message);
				if(mysql_num_rows($resultStockIDs) > 0) 	
				$stockIDRows = mysql_num_rows($resultStockIDs);
			 ?>
              <label for="stockID" id="searchlabel">Stock ID:</label>
              <select name="stockID" id="searchSelect">
                <option value="">Select</option>
                <?php
                 for($i = 0; $i< $stockIDRows; $i++){
                    $stockIDs = mysql_fetch_array($resultStockIDs);
                    $stockID = htmlspecialchars(stripslashes($stockIDs["stockID"]));
                    echo "<option value=\"$stockID\" "; if($valuesArray["stockID"] == $stockID) echo "selected = \"selected\" ";
                    echo ">$stockID</option>";
                }
                ?>
              </select>
              <label for="searchTerm" id="searchlabel">&nbsp;</label>
              <input id="searchTerm" name="searchTerm" type="text" maxlength="30" size="20" style="text-indent:0px;"
				<?php if ($errorFlag == true){ $value = $valuesArray["searchTerm"]; echo "value=\"$value\" "; }?> />
              <input id="searchButtons"  type="submit" name="searchButton"value=" &nbsp;  Search &nbsp; &nbsp;"/>
              <input id="searchButtonsPDF"  type="submit" name="searchButton" value=" PDF Export"/>
            </form>
           </td>
	</tr>
	<tr>
          <td id="resultCounter" align="right">
            <?php if($row1 > 0){
       		 echo ($lowerLimit + 1)."
       		 &nbsp;&nbsp;-&nbsp;&nbsp;".($lowerLimit + $row1)."&nbsp;&nbsp;:&nbsp;&nbsp;".$row2;
       		 echo "&nbsp;&nbsp;&nbsp;&nbsp;".$previous."&nbsp;  &nbsp; ".$next;
	
            }
            else {echo "&nbsp;";}
        ?>
          </td>
        </tr>
      </table></td>
  </tr>
  <tr valign="top">
  	<td>
    <table cellpadding="0" cellspacing="0" border="0" align="center" width="100%">
    <tr  id="stockItemsHeader" align="center">
    	<td id="namesUsers">Stock ID</td><td id="descrpitionsUsers">Description</td>
        <td id="namesUsers">Stock Date</td><td id="namesUsers">User</td>
        <td id="namesUsers">Last Modified</td><td id="namesUsers">Time</td><td id="actionsUsers">&nbsp;</td>
     </tr>
     </table>
     </td>
     </tr>
   <tr valign="top">
  	<td>
    <table cellpadding="0" cellspacing="0" border="0" align="left" width="100%">  
  <?php echo $stockItemsList; 
  		
  ?>
 
  	</table>
    </td>
    </tr>
    
    
</table>
<?php
	 }
	 ?>
