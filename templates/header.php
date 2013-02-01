<?php

	/*
		Header interface and concrete implementation.
		
		Interface: IHeader
		
		Concrete class 1: Header
		
		getHeader() returns a normal header, using cookies
		getHeaderNoCookies() does not use session, therefore no cookies
		in order to comply with EU cookies legislation
		
		*/

	interface IHeader{
		
		public function getHeader();
		
		public function getHeaderNoCookies();
		
	}
	
	class Header implements IHeader{
		
		// Helper method to check if currently logged in
		public function checkLogin(){
			if(isset($_SESSION['loggedIn'])){
				if($_SESSION['loggedIn']){
					return true;
				}
			}
			else{
				return false;
			}
		}
		
		// return normal (cookies) header
		public function getHeader(){
			include_once 'libraries/session.php';
			include_once 'libraries/sql.php';
			
			$site_name = getSetting("site_name");
			$site_desc = getSetting("site_description");
			
			$header = "<!DOCTYPE html>\n<head>\n
				<link rel='stylesheet' type='text/css' href='default.css'>\n
				<meta charset='UTF-8'>\n
				<meta name='viewport' content='width=device-width, initial-scale=1'>\n
				<title>$site_name</title>\n";
			// *todo* - insert more HTML doctype headers here
			
			
			// if logged in, make this page timeout after 20 mins
			if($this->checkLogin()){
				$header = $header . "<meta http-equiv='refresh' content='1210'>\n";
			}
			
			// close HTML header tag
			$header = $header . "</head>\n<body>\n";
			
			$show_Description = (boolean)getSetting("show_Description");
			$header = $header . "<div class='wrap'><div class='header'><div class='header_Title'>
				<a href='index.php'>$site_name</a></div>\n";
			
			// display site description in header if appropriate
			if($show_Description){
				$header = $header . "<div class='header_Description'>$site_desc</div> \n";
			}
			
			// display log in / log out depending on state
			if($this->checkLogin()){
				  $firstName = $_SESSION['firstName'];
				  $lastName = $_SESSION['lastName'];
				  // display user's name
				  $header = $header . "<div class='header_Name'>Hello $firstName $lastName! </div>";
				  $header = $header . "<div class='navigation'><ul class='header_Nav'> <a href='logout.php'>
				  <li class='logout'>Log out</li></a>";
			}
			// display 'Log In'
			else{
				$header = $header . "<div class='navigation'><ul class='header_Nav'><a href='login.php'><li>Log in</li></a>";
			}
			
		
			$header = $header . " <a href='index.php'><li>Home</li></a>
			<a href='about.php'><li>About $site_name</li></a></ul>";
			
			// close header div
			$header = $header . " </div></div>";
			
			// if there is not a cookie present, advise about cookie collection
			// as per EU policies
			$displayCookie = false;
			if(!isset($_COOKIE['EUconsent'])){
				$displayCookie = true;
			}
			else if($_COOKIE['EUconsent'] == false){
				$displayCookie = true;
			}
			
			if($displayCookie){
				$header = $header . "<div class='EUconsent'><div class='EUconsentText'>
				This site uses cookies. They're nothing to worry about, but if you want 
				to remove them, you can by clicking <a href='remove_cookies.php'>here.</a>
				<br />Unfortunately, if you do this, you won't be able to log in!
				<br />This notice will disappear in the future.
				</div></div>";
				// save notification cookie
				setcookie("EUconsent", true);
			}
			
			
			// function will return header
			return $header;
			
		}
		
		// return non-cookies header
		public function getHeaderNoCookies(){

			include_once 'libraries/sql.php';
			
			$site_name = getSetting("site_name");
			$site_desc = getSetting("site_description");
			
			$header = "<!DOCTYPE html>\n<head>\n
				<link rel='stylesheet' type='text/css' href='default.css'>\n
				<meta charset='UTF-8'>\n
				<meta name='viewport' content='width=device-width, initial-scale=1'>\n
				<title>$site_name</title>\n";
			// *todo* - insert more HTML doctype headers here
			
			// close HTML header tag
			$header = $header . "</head>\n<body>\n";
			
			$show_Description = (boolean)getSetting("show_Description");
			$header = $header . "<div class='header'><div class='header_Title'><a href='index.php'>$site_name</a></div>\n";
			
			// display site description in header if appropriate
			if($show_Description){
				$header = $header . "<div class='header_Description'>$site_desc</div> \n";
			}
			
			// print login
			$header = $header . "<div class='navigation'><ul class='header_Nav'><a href='login.php'><li>Log in</li></a>";
		
			// print other links
			$header = $header . " <a href='index.php'><li>Home</li></a>
			<a href='about.php'><li>About $site_name</li></a></ul>";
			
			// close header div
			$header = $header . " </div></div>";
			
			// function will return header
			return $header;
			
		}
		
		
	}

?>
