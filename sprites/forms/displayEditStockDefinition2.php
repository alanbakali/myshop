<?php 
function displayEditStockDefinition2($message,$errorArray,$valuesArray,$errorFlag,$errorType){
?>
<link href="/Myshop/css/global.css" rel="stylesheet" type="text/css" />
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>
	<td>
    <table cellpadding="0" cellspacing="0" border="0" id="formHeader" width="100%">
    	<tr>     
            <td>Stock Definition - Edit Stock Definition</td>
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
<td height="350" valign="top">
<table id="forms" cellpadding="0" cellspacing="0" border="0" >
	<tr>
    	<td  valign="top" id="leftBoby">
        <table id="formMenu">
        	<?php displayStockDefinitionMenu(); ?>
        </table>
        </td>    
        <td>
        	<table  cellpadding="0" cellspacing="0" border="0" align="right" id="rightBoby">           
            
            <tr>
                <td>
                 <form action="/Myshop/administrator.php" method="post" name="editStockDefinition2" id="editStockDefinition2">
                  <input id="frmName" name="frmName" value="editStockDefinition2" type="hidden" />
                  	 <div id="formClear">&nbsp;</div>
                  	<div id="formFields">
                        <label for="stockID">Stock ID:</label>
                        <input id="disabled" name="stockID" type="text" maxlength="15" size="10" readonly="readonly"
                        <?php if ($errorFlag == true){ $value = $valuesArray["stockID"]; echo "value=\"$value\" "; }?> />
                        <?php if($errorFlag == true){ echo $errorArray["stockID"];} ?>
                      </div>
                      <div id="formFields">
                        <label for="stockDate">Stock Date:</label>
                        <select name="month">
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
                        <select name="day" size="1">
                            <option value="01" <?php if($valuesArray["day"] == "01") echo "selected = selected"?>>01</option>
                            <option value="02" <?php if($valuesArray["day"] == "02") echo "selected = selected"?>>02</option>
                            <option value="03" <?php if($valuesArray["day"] == "03") echo "selected = selected"?>>03</option>
                            <option value="04" <?php if($valuesArray["day"] == "04") echo "selected = selected"?>>04</option>
                            <option value="05" <?php if($valuesArray["day"] == "05") echo "selected = selected"?>>05</option>
                            <option value="06" <?php if($valuesArray["day"] == "06") echo "selected = selected"?>>06</option>
                            <option value="07" <?php if($valuesArray["day"] == "07") echo "selected = selected"?>>07</option>
                            <option value="08" <?php if($valuesArray["day"] == "08") echo "selected = selected"?>>08</option>
                            <option value="09" <?php if($valuesArray["day"] == "09") echo "selected = selected"?>>09</option>
                            <option value="10" <?php if($valuesArray["day"] == "10") echo "selected = selected"?>>10</option>
                            <option value="11" <?php if($valuesArray["day"] == "11") echo "selected = selected"?>>11</option>
                            <option value="12" <?php if($valuesArray["day"] == "12") echo "selected = selected"?>>12</option>
                            <option value="13" <?php if($valuesArray["day"] == "13") echo "selected = selected"?>>13</option>
                            <option value="14" <?php if($valuesArray["day"] == "14") echo "selected = selected"?>>14</option>
                            <option value="15" <?php if($valuesArray["day"] == "15") echo "selected = selected"?>>15</option>
                            <option value="16" <?php if($valuesArray["day"] == "16") echo "selected = selected"?>>16</option>
                            <option value="17" <?php if($valuesArray["day"] == "17") echo "selected = selected"?>>17</option>
                            <option value="18" <?php if($valuesArray["day"] == "18") echo "selected = selected"?>>18</option>
                            <option value="19" <?php if($valuesArray["day"] == "19") echo "selected = selected"?>>19</option>
                            <option value="20" <?php if($valuesArray["day"] == "20") echo "selected = selected"?>>20</option>
                            <option value="21" <?php if($valuesArray["day"] == "21") echo "selected = selected"?>>21</option>
                            <option value="22" <?php if($valuesArray["day"] == "22") echo "selected = selected"?>>22</option>
                            <option value="23" <?php if($valuesArray["day"] == "23") echo "selected = selected"?>>23</option>
                            <option value="24" <?php if($valuesArray["day"] == "24") echo "selected = selected"?>>24</option>
                            <option value="25" <?php if($valuesArray["day"] == "25") echo "selected = selected"?>>25</option>
                            <option value="26" <?php if($valuesArray["day"] == "26") echo "selected = selected"?>>26</option>
                            <option value="27" <?php if($valuesArray["day"] == "27") echo "selected = selected"?>>27</option>
                            <option value="28" <?php if($valuesArray["day"] == "28") echo "selected = selected"?>>28</option>
                            <option value="29" <?php if($valuesArray["day"] == "29") echo "selected = selected"?>>29</option>
                            <option value="30" <?php if($valuesArray["day"] == "30") echo "selected = selected"?>>30</option>
                            <option value="31" <?php if($valuesArray["day"] == "31") echo "selected = selected"?>>31</option>
                          </select>
                          <select name="year" size="1">
                          <?php $year = $valuesArray["year"];
                          for($i = 0; $i < 3; $i++){
                             echo "<option value=\"$year\"'"; if($valuesArray["year"] == $year) echo "selected = selected";
							 echo ">$year</option>";
							 $year = $year - 1;
                            }?></select>
	 
                        <?php if($errorFlag == true){ echo $errorArray["stockDate"];} ?>
                      </div>
                      <div id="formFields" align="left">
                      <label for="description">Description:</label>
                       <textarea name="description" cols="30" rows="5" class="textarea"><?php if ($errorFlag == true){echo $valuesArray["description"];}?></textarea> 
    					<?php if($errorFlag == true){ echo $errorArray["description"];} ?>
                      </div>
                      <div id="formFields"> 
                    <input id="formButtons" type="submit" name="Save"value="Save"/>
                    <input id="formButtonsCancel" type="reset" name="Cancel"value="Cancel"/>
                  </div>
                      <div id="FormFields">&nbsp;</div>
                      <div id="FormFields">&nbsp;</div>                   
                    </form>
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