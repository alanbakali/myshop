<?php 
function displayLoginForm($message){
?>

<table cellpadding="0" cellspacing="0" border="0" width="100%">
  <tr>
    <td><table cellpadding="0" cellspacing="0" border="0" id="formHeader" width="100%">
        <tr>
          <td>Login</td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td><table id="loginForm" align="right"border="0" cellspacing="0" cellpadding="0" height="400px">
        <tr valign="top">
          <td align="left" ><form action="/Myshop/loggin.php" method="post" name="frmLogin" id="frmLogin">
              <input id="frmName" name="frmName" value="frmLogin" type="hidden" />
              <div id="formClear">&nbsp;</div>
              <div id="loginFields">
                <label for="UserName" id="loginlabel">Username</label>
                <input id="loginTerm" name="userName" type="text" maxlength="30" size="10"/>
              </div>
              <div id="loginFields">
                <label for="password"  id="loginlabel">Password</label>
                <input id="loginTerm" name="password" type="password" maxlength="30" size="10"/>
              </div>
              <div id="loginFields">
                <input id="loginButtons" type="submit" value="Login"/>
              </div>
              <div id="loginFields">
                <?php
				 if($message){
					displayErrorMessage($message,$errorType);
				 }
					
                  else {
                  ?>
                <div id="loginFields"> &nbsp; </div>
                <?php
				 }
				 ?>
              </div>
              <div id="loginFields">
                <div id="loginLinks"><a href="#">Can't Login?</a></div>
              </div>
            </form></td>
        </tr>
      </table></td>
  </tr>
</table>
<?php
 }
 ?>
