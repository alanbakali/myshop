<?php 
function displayUsersHome($message,$errorArray,$valuesArray,$errorFlag,$errorType){
?>
 <table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>
	<td>
    <table cellpadding="0" cellspacing="0" border="0" id="formHeader" width="100%">
    	<tr>     
            <td>Stock Home</td>
            <?php displayWelcomeMessage();?>
        </tr>
     </table>
     </td>
</tr>
<tr>
  <td valign="top" align="center">
    <?php
    if($message)
    displayMessage($message,$errorType);
    ?>
  </td>
 </tr>
<tr>
<td>
<table id="forms" cellpadding="0" cellspacing="0" border="0" >
	<tr>
    	<td  valign="top" id="leftBoby">
        <table id="formMenu">
        	<tr>
                <td id="adminMenuTitles"><img src="/Myshop/images/raw/user.png" />&nbsp;&nbsp;Users</td>
             </tr>
             <tr>
                <td id="adminMenuLinks"><img src="/Myshop/images/raw/adminMenuLinks.png" /><a href="administrator.php?p=newUser">New User</a></td>
             </tr>
             <tr>
                <td id="adminMenuLinks"><img src="/Myshop/images/raw/adminMenuLinks.png" /><a href="administrator.php?p=editUser">Edit User</a></td>
             </tr>
             <tr>
                <td id="adminMenuLinks"><img src="/Myshop/images/raw/adminMenuLinks.png" /><a href="administrator.php?p=changePassword">Change Password</a></td>
             </tr>
             <tr>
                <td>&nbsp;</td>
             </tr>
        </table>
        </td>    
        <td align="center" >
        	<table  cellpadding="0" cellspacing="0" border="0" align="right" id="rightBoby">           
            
            <tr>
                <td height="300">&nbsp;</td>
             </tr>	
             
           </table>
       </td>
    </tr>
</table>
</td>
</tr></table>
     
     <?php
	 }
	 ?>