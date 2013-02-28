<?php 
function displayViewDownPaymentInfo($message,$errorArray,$valuesArray,$errorFlag,$errorType){


if($valuesArray["phone"] == ""){$valuesArray["phone"] ="-";}
if($valuesArray["email"] == ""){$valuesArray["email"] ="-";}
if($valuesArray["serial"] == ""){$valuesArray["serial"] ="-";}
if($valuesArray["lastPayment"] == 0){$valuesArray["lastPayment"] ="-";}
else {$valuesArray["lastPayment"] = "K".number_format($valuesArray["lastPayment"], 2, '.', ',');}



if($valuesArray["recieptNumber2"] == 0){$valuesArray["recieptNumber2"] ="-";}
else {$valuesArray["recieptNumber2"] = $valuesArray["recieptNumber2"];}
?>
 <table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>
	<td>
    <table cellpadding="0" cellspacing="0" border="0" id="formHeader" width="100%">
    	<tr>     
            <td>DownPayment - DownPayment Info</td>
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
        	<table cellpadding="0" cellspacing="0" border="0" align="right" id="rightBoby" height="350">           
            
            <tr>
                <td valign="top">
                  
                  <div id="formFields">
                  <label for="description">Item:</label>
                    <div id="itemInfo"><?php  echo $valuesArray["description"]; ?></div>
                  </div>
                  <div id="formFields">
                    <label for="serial">Serial:</label>
                     <div id="itemInfo"><?php echo $valuesArray["serial"];?></div> 
                  </div>
                  <div id="formFields">
                    <label for="price">Cost Price:</label>
                     <div id="itemInfo"><?php echo "K".number_format($valuesArray["price"], 2, '.', ','); ?></div> 
                  </div> 
                    
                  <div id="formFields">
                      <div id="formLine">&nbsp;</div>
                    </div>
                  <div id="formFields">
                    <label for="customerName">Customer Name:</label>
                    <div id="itemInfo"><?php echo $valuesArray["title"].". ".$valuesArray["customerName"];?></div>
                  </div> 
                  <div id="formFields">
                    <label for="address">Address:</label>
                    <div id="itemInfo"><?php echo $valuesArray["address"];?></div>
                  </div>
                    <div id="formFields">
                    <label for="phone">Phone:</label>
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
                    <label for="downPaymentID">DownPayment ID:</label>
                    <div id="itemInfo"><?php echo $valuesArray["downPaymentID"];?></div>
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
                    <label for="firstPayment">First Payment:</label>
                    <div id="itemInfo"><?php echo "K".number_format($valuesArray["firstPayment"], 2, '.', ',');?></div> 
                  </div>
                  <div id="formFields">
                    <label for="itemID">Reciept Number:</label>
                     <div id="itemInfo"><?php echo $valuesArray["recieptNumber"];?></div> 
                  </div>
                  <div id="formFields">
                    <label for="lastPayment">Final Payment:</label>
                    <div id="itemInfo"><?php echo $valuesArray["lastPayment"];?></div> 
                    </div>
                    <div id="formFields">
                    <label for="lastPayment">Reciept Number 2:</label>
                     <div id="itemInfo"><?php echo $valuesArray["recieptNumber2"];?></div> 
                    </div>
                  <div id="formFields">
                    <label for="balance">Balance:</label>
                    <div id="itemInfo"><?php echo "K".number_format($valuesArray["balance"], 2, '.', ',');?></div> 
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
                  <div id="formFooter">&nbsp;</div>
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