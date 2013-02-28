<?php 
function displayReportsHome($message,$errorArray,$valuesArray,$errorFlag,$errorType){
?>
 <table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>
	<td>
    <table cellpadding="0" cellspacing="0" border="0" id="formHeader" width="100%">
    	<tr>     
            <td>Reports</td>
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
        	 <?php displayReportsMenu(); ?>
        </table>
        </td>    
        <td align="center" >
        	<table  cellpadding="0" cellspacing="0" border="0" align="right" id="rightBoby">           
            <tr>
            <td valign="top"><table  cellpadding="0" cellspacing="0" border="0" align="left" width="100%">
                <tr valign="top">
                  <td align="left">
                   <form action="/Myshop/administrator.php" method="post" name="viewStockItems">
                      <input id="frmName" name="frmName" value="viewStockItems" type="hidden" />
                      <input id="actualFormName" name="actualFormName" value="stockItemHome" type="hidden" />
                      <div id="formClear">&nbsp;</div>
                      <label id="searchlabel" for="searchTerm">&nbsp;</label>
                      <input id="searchTerm" name="searchTerm" type="hidden" maxlength="240" size="20" style="text-indent:0px;"/>
                      &nbsp;&nbsp;
                      <input id="searchButtons"type="hidden" name="searchButton"value=" &nbsp;  Search &nbsp; &nbsp;"/>
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