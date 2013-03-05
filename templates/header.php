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
			
			// define page metadata
			$header = "<!DOCTYPE html>\n<head>\n
				<link rel='stylesheet' type='text/css' href='default.css'>\n
				<meta charset='UTF-8'>\n
				<meta name='viewport' content='width=device-width, initial-scale=1'>\n
				<link rel='apple-touch-icon' media='screen and (resolution: 163dpi)' href='images/phoneIcon.png' />
				<link rel='shortcut icon' href='images/fav.ico' />
				<title>$site_name</title>\n";
			
			
			// if logged in, make this page timeout after 20 mins
			if($this->checkLogin()){
				$header = $header . "<meta http-equiv='refresh' content='1210'>\n";
			}
			
			// import jquery for use with date/time pickers
			$header = $header. '<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
				<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
				<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
				<script src="js/jquery-ui-timepicker-addon.js"></script>
			  
				<script>
					$(document).ready(function() {
						$(".datepicker").datetimepicker({
							minDate: 0,
							maxDate: 90,
							dateFormat: "yy-mm-dd",
							timeFormat: "HH:mm\':00\'"});
					});
				</script>';
	
			// import TinyMCE
			$header = $header . '<script language="javascript" type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>
				<script language="javascript" type="text/javascript">
				tinyMCE.init({
						theme : "advanced",
						mode : "specific_textareas",
						editor_selector : "edit_inline",
						width: "100%"

				});
				</script>';

			
			// close HTML header tag
			$header = $header . "</head>\n<body>\n";
			
			$show_Description = getSetting("show_description");
			$header = $header . "<div class='wrap'><div class='header'><div class='header_Title'>
				<a href='index.php'>$site_name</a></div>\n";
			
			// display site description in header if appropriate
			if($show_Description == "true"){
				$header = $header . "<div class='header_Description'>$site_desc</div> \n";
			}
			
			// display log in / log out depending on state
			if($this->checkLogin()){
				  $firstName = $_SESSION['firstName'];
				  $lastName = $_SESSION['lastName'];
				  // display user's name
				  $header = $header . "<div class='header_Name'>Hello $firstName $lastName! </div>";
				  $header = $header . "<div class='navigation'><ul class='header_Nav'><li class='logout'><a href='logout.php'>
				  Log out</a></li>";
			}
			// display 'Log In'
			else{
				$header = $header . "<div class='navigation'><ul class='header_Nav'><li><a href='login.php'>Log in</a></li>";
			}
			
		
			$header = $header . " <li><a href='index.php'>Home</a></li>
			<li><a href='about.php'>About $site_name</a></li></ul>";
			
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
			
			// if user was redirected here because they timed out, notify
			$displayTimeout = false;
			if(isset($_COOKIE['timedOut'])){
				if($_COOKIE['timedOut'] == true){
					$displayTimeout = true;
					// unset so message only appears once
					unset($_COOKIE['timedOut']);
				}
			}
			
			if($displayTimeout){
				$header = $header . "<div class='errorNotice'><div class='errorText'>
				For your security, you've been logged out as you've been idle for 20 minutes. 
				Please log in again to continue.
				</div></div>";
				
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
				<link rel='apple-touch-icon' media='screen and (resolution: 163dpi)' href='images/phoneIcon.png' />
				<link rel='shortcut icon' href='images/fav.ico' />
				<title>$site_name</title>\n";
			// *todo* - insert more HTML doctype headers here
			
			// close HTML header tag
			$header = $header . "</head>\n<body>\n";
			
			$show_Description = getSetting("show_description");
			$header = $header . "<div class='wrap'><div class='header'><div class='header_Title'>
			<a href='index.php'>$site_name</a></div>\n";
			
			// display site description in header if appropriate
			if($show_Description == "true"){
				$header = $header . "<div class='header_Description'>$site_desc</div> \n";
			}
			
			// print login
			$header = $header . "<div class='navigation'><ul class='header_Nav'><li><a href='login.php'>Log in</a></li>";
		
			// print other links
			$header = $header . " <li><a href='index.php'>Home</a></li>
			<li><a href='about.php'>About $site_name</a></li></ul>";
			
			// close header div
			$header = $header . " </div></div>";
			
			// function will return header
			return $header;
			
		}
		
		
	}

?>
