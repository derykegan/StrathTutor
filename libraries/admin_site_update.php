<?php
	
	include_once "sql.php";
	include_once "user_check.php";
	
	// check is admin, direct to index if not
	if(!validateUserType("admin")){
		header("Location: index.php");
	}
	
	
	foreach($_POST as $key => $value){
		
		// security
		$key = escapeQuery($key);
		$value = escapeQuery($value);
	
		$query = "UPDATE `Settings` SET `value` = '$value' WHERE `key` = '$key'";
		
		doQuery($query);
		
	}
	
	// redirect to previous page
	header("Location: ../admin_site.php");

?>
