<?php 
function displayPaymentServices($message,$errorArray,$valuesArray,$errorFlag,$errorType){
?>
<link href="/Myshop/css/global.css" rel="stylesheet" type="text/css" />
<table cellpadding="0" cellspacing="0" border="0" width="100%">
  <tr>
    <td><table cellpadding="0" cellspacing="0" border="0" id="formHeader" width="100%">
        <tr>
          <td>Services - Payments</td>
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
              <?php displayServicesMenu(); ?>
            </table></td>
          <td align="center" ><table cellpadding="0" cellspacing="0" border="0" align="right" id="rightBoby">
              <tr>
                <td valign="top"><form action="/Myshop/administrator.php" method="post" name="paymentServices" id="paymentServices" >
                    <input id="frmName" name="frmName" value="paymentServices" type="hidden" />
                    <input id="serviceID" name="serviceID" value="<?php echo $valuesArray["serviceID"];?>" type="hidden" />
                    <input id="initialAmount" name="initialAmount" value="<?php echo $valuesArray["initialAmount"];?>" type="hidden" />
                     <input id="item" name="item" value="<?php echo $valuesArray["item"];?>" type="hidden" />
                    <input id="charges" name="charges" value="<?php echo $valuesArray["charges"];?>" type="hidden" />
                    <input id="title" name="title" value="<?php echo $valuesArray["title"];?>" type="hidden" />
                    <input id="customerName" name="customerName" value="<?php echo $valuesArray["customerName"];?>" type="hidden" />
                    <input id="phone" name="phone" value="<?php echo $valuesArray["phone"];?>" type="hidden" />
                    
                    <?php 
						if($valuesArray["phone"] == ""){$valuesArray["phone"] ="-";}
						if($valuesArray["email"] == ""){$valuesArray["email"] ="-";}
					?>

                    
                  <div id="formClear">&nbsp;</div>
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
                    <label for="serviceID">Service ID:</label>
                    <div id="itemInfo"><?php echo $valuesArray["serviceID"];?></div>
                  </div>
                  <div id="formFields">
                    <label for="item">Item:</label>
                    <div id="itemInfo"><?php echo $valuesArray["item"];?></div> 
                   </div>
                   <div id="formFields">
                    <label for="charges">Charges:</label>
                    <div id="itemInfo"><?php echo "K".number_format($valuesArray["charges"], 2, '.', ',');?></div> 
                    </div>
                  <div id="formFields">
                    <label for="balance">Balance:</label>
                    <div id="itemInfo"><?php echo "K".number_format(($valuesArray["charges"] - $valuesArray["initialAmount"]), 2, '.', ',');?></div> 
                  </div>
                    <div id="formFields">
                      <div id="formLine">&nbsp;</div>
                    </div>
                    <div id="formFields">
                      <label for="payment">Amount Paid:</label>
                      <input id="payment" name="payment" type="text" maxlength="10" size="10"
                    <?php if ($errorFlag == true){ $value = $valuesArray["payment"]; echo "value=\"$value\" "; }?> />
                      <?php if($errorFlag == true){ echo $errorArray["payment"];} ?>
                    </div>
                    <div id="formFields">
                        <label for="recieptNumber">Reciept Number :</label>
                        <input id="recieptNumber" name="recieptNumber" type="text" maxlength="15" size="15" 
                        <?php if ($errorFlag == true){ $value = $valuesArray["recieptNumber"]; echo "value=\"$value\" "; }?> />
                        <?php if($errorFlag == true){ echo $errorArray["recieptNumber"];} ?>
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
