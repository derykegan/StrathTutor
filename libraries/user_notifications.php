<?php
	// Class to deal with MySQL interaction for user notifications
	
	include_once 'sql.php';
	include_once 'lessons.php';
	
	// returns this tutor's notifications
	function getTutorNotifications($username){
		findAndCleanLessons();
		$username = escapeQuery($username);
		
		$num_days = getSetting('notif_num_days');
		if($num_days <= 0){
			// in this case notifications have been disabled
			return;
		}
		
		// else use number of days 
		
		$query = "SELECT L.lesson_id, U1.username AS tutor, U2.username AS student, L.startTime, L.duration, Subject.SubjectDescription, LS.statusDescription
			FROM Lessons AS L 
			INNER JOIN Subject ON L.subject_id = Subject.SubjectId
			INNER JOIN User AS U1 ON L.tutor_id = U1.user_id
			INNER JOIN User AS U2 ON L.student_id = U2.user_id
			INNER JOIN LessonStatus AS LS ON L.status = LS.statusName
			WHERE U1.username = '$username'
			AND (
			L.startTime > now( )
			AND L.startTime < now( ) + INTERVAL + '$num_days' DAY
			)
			AND STATUS != 'CANCELLED'
			ORDER BY L.startTime ASC";
		
		
		$result = doQuery($query);
		
		// save query results in an array
		$result_array = array();
		while($row = mysqli_fetch_assoc($result))
		{
    		$result_array[] = $row;
		}
		
		return $result_array;
	}
	
	// returns this student's notifications
	function getStudentNotifications($username){
		findAndCleanLessons();
		$username = escapeQuery($username);
		$studentId = getIdFromUsername($username);
		
		$num_days = getSetting('notif_num_days');
		if($num_days <= 0){
			// in this case notifications have been disabled
			return;
		}
		
		// else use number of days 
		
		$query = "SELECT L.lesson_id, U1.username AS tutor, U2.username AS student, L.startTime, L.duration, Subject.SubjectDescription, LS.statusDescription
			FROM Lessons AS L 
			INNER JOIN Subject ON L.subject_id = Subject.SubjectId
			INNER JOIN User AS U1 ON L.tutor_id = U1.user_id
			INNER JOIN User AS U2 ON L.student_id = U2.user_id
			INNER JOIN LessonStatus AS LS ON L.status = LS.statusName
			WHERE U2.username = '$username'
			AND (
			L.startTime > now( )
			AND L.startTime < now( ) + INTERVAL + '$num_days' DAY
			)
			AND STATUS != 'CANCELLED'
			ORDER BY L.startTime ASC";
		
		
		$result = doQuery($query);
		
		// save query results in an array
		$result_array = array();
		while($row = mysqli_fetch_assoc($result))
		{
    		$result_array[] = $row;
		}
		
		return $result_array;
	}
	

?>
