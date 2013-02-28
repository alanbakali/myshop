<?php
	/*******************************************************************
		 Myshop Shop Sales Management System					
		-------------------------------------------------
		Verion: 1.0.0.1
		Develper:		Alan Bakali
		Co- Doveloper:	Jones Kumwenda			
	
	/*******************************************************************/
	session_start();
	require_once("./modules/required_modules.php");	//We are including all the required modules from other filess
	
	if(session_is_registered("userName") || isset($_SESSION['userName'])){ 
		session_unregister("userName");
		unset($_SESSION['userName']);
		session_destroy;							//No session has yet started 
	}
	if(isset($_GET['p'])){					// a page command was issued through a get request
		switch(rawurldecode($_GET['p'])){	// Process page commannd 
				
			case "aboutUs"				:	displayHeader("Myshop: About Us");	
											displayAdminTemp("aboutUs");
											displayAboutUs($message);
											displayFooter();  exit;
											
			case "contactUs"			:	displayHeader("Myshop: About Us");	
											displayAdminTemp("contactUs");
											displayContactUs($message);
											displayFooter();  exit;
																		
			default						:	displayHeader("Myshop: Home");
											displayAdminTemp("Logout");
											displayLoginForm("");
											displayFooter();
											exit;
		}
	}
	else{
		session_start();
		if (session_is_registered("userName")){
			displayHeader("Myshop: Home");
			displayAdminTemp("Logout");
			displayLoginForm("Please login to access our system");
			displayFooter();
			session_unregister("userName");
			unset($_SESSION['userName']);
			session_destroy();
			exit;
		}
		displayHeader("Myshop: Home");
		displayAdminTemp("Logout");
		displayLoginForm("");
		displayFooter();
}
?>