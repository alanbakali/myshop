<?php 
function displayEditExpenseDefinition($message,$errorArray,$valuesArray,$errorFlag,$errorType){
?>
 
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>
	<td>
    <table cellpadding="0" cellspacing="0" border="0" id="formHeader" width="100%">
    	<tr>     
            <td>Expense - Define Expense</td>
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
<td valign="top">
<table id="forms" cellpadding="0" cellspacing="0" border="0" >
	<tr>
    	<td  valign="top" id="leftBoby">
        <table id="formMenu">
       <?php displayExpensesMenu(); ?>
        </table>
        </td>    
        <td align="left">
        	<table  cellpadding="0" cellspacing="0" border="0" align="right" id="rightBoby" width="100%">           
            
            <tr>
                <td>
                 <form action="/Myshop/administrator.php" method="post" name="editExpenseDefinition" id="editExpenseDefinition">
                  <input id="frmName" name="frmName" value="editExpenseDefinition" type="hidden" />
                  <input id="initialExpenseName" name="initialExpenseName" value="<?php echo $valuesArray["expenseName"];?>" type="hidden" />
                  	<div id="formClear">&nbsp;</div>
                  	<div id="formFields">
                        <label for="expenseName">Expense Name:</label>
                        <input id="expenseName" name="expenseName" type="text" maxlength="30" size="30" 
                        <?php if ($errorFlag == true){ $value = $valuesArray["expenseName"]; echo "value=\"$value\" "; }?> />
                        <?php if($errorFlag == true){ echo $errorArray["expenseName"];} ?>
                      </div>
                      <div id="formFields">
                      <label for="description">Description:</label>
                       <textarea name="description" cols="30" rows="5" class="textarea"><?php if ($errorFlag == true){echo $valuesArray["description"];}?></textarea> 
    					<?php if($errorFlag == true){ echo $errorArray["description"];} ?>
                       </div>
                      <div id="formFields"> 
                    <input id="formButtons" type="submit" name="Save"value="Save"/>
                    <input id="formButtonsCancel" type="reset" name="Cancel"value="Cancel"/>
                  </div>
                                      
                    </form>
                  </td>
             </tr>	
             <tr>
                <td height="120">&nbsp;</td>
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