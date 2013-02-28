<?php 
function displayNewStockDefinition($message,$errorArray,$valuesArray,$errorFlag,$errorType){

$query = "SELECT stockID FROM stock ORDER BY stockID DESC LIMIT 0,1";
$result = sql_query($query, $message);

if(mysql_num_rows($result) >= 1) {
	$errorFlag=true;			
	$row = mysql_fetch_array($result);
	$valuesArray["stockID"]= htmlspecialchars(stripslashes($row["stockID"])) + 1;
}

if(mysql_num_rows($result) == 0) {
	$errorFlag=true;			
	$row = mysql_fetch_array($result);
	$valuesArray["stockID"]= 1000;
}
			

?>
<link href="/Myshop/css/global.css" rel="stylesheet" type="text/css" />
 
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>
	<td>
    <table cellpadding="0" cellspacing="0" border="0" id="formHeader" width="100%">
    	<tr>     
            <td>Stock Definition - New Stock Definition</td>
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
       <?php displayStockDefinitionMenu(); ?>
        </table>
        </td>    
        <td align="left">
        	<table  cellpadding="0" cellspacing="0" border="0" align="right" id="rightBoby" width="100%">           
            
            <tr>
                <td>
                 <form action="/Myshop/administrator.php" method="post" name="newStockDefinition" id="newStockDefinition">
                  <input id="frmName" name="frmName" value="newStockDefinition" type="hidden" />
                  	<div id="formClear">&nbsp;</div>
                  	<div id="formFields">
                        <label for="stockID">Stock ID:</label>
                        <input id="stockID" name="stockID" type="text" maxlength="15" size="10" readonly="readonly"
                        <?php if ($errorFlag == true){ $value = $valuesArray["stockID"]; echo "value=\"$value\" "; }?> />
                        <?php if($errorFlag == true){ echo $errorArray["stockID"];} ?>
                      </div>
                      <div id="formFields">
                        <label for="stockDate">Stock Date:</label>
                        <select name="month">
                            <option value="01">Jan</option>
                            <option value="02">Feb</option>
                            <option value="03">Mar</option>
                            <option value="04">Apr</option>
                            <option value="05">May</option>
                            <option value="06">Jun</option>
                            <option value="07">Jul</option>
                            <option value="08">Aug</option>
                            <option value="09">Sep</option>
                            <option value="10">Oct</option>
                            <option value="11">Nov</option>
                            <option value="Dec">Dec</option>
                          </select>
                        <select name="day" size="1">
                            <option value="01">01</option>
                            <option value="02">02</option>
                            <option value="03">03</option>
                            <option value="04">04</option>
                            <option value="05">05</option>
                            <option value="06">06</option>
                            <option value="07">07</option>
                            <option value="08">08</option>
                            <option value="09">09</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                            <option value="14">14</option>
                            <option value="15">15</option>
                            <option value="16">16</option>
                            <option value="17">17</option>
                            <option value="18">18</option>
                            <option value="19">19</option>
                            <option value="20">20</option>
                            <option value="21">21</option>
                            <option value="22">22</option>
                            <option value="23">23</option>
                            <option value="24">24</option>
                            <option value="25">25</option>
                            <option value="26">26</option>
                            <option value="27">27</option>
                            <option value="28">28</option>
                            <option value="29">29</option>
                            <option value="30">30</option>
                            <option value="31">31</option>
                          </select>
                          <select name="year" size="1">
                          <?php $year = date("Y");
                          for($i = 0; $i<=2; $i++){
                            $year = date("Y") - $i;
                             echo "<option value=\"$year\" "; if($valuesArray["year"] == $year) echo "selected = selected";
							 echo ">$year</option>";
                            }?></select>
	 
                        <?php if($errorFlag == true){ echo $errorArray["stockDate"];} ?>
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