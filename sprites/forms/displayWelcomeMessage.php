<?php
function displayWelcomeMessage(){
$userName = $_SESSION['userName'];
?>
 <td valign="bottom" align="right" id="welcomeMessage" nowrap="nowrap"><a href="logout.php">
 	Logout</a><?php echo "<a href=\"actions.php?action=info&amp;userName=$userName&amp;whichForm=frmUsers\">&nbsp;"; 
    				echo ucwords($_SESSION['fName'])." ".ucwords($_SESSION['lName'])."</a>"; ?>&nbsp;
</td>
<?php
}
?>