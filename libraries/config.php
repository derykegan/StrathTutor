<?php
	// Class to store global configuration settings.
	
	// site name and description
	$site_name = "StrathTutor";
	$site_description = "StrathTutor is a private tuition management system.";
	// boolean - display site description under title?
	$display_description = true;
	
	// returns the name of the site
	function getSiteName(){
		return $site_name;
	}
	
	// returns the site description
	function getSiteDesc(){
		return $site_desc;
	}
	
	// returns whether to display site description
	function displayDescription(){
		return $display_description;
	}
	

?>
