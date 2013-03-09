<?php
	include_once "sql.php";
	include_once "user_check.php";
	
	/*
		Backend processing for file uploads.
		
		Contains list of allowed file mime types
		
		*/
		
	$allowed_size = 5 * 1024 * 1024;
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
	function fvalidateFileType($fileType){
		global $allowed_types;
		return in_array($fileType, $allowed_types);
	}
	
	// Checks that file size is within limits
	function validateFileSize($size){
		global $allowed_size;
		return ($size <= $allowed_size);
	}

?>
