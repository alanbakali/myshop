<?php 
function displayViewServiceInfo($message,$errorArray,$valuesArray,$errorFlag,$errorType){


if($valuesArray["diagnosis"] == ""){$valuesArray["diagnosis"] ="-";}
if($valuesArray["serial"] == ""){$valuesArray["serial"] ="-";}

if($valuesArray["phone"] == ""){$valuesArray["phone"] ="-";}
if($valuesArray["email"] == ""){$valuesArray["email"] ="-";}
?>
 <table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>
	<td>
    <table cellpadding="0" cellspacing="0" border="0" id="formHeader" width="100%">
    	<tr>     
            <td>Services - Service Info</td>
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
        <td align="left" >
        	<table cellpadding="0" cellspacing="0" border="0" align="left" id="rightBoby">           
            
            <tr> 
                <td valign="top"> 
                  <div id="formFields">&nbsp;</div>
                    <div id="formFields">
                    <label for="itemID">ServiceID:</label>
                     <div id="itemInfo"><?php echo $value = $valuesArray["serviceID"];?></div> 
                  </div>
                  <div id="formFields">
                  <label for="description">Item:</label>
                    <div id="itemInfo"><?php  echo $valuesArray["item"]; ?></div>
                  </div>
                  <div id="formFields">
                  <label for="serial">Serial:</label>
                    <div id="itemInfo"><?php  echo $valuesArray["serial"]; ?></div>
                  </div>
                   <div id="formFields">
                  <label for="problem">Problem:</label>
                    <div id="itemInfo"><?php  echo $valuesArray["problem"]; ?></div>
                  </div>
                   <div id="formFields">
                  <label for="diagnosis">Diagnosis:</label>
                    <div id="itemInfo"><?php  echo $valuesArray["diagnosis"]; ?></div>
                  </div>
                  <div id="formFields">
                    <label for="charges">Charges:</label>
                     <div id="itemInfo"><?php echo "K".number_format($valuesArray["charges"], 2, '.', ','); ?></div
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