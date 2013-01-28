<?php
	// class to perform user type validation for current user
	// returns true if valid, false if not
	function validateUserType($typeToValidate){
		$continue = false;
	
		// check if logged in, and what user type
		if(isset($_SESSION['loggedIn']) ) {
			if($_SESSION['loggedIn']){
				// check user is desired level
				if($_SESSION['userType'] == $typeToValidate){
					$continue = true;
				}
			}
		}
		
		return $continue;
		
	}

?>
