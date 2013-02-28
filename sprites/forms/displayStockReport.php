<?php 
function displayStockReport($message,$errorArray,$valuesArray,$errorFlag,$errorType){

$query = "SELECT * FROM stock ORDER BY stockID DESC";
$result = sql_query($query, $message);
$row = mysql_num_rows($result);
			 
?>
<link href="/Myshop/css/global.css" rel="stylesheet" type="text/css" />

<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>
	<td>
    <table cellpadding="0" cellspacing="0" border="0" id="formHeader" width="100%">
    	<tr>     
            <td>Report - Stock Report</td>
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
        	<table cellpadding="0" cellspacing="0" border="0" align="right" id="rightBoby">    
            <div id="formClear">&nbsp;</div>       
            <tr>
            	<td id="reportTitle" align="left">Stock Report</td>
               </tr>
            <tr>
                <td>
                 <form action="/Myshop/fpdf/Reports.php" method="post" name="stockReport" id="stockReport" target="_blank">
                  <input id="frmName" name="frmName" value="stockReport" type="hidden" />
                  	
                  	<div id="formFields">
                        <label for="stockID">StockID:</label>
                        <select name="stockID">
                        <option value="" <?php if(errorFlag == false) echo "selected=selected"; ?>
                      <?php if ($errorFlag == true){ if ($valuesArray["stockID"] == "") echo "selected= selected"; }?>>----Select----</option>
                        <?php
						 for($i = 0; $i< $row; $i++){
						 	$stockIDs = mysql_fetch_array($result);
							$stockID = htmlspecialchars(stripslashes($stockIDs["stockID"]));
							echo "<option value=\"$stockID\" >$stockID</option>";
						}
						?>
                     	 </select>
                        <?php if($errorFlag == true){ echo $errorArray["stockID"];} ?>
                      </div>
                      <div style="height:10px;">&nbsp;</div> 
                     <div id="formFields">
                      <label for="availability">Availability:</label>
                      <select name="availability">
                      <option value="">----Select----</option>
                      <option value="Available">Available</option>
                      <option value="Sold Items">Sold Items</option>
                      <option value="Installment">Installment</option>
                        </select>
                    </div>
                    <div style="height:6px;">&nbsp;</div> 
                      <div id="formFields">
                      <input id="saveButtonsPDF"  type="submit" name="save" value="View Report&nbsp;&nbsp;"/>
                    </div>                    
                      <div id="formFields">&nbsp;</div>       
                    </form>
                  </td>
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