<?php 
function displayServicesHome($message,$errorArray,$valuesArray,$errorFlag,$errorType){
?>
 <table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>
	<td>
    <table cellpadding="0" cellspacing="0" border="0" id="formHeader" width="100%">
    	<tr>     
            <td>Services</td>
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
        	 <?php displayServicesMenu(); ?>
        </table>
        </td>    
        <td align="center" >
        	<table  cellpadding="0" cellspacing="0" border="0" align="right" id="rightBoby">           
            <tr>
            <td valign="top"><table  cellpadding="0" cellspacing="0" border="0" align="left" width="100%">
                <tr valign="top">
                  <td align="left">
                   <form action="/Myshop/administrator.php" method="post" name="viewServices">
                      <input id="frmName" name="frmName" value="viewServices" type="hidden" />
                      <input id="actualFormName" name="actualFormName" value="servicesHome" type="hidden" />
                      <div id="formClear">&nbsp;</div>
                      <label id="searchlabel" for="searchTerm">&nbsp;</label>
                      <input id="searchTerm" name="searchTerm" type="text" maxlength="240" size="20" style="text-indent:0px;"
            <?php if ($errorFlag == true){ $value = $valuesArray["searchTerm"]; echo "value=\"$value\" "; }?> />
                      &nbsp;&nbsp;
                      <input id="searchButtons"type="submit" name="searchButton"value=" &nbsp;  Search &nbsp; &nbsp;"/>
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