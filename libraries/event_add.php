<?php
	include_once "sql.php";
	include_once "session.php";
	
	/*
	
		Class to add an event to the system log.
		
		*/
		
	function addEvent($eventType, $eventDetails){
		
		$eventType = escapeQuery($eventType);
		$eventDetails = escapeQuery($eventDetails);
		
		$query = "INSERT INTO EventLog(
		event_type,
		event_details,
		event_datetime)
		VALUES(
		'$eventType',
		'$eventDetails',
		NOW())";
		
		doQuery($query);
		
	}

?>
