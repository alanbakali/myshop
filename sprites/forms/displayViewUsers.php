<?php 
function displayViewUsers($message,$errorArray,$valuesArray,$errorFlag,$errorType){
		$perPage = 15;
		
		$userGroup	= $valuesArray["userGroup"];
		$searchTerm = $valuesArray["searchTerm"];
		
		if($valuesArray["query"] && $valuesArray["query"] !=""){
			$query1 = $valuesArray["query"];
			$query2 = $valuesArray["query"];
		}
		else{
			if($valuesArray["lowerLimit"] == ""){	$lowerLimit = 0;}
			else {$lowerLimit = $valuesArray["lowerLimit"];}
		
			if(($userGroup !="")){
				$userGroupSearch = 'AND userGroup ="'.$userGroup.'"';
				$userGroupSearch1 = 'userGroup ="'.$userGroup.'"';
			}
			else {
				$userGroupSearch = 'AND userGroup !=""';
				$userGroupSearch1 = 'userGroup !=""';
			}
			
			if($searchTerm !=""){
				$errorFlag=true;
				$searchTerm = trim(stripslashes($searchTerm));//Removing white spaces from strat and end of search term
				$searchTermArray = explode(" ", $searchTerm);//Splitting multiple word search term into single search terms
				$numberOfSearchTerms = count($searchTermArray);
				for($j = 0; $j < $numberOfSearchTerms; $j++){
					if($j == 0){
						$allSearchTerms  = ' (userName LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR fName LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR lName LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR userGroup LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR status LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR email LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR phone LIKE "%'.addslashes($searchTermArray[$j]).'%"';
					}
					else {
						$allSearchTerms  = ' OR userName LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR fName LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR lName LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR userGroup LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR status LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR email LIKE "%'.addslashes($searchTermArray[$j]).'%"';
						$allSearchTerms .= ' OR phone LIKE "%'.addslashes($searchTermArray[$j]).'%"';
					}
				}
				
				// Check if the item realy exist in the database before inserting
				$query1 = 'SELECT * FROM users WHERE';
				$query1 .= $allSearchTerms.') '.$userGroupSearch.' ORDER BY userName DESC LIMIT '.$lowerLimit.','.$perPage;
				
				$query2 = 'SELECT * FROM users WHERE';
				$query2 .= $allSearchTerms.') '.$userGroupSearch.' ORDER BY userName DESC';			
				
				$searchTerm=stripslashes($searchTerm);
			}
			else {
				$query1 = 'SELECT * FROM users WHERE '.$userGroupSearch1.' ORDER BY userName DESC LIMIT '.$lowerLimit.','.$perPage;
				$query2 = 'SELECT * FROM users WHERE '.$userGroupSearch1.' ORDER BY userName DESC';
				
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
	else
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
			
		/*****************Determining if to display Next and  Previous*************************/
		if($row2 > $lowerLimit + $perPage){
			
			$next = "<a href=\"actions.php?action=next&amp;lowerLimit=".$lowerLimit + $perPage."&amp;searchTerm=$searchTerm&amp;whichForm=frmUsers\" ";
			$next .= "onmouseover=\"document.next.src =  defaultImage_Next.src;\" ";
			$next .= "onmouseout=\"document.next.src = defaultImage_Next.src;\">";
			$next .= "<img src=\"/Myshop/images/raw/next.png\" name =\"next\" title =\"Next\" /></a>";
			
		}
		else {$next = "<img src=\"/Myshop/images/raw/empty.png\" title =\"Next\"/>&nbsp;";}
		
		if($lowerLimit > 0){
			$previous = "<a href=\"actions.php?action=previous&amp;lowerLimit=".$lowerLimit + $perPage."&amp;searchTerm=$searchTerm&amp;whichForm=frmUsers\" >";
			$$previous .= "onmouseover=\"document.previous.src =  defaultImage_Previous.src;\" ";
			$$previous .= "onmouseout=\"document.previous.src = defaultImage_Previous.src;\">";
			$previous .= "<img src=\"/Myshop/images/raw/previous.png\" name =\"previous\" /></a>";
			
		}
		else {$previous = "<img src=\"/Myshop/images/raw/empty2.png\" />&nbsp;";}
		//$stockItemsList .= $row." Results found";
		for($i = 0; $i< $row1; $i++){
			if(($i + 1)%2 == 0){$bgcolor = "#F8FAFA";}
			else{$bgcolor = "#FBFBFB";}
			$users 				= mysql_fetch_array($result1);
			$userName 			=htmlspecialchars(stripslashes($users["userName"]));
			$userGroup 			=htmlspecialchars(stripslashes($users["userGroup"]));
			$status				=htmlspecialchars(stripslashes($users["status"]));
			$fName				=htmlspecialchars(stripslashes($users["fName"]));
			$lName				=htmlspecialchars(stripslashes($users["lName"]));
			$phone				=htmlspecialchars(stripslashes($users["phone"]));
			$email				=htmlspecialchars(stripslashes($users["email"]));
			$lastDate			=convertDate(htmlspecialchars(stripslashes($users["lastDate"])));
			
			
			if($phone == ""){$phone = "-";}
			if($email == ""){$email = "-";}
			
			$infoImage = "<img src=\"/Myshop/images/raw/action_info_icon.png\" title =\"Information\"  alt =\"Information\" />";
			$editImage = "<img src=\"/Myshop/images/raw/action_edit_icon.png\" title =\"Edit\"  alt =\"Edit\" />";
			$resetImage = "<img src=\"/Myshop/images/raw/action_reset_icon.png\" title =\"Reset Password\"  alt =\"Reset Password\" />";
			/*********************Info List**********************************************************************/
			$infoList = "<a href=\"actions.php?action=info&amp;lowerLimit=$lowerLimit&amp;searchTerm=$searchTerm&amp;userName=$userName&amp;whichForm=frmUsers\">";
			$infoList .= $infoImage."</a>";
			
			/***********************Edit List********************************************************************/
			$editList = "<a href=\"actions.php?action=edit&amp;lowerLimit=$lowerLimit&amp;searchTerm=$searchTerm&amp;userName=$userName&amp;whichForm=frmUsers\">";
			$editList .= $editImage."</a>";
			
			/***********************Edit List********************************************************************/
			$resetList = "<a href=\"actions.php?action=reset&amp;lowerLimit=$lowerLimit&amp;searchTerm=$searchTerm&amp;userName=$userName&amp;whichForm=frmUsers\" ";
			$resetList .= "onclick =\"return window.confirm('Do you real want to reset password for this user ');\">";
			$resetList .= $resetImage."</a>";
			
			$usersList .= "<tr id=\"stockItems\" bgcolor=\"$bgcolor\" valign =\"top\">";
			$usersList .= "<td id=\"namesUsers\">".$userName;
			$usersList .= "</td><td id=\"namesUsers\">".$userGroup;
			$usersList .= "</td><td id=\"namesUsers\">".$status;
			$usersList .= "</td><td id=\"namesUsers\">".$fName;
			$usersList .= "</td><td id=\"namesUsers\">".$lName."</td><td id=\"namesUsers\">".$phone."</td><td id=\"serialUsers\">".$email;
			$usersList .= "</td><td id=\"namesUsers\">".$lastDate."</td>";
			$usersList .= "</td><td id=\"actionsUsers\">".$infoList.$editList.$resetList."</td></tr>";
			
			
		}
			for($k = 0; $k < ($perPage - $row1); $k++){
				$emptyRows .= "<tr  valign =\"top\" id=\"stockItems\">";
				$emptyRows .= "</tr>";
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
          <td>Users - Users List</td>
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
            <td align="left">
            	<form action="/Myshop/administrator.php" method="post" name="viewUsers">
		<div>&nbsp;</div>
              <input id="frmName" name="frmName" value="viewUsers" type="hidden" />
             
               <label for="userGroup" id="searchlabel">User Group:</label>
	     		  <select name="userGroup" id="userGrp" class="txtBox">
                  <option value="" <?php if(errorFlag == false) echo "selected=$selected"; ?> 
                  <?php if ($errorFlag == true){ if ($valuesArray["userGroup"] == "") echo "selected= $selected"; }?>>----Select----</option>
                  <option value="Administrator" 
                  <?php if ($errorFlag == true){ if ($valuesArray["userGroup"] == "Administrator") echo "selected=$selected"; }?>>Administrator</option>
                  <option value="Technician"
                  <?php if ($errorFlag == true){ if ($valuesArray["userGroup"] == "Technician") echo "selected=$selected"; }?>>Technician</option>
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
        </td></tr>
      </table></td>
  </tr>
  <tr valign="top">
  	<td>
    <table cellpadding="0" cellspacing="0" border="0" align="center" width="100%">
    <tr  id="stockItemsHeader" align="center">
    	<td id="namesUsers">UserName</td><td id="namesUsers">User Group</td>
        <td id="namesUsers">Status</td><td id="namesUsers">First Name</td>
        <td id="namesUsers">Last Name</td><td id="namesUsers">Phone</td>
        <td id="serialUsers">E-mail</td><td id="namesUsers">Last Login</td><td id="actionsUsers">&nbsp;</td>
     </tr>
     </table>
     </td>
     </tr>
   <tr valign="top">
  	<td>
    <table cellpadding="0" cellspacing="0" border="0" align="left" width="100%">  
  <?php echo $usersList; 
  		
  ?>
 
  	</table>
    </td>
    </tr>
    
    
</table>
<?php
	 }
	 ?>
