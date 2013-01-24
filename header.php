<?php
	// import session and sql
	include_once 'libraries/session.php';
	include_once 'libraries/sql.php';
	
	$header = "<!DOCTYPE html>\n<meta charset='UTF-8'>";
	// *todo* - insert more HTML doctype headers here

	// method to return header when called.
	function getHeader(){
		global $header;
		
		// if logged in, make this page timeout after 20 mins
		if(checkLogin()){
			$header = $header . "<meta http-equiv='refresh' content='1210'>";
		}
		
		$site_name = getSetting("site_name");
		$site_desc = getSetting("site_description");
		$show_Description = (boolean)getSetting("show_Description");
		$header = $header . "<div class='header_Title'><a href='index.php'>$site_name</a></div>";
		
		// display site description in header if appropriate
		if($show_Description){
			$header = $header . "<div class='header_Description'>$site_desc</div> ";
		}
		
		// display log in / log out depending on state
		if(checkLogin()){
			  $firstName = $_SESSION['firstName'];
			  // display 'Log out'
			  $header = $header . "<div class='header_Nav'>Hello $firstName | <a href='logout.php'>Log out</a> |";
		}
		// display 'Log In'
		else{
			$header = $header . "<div class='header_Nav'><a href='login.php'>Log in</a> |";
		}
		
	
		$header = $header . " <a href='about.php'>About</a></div>";
		
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
