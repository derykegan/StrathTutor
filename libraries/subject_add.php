<?php
	include_once "sql.php";
	include_once "session.php";
	
	$redirURL = "../admin_subjects.php";
	
	// make sure that form has been filled out
	if(isset($_POST['subject_subject']) && isset($_POST['subject_level']) && isset($_POST['subject_description'])){
		$subject = $_POST['subject_subject'];
		$level = $_POST['subject_level'];
		$description = $_POST['subject_description'];
	}
	else{
		header:("Location: " . $redirURL);
	}
	
	// security - escape queries
	$subject = escapeQuery($subject);
	$level = escapeQuery($level);
	$description = escapeQuery($description);
	
	$query = "INSERT INTO Subject(SubjectName, SubjectLevel, SubjectDescription)
	VALUES ('$subject', '$level', '$description')";
	
	doQuery($query);
	
	// redirect to previous page
	header("Location: " . $redirURL);

?>
