<?php
	// Hashes the supplied password
	function hashPassword($password){
		return hash("sha512", $password); 
	}

?>
