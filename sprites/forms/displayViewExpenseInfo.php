<?php 
function displayViewExpenseInfo($message,$errorArray,$valuesArray,$errorFlag,$errorType){

$query = "SELECT expenseName FROM expenseDefinition ORDER BY expenseName DESC";
$result = sql_query($query, $message);

$row = mysql_num_rows($result);	
?>
 
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>
	<td>
    <table cellpadding="0" cellspacing="0" border="0" id="formHeader" width="100%">
    	<tr>     
            <td>Expense - Expense Info</td>
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
                
                 <div id="formClear">&nbsp; </div>
                 	<div id="formFields">
                      <div id="formLine">&nbsp;</div>
                    </div>
                  <div id="formFields">
                    <label for="customerName">Expense Name:</label>
                    <div id="itemInfo"><?php echo $valuesArray["expenseName"];?></div>
                  </div> 
                   <div id="formFields">
                    <label for="phone">Comment:</label>
                    <div id="itemInfo"><?php echo $valuesArray["comment"];?></div> 
                  </div>
                    <div id="formFields">
                    <label for="downPaymentID">amount:</label>
                    <div id="itemInfo"><?php echo $valuesArray["amount"];?></div>
                  </div>
                  <div id="formFields">
                    <label for="balance">Month:</label>
                    <div id="itemInfo"><?php echo $valuesArray["month"];?></div> 
                  </div>
                  <div id="formFields">
                    <label for="balance">Year:</label>
                    <div id="itemInfo"><?php echo $valuesArray["year"];?></div> 
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
                    <div id="formFields">
                      <div id="formLine">&nbsp;</div>
                    </div>
                  </td>
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