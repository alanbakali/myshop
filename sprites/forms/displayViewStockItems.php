 <?php 
function displayViewStockItems($message,$errorArray,$valuesArray,$errorFlag,$errorType){
		$perPage = 15;
		$searchTerm = $valuesArray["searchTerm"];
		$stockID	= $valuesArray["stockID"];
		
		if($valuesArray["query"] && $valuesArray["query"] !=""){
			$query1 = $valuesArray["query"];
			$query2 = $valuesArray["query"];
		}
		else{
			
			if($valuesArray["lowerLimit"] == ""){	$lowerLimit = 0;}
			else {$lowerLimit = $valuesArray["lowerLimit"];}
		
			
			
			if(($stockID !="")){$stockIDSearch = ' AND stockID ='.$stockID;}
			else {$stockIDSearch = "";}
			
			if($searchTerm !=""){
				$errorFlag=true;
				$allSearchTerms = viewStockItemsSearchTerms($searchTerm);
				// Check if the item realy exist in the database before inserting
				$query1 = 'SELECT * FROM stockitems WHERE ';
				$query1 .= 'quantity > 0 AND '.$allSearchTerms.') '.$stockIDSearch.' ORDER BY itemID DESC LIMIT '.$lowerLimit.','.$perPage;
				
				$query2 = 'SELECT * FROM stockitems WHERE '; 
				$query2 .= 'quantity > 0 AND '.$allSearchTerms.') '.$stockIDSearch.' ORDER BY itemID DESC';			
				
				$searchTerm=stripslashes($searchTerm);  
			}
			else {
				$query1 = 'SELECT * FROM stockitems WHERE quantity > 0 '.$stockIDSearch.' ORDER BY itemID DESC LIMIT '.$lowerLimit.','.$perPage;
				$query2 = 'SELECT * FROM stockitems WHERE quantity > 0 '.$stockIDSearch.' ORDER BY itemID DESC';
			}
			
		}
		
		
	/**********************************************************************************************/
	
	$result2 = sql_query($query2, $message);
	$row2 = mysql_num_rows($result2);
	/********************************************************************************************/
	
	$result1 = sql_query($query1, $message);
	if(mysql_num_rows($result1) == 0) {	
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
			
		/*****************Determining if to display Next and  Previous***********************stockID**/
		if($row2 > $lowerLimit + $perPage){
			
			$next = "<a href=\"actions.php?action=next&amp;stockID=$stockID&amp;lowerLimit=".($lowerLimit + $perPage)."&amp;searchTerm=$searchTerm&amp;whichForm=frmItems\" ";
			$next .= "onmouseover=\"javascript:document.next.src =  defaultImage_Next.src;\" ";
			$next .= "onmouseout=\"document.next.src = defaultImage_Next.src;\">";
			$next .= "<img src=\"/Myshop/images/raw/next.png\" name =\"next\" title =\"Next\" /></a>";
			
		}
		else {$next = "<a href=\"#\"><img src=\"/Myshop/images/raw/empty.png\" title =\"Next\"/></a>";}
		
		if($lowerLimit > 0){
			$previous = "<a href=\"actions.php?action=previous&amp;stockID=$stockID&amp;lowerLimit=".($lowerLimit - $perPage)."&amp;searchTerm=$searchTerm&amp;whichForm=frmItems\" ";
			$previous .= "onmouseover=\"document.previous.src =  defaultImage_Previous.src;\" ";
			$previous .= "onmouseout=\"document.previous.src = defaultImage_Previous.src;\">";
			$previous .= "<img src=\"/Myshop/images/raw/previous.png\" name =\"previous\" title =\"Previous\" /></a>";
			
		}
		else {$previous = "<a href=\"#\"><img src=\"/Myshop/images/raw/empty2.png\" /></a>";}
		//$stockItemsList .= $row." Results found";
		for($i = 0; $i< $row1; $i++){
			if(($i + 1)%2 == 0){$bgcolor = "#F8FAFA";}
			else{$bgcolor = "#FBFBFB";}
			$stockItems 		= mysql_fetch_array($result1);
			$stockID 			=htmlspecialchars(stripslashes($stockItems["stockID"]));
			$itemID 			=htmlspecialchars(stripslashes($stockItems["itemID"]));
			$serial 			=htmlspecialchars(stripslashes($stockItems["serial"]));
			$description 		=htmlspecialchars(stripslashes($stockItems["description"]));
			$quantity 			=htmlspecialchars(stripslashes($stockItems["quantity"]));
			$price				=number_format(htmlspecialchars(stripslashes($stockItems["price"])), 2, '.', ',');
			$user				=htmlspecialchars(stripslashes($stockItems["user"]));
			$date				=convertDate(htmlspecialchars(stripslashes($stockItems["date"])));
			$time				=htmlspecialchars(stripslashes($stockItems["time"]));
			$sold				=htmlspecialchars(stripslashes($stockItems["sold"]));
			$deleted			=htmlspecialchars(stripslashes($stockItems["deleted"]));
			$installment		=htmlspecialchars(stripslashes($stockItems["installment"]));
			
			if($serial == ""){$serial = "-";}
			
			$infoImage = "<img src=\"/Myshop/images/raw/action_info_icon.png\" title =\"Information\"  alt =\"Information\" />";
			$editImage = "<img src=\"/Myshop/images/raw/action_edit_icon.png\" title =\"Edit\"  alt =\"Edit\" />";
			$deleteImage = "<img src=\"/Myshop/images/raw/action_delete_icon.png\" title =\"Delete\"  alt =\"Delete\" />";
			$saleImage = "<img src=\"/Myshop/images/raw/action_sales.png\" title =\"Sale\"  alt =\"Sale\"/>";
			$installmentImage = "<img src=\"/Myshop/images/raw/action_installment.png\" title =\"Installment\" alt =\"Installment\"/>";
			
			/********************************Delete List*************************************************/
			$deleteList = "<a href=\"actions.php?action=delete&amp;lowerLimit=$lowerLimit&amp;searchTerm=$searchTerm&amp;";
			$deleteList .= "stockID=$stockID&amp;itemID=$itemID&amp;whichForm=frmItems\">";
			$deleteList .= $deleteImage."</a>";
			
			/*******************************Sale List*****************888888888***********************************/
			$saleList = "<a href=\"actions.php?action=sale&amp;lowerLimit=$lowerLimit&amp;searchTerm=$searchTerm&amp;";
			$saleList .= "stockID=$stockID&amp;itemID=$itemID&amp;whichForm=frmItems\">";
			$saleList .= $saleImage."</a>";
			
			/****************************************************************************************************/
			$installmentList = "<a href=\"actions.php?action=installment&amp;stockID=$stockID&amp;";
			$installmentList .= "lowerLimit=$lowerLimit&amp;searchTerm=$searchTerm&amp;itemID=$itemID&amp;whichForm=frmItems\">";
			$installmentList .= $installmentImage;
			/*********************Info List**********************************************************************/
			$infoList = "<a href=\"actions.php?action=info&amp;lowerLimit=$lowerLimit&amp;searchTerm=$searchTerm&amp;";
			$infoList .= "stockID=$stockID&amp;itemID=$itemID&amp;whichForm=frmItems\">";
			$infoList .= $infoImage."</a>";
			
			/***********************Edit List********************************************************************/
			$editList = "<a href=\"actions.php?action=edit&amp;lowerLimit=$lowerLimit&amp;searchTerm=$searchTerm&amp;itemID=$itemID&amp;whichForm=frmItems\">";
			$editList .= $editImage."</a>";
			
			/*****************************Providing Certain previledges to super user*********************************************/

			if($_SESSION['userGroup'] != "Administrator"){
				$editList	 = "";
				$deleteList	 = ""; 
			}
			/**********************************************************************************************************************/
			
			$stockItemsList .= "<tr id=\"stockItems\" bgcolor=\"$bgcolor\" valign =\"top\">";
			$stockItemsList .= "<td id=\"itemIDs\">".$itemID."</td><td id=\"itemIDs\">".$stockID;
			$stockItemsList .= "</td><td id=\"serials\">".$serial."</td> <td id=\"descrpitions\">".$description;
			$stockItemsList .= "</td><td id=\"itemIDs\">".$quantity."</td><td id=\"names\">K".$price;
			$stockItemsList .= "</td><td id=\"itemIDs\">".$user."</td>";
			$stockItemsList .= "</td><td id=\"actions\" align=\"center\">".$infoList.$editList.$saleList.$installmentList."</td></tr>";
			
			
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
    <td><table cellpadding="0" cellspacing="0" border="0" id="formHeader" width="100%" align="left">
        <tr>
          <td>Stock - Stock Items List</td>
          <?php displayWelcomeMessage();?>
        </tr>
      </table>
  </tr>
  <tr>
    <td valign="top" align="center"><?php
    if($message)
    displayMessage($message,$errorType);
    ?>
    </td>
  </tr>
  <tr>
    <td><table  cellpadding="0" cellspacing="0" border="0" width="100%">
        <tr>
          <td align="left"><form action="/Myshop/administrator.php" method="post" name="viewStockItems">
		<div>&nbsp;</div>
              <input id="frmName" name="frmName" value="viewStockItems" type="hidden" />
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
              <input id="searchButtonsPDF"  type="submit" name="searchButton" value=" PDF Export"
               onclick="javascript:action='/Myshop/fpdf/Reports.php';   target='_blank';"/>
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
    <td><table cellpadding="0" cellspacing="0" border="0" width="100%">
        <tr  id="stockItemsHeader" align="center">
          <td id="itemIDs">Item ID</td>
          <td id="itemIDs">Stock ID</td>
          <td id="serials">Serial Number</td>
          <td id="descrpitions">Item Description</td>
          <td id="itemIDs">Quantity</td>
          <td id="names">Price</td>
          <td id="itemIDs">User</td>
          <td id="actions">Actions</td>
        </tr>
      </table></td>
  </tr>
  <tr valign="top">
    <td><table cellpadding="0" cellspacing="0" border="0" width="100%">
        <?php echo $stockItemsList; 
  		
  ?>
        
      </table></td>
  </tr>
  
</table>
<?php
	 }
	 ?>
