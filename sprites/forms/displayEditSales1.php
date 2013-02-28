<?php 
function displayEditSales1($message,$errorArray,$valuesArray,$errorFlag,$errorType){
?>
 <table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>
	<td>
    <table cellpadding="0" cellspacing="0" border="0" id="formHeader" width="100%">
    	<tr>     
            <td>Sales - Sales Edit</td>
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
        	<?php displaySalesMenu(); ?>
        </table>
        </td>    
        <td align="left" >
        	<table  cellpadding="0" cellspacing="0" border="0" align="right" id="rightBoby">           
            <tr>
            <td valign="top"><table  cellpadding="0" cellspacing="0" border="0" align="left" width="100%">
                <tr valign="top">
                  <td align="left"></div>
                   <form action="/Myshop/administrator.php" method="post" name="editSales1">
                      <input id="frmName" name="frmName" value="editSales1" type="hidden" />
                      <input id="actualFormName" name="actualFormName" value="editSales1" type="hidden" /> 
                       <div id="formClear">&nbsp;</div>
                      <label id="searchlabel" for="saleID">Sale ID</label>
                      <input id="searchTerm" name="saleID" type="text" maxlength="240" size="20" style="text-indent:0px;"
                <?php if ($errorFlag == true){ $value = $valuesArray["saleID"]; echo "value=\"$value\" "; }?> />
                      &nbsp;&nbsp;
                      <input id="searchButtons"type="submit" name="searchButton"value=" &nbsp; Retrieve &nbsp; &nbsp;"/>
                      
                      
                    </form>
                 </td>
        	</tr>
      </table></td>
  </tr>
    <tr>
        <td height="270">&nbsp;</td>
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