<?php 
function displayViewStockDefinitionInfo($message,$errorArray,$valuesArray,$errorFlag,$errorType){

?>
<link href="/Myshop/css/global.css" rel="stylesheet" type="text/css" />
<table cellpadding="0" cellspacing="0" border="0" width="100%">
  <tr>
    <td><table cellpadding="0" cellspacing="0" border="0" id="formHeader" width="100%">
        <tr>
          <td>Stock - Stock Item Info</td>
          <?php displayWelcomeMessage();?>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td><table id="forms" cellpadding="0" cellspacing="0" border="0" >
        <tr>
          <td  valign="top" id="leftBoby"><table id="formMenu">
              <?php displayStockDefinitionMenu(); ?>
            </table></td>
          <td align="center" ><table cellpadding="0" cellspacing="0" border="0" align="right" id="rightBoby" height="350">
              <tr>
                <td></td>
              </tr>
              <tr>
                <td><div id="formClear">&nbsp;</div>
                	<div id="formFields">
                    <label for="stockID">Stock ID:</label>
                    <div id="itemInfo">
                      <?php
                                 echo $valuesArray["stockID"] ;
                            ?>
                    </div>
                  </div>
                  <div id="formFields">
                    <label for="quantity">Stock Date:</label>
                    <div id="itemInfo">
                      <?php 
                                echo $valuesArray["stockDate"]; 
                            ?>
                    </div>
                  </div>
                  <div id="formFields">
                    <label for="description">Description:</label>
                    <div id="itemInfo">
                      <?php 
                                echo $valuesArray["description"];  
                            ?>
                    </div>
                  </div>
                  <div id="formFields">
                      <div id="formLine">&nbsp;</div>
                    </div>
                  <div id="formFields">
                    <label for="user">User:</label>
                    <div id="itemInfo"><?php echo $valuesArray["user"];?></div>
                  </div>
                  <div id="formFields">
                    <label for="date">Date:</label>
                    <div id="itemInfo"><?php echo $valuesArray["date"];?></div> 
                  </div> 
                  <div id="formFields">
                    <label for="time">Time:</label>
                    <div id="itemInfo"><?php echo $valuesArray["time"];?></div> 
                  </div> 
                  <div id="formClear">&nbsp;</div>
                  </td>
              </tr>
              <tr>
                <td height="270px"></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
<?php
	 }
	 ?>
