<?php 
function displayCancelInstallment($message,$errorArray,$valuesArray,$errorFlag,$errorType){

?>
<link href="/Myshop/css/global.css" rel="stylesheet" type="text/css" />
<table cellpadding="0" cellspacing="0" border="0" width="100%">
  <tr>
    <td><table cellpadding="0" cellspacing="0" border="0" id="formHeader" width="100%">
        <tr>
          <td>Installments - Cancel Installment</td>
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
                <td valign="top">
                <form action="/Myshop/administrator.php" method="post" name="cancelInstallment" id="cancelInstallment">
                    <input id="frmName" name="frmName" value="cancelInstallment" type="hidden" />
                    <input id="installmentID" name="installmentID" value="<?php echo $valuesArray["installmentID"];?>" type="hidden" />
                    <input id="initialQuantity" name="initialQuantity" value="<?php echo $valuesArray["initialQuantity"];?>" type="hidden" />
                    <input id="itemID" name="itemID" value="<?php echo $valuesArray["itemID"];?>" type="hidden" />
                    <input id="totalCostPrice" name="totalCostPrice" value="<?php echo $valuesArray["totalCostPrice"];?>" type="hidden" />
		    <input id="costPrice" name="costPrice" value="<?php echo $valuesArray["costPrice"];?>" type="hidden" />
                    <input id="firstPayment" name="firstPayment" value="<?php echo $valuesArray["firstPayment"];?>" type="hidden" />
                    <input id="balance" name="balance" value="<?php echo $valuesArray["balance"];?>" type="hidden" />
                    <input id="lastPayment" name="lastPayment" value="<?php echo $valuesArray["lastPayment"];?>" type="hidden" />
                    <input id="customerName" name="customerName" value="<?php echo $valuesArray["customerName"];?>" type="hidden" />
                    <input id="title" name="title" value="<?php echo $valuesArray["title"];?>" type="hidden" />
                    <input id="description" name="description" value="<?php echo $valuesArray["description"];?>" type="hidden" />
                    <input id="phone" name="phone" value="<?php echo $valuesArray["phone"];?>" type="hidden" />
                    <?php
		     if($valuesArray["phone"] == ""){$valuesArray["phone"] ="-";}
                     if($valuesArray["address"] == ""){$valuesArray["address"] ="-";}
 		    ?>
                    <div id="formFields">
                    <label for="description">Item:</label>
                    <div id="itemInfo">
                      <?php 
                            echo $value = $valuesArray["description"]; 
                        ?>
                    </div>
                    </div>
                     <div id="formFields">
                      <label for="itemID">Quantity:</label>
                      <div id="itemInfo">
                        <?php 
                            echo $value = $valuesArray["initialQuantity"]; 
                        ?>
                      </div>
                    </div>
                    <div id="formFields">
                      
                    <div id="formFields">
                      <label for="balance">Balance:</label>
                      <div id="itemInfo">
                        <?php 
                            echo "K".number_format($valuesArray["balance"], 2, '.', ','); 
                        ?>
                      </div>
                    </div>
                 
                    <div id="formFields">
                      <label for="description">Name:</label>
                      <div id="itemInfo"><?php echo $valuesArray["title"].". ".$valuesArray["customerName"];?></div>
                    </div>
                    <div id="formFields">
                      <label for="itemID">Phone:</label>
                      <div id="itemInfo"><?php echo $valuesArray["phone"];?></div>
                    </div>
                    <div id="formFields">
                      <div id="formLine">&nbsp;</div>
                    </div>
                    <div id="formFields">
                      <label for="quantity">Quantity Returned:</label>
                      <input id="quantity" name="quantity" type="text" maxlength="10" size="7"
                        <?php if ($errorFlag == true){ $value = $valuesArray["quantity"]; echo "value=\"$value\" "; }?> />
                      <?php if($errorFlag == true){ echo $errorArray["quantity"];} ?>
                    </div>
                    <div id="formFields">
                      <label for="amount">Amount Returned:</label>
                      <input id="amount" name="amount" type="text" maxlength="10" size="10"
                        <?php if ($errorFlag == true){ $value = $valuesArray["amount"]; echo "value=\"$value\" "; }?> />
                      <?php if($errorFlag == true){ echo $errorArray["amount"];} ?>
                    </div>
                    <div id="formFields" align="left">
                      <label for="reason">Reason:</label>
                      <textarea name="reason" cols="30" rows="5" class="textarea"><?php if ($errorFlag == true){echo $valuesArray["reason"];}?></textarea>
                      <?php if($errorFlag == true){ echo $errorArray["reason"];} ?>
                    </div
                    ><div id="formFields">
                      <div id="formLine">&nbsp;</div>
                    </div>
                    <div id="formFields">
                      <input id="formButtons" type="submit" name="Save"value="Save"  />
                    </div>
                  </form></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td>&nbsp;&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
<?php
	 }
	 ?>
