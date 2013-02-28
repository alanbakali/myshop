<?php 
function displayEditService($message,$errorArray,$valuesArray,$errorFlag,$errorType){
?>
<link href="/Myshop/css/global.css" rel="stylesheet" type="text/css" />
<table cellpadding="0" cellspacing="0" border="0" width="100%">
  <tr>
    <td><table cellpadding="0" cellspacing="0" border="0" id="formHeader" width="100%">
        <tr>
          <td>Services- Edit Service</td>
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
                <td valign="top">
                <form action="/Myshop/administrator.php" method="post" name="editService" id="editService" >
                    <input id="frmName" name="frmName" value="editService" type="hidden" />
                    <input id="frmName" name="serviceID" value="<?php echo $valuesArray["serviceID"];?>" type="hidden" />
                    
                   
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
                       <textarea name="address" cols="30" rows="3" class="textarea"><?php if ($errorFlag == true){echo $valuesArray["address"];}?></textarea> 
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
                      <input id="email" name="email" type="text" maxlength="25" size="25"
                        <?php if ($errorFlag == true){ $value = $valuesArray["email"]; echo "value=\"$value\" "; }?> />
                      <?php if($errorFlag == true){ echo $errorArray["email"];} ?>
                    </div>
                    
                    <div id="formFields">
                      <div id="formLine">&nbsp;</div>
                    </div>
                    <div id="formFields" align="left">
                      <label for="item">Item:</label>
                       <textarea name="item" cols="30" rows="2" class="textarea"><?php if ($errorFlag == true){echo $valuesArray["item"];}?></textarea> 
    					<?php if($errorFlag == true){ echo $errorArray["item"];} ?>
                      </div>
                      <div id="formFields">
                        <label for="serial">Serial:<small id="optional">*</small></label>
                        <input id="serial" name="serial" type="text" maxlength="18" size="18" 
                        <?php if ($errorFlag == true){ $value = $valuesArray["serial"]; echo "value=\"$value\" "; }?> />
                        <?php if($errorFlag == true){ echo $errorArray["serial"];} ?>
                      </div>
                      <div id="formFields">
                      <label for="problem">Problem:</label>
                       <textarea name="problem" cols="30" rows="2" class="textarea"><?php if ($errorFlag == true){echo $valuesArray["problem"];}?></textarea> 
    					<?php if($errorFlag == true){ echo $errorArray["problem"];} ?>
                      </div>
                      <div id="formFields">
                      <label for="diagnosis">Diagnosis:<small id="optional">*</small></label>
                       <textarea name="diagnosis" cols="30" rows="2" class="textarea"><?php if ($errorFlag == true){echo $valuesArray["diagnosis"];}?></textarea> 
    					<?php if($errorFlag == true){ echo $errorArray["diagnosis"];} ?>
                      </div>
                      <div id="formFields">
                        <label for="charges">Charges:</label> 
                        <input id="charges" name="charges" type="text" maxlength="15" size="15"
                        <?php if ($errorFlag == true){ $value = $valuesArray["charges"]; echo "value=\"$value\" "; }?> />
                        <?php if($errorFlag == true){ echo $errorArray["charges"];} ?>
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
                <td id="formFields" height="30"><label for="serial"><small id="optional">*</small>&nbsp;Optional Field</label></td>
              </tr>
   
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
<?php
	 }
	 ?>
