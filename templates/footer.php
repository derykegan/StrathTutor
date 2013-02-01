<?php
	include_once 'header.php';
	
	// start footer
	$footer = "<footer>\n";

	// method to return header when called.
	function getFooter(){
		global $footer;
		
		$footer = $footer . "<div>StrathTutor<br /> \n";
		$footer = $footer . "by Deryk Egan, 200907381</div>\n";
		
		// vary cookies removal message depending on login status
		if(checkLogin()){
			$footer = $footer . "<a class='cookies' href='libraries/remove_cookies.php'>
				Remove all cookies (forces logout)</a>";
		}
		else {
			$footer = $footer . "<a class='cookies' href='libraries/remove_cookies.php'>
				Remove all cookies</a>";
		}
		
		// close footer and body tags
		$footer = $footer . "</footer></body>\n";
		
		// function will return footer
		return $footer;
	}
	

?>
