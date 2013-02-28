<?php 
function displayLastPaymentDownPayment1($message,$errorArray,$valuesArray,$errorFlag,$errorType){
?>
 <table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>
	<td>
    <table cellpadding="0" cellspacing="0" border="0" id="formHeader" width="100%">
    	<tr>     
            <td>DownPayment - Final Payment</td>
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
        	<?php displayDownPaymentsMenu(); ?>
        </table>
        </td>    
        <td align="center" >
        	<table  cellpadding="0" cellspacing="0" border="0" align="right" id="rightBoby">           
            <tr>
            <td valign="top"><table  cellpadding="0" cellspacing="0" border="0" align="left" width="100%">
                <tr valign="top">
                  <td align="left" nowrap="nowrap">
                   <form action="/Myshop/administrator.php" method="post" name="lastPaymentDownPayment">
                      <input id="frmName" name="frmName" value="lastPaymentDownPayment" type="hidden" />
                     <div id="formClear">&nbsp;</div>
                     <div id="formFields">
                      <label for="downPaymentID" id="searchlabel">DownPayment ID:</label>
                      <input id="searchTerm" name="downPaymentID" type="text" maxlength="20" size="20" style="text-indent:0px;" />
                      <input id="searchButtons"type="submit" name="searchButton"value=" &nbsp; Retrieve &nbsp; &nbsp;"/>
                      </div>
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