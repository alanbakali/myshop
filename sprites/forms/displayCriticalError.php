<?php
function displayCriticalError($message, $errorType){
$errorImagepath = "/Myshop/images/icons/";

if($errorType == "success"){
	$errorImage = "success_icon.png";
}
if($errorType == "info"){
	$errorImage = "info_icon.png";
}
if($errorType == "warning"){
	$errorImage = "warning_icon.png";
}
else{
	$errorImage = "error_icon.png";
}
?>

    <tr valign="top" align="center">
    	<td id="messageBox"><table align="center"><tr valign="top">
            <td align="left" valign="middle" width="40" height="35"><img src=" <?php echo $errorImagepath.$errorImage;?> "/>
            </td>
            <td align="left"valign="top"><?php echo $message; ?> </td>
            </tr></table></td>
    </tr>
    

<?php
}
?>