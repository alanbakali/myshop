<?php 
function displayAdminTemp($topLink){
?>
<link href="/Myshop/css/global.css" rel="stylesheet" type="text/css" />

<table border="0" cellspacing="0" cellpadding="0" width="100%">
<tr id="navigation1">
<td  width="100%">
<table  align="left" border="0" cellspacing="0" cellpadding="0" style="margin:0px">
<tr>
<?php 
if(($topLink == "Home") || ($topLink == "Stock") || ($topLink == "Sales") || ($topLink == "Installments") || ($topLink == "DownPayments") ||
	($topLink == "Services") || ($topLink == "Expenses") || ($topLink == "Reports") || ($topLink == "Quotations")){
?>

    <td <?php if($topLink == "Home"){echo "id =\"current\" ";} else {echo "id =\"none\" ";}?>><a href="administrator.php?p=adminHome">Home</a></td>
    <td <?php if($topLink == "Stock"){echo "id =\"current\" ";} else {echo "id =\"none\" ";} ?>><a href="administrator.php?p=stock">Stock</a></td>
    <td <?php if($topLink == "Sales"){echo "id =\"current\" ";} else {echo "id =\"none\" ";} ?>><a href="administrator.php?p=sales">Sales</a></td>
    <td <?php if($topLink == "Installments"){echo "id =\"current\" ";} else {echo "id =\"none\" ";} ?>><a href="administrator.php?p=installments">Installments</a></td>
    <td <?php if($topLink == "DownPayments"){echo "id =\"current\" ";} else {echo "id =\"none\" ";} ?>><a href="administrator.php?p=downpayments">DownPayments</a></td>
    <td <?php if($topLink == "Expenses"){echo "id =\"current\" ";} else {echo "id =\"none\" ";} ?>><a href="administrator.php?p=expenses">Expenses</a></td>
    <td <?php if($topLink == "Reports"){echo "id =\"current\" ";} else {echo "id =\"none\" ";} ?>><a href="administrator.php?p=reports">Reports</a></td>
	
 <?php
}

else{
?>

<td <?php if($topLink == "Logout"){echo "id =\"current\" ";} else {echo "id =\"none\" ";} ?>>
    <a href="index.php">Home</a> 
 </td>
  
 <?php
}
?>
</tr>
</table>
</td>        	
</tr>

</table>
<?php
}		
		
?>
