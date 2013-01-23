<?php
	// Class to store global configuration settings.
	
	// mysql settings
	$db_username = "rmb09188";
	$db_password = "ersterys";
	$db_hostname = "localhost";
	$db_name = "rmb09188";
	
	// site name and description
	$site_name = "StrathTutor";
	$site_description = "StrathTutor is a private tution management system.";
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
