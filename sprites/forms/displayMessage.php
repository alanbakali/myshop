<?php
function displayMessage($message,$errorType){

$errorImagepath = "/Myshop/images/icons/";

if($errorType == "success"){
	$errorImage = "success_icon.png";
}
else if($errorType == "info"){
	$errorImage = "info_icon.png";
}
else if($errorType == "warning"){
	$errorImage = "warning_icon.png";
}
else{
	$errorImage = "error_icon.png";
}
?>
<link href="/Myshop/css/global.css" rel="stylesheet" type="text/css" />


 <table  align="center" id="messageBox" cellpadding="0" cellspacing="0" border="0" width="100%">
<tr valign="middle">

<td align="left" valign="middle" width="30"><img src=" <?php echo $errorImagepath.$errorImage;?> "/></td>
<td align="left" valign="middle"><?php echo ucfirst($message); ?> </td>
<td>&nbsp;</td>
</tr>
</table>
<?php
}

function displayErrorMessage($message,$errorType){

$errorImagepath = "/Myshop/images/icons/";

if($errorType == "success"){
	$errorImage = "success_icon.png";
}
else if($errorType == "info"){
	$errorImage = "info_icon.png";
}
else if($errorType == "warning"){
	$errorImage = "warning_icon.png";
}
else{
	$errorImage = "error_icon.png";
}

?>

<div id="errorMsg">
<?php
 echo $message; 
?>
</div>
<?php
}
?>