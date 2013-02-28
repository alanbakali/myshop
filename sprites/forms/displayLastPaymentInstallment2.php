<?php 
function displayLastPaymentInstallment2($message,$errorArray,$valuesArray,$errorFlag,$errorType){

?>
<link href="/Myshop/css/global.css" rel="stylesheet" type="text/css" />
<table cellpadding="0" cellspacing="0" border="0" width="100%">
  <tr>
    <td><table cellpadding="0" cellspacing="0" border="0" id="formHeader" width="100%">
        <tr>
          <td>Installments - Final Payment</td>
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
              <?php displayInstallmentMenu(); ?>
            </table></td>
          <td align="center" ><table cellpadding="0" cellspacing="0" border="0" align="right" id="rightBoby">
              <tr>
                <td valign="top"><form action="/Myshop/administrator.php" method="post" name="lastPaymentInstallment2" id="lastPaymentInstallment2" >
                    <input id="frmName" name="frmName" value="lastPaymentInstallment2" type="hidden" />
                    <input id="itemID" name="itemID" value="<?php echo $valuesArray["itemID"];?>" type="hidden" />
                    <input id="description" name="description" value="<?php echo $valuesArray["description"];?>" type="hidden" />
                    <input id="price" name="price" value="<?php echo $valuesArray["price"];?>" type="hidden" />
                    <input id="quantity" name="quantity" value="<?php echo $valuesArray["quantity"];?>" type="hidden" />
                    <input id="title" name="title" value="<?php echo $valuesArray["title"];?>" type="hidden" />
                    <input id="customerName" name="customerName" value="<?php echo $valuesArray["customerName"];?>" type="hidden" />
                    <input id="phone" name="phone" value="<?php echo $valuesArray["phone"];?>" type="hidden" />
                    <input id="address" name="address" value="<?php echo $valuesArray["address"];?>" type="hidden" />
                    <input id="email" name="email" value="<?php echo $valuesArray["email"];?>" type="hidden" />
                    <input id="installmentID" name="installmentID" value="<?php echo $valuesArray["installmentID"];?>" type="hidden" />
                    <input id="totalCostPrice" name="totalCostPrice" value="<?php echo $valuesArray["totalCostPrice"];?>" type="hidden" />
                    <input id="firstPayment" name="firstPayment" value="<?php echo $valuesArray["firstPayment"];?>" type="hidden" />
                    <input id="balance" name="balance" value="<?php echo $valuesArray["balance"];?>" type="hidden" />
                  <?php
		  if($valuesArray["phone"] == ""){$valuesArray["phone"] ="-";}
		  if($valuesArray["address"] == ""){$valuesArray["address"] ="-";}
 		  ?>
                  <div id="formFields">&nbsp; </div>
                  <div id="formFields">&nbsp; </div>
                 
                  <div id="formFields">
                    <label for="customerName">Name:</label>
                    <div id="itemInfo"><?php echo $valuesArray["title"].". ".$valuesArray["customerName"];?></div>
                  </div> 
                   <div id="formFields">
                    <label for="phone">Phone:</label>
                    <div id="itemInfo"><?php echo $valuesArray["phone"];?></div> 
                  </div>
                  <div id="formFields">
                      <div id="formLine">&nbsp;</div>
                    </div>
                  <div id="formFields">
                    <label for="installmentID">Installment ID:</label>
                    <div id="itemInfo"><?php echo $valuesArray["installmentID"];?></div>
                  </div>
                  <div id="formFields">
                    <label for="price">Quantity:</label>
                    <div id="itemInfo"><?php echo $valuesArray["quantity"];?></div> 
                    </div>
                  <div id="formFields">
                    <label for="balance">Balance:</label>
                    <div id="itemInfo"><?php echo "K".number_format($valuesArray["balance"], 2, '.', ',');?></div> 
                  </div>
                    <div id="formFields">
                      <div id="formLine">&nbsp;</div>
                    </div>
                    <div id="formFields">
                      <label for="lastPayment">Final Payment:</label>
                      <input id="lastPayment" name="lastPayment" type="text" maxlength="10" size="10"
                      onmouseout="return calculateBalance(this.form);"
                    <?php if ($errorFlag == true){ $value = $valuesArray["lastPayment"]; echo "value=\"$value\" "; }?> />
                      <?php if($errorFlag == true){ echo $errorArray["lastPayment"];} ?>
                    </div>
                    <div id="formFields">
                        <label for="recieptNumber2">Reciept Number 2:</label>
                        <input id="recieptNumber2" name="recieptNumber2" type="text" maxlength="15" size="15" 
                         onmouseover="return calculateTotalPrice(this.form);"
                        <?php if ($errorFlag == true){ $value = $valuesArray["recieptNumber2"]; echo "value=\"$value\" "; }?> />
                        <?php if($errorFlag == true){ echo $errorArray["recieptNumber2"];} ?>
                    </div>
                    <div id="formFields">
                      <div id="formLine">&nbsp;</div>
                    </div>
                    <div id="formFields">
                      <label for="lastBalance">Final Balance:</label>
                      <input id="disabled" name="lastBalance" type="text" maxlength="14" size="14" readonly="readonly"
                    <?php if ($errorFlag == true){ $value = $valuesArray["lastBalance"]; echo "value=\"$value\" "; }?> />
                      <?php if($errorFlag == true){ echo $errorArray["lastBalance"];} ?>
                    </div>
                    <div id="formFields">
                      <div id="formLine">&nbsp;</div>
                    </div>
                    <div id="formFields">
                      <input id="formButtons" type="submit" name="Save"value="Save"/>
                      <input id="formButtonsCancel" type="reset" name="Cancel"value="Cancel"/>
                    </div>
                    <div id="formFields">&nbsp; </div>
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
