<?php 
function displayViewSaleInfo($message,$errorArray,$valuesArray,$errorFlag,$errorType){

if(($valuesArray["price"] != 0) && ($valuesArray["quantity"] != 0)){
$valuesArray["totalCostPrice"] = ($valuesArray["price"] * $valuesArray["quantity"]);
}
if($valuesArray["phone"] == ""){$valuesArray["phone"] ="-";}
if($valuesArray["email"] == ""){$valuesArray["email"] ="-";}
?>
 <table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>
	<td>
    <table cellpadding="0" cellspacing="0" border="0" id="formHeader" width="100%">
    	<tr>     
            <td>Sales - Sale Item Info</td>
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
        	<table cellpadding="0" cellspacing="0" border="0" align="left" id="rightBoby">           
            
            <tr> 
                <td valign="top"> 
                  <div id="formFields">&nbsp;</div>
                  <div id="formFields">
                  <label for="description">Item:</label>
                    <div id="itemInfo"><?php  echo $valuesArray["description"]; ?></div>
                  </div>
                  <div id="formFields">
                    <label for="price">Cost Price:</label>
                     <div id="itemInfo"><?php echo "K".number_format($valuesArray["price"], 2, '.', ','); ?></div> 
                  </div> 
                    <div id="formFields">
                    <label for="itemID">Item ID:</label>
                     <div id="itemInfo"><?php echo $value = $valuesArray["itemID"];?></div> 
                  </div>
                  <div id="formFields">
                      <div id="formLine">&nbsp;</div>
                    </div>
                  <div id="formFields">
                    <label for="description">Name:</label>
                    <div id="itemInfo"><?php echo $valuesArray["title"].". ".$valuesArray["customerName"];?></div>
                  </div> 
                    <div id="formFields">
                    <label for="itemID">Phone:</label>
                    <div id="itemInfo"><?php echo $valuesArray["phone"];?></div> 
                  </div>
                  <div id="formFields">
                    <label for="itemID">E-mail:</label>
                     <div id="itemInfo"><?php echo $valuesArray["email"];?></div> 
                  </div>
                  <div id="formFields">
                      <div id="formLine">&nbsp;</div>
                    </div>
                  <div id="formFields">
                    <label for="description">Sale ID:</label>
                    <div id="itemInfo"><?php echo $valuesArray["saleID"];?></div>
                  </div>
                  <div id="formFields">
                    <label for="price">Quantity:</label>
                    <div id="itemInfo"><?php echo $valuesArray["quantity"];?></div> 
                  </div> 
                  <div id="formFields">
                    <label for="itemID">Total Cost Price:</label>
                     <div id="itemInfo"><?php echo "K".number_format($valuesArray["totalCostPrice"], 2, '.', ',');?></div> 
                  </div>
                  <div id="formFields">
                    <label for="itemID">Selling Price:</label>
                    <div id="itemInfo"><?php echo "K".number_format($valuesArray["sellingPrice"], 2, '.', ',');?></div> 
                  </div>
                  <div id="formFields">
                    <label for="itemID">Discount:</label>
                    <div id="itemInfo"><?php echo "K".number_format($valuesArray["discount"], 2, '.', ',');?></div> 
                  </div>
                  <div id="formFields">
                    <label for="itemID">Reciept Number:</label>
                     <div id="itemInfo"><?php echo $valuesArray["recieptNumber"];?></div> 
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