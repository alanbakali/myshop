<?php 
function displayChangePassword($message,$errorArray,$valuesArray,$errorFlag,$errorType){
echo  $valuesArray["currentPassword"];	
?>
<link href="/Myshop/css/global.css" rel="stylesheet" type="text/css" />
<table cellpadding="0" cellspacing="0" border="0" width="100%">
  <tr>
    <td><table cellpadding="0" cellspacing="0" border="0" id="formHeader" width="100%">
        <tr>
          <td>Users - Change Password</td>
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
             <?php 
		if($_SESSION['userGroup'] == "Administrator"){
		  displayUsersMenu();
		}
		else{
		  displayOtherMenu();
		}
	     ?>
            </table></td>
          <td align="center" ><table cellpadding="0" cellspacing="0" border="0" align="right" id="rightBoby">
              <tr>
                <td valign="top">
                <form action="/Myshop/administrator.php" method="post" name="changePassword" id="changePassword" >
                    <input id="frmName" name="frmName" value="changePassword" type="hidden" />
                    <input id="userName" name="userName" value="<?php echo $_SESSION['userName']; ?>" type="hidden" />
                    <div id="formClear">&nbsp;</div>
                    
                    <div id="formFields">
                      <label for="userName">UserName:</label>
                       <div id="itemInfo">
                      <?php 
						echo $_SESSION['userName'];
					 ?>
                    </div>
                    </div>
                    <div id="formFields">
                      <label for="userGroup">User Group:</label>
                       <div id="itemInfo">
                      <?php 
						echo $_SESSION['userGroup'];
					 ?>
                    </div>
                    </div>
                    <div id="formFields">
                      <label for="status">Status:</label>
                      <div id="itemInfo">
                      <?php 
						echo $_SESSION['status'];
					 ?>
                    </div>
                    </div>
                    <div id="formFields">              
                    <div id="formLine">&nbsp;</div>
                    </div>
                    <div id="formFields">
                      <label for="currentPassword">Current Password:</label>
                      <input id="currentPassword" name="currentPassword" type="password" maxlength="15" size="15"
                        <?php if ($errorFlag == true){ $value = $valuesArray["currentPassword"]; echo "value=\"$value\" "; }?> />
                      <?php if($errorFlag == true){ echo $errorArray["currentPassword"];} ?>
                    </div>
                    <div id="formFields">
                      <label for="newPassword">New Password:</label>
                      <input id="newPassword" name="newPassword" type="password" maxlength="15" size="15"
                        <?php if ($errorFlag == true){ $value = $valuesArray["newPassword"]; echo "value=\"$value\" "; }?> />
                      <?php if($errorFlag == true){ echo $errorArray["newPassword"];} ?>
                    </div>
                    <div id="formFields">
                      <label for="confirmPassword">Confirm Password:</label>
                      <input id="confirmPassword" name="confirmPassword" type="password" maxlength="15" size="15"
                        <?php if ($errorFlag == true){ $value = $valuesArray["confirmPassword"]; echo "value=\"$value\" "; }?> />
                      <?php if($errorFlag == true){ echo $errorArray["confirmPassword"];} ?>
                    </div>
                    <div id="formFields">              
                    <div id="formLine">&nbsp;</div>
                    </div>
                    <div id="formFields">
                      <input id="formButtons" type="submit" name="Save"value="Save"/>
                      <input id="formButtonsCancel" type="reset" name="Cancel"value="Cancel"/>
                    </div>
                  </form>
                  </td>
              </tr>
              <tr>
                <td></td>
              </tr>
              <tr valign="bottom">
                <td><div id="formClear">&nbsp;</div></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
<?php
	 }
	 ?>
