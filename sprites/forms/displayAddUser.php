<?php 
function displayAddUser($message,$errorArray,$valuesArray,$errorFlag,$errorType){
?>
<link href="/Myshop/css/global.css" rel="stylesheet" type="text/css" />
<table cellpadding="0" cellspacing="0" border="0" width="100%">
  <tr>
    <td><table cellpadding="0" cellspacing="0" border="0" id="formHeader" width="100%">
        <tr>
          <td>Users - Add User</td>
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
             <?php displayUsersMenu(); ?>
            </table></td>
          <td align="center" ><table cellpadding="0" cellspacing="0" border="0" align="right" id="rightBoby">
              <tr>
                <td valign="top"><form action="/Myshop/administrator.php" method="post" name="addUser" id="addUser" >
                    <input id="frmName" name="frmName" value="addUser" type="hidden" />
                    <div id="formClear">&nbsp;</div>
                    <div id="formFields">
                      <label for="fName">First Name:</label>
                      <input id="fName" name="fName" type="text" maxlength="15" size="15"
                        <?php if ($errorFlag == true){ $value = $valuesArray["fName"]; echo "value=\"$value\" "; }?> />
                      <?php if($errorFlag == true){ echo $errorArray["fName"];} ?>
                    </div>
                    <div id="formFields">
                      <label for="lName">Last Name:</label>
                      <input id="lName" name="lName" type="text" maxlength="15" size="15"
                        <?php if ($errorFlag == true){ $value = $valuesArray["lName"]; echo "value=\"$value\" "; }?> />
                      <?php if($errorFlag == true){ echo $errorArray["lName"];} ?>
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
                      <label for="">UserName:</label>
                      <input id="userName" name="userName" type="text" maxlength="15" size="15"
                        <?php if ($errorFlag == true){ $value = $valuesArray["userName"]; echo "value=\"$value\" "; }?> />
                      <?php if($errorFlag == true){ echo $errorArray["userName"];} ?>
                    </div>
                    <div id="formFields">
                      <label for="userGrp">User Group:</label>
                      <select name="userGroup" id="userGrp" class="txtBox">
                      <option value="" <?php if(errorFlag == false) echo "selected=$selected"; ?>
                      <?php if ($errorFlag == true){ if ($valuesArray["userGroup"] == "") echo "selected= $selected"; }?>>Select</option>
                      <option value="Administrator" 
                      <?php if ($errorFlag == true){ if ($valuesArray["userGroup"] == "Administrator") echo "selected=$selected"; }?>>Administrator</option>
                      <option value="Technician"
                      <?php if ($errorFlag == true){ if ($valuesArray["userGroup"] == "Technician") echo "selected=$selected"; }?>>Technician</option>
                        </select>
                        <?php if($errorFlag == true){ echo $errorArray["userGroup"]; } ?>
                    </div>
                    <div id="formFields">
                      <label for="title">Account Status:</label>
                      <div id="radio">
                        <input name="status" type="radio" value="Active"  
                       <?php if (($errorFlag == true) && ($valuesArray["status"]=="Active")) echo " checked= \"checked \" " ?> >
                        Active
                        <input type="radio" name="status" value="Inactive"
                      <?php if (($errorFlag == true) && ($valuesArray["status"]== "Inactive")) echo " checked= \"checked \" " ?> >
                        Inactive.
                        <?php if($errorFlag == true){ echo $errorArray["status"]; } ?>
                        </div>
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
