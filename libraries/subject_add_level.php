<?php
	include_once "sql.php";
	include_once "session.php";
	
	$redirURL = "../admin_subjects.php";
	
	// make sure that form has been filled out
	if(isset($_POST['level_level']) && isset($_POST['level_description'])){
		$level = $_POST['level_level'];
		$description = $_POST['level_description'];
	}
	else{
		header:("Location: " . $redirURL);
	}
	
	// security - escape queries
	$level = escapeQuery($level);
	$description = escapeQuery($description);
	
	$query = "INSERT INTO SubjectLevel(Level, Description)
	VALUES ('$level', '$description')";
	
	doQuery($query);
	
	// redirect to previous page
	header("Location: " . $redirURL);

?>
