<?php 
function displayEditInstallment1($message,$errorArray,$valuesArray,$errorFlag,$errorType){
?>

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
          <td align="center" ><table  cellpadding="0" cellspacing="0" border="0" align="right" id="rightBoby">
              <tr>
                <td valign="top"><table  cellpadding="0" cellspacing="0" border="0" align="left" width="100%">
                    <tr valign="top">
                      <td align="left"></div>
                        <form action="/Myshop/administrator.php" method="post" name="editInstallment">
                          <input id="frmName" name="frmName" value="editInstallment" type="hidden" />
                          <div id="formClear">&nbsp;</div>
                          <label for="installmentID" id="searchlabel">Installment ID:</label>
                          <input id="searchTerm" name="installmentID" type="text" maxlength="240" size="20"
            <?php if ($errorFlag == true){ $value = $valuesArray["installmentID"]; echo "value=\"$value\" "; }?> />
                          &nbsp;&nbsp;
                          <input id="searchButtons"type="submit" name="searchButton"value=" &nbsp;  Retrieve &nbsp; &nbsp;"/>
                        </form></td>
                    </tr>
                  </table></td>
              </tr>
              <tr>
                <td height="270">&nbsp;</td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
<?php
	 }
	 ?>
