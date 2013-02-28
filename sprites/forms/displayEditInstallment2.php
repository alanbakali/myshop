<?php 
function displayEditInstallment2($message,$errorArray,$valuesArray,$errorFlag,$errorType){
?>
<link href="/Myshop/css/global.css" rel="stylesheet" type="text/css" />
<table cellpadding="0" cellspacing="0" border="0" width="100%">
  <tr>
    <td><table cellpadding="0" cellspacing="0" border="0" id="formHeader" width="100%">
        <tr>
          <td>Installments - Installment Edit</td>
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
                <td valign="top"><form action="/Myshop/administrator.php" method="post" name="editInstallment2" id="editInstallment2" >
                    <input id="frmName" name="frmName" value="editInstallment2" type="hidden" />
                    <input id="itemID" name="itemID" value="<?php echo $valuesArray["itemID"];?>" type="hidden" />
                    <input id="description" name="description" value="<?php echo $valuesArray["description"];?>" type="hidden" />
                    <input id="price" name="price" value="<?php echo $valuesArray["price"];?>" type="hidden" />
                    <input id="stockQuantity" name="stockQuantity" value="<?php echo $valuesArray["stockQuantity"];?>" type="hidden" />
                     <input id="initialQuantity" name="initialQuantity" value="<?php echo $valuesArray["initialQuantity"];?>" type="hidden" />
                    <div id="formFields">
                      <label for="description">Item:</label>
                      <div id="itemInfo">
                        <?php 
                            echo $valuesArray["description"];  
                        ?>
                      </div>
                    </div>
                    <div id="formFields">
                      <label for="price">Cost Price:</label>
                      <div id="itemInfo">
                        <?php 
                            echo "K".number_format($valuesArray["price"], 2, '.', ','); 
                        ?>
                      </div>
                    </div>
                    <div id="formFields">
                      <label for="itemID">Item ID:</label>
                      <div id="itemInfo">
                        <?php 
                            echo $value = $valuesArray["itemID"]; 
                        ?>
                      </div>
                    </div>
                    <div id="formFields">
                      <label for="itemID">Available in Stock:</label>
                      <div id="itemInfo">
                        <?php 
                            echo $value = $valuesArray["stockQuantity"]; 
                        ?>
                      </div>
                    </div>
                   <div id="formFields">
                      <div id="formLine">&nbsp;</div>
                    </div>
                    <div id="formFields">
                      <label for="title">Customer Title:</label>
                      <div id="radio">
                        <input name="title" type="radio" value="Mr"  
                       <?php if (($errorFlag == true) && ($valuesArray["title"]=="Mr")) echo " checked= \"checked \" " ?> >
                        Mr.
                        <input type="radio" name="title" value="Mrs"
                      <?php if (($errorFlag == true) && ($valuesArray["title"]== "Mrs")) echo " checked= \"checked \" " ?> >
                        Mrs.
                        <input type="radio" name="title" value="Mrs"
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
                      <label for="installmentID">Installment ID:</label>
                      <input id="disabled" name="installmentID" type="text" maxlength="10" size="7" readonly="readonly"
                        <?php if ($errorFlag == true){ $value = $valuesArray["installmentID"]; echo "value=\"$value\" "; }?> />
                      <?php if($errorFlag == true){ echo $errorArray["installmentID"];} ?>
                    </div>
                    <div id="formFields">
                      <label for="quantity">Quantity:</label>
                      <input id="quantity" name="quantity" type="text" maxlength="10" size="7" 
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
                      onmouseover="return calculateTotalPrice(this.form);"
                        <?php if ($errorFlag == true){ $value = $valuesArray["recieptNumber"]; echo "value=\"$value\" "; }?> />
                      <?php if($errorFlag == true){ echo $errorArray["recieptNumber"];} ?>
                    </div>
                    <?php if($valuesArray["lastPayment"] > 0){displayRecieptNumber2($message,$errorArray,$valuesArray,$errorFlag,$errorType);} ?>
                    <div id="formFields">
                      <div id="formLine">&nbsp;</div>
                    </div>
                    <div id="formFields">
                      <label for="totalCostPrice">Total Cost Price:</label>
                      <input id="disabled" name="totalCostPrice" type="text" maxlength="14" size="14" readonly="readonly"
                    <?php if ($errorFlag == true){ $value = $valuesArray["totalCostPrice"]; echo "value=\"$value\" "; }?> />
                      <?php if($errorFlag == true){ echo $errorArray["totalPayment"];} ?>
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
                      <input id="formButtonsCancel" type="reset" name="Cancel"value="Cancel" />
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
	
// Thsi function displays the reciept number for last payment 
	 
function displayRecieptNumber2($message,$errorArray,$valuesArray,$errorFlag,$errorType){
?>
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

<?php 
}
?>
