<?php	
//This module Contains functions that are used to validate the fields entered by the user
/*.........................................
 ..........................................
 ..........................................
 ..........................................
 */
/********************************************************************************/
/*  A function that checks if all fields of the form have been filled out. 
/*	if all are not filled 
/********************************************************************************/

function filled_out($form_vars){
// test that each variable has a value
	foreach ($form_vars as $key => $value){
		if (!isset($key) || ($value == "")){
			return false;
		}
	}
	return true;
}

function checkPhoneNumber($num){
	if ((is_numeric($num)) && ((strlen($num) == 10) || (strlen($num) == 8)))
		{return true;}
		
	else {return false;}
}


function validEmail($address)
{
// check an email address is possibly valid
if (ereg("^[a-zA-Z0-9_]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$", $address))return true;
else return false;
}

function loginValidation(&$message){ 

	if (filled_out($_POST) == false){ 			//check if the fields are not empty
		$message = "Please enter username and password";
		return false;
	}
	else return true;									// if not empty query the database if user and password exits
		
}
function notFilledOut($form_vars){
// test that each variable has a value
	foreach ($form_vars as $key => $value){
		if($key == "frmName" ){}						// if $key =frmName do nothing
		else{
			if(isset($key)&&($value <> "")){return true;}	// else check if the field is filled
			}	
	}
	return false ; //returns false if all form fields are empty
}

function convertDate($date){
	$year = substr($date, 0, 4);
	$month = substr($date, 5, 2);
	$day = substr($date, 8, 2);
	
	if($month == "01"){$month = "Jan";} 
	if($month == "02"){$month = "Feb";} 
	if($month == "03"){$month = "Mar";} 
	if($month == "04"){$month = "Apr";} 
	if($month == "05"){$month = "May";} 
	if($month == "06"){$month = "Jun";} 
	if($month == "07"){$month = "Jul";} 
	if($month == "08"){$month = "Aug";} 
	if($month == "09"){$month = "Sep";} 
	if($month == "10"){$month = "Oct";} 
	if($month == "11"){$month = "Nov";} 
	if($month == "12"){$month = "Dec";} 
	
	return $day."-".$month."-".$year;

}

function convertMonth($month){
	
	if(($month == "01") || ($month == "1")){$month = "January";} 
	if(($month == "02") || ($month == "2")){$month = "February";} 
	if(($month == "03") || ($month == "3")){$month = "March";} 
	if(($month == "04") || ($month == "4")){$month = "April";} 
	if(($month == "05") || ($month == "5")){$month = "May";} 
	if(($month == "06") || ($month == "6")){$month = "June";} 
	if(($month == "07") || ($month == "7")){$month = "July";} 
	if(($month == "08") || ($month == "8")){$month = "August";} 
	if(($month == "09") || ($month == "9")){$month = "September";} 
	if($month == "10"){$month = "October";} 
	if($month == "11"){$month = "November";} 
	if($month == "12"){$month = "December";} 
	
	return $month;

}

?>
