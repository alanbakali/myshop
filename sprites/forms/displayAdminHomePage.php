<?php
function displayAdminHomePage($message){
?>

<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td><table cellpadding="0" cellspacing="0" border="0" id="formHeader" width="100%">
        <tr>
          <td> <?php if($_SESSION['userGroup'] == "Administrator"){ echo "Administration Menu";}
		  			 else { echo "Main Menu";}
				?>
		  </td>
          <?php displayWelcomeMessage();?>
        </tr>
      </table></td>
  </tr>
  <tr valign="top">
    <td height="30">&nbsp;</td>
  </tr>
  <tr>
    <td><table border="0" cellspacing="0" cellpadding="0" width="92%" align="center" style="margin-top:25px;">
        <tr valign="top" id="adminMenu">
          <td><table>
              <?php displayStockMenu(); ?>
            </table></td>
          <td><table>
              <?php displaySalesMenu(); ?>
            </table></td>
          <td><table>
              <?php displayDownPaymentsMenu();	?>
            </table></td>
        </tr>
        <tr valign="top" id="adminMenu">
          <td><table>
              <?php displayInstallmentMenu(); ?>
            </table></td>
          <td><table>
          	 <?php if($_SESSION['userGroup'] == "Administrator"){
			  			displayStockDefinitionMenu();
					}
					else{
						displayDownPaymentsMenu();
					}
			?>
            </table></td>
          <td><table>
          	   <?php if($_SESSION['userGroup'] == "Administrator"){
			  			displayUsersMenu();
					}
					else{
						displayOtherMenu();
					}
				?>
            </table></td>
        </tr>
             </table></td>
  </tr>
</table>
<?php
 }
 ?>
