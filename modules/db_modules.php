<?php

// Do not do this every time you want to query~~~~!!!

// Connecting, selecting database
@ $link = mysql_connect("localhost","root","password");
if (!$link){
	$message = "Connection Error:";
	 sql_error($message);
}

@ $link2 = mysql_select_db("myshop", $link);
if(!$link2){
	$message ="Database Error:";
	sql_error($message);
}


// run a specified MySQL database query
function sql_query($query, &$message){
	global $link;

	// Performing SQL query
	$result = mysql_query($query, $link);
	if($result ==false){
		$message = "Query Error:";
		sql_error($message);
	}
	return $result;
}

function sql_error($message,$errorType = null){
	$description = mysql_error();
	$number = mysql_errno();
	$error ="MySQL Error : $message\n";
	$error.="Error Number: $number $description\n";
	$error.="Date        : ".date("D, F j, Y H:i:s")."\n";
	$error.="IP          : ".getenv("REMOTE_ADDR")."\n";
	$error.="Browser     : ".getenv("HTTP_USER_AGENT")."\n";
	$error.="Referer     : ".getenv("HTTP_REFERER")."\n";
	$error.="PHP Version : ".PHP_VERSION."\n";
	$error.="OS          : ".PHP_OS."\n";
	$error.="Server      : ".getenv("SERVER_SOFTWARE")."\n";
	$error.="Server Name : ".getenv("SERVER_NAME")."\n";
	echo "<b><font size=3 face=Arial>$message</font></b><hr>";
	echo "<pre>$error</pre>";
	exit;
}

function viewStockItemsSearchTerms($searchTerm){
	$searchTerm = trim(stripslashes($searchTerm));//Removing white spaces from strat and end of search term
	$searchTermArray = explode(" ", $searchTerm);//Splitting multiple word search term into single search terms
	$numberOfSearchTerms = count($searchTermArray);
	for($j = 0; $j < $numberOfSearchTerms; $j++){
		if($j == 0){
			$allSearchTerms = 	' (itemID LIKE "%'.addslashes($searchTermArray[$j]).'%"';
			$allSearchTerms .= ' OR stockID LIKE "%'.addslashes($searchTermArray[$j]).'%"';
			$allSearchTerms .= ' OR serial LIKE "%'.addslashes($searchTermArray[$j]).'%"';
			$allSearchTerms .= ' OR description LIKE "%'.addslashes($searchTermArray[$j]).'%"';
			$allSearchTerms .= ' OR price LIKE "%'.addslashes($searchTermArray[$j]).'%"';
			$allSearchTerms .= ' OR quantity LIKE "%'.addslashes($searchTermArray[$j]).'%"';
			$allSearchTerms .= ' OR deleted LIKE "%'.addslashes($searchTermArray[$j]).'%"';
			$allSearchTerms .= ' OR date LIKE "%'.addslashes($searchTermArray[$j]).'%"';
			$allSearchTerms .= ' OR time LIKE "%'.addslashes($searchTermArray[$j]).'%"';
			$allSearchTerms .= ' OR user LIKE "%'.addslashes($searchTermArray[$j]).'%"';
		}
		else {
			$allSearchTerms .= ' OR itemID LIKE "%'.addslashes($searchTermArray[$j]).'%"';
			$allSearchTerms .= ' OR stockID LIKE "%'.addslashes($searchTermArray[$j]).'%"';
			$allSearchTerms .= ' OR serial LIKE "%'.addslashes($searchTermArray[$j]).'%"';
			$allSearchTerms .= ' OR description LIKE "%'.addslashes($searchTermArray[$j]).'%"';
			$allSearchTerms .= ' OR price LIKE "%'.addslashes($searchTermArray[$j]).'%"';
			$allSearchTerms .= ' OR quantity LIKE "%'.addslashes($searchTermArray[$j]).'%"';
			$allSearchTerms .= ' OR deleted LIKE "%'.addslashes($searchTermArray[$j]).'%"';
			$allSearchTerms .= ' OR date LIKE "%'.addslashes($searchTermArray[$j]).'%"';
			$allSearchTerms .= ' OR time LIKE "%'.addslashes($searchTermArray[$j]).'%"';
			$allSearchTerms .= ' OR user LIKE "%'.addslashes($searchTermArray[$j]).'%"';
		}
	}
	return $allSearchTerms;
}

?>
