<?php 
function displayViewUserInfo($message,$errorArray,$valuesArray,$errorFlag,$errorType){
if($valuesArray["phone"] == ""){$valuesArray["phone"] = "-";}
if($valuesArray["email"] == ""){$valuesArray["email"] = "-";}
?>
<link href="/Myshop/css/global.css" rel="stylesheet" type="text/css" />
<table cellpadding="0" cellspacing="0" border="0" width="100%">
  <tr>
    <td><table cellpadding="0" cellspacing="0" border="0" id="formHeader" width="100%">
        <tr>
          <td>Users - User Info</td>
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
                    <div id="formClear">&nbsp;</div>
                    <div id="formFields">              
                    <div id="formLine2">&nbsp;</div>
                    </div>
                    <div id="formFields">
                      <label for="fName">First Name:</label>
                       <div id="itemInfo">
                      <?php 
						echo $valuesArray["fName"];
					 ?>
                    </div>
                    </div>
                    <div id="formFields">
                      <label for="lName">Last Name:</label>
                       <div id="itemInfo">
                      <?php 
						echo $valuesArray["lName"];
					 ?>
                    </div>
                    </div>
                    <div id="formFields">
                      <label for="phone">Phone:</label>
                       <div id="itemInfo">
                      <?php 
						echo $valuesArray["phone"];
					 ?>
                    </div>
                    </div>
                    <div id="formFields">
                      <label for="email">E-mail:</label>
                       <div id="itemInfo">
                      <?php 
						echo $valuesArray["email"];
					 ?>
                    </div>
                    </div>
                    <div id="formFields">
                      <div id="formLine2">&nbsp;</div>
                    </div>
                    <div id="formFields">
                      <label for="userName">UserName:</label>
                       <div id="itemInfo">
                      <?php 
						echo $valuesArray["userName"];
					 ?>
                    </div>
                    </div>
                    <div id="formFields">
                      <label for="userGroup">User Group:</label>
                       <div id="itemInfo">
                      <?php 
						echo $valuesArray["userGroup"];
					 ?>
                    </div>
                    </div>
                    <div id="formFields">
                      <label for="status">Account Status:</label>
                      <div id="itemInfo">
                      <?php 
						echo $valuesArray["status"];
					 ?>
                    </div>
                    </div>
                    <div id="formFields">              
                    <div id="formLine2">&nbsp;</div>
                    </div>
                    
                    
                  </td>
              </tr>
              <tr>
                <td></td>
              </tr>
          
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
<?php
	 }
	 ?>
