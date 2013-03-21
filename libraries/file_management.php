<?php
	include_once "sql.php";
	include_once "user_check.php";
	include_once "session.php";
	include_once "lessons.php";
	
	/*
		Backend processing for file uploads.
		
		Contains list of allowed file mime types
		
		*/
		
	$redir_error = "../user_lesson_display.php?=";
	$redir_success = "../user_lesson_display.php?=";
		
	// retrieve maximum file size (kb) from db
	$size_kb = getSetting('max_file_size');
	// convert to bytes
	$allowed_size = $size_kb * 1024;
	
	$allowed_types = array(
		"application/ogg",
		"application/pdf",
		"application/xhtml+xml",
		"application/zip",
		"application/gzip",
		"audio/mpeg",
		"audio/mp4",
		"audio/ogg",
		"audio/vorbis",
		"image/gif",
		"image/jpeg",
		"image/pjpeg",
		"image/png",
		"text/html",
		"text/plain",
		"text/xml",
		"video/mpeg",
		"video/mp4",
		"video/ogg",
		"video/quicktime",
		"video/x-matroska",
		"video/x-ms-wmv",
		"video/x-flv",
		"application/x-tar",
		"application/vnd.ms-powerpoint",
		"application/vnd.openxmlformats-officedocument.presentationml.slideshow",
		"application/vnd.ms-excel",
		"application/msword",
		"application/vnd.openxmlformats-officedocument.wordprocessingml.document",
		"application/vnd.openxmlformats-officedocument.presentationml.presentation",
		"application/vnd.ms-office"
		);
		
	// Checks that the gives file type is valid
	function validateFileType($fileType){
		global $allowed_types;
		return in_array($fileType, $allowed_types);
	}
	
	// Checks that file size is within limits
	function validateFileSize($size){
		global $allowed_size;
		return ($size <= $allowed_size);
	}
	
	// Process input ---------------------
	
	// check is logged in.
	if(getLoggedInType() == ''){
		setError("Not logged in.");
		header($redir_error);
	}
	
	// validate form
	if(!isset($_POST['lesson_id'], $_POST['file_description'])){
		setError("Required information not provided, please try again.");
		header($redir_error);
		exit;
	}
	
	$lesson_id = $_POST['lesson_id'];
	$description = $_POST['file_description'];
	
	// validate file type
	if(!validateFileType($_FILES["file"]["type"])){
		setError("Submitted file was not of an approved file type. Please try again.");	
		header($redir_error . $lesson_id);
		exit;
	}
	// validate file size
	if(!validateFileSize($_FILES["file"]["size"])){
		setError("Submitted file was larger than the allowed size. ("
		. $size_kb . " KB). Please try again.");	
		header($redir_error . $lesson_id);
		exit;
	}
	
	// validate for php/ upload errors
	if ($_FILES["file"]["error"] > 0){
		setError("Error: " . $_FILES["file"]["error"]);
		header($redir_error . $lesson_id);
		exit;
	}
	
	// else file has uploaded successfully
	
	// create server name by hashing the lesson id and file name
	$file_name_server = hash("md5", $lesson_id . $_FILES["file"]["name"]);
	
	// now check that the file doesn't already exist
	if(file_exists("../upload/" . $lesson_id ."/" . $file_name_server)){
		setError("Error: File already exists with this name.");
		header($redir_error . $lesson_id);
		exit;
	}
	
	// check location to make sure it exists, create it if not
	if(!is_dir("../upload/" . $lesson_id . "/")){
		mkdir("../upload/" . $lesson_id . "/");
	}
	
	// now move temp file to actual location and name
	move_uploaded_file($_FILES["file"]["tmp_name"], 
		"../upload/" . $lesson_id . "/" . $file_name_server);
		
	// now update lesson db
	addLessonFile($lesson_id, $_FILES["file"]["name"], 
		$file_name_server, $description);
		
	// now set success message and redirect
	setSuccess("File succesfully uploaded.");
	header($redir_success . $lesson_id);
	exit;


?>
