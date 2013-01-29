<?php
	// import session and sql
	include_once 'libraries/session.php';
	include_once 'libraries/sql.php';
	
	$header = "<!DOCTYPE html>\n<head>\n
		<link rel='stylesheet' type='text/css' href='default.css'>\n
		<meta charset='UTF-8'>\n
		<meta name='viewport' content='width=device-width, initial-scale=1'>\n";
	// *todo* - insert more HTML doctype headers here

	// method to return header when called.
	function getHeader(){
		global $header;
		
		// if logged in, make this page timeout after 20 mins
		if(checkLogin()){
			$header = $header . "<meta http-equiv='refresh' content='1210'>\n";
		}
		
		// close HTML header tag
		$header = $header . "</head>\n<body>\n";
		
		$site_name = getSetting("site_name");
		$site_desc = getSetting("site_description");
		$show_Description = (boolean)getSetting("show_Description");
		$header = $header . "<div class='header'><div class='header_Title'><a href='index.php'>$site_name</a></div>\n";
		
		// display site description in header if appropriate
		if($show_Description){
			$header = $header . "<div class='header_Description'>$site_desc</div> \n";
		}
		
		// display log in / log out depending on state
		if(checkLogin()){
			  $firstName = $_SESSION['firstName'];
			  $lastName = $_SESSION['lastName'];
			  // display user's name
			  $header = $header . "<div class='header_Name'>Hello $firstName $lastName! </div>";
			  $header = $header . "<ul class='header_Nav'> <a href='logout.php'><li class='logout'>Log out</li></a>";
		}
		// display 'Log In'
		else{
			$header = $header . "<ul class='header_Nav'><a href='login.php'><li>Log in</li></a>";
		}
		
	
		$header = $header . " <a href='index.php'><li>Home</li></a>
		<a href='about.php'><li>About $site_name</li></a></ul>";
		
		// close header div
		$header = $header . " </div>";
		
		// if there is not a cookie present, advise about cookie collection
		// as per EU policies
		if(!isset($_COOKIE['EUconsent'])){
			$header = $header . "<div class='EUconsent'>This site uses cookies,
			by continuing you consent to their use.</div>";
			// save notification cookie
			setcookie("EUconsent", true);
		}
		
		// function will return header
		return $header;
	}
	
	// Helper method to check if currently logged in
	function checkLogin(){
		if(isset($_SESSION['loggedIn'])){
			if($_SESSION['loggedIn']){
				return true;
			}
		}
		else{
			return false;
		}
	}

?>
