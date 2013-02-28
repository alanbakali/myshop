<?php 
function displayEditStockItem2($message,$errorArray,$valuesArray,$errorFlag,$errorType){
$query = "SELECT stockID FROM stock ORDER BY stockID DESC LIMIT 0,3";
	$result = sql_query($query, $message);
	if($result == false){ // if connection to database failed disply critical error page
		displayCriticalError($message,$errorType);
		displayFooter();
		exit;
	}
	else 
		if(mysql_num_rows($result) >= 1) {	
				$row = mysql_num_rows($result);
				 
		}
?>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>
	<td>
    <table cellpadding="0" cellspacing="0" border="0" id="formHeader" width="100%">
    	<tr>     
            <td>Stock - Stock Item Edit</td>
            <?php displayWelcomeMessage();?>
        </tr>
     </table>
     </td>
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
<td>
<table id="forms" cellpadding="0" cellspacing="0" border="0" >
	<tr>
    	<td  valign="top" id="leftBoby">
        <table id="formMenu">
        	<?php displayStockMenu(); ?>
        </table>
        </td>    
        <td align="left" >
        	<table  cellpadding="0" cellspacing="0" border="0" align="left" id="rightBoby" width="100%">           
            
            <tr>
                <td align="left">
                 <form action="/Myshop/administrator.php" method="post" name="editStockItem3" id="editStockItem3">
                  <input id="frmName" name="frmName" value="editStockItem3" type="hidden" />
                  <input id="lowerLimit" name="lowerLimit" value="<?php echo $valuesArray["lowerLimit"];?>" type="hidden" />
                  <input id="searchTerm" name="searchTerm" value="<?php echo $valuesArray["searchTerm"];?>" type="hidden" />
                  	 <div id="formClear">&nbsp;</div>
                  	 <div id="formFields">
                        <label for="stockID">Stock ID:</label>
                        <select name="stockID">
                        <option value="">Select&nbsp;&nbsp;&nbsp;</option>
                        <?php
						 for($i = 0; $i< $row; $i++){
						 	$stockIDs = mysql_fetch_array($result);
							$stockID = htmlspecialchars(stripslashes($stockIDs["stockID"]));
							echo "<option value=\"$stockID\" "; if($valuesArray["stockID"] == $stockID) echo "selected = selected";
							echo ">$stockID</option>";
						}
						?>
                     	 </select>
                        <?php if($errorFlag == true){ echo $errorArray["stockID"];} ?>
                      </div>
                      <div id="formFields">
                        <label for="itemID">Item ID:</label>
                        <input id="itemID" name="itemID" type="text" maxlength="8" size="8" readonly="readonly"
                        <?php if ($errorFlag == true){ $value = $valuesArray["itemID"]; echo "value=\"$value\" "; }?> />
                        <?php if($errorFlag == true){ echo $errorArray["itemID"];} ?>
                      </div>
                      <div id="formFields">
                        <label for="serial">Serial:&nbsp;<small id="optional">*</small></label>
                        <input id="serial" name="serial" type="text" maxlength="20" size="20" 
                        <?php if ($errorFlag == true){ $value = $valuesArray["serial"]; echo "value=\"$value\" "; }?> />
                        <?php if($errorFlag == true){ echo $errorArray["serial"];} ?>
                      </div>
                      <div id="formFields" align="left">
                      <label for="description">Description:</label>
                       <textarea name="description" cols="30" rows="5" class="textarea"><?php if ($errorFlag == true){echo $valuesArray["description"];}?></textarea> 
    					<?php if($errorFlag == true){ echo $errorArray["description"];} ?>
                      </div>
                      <div id="formFields">
                        <label for="quantity">Quantity:</label>
                        <input id="quantity" name="quantity" type="text" maxlength="15" size="10"
                        <?php if ($errorFlag == true){ $value = $valuesArray["quantity"]; echo "value=\"$value\" "; }?> />
                        <?php if($errorFlag == true){ echo $errorArray["quantity"];} ?>
                      </div>
                      <div id="formFields">
                        <label for="price">Price:</label>
                        <input id="price" name="price" type="text" maxlength="15" size="15"
                        <?php if ($errorFlag == true){ $value = $valuesArray["price"]; echo "value=\"$value\" "; }?> />
                        <?php if($errorFlag == true){ echo $errorArray["price"];} ?>
                      </div>  
                      <div id="formFields"> 
                    <input id="formButtons" type="submit" name="Save"value="Save"/>
                    <input id="formButtonsCancel" type="reset" name="Cancel"value="Cancel"/>
                  </div>
                      <div id="FormFields">&nbsp;</div>
                      <div id="FormFields">&nbsp;</div>                   
                    </form>
                  </td>
             </tr>	
              <tr>
             	<td></td>
            </tr>
            <tr valign="bottom">
             	<td id="formFields"><label for="serial"><small id="optional">*</small>&nbsp;Optional Field</label></td>
            </tr>
           
           </table>
       </td>
    </tr>
</table>
</td>
</tr></table>
     
     <?php
	 }
	 ?>