<?php 
function displayEnterDownPayment($message,$errorArray,$valuesArray,$errorFlag,$errorType){
if(($valuesArray["downPaymentID"] =="")){
$query = "SELECT downPaymentID FROM downpayments ORDER BY downPaymentID DESC";
$result = sql_query($query, $message);
if($result == false){ // if connection to database failed disply critical error page
	displayCriticalError($message,$errorType);
	displayFooter();
	exit;
}
 
if(mysql_num_rows($result) >= 1) {
	$errorFlag=true;			
	$row = mysql_fetch_array($result);
	$valuesArray["downPaymentID"]= htmlspecialchars(stripslashes($row["downPaymentID"])) + 1;
}

if(mysql_num_rows($result) == 0) {
	$errorFlag=true;			
	$row = mysql_fetch_array($result);
	$valuesArray["downPaymentID"]= 1000;
}
}


?>
<link href="/Myshop/css/global.css" rel="stylesheet" type="text/css" />
<table cellpadding="0" cellspacing="0" border="0" width="100%">
  <tr>
    <td><table cellpadding="0" cellspacing="0" border="0" id="formHeader" width="100%">
        <tr>
          <td>DownPayment - DownPayment Entry</td>
          <?php displayWelcomeMessage();?>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td valign="top" align="center"><?php
    if($message)
    displayMessage($message,$errorType);
    ?>
    </td>
  </tr>
  <tr>
    <td><table id="forms" cellpadding="0" cellspacing="0" border="0" >
        <tr>
          <td  valign="top" id="leftBoby"><table id="formMenu">
             <?php displayDownPaymentsMenu(); ?>
            </table></td>
          <td align="center" ><table cellpadding="0" cellspacing="0" border="0" align="right" id="rightBoby">
              <tr>
                <td valign="top"><form action="/Myshop/administrator.php" method="post" name="enterDownPayment" id="enterDownPayment" >
                    <input id="frmName" name="frmName" value="enterDownPayment" type="hidden" />
                    
                    
                    <div id="formFields">
                      <label for="title">Title:</label>
                      <div id="radio">
                        <input name="title" type="radio" value="Mr"  
                       <?php if (($errorFlag == true) && ($valuesArray["title"]=="Mr")) echo " checked= \"checked \" " ?> >
                        Mr.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="title" value="Mrs"
                      <?php if (($errorFlag == true) && ($valuesArray["title"]== "Mrs")) echo " checked= \"checked \" " ?> >
                        Mrs.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="title" value="Miss"
                      <?php if (($errorFlag == true) && ($valuesArray["title"]== "Miss")) echo " checked= \"checked \" " ?> >
                        Miss
                        <?php if($errorFlag == true){ echo $errorArray["title"]; } ?>
                        </div>
                    </div>
                    <div id="formFields">
                      <label for="customerName">Name:</label>
                      <input id="customerName" name="customerName" type="text" maxlength="25" size="25"
                        <?php if ($errorFlag == true){ $value = $valuesArray["customerName"]; echo "value=\"$value\" "; }?> />
                      <?php if($errorFlag == true){ echo $errorArray["customerName"];} ?>
                    </div>
                    <div id="formFields" align="left">
                      <label for="address">Address:<small id="optional">*</small></label>
                       <textarea name="address" cols="30" rows="4" class="textarea"><?php if ($errorFlag == true){echo $valuesArray["address"];}?></textarea> 
    					<?php if($errorFlag == true){ echo $errorArray["address"];} ?>
                      </div>
                    <div id="formFields">
                      <label for="phone">Phone:<small id="optional">*</small></label>
                      <input id="phone" name="phone" type="text" maxlength="18" size="18"
                        <?php if ($errorFlag == true){ $value = $valuesArray["phone"]; echo "value=\"$value\" "; }?> />
                      <?php if($errorFlag == true){ echo $errorArray["phone"];} ?>
                    </div>
                    <div id="formFields">
                      <label for="email">E-mail:<small id="optional">*</small></label>
                      <input id="email" name="email" type="text" maxlength="30" size="30"
                        <?php if ($errorFlag == true){ $value = $valuesArray["email"]; echo "value=\"$value\" "; }?> />
                      <?php if($errorFlag == true){ echo $errorArray["email"];} ?>
                    </div>
                    
                    <div id="formFields">
                      <div id="formLine">&nbsp;</div>
                    </div>
                    <div id="formFields">
                      <label for="downPaymentID">DownPayment ID:</label>
                      <input id="downPaymentID" name="downPaymentID" type="text" maxlength="15" size="10"
                        <?php if ($errorFlag == true){ $value = $valuesArray["downPaymentID"]; echo "value=\"$value\" "; }?> />
                      <?php if($errorFlag == true){ echo $errorArray["downPaymentID"];} ?>
                    </div>
                    <div id="formFields" align="left">
                      <label for="description">Item:</label>
                       <textarea name="description" cols="30" rows="4" class="textarea"><?php if ($errorFlag == true){echo $valuesArray["description"];}?></textarea> 
    					<?php if($errorFlag == true){ echo $errorArray["description"];} ?>
                      </div>
                      <div id="formFields">
                        <label for="price">Price:</label> 
                        <input id="price" name="price" type="text" maxlength="15" size="15"
                        <?php if ($errorFlag == true){ $value = $valuesArray["price"]; echo "value=\"$value\" "; }?> />
                        <?php if($errorFlag == true){ echo $errorArray["price"];} ?>
                      </div> 
                      <div id="formFields">
                        <label for="quantity">Quantity:</label>
                        <input id="quantity" name="quantity" type="text" maxlength="15" size="10"
                        onchange="return calculateTotalPrice(this.form);"
                        <?php if ($errorFlag == true){ $value = $valuesArray["quantity"]; echo "value=\"$value\" "; }?> />
                        <?php if($errorFlag == true){ echo $errorArray["quantity"];} ?>
                      </div> 
                    <div id="formFields">
                      <label for="firstPayment">First Payment:</label>
                      <input id="firstPayment" name="firstPayment" type="text" maxlength="15" size="15"
                      onmouseout="return calculateBalance(this.form);"
                        <?php if ($errorFlag == true){ $value = $valuesArray["firstPayment"]; echo "value=\"$value\" "; }?> />
                      <?php if($errorFlag == true){ echo $errorArray["firstPayment"];} ?>
                    </div>
                    <div id="formFields">
                      <label for="recieptNumber">Reciept Number:</label>
                      <input id="recieptNumber" name="recieptNumber" type="text" maxlength="15" size="15" 
                      onmouseout="return calculateBalance(this.form);"
                        <?php if ($errorFlag == true){ $value = $valuesArray["recieptNumber"]; echo "value=\"$value\" "; }?> />
                      <?php if($errorFlag == true){ echo $errorArray["recieptNumber"];} ?>
                    </div>
                    <div id="formFields">
                      <div id="formLine">&nbsp;</div>
                    </div>
                    <div id="formFields">
                      <label for="totalCostPrice">Total Cost Price:</label>
                      <input id="disabled" name="totalCostPrice" type="text" maxlength="14" size="14" readonly="readonly"
                    <?php if ($errorFlag == true){ $value = $valuesArray["totalCostPrice"]; echo "value=\"$value\" "; }?> />
                      <?php if($errorFlag == true){ echo $errorArray["totalCostPrice"];} ?>
                    </div>
                    <div id="formFields">
                      <label for="balance">Balance:</label>
                      <input id="disabled" name="balance" type="text" maxlength="14" size="14" readonly="readonly"
                    <?php if ($errorFlag == true){ $value = $valuesArray["balance"]; echo "value=\"$value\" "; }?> />
                      <?php if($errorFlag == true){ echo $errorArray["balance"];} ?>
                    </div> 
                    <div id="formFields">              
                    <div id="formLine">&nbsp;</div>
                    </div>
                    <div id="formFields">
                      <input id="formButtons" type="submit" name="Save"value="Save"/>
                      <input id="formButtonsCancel" type="reset" name="Cancel"value="Cancel"/>
                    </div>
                  </form></td>
              </tr>
              <tr>
                <td></td>
              </tr>
              <tr valign="bottom">
                <td id="formFields"><label for="serial"><small id="optional">*</small>&nbsp;Optional Field</label></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
<?php
	 }
	 ?>
