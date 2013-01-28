<?php
	
	// start footer
	$footer = "<footer>\n";

	// method to return header when called.
	function getFooter(){
		global $footer;
		
		$footer = $footer . "<div>StrathTutor<br /> \n";
		$footer = $footer . "by Deryk Egan, 200907381\n";
		
		// close footer and body tags
		$footer = $footer . "</footer></body>\n";
		
		// function will return footer
		return $footer;
	}
	

?>
