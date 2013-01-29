<?php
	
	// start footer
	$footer = "<footer>\n";

	// method to return header when called.
	// optionally takes current page path as parameter for cookie redirect
	function getFooter($currentPage){
		global $footer;
		
		$footer = $footer . "<div>StrathTutor<br /> \n";
		$footer = $footer . "by Deryk Egan, 200907381</div>\n";
		$footer = $footer . "<a class='cookies' href='libraries/remove_cookies.php'>
		Remove all cookies (forces logout)</a>";
		
		// close footer and body tags
		$footer = $footer . "</footer></body>\n";
		
		// function will return footer
		return $footer;
	}
	

?>
