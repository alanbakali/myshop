<?php
function displayStockMenu(){

?>
    <tr>
        <td id="adminMenuTitles">Stock</td>
     </tr>
     <tr>
        <td id="adminMenuLinks"><img src="/Myshop/images/raw/adminMenuLinks.png" /><a href="administrator.php?p=enterStockItem">Add Stock Item</a></td>
     </tr>
      <?php 
      if($_SESSION['userGroup'] == "Administrator"){
      ?>
     <tr>
        <td id="adminMenuLinks"><img src="/Myshop/images/raw/adminMenuLinks.png" /><a href="administrator.php?p=editStockItem1">Edit Stock Item</a></td>
     </tr>
      <?php 
     }
    ?>
     
     <tr>
        <td id="adminMenuLinks"><img src="/Myshop/images/raw/adminMenuLinks.png" /><a href="administrator.php?p=viewStockItems">Stock Items List</a></td>
     </tr>
     <tr>
        <td>&nbsp;</td>
     </tr>
<?php
}
?>

<?php
function displaySalesMenu(){
	?>
	<tr>
	<td id="adminMenuTitles">Sales</td>
	 </tr>
	 <tr>
		<td id="adminMenuLinks"><img src="/Myshop/images/raw/adminMenuLinks.png" /><a href="administrator.php?p=enterSales">Enter Sales</a></td>
	 </tr>
	  <?php 
	  if($_SESSION['userGroup'] == "Administrator"){
	  ?>
	 <tr>
		<td id="adminMenuLinks"><img src="/Myshop/images/raw/adminMenuLinks.png" /><a href="administrator.php?p=editSales">Edit Sales</a></td>
	 </tr>
	 <?php
	}
	?>
	 <tr>
		<td id="adminMenuLinks"><img src="/Myshop/images/raw/adminMenuLinks.png" /><a href="administrator.php?p=viewSales">Sales List</a></td>
	 </tr>
	 <tr>
		<td>&nbsp;</td>
	 </tr>
<?php
}
?>


<?php
function displayInstallmentMenu(){

?>   

<tr>
    <td id="adminMenuTitles">Installments</td>
 </tr>
 <tr>
    <td id="adminMenuLinks"><img src="/Myshop/images/raw/adminMenuLinks.png" /><a href="administrator.php?p=viewInstallments">Installments List</a></td>
 </tr>
  <tr>
    <td id="adminMenuLinks"><img src="/Myshop/images/raw/adminMenuLinks.png" /><a href="administrator.php?p=newInstallment">New Installment</a></td>
 </tr>
 <tr>
    <td id="adminMenuLinks"><img src="/Myshop/images/raw/adminMenuLinks.png" /><a href="administrator.php?p=lastPaymentInstallment">Final Payment</a></td>
 </tr>
   <tr>
    <td>&nbsp;</td>
  </tr>
 <?php
}
?>


<?php
function displayDownPaymentsMenu(){
?>   
<tr>
<td id="adminMenuTitles">DownPayments</td>
</tr>
<tr>
<td id="adminMenuLinks"><img src="/Myshop/images/raw/adminMenuLinks.png" /><a href="administrator.php?p=viewDownPayments">DownPayments List</a></td>
</tr>
<tr>
<td id="adminMenuLinks"><img src="/Myshop/images/raw/adminMenuLinks.png" /><a href="administrator.php?p=newDownPayment">New DownPayment</a></td>
</tr>
<tr>
<tr>
<td id="adminMenuLinks"><img src="/Myshop/images/raw/adminMenuLinks.png" /><a href="administrator.php?p=lastPaymentDownPayment">Final Payment</a></td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>

<?php
}
?>

<?php
function displayStockDefinitionMenu(){
?>  

<tr>
<td id="adminMenuTitles">Stock Definition</td>
</tr>
<tr>
<td id="adminMenuLinks"><img src="/Myshop/images/raw/adminMenuLinks.png" /><a href="administrator.php?p=newStockDefinition">New Stock Definition</a></td>
</tr>
<tr>
<td id="adminMenuLinks"><img src="/Myshop/images/raw/adminMenuLinks.png" /><a href="administrator.php?p=editStockDefinition">Edit Stock Definition</a></td>
</tr>
<tr>
<td id="adminMenuLinks"><img src="/Myshop/images/raw/adminMenuLinks.png" /><a href="administrator.php?p=viewStockDefinitions">Stock Definitions List</a></td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
<?php
}
?>

<?php
function displayServicesMenu(){
?>  
<tr>
<td id="adminMenuTitles">Services</td>
</tr>
<tr>
<td id="adminMenuLinks"><img src="/Myshop/images/raw/adminMenuLinks.png" /><a href="administrator.php?p=enterService">Enter Service</a></td>
</tr>
<tr>
<td id="adminMenuLinks"><img src="/Myshop/images/raw/adminMenuLinks.png" /><a href="administrator.php?p=viewServices">View Services</a></td>
</tr>

<tr>
<td>&nbsp;</td>
</tr>
<?php
}
?>

<?php
function displayExpensesMenu(){
?>  
<tr>
<td id="adminMenuTitles">Expenses</td>
</tr>
<tr>
<td id="adminMenuLinks"><img src="/Myshop/images/raw/adminMenuLinks.png" /><a href="administrator.php?p=enterExpense">Enter Expense</a></td>
</tr>
<?php 
if($_SESSION['userGroup'] == "Administrator"){
?>
<tr>
<td id="adminMenuLinks"><img src="/Myshop/images/raw/adminMenuLinks.png" /><a href="administrator.php?p=defineExpense">Define Expense</a></td>
</tr>
<?php
}
?>
<tr>
<td id="adminMenuLinks"><img src="/Myshop/images/raw/adminMenuLinks.png" /><a href="administrator.php?p=viewExpenses">View Expenses</a></td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
<?php
}
?>


<?php
function displayReportsMenu(){
?>  
<tr>
<td id="adminMenuTitles">Reports</td>
</tr>
<tr>
<td id="adminMenuLinks"><img src="/Myshop/images/raw/adminMenuLinks.png" /><a href="administrator.php?p=stockReport">Stock Report</a></td>
</tr>
<tr>
<td id="adminMenuLinks"><img src="/Myshop/images/raw/adminMenuLinks.png" /><a href="administrator.php?p=incomeExpenditure">Income and Expenditure</a></td>
</tr>
<tr>
<td id="adminMenuLinks"><img src="/Myshop/images/raw/adminMenuLinks.png" /><a href="administrator.php?p=transactions">Transactions</a></td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
<?php
}
?>

<?php
function displayUsersMenu(){
?>  
<tr>
<td id="adminMenuTitles">Users</td>
</tr>
<tr>
<td id="adminMenuLinks"><img src="/Myshop/images/raw/adminMenuLinks.png" /><a href="administrator.php?p=newUser">Add User</a></td>
</tr>
<tr>
<td id="adminMenuLinks"><img src="/Myshop/images/raw/adminMenuLinks.png" /><a href="administrator.php?p=usersList">Users List</a></td>
</tr>
<tr>
<td id="adminMenuLinks"><img src="/Myshop/images/raw/adminMenuLinks.png" /><a href="administrator.php?p=changePassword">Change Password</a></td>
</tr><tr>
<td>&nbsp;</td>
</tr>
<?php
}
?>




<?php
function displayQuotationsMenu(){
?>  
<tr>
<td id="adminMenuTitles">Quotations</td>
</tr>
<tr>
<td id="adminMenuLinks"><img src="/Myshop/images/raw/adminMenuLinks.png" /><a href="administrator.php?p=newQuatations">New Quatation</a></td>
</tr>
<tr>
<td id="adminMenuLinks"><img src="/Myshop/images/raw/adminMenuLinks.png" /><a href="administrator.php?p=viewQuatations">Quatations List</a></td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
<?php
}
?>
<?php
function displayOtherMenu(){
$userName = $_SESSION['userName'];
?>  
<tr>
<td id="adminMenuTitles">Extra</td>
</tr>
<tr>
<td id="adminMenuLinks"><img src="/Myshop/images/raw/adminMenuLinks.png" />
<?php echo "<a href=\"actions.php?action=info&amp;userName=$userName&amp;whichForm=frmUsers\">My Account</a>"; ?>
</td>
</tr>
<td id="adminMenuLinks"><img src="/Myshop/images/raw/adminMenuLinks.png" /><a href="administrator.php?p=changePassword">Change Password</a></td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
<?php
}
?>