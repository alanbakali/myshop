<?php

function displayHeader($title){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title><?php echo $title; ?></title>

<script language="javascript" src="/Myshop/javaScript/global_js.js"></script>

<link href="/Myshop/css/global.css" rel="stylesheet" type="text/css" />
</head>
<body  onload="javascript:if(document.frmLogin) { document.frmLogin.userName.focus(); }">
<table border="0" cellspacing="0" cellpadding="0" align="center" id="outerBody" height="100%">
  <tr valign="bottom">
    <td id="banner" >
      <table border="0" cellspacing="0" cellpadding="0" width="100%">
            <tr valign="bottom" height="70">
              <td></td>
              <td>&nbsp;</td>
              <td align="right" id="version">Shop Management System <small id="versionNumber">1.0.0.1</small></td>
            </tr>
    </table>
  </td>
 </tr>
 <tr valign="top">
  <td id="bodyFrame">
	<?php
    }

      /* This marks the end of displayHeader function.*/
      /* This place is where we fill all our main body contents
      /*ie.		displayHeader()-is the above function
      /^   		display...()-is the main body we need to fill
      /^  		displayFooter-is the the function below

     /*This marks the beggining of displayFooter function*/
   function displayFooter(){
   ?>
  </td>
 </tr>
 <tr>
  <td id="footer" align="center">
    <table id = "footer2"><tr valign ="bottom"><td  align="center">
    Myshop&nbsp;&copy;2011
    </td></tr></table>
  </td>
 </tr>
</table>
</body>
</html>
<?php ///This marks the end of displayFooter function
}
?>
