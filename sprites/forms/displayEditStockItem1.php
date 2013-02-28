<?php 
function displayEditStockItem1($message,$errorArray,$valuesArray,$errorFlag,$errorType){
?>
 <table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>
	<td>
    <table cellpadding="0" cellspacing="0" border="0" id="formHeader" width="100%">
    	<tr>     
            <td>Stock - Stock Item Edit</td>
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
        	<?php displayStockMenu(); ?>
        </table>
        </td>    
        <td align="left" >
        	<table  cellpadding="0" cellspacing="0" border="0" align="right" id="rightBoby">           
            <tr>
            <td valign="top"><table  cellpadding="0" cellspacing="0" border="0" align="left" width="100%">
                <tr valign="top">
                  <td align="left">
                   <form action="/Myshop/administrator.php" method="post" name="editStockItem2" id="editStockItem2">
                  <input id="frmName" name="frmName" value="editStockItem2" type="hidden" />
                   <div id="formClear">&nbsp;</div>
                  <label for="saleID" id="searchlabel">Item ID:</label>
                    <input id="searchTerm" name="itemID" type="text" maxlength="15" size="15"
                    <?php if ($errorFlag == true){ $value = $valuesArray["itemID"]; echo "value=\"$value\" "; }?> />
                    <?php if($errorFlag == true){ echo $errorArray["itemID"];} ?>&nbsp;&nbsp;
                   <input id="searchButtons"  type="submit" name="go"value=" &nbsp; Retrieve &nbsp;"/>
                    </form>
                 </td>
        	</tr>
      </table></td>
  </tr>
    <tr>
        <td>&nbsp;</td>
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