<?php
	// class to remove all cookies
	session_destroy();
	
	// set EU privacy cookie to be removed
	setcookie("EUconsent", false, time() - 9999);
	
	$printme = "<!DOCTYPE html>\n<head>\n
		<link rel='stylesheet' type='text/css' href='default.css'>\n
		<meta charset='UTF-8'>\n
		<meta name='viewport' content='width=device-width, initial-scale=1'></head>\n";
		
	echo($printme);
	echo("<body>All cookies have been removed, you may now close this browser
	tab or window.</body>");

?>
