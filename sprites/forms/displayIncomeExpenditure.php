<?php 
function displayIncomeExpenditure($message,$errorArray,$valuesArray,$errorFlag,$errorType){

?>
 
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>
	<td>
    <table cellpadding="0" cellspacing="0" border="0" id="formHeader" width="100%">
    	<tr>     
            <td>Reports - Income and Expenditure</td>
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
       <?php displayReportsMenu(); ?>
        </table>
        </td>    
        <td align="left">
        	<table  cellpadding="0" cellspacing="0" border="0" align="right" id="rightBoby" width="100%">           
            
            <tr>
                <td>
                 <form action="/Myshop/administrator.php" method="post" name="enterExpense" id="enterExpense">
                  <input id="frmName" name="frmName" value="enterExpense" type="hidden" />
                  	<div id="formClear">&nbsp;</div>
                        <div id="formFields">
                        <label for="stockDate">Month</label>
                        <select name="month">
                        	<option value="" id="option">----Month---</option>
                            <option value="01" <?php if($valuesArray["month"] == "01") echo "selected = selected"?>>Jan</option>
                            <option value="02" <?php if($valuesArray["month"] == "02") echo "selected = selected"?>>Feb</option>
                            <option value="03" <?php if($valuesArray["month"] == "03") echo "selected = selected"?>>Mar</option>
                            <option value="04" <?php if($valuesArray["month"] == "04") echo "selected = selected"?>>Apr</option>
                            <option value="05" <?php if($valuesArray["month"] == "05") echo "selected = selected"?>>May</option>
                            <option value="06" <?php if($valuesArray["month"] == "06") echo "selected = selected"?>>Jun</option>
                            <option value="07" <?php if($valuesArray["month"] == "07") echo "selected = selected"?>>Jul</option>
                            <option value="08" <?php if($valuesArray["month"] == "08") echo "selected = selected"?>>Aug</option>
                            <option value="09" <?php if($valuesArray["month"] == "09") echo "selected = selected"?>>Sep</option>
                            <option value="10" <?php if($valuesArray["month"] == "10") echo "selected = selected"?>>Oct</option>
                            <option value="11" <?php if($valuesArray["month"] == "11") echo "selected = selected"?>>Nov</option>
                            <option value="12" <?php if($valuesArray["month"] == "12") echo "selected = selected"?>>Dec</option>
                          </select>
                          <select name="year" size="1">
                          <option value="" id="option">---Year---</option>
                          <?php $year = date("Y");
                          for($i = 0; $i<=2; $i++){
                            $year = date("Y") - $i;
                             echo "<option value=\"$year\" "; if($valuesArray["year"] == $year) echo "selected = \"selected\" ";
							 echo ">$year</option>";
                            }?></select>
	 
                        <?php if($errorFlag == true){ echo $errorArray["month"];} ?>
                      </div>
                      <div id="formFields"> 
                    <input id="formButtons" type="submit" name="Save"value="View as PDF"/>
                    <input id="formButtonsCancel" type="submit" name="Cancel"value="Cancel"
                    onclick="javascript:action='administrator.php?p=reports'; "/>
                  </div>
                                      
                    </form>
                  </td>
             </tr>	
             <tr>
                <td height="200">&nbsp;</td>
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