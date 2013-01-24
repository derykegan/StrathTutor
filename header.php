<?php
	// import session and sql
	include_once 'libraries/session.php';
	include_once 'libraries/sql.php';
	
	// *todo* - insert HTML doctype headers here

	// method to return header when called.
	function getHeader(){
		$site_name = getSetting("site_name");
		$site_desc = getSetting("site_description");
		$header = "<div class='header_Title'>$site_name</div>";
		
		// display site description in header if appropriate
		if(displayDescription()){
			$header = $header . "<div class='header_Description'>$site_desc</div>";
		}
		
		$header = "<div class='header_Nav'>Log in | About</div>";
		
		// function will return header
		return $header;
	}

?>
