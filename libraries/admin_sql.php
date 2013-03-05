<?php
	// Class to deal with MySQL interaction for admin pages.
	
	include_once 'sql.php';
	
	// returns site settings as an associative array
	function getSiteSettings(){
		$query = 'SELECT * FROM Settings';
		$result = doQuery($query);
		
		// save query results in an array
		$result_array = array();
		while($row = mysqli_fetch_assoc($result))
		{
    		$result_array[] = $row;
		}
		
		return $result_array;
	}
	
	// returns event log as an associative array
	function getAdminLog(){
		$query = 'SELECT * FROM EventLog
				ORDER BY event_datetime DESC';
		$result = doQuery($query);
		
		// save query results in an array
		$result_array = array();
		while($row = mysqli_fetch_assoc($result))
		{
    		$result_array[] = $row;
		}
		
		return $result_array;
	}
	
	// returns the pages editable by admins
	function getSitePages(){
		$query = 'SELECT * FROM PageContent';
		$result = doQuery($query);
		
		// save query results in an array
		$result_array = array();
		while($row = mysqli_fetch_assoc($result))
		{
    		$result_array[] = $row;
		}
		
		return $result_array;
	}
	
	// returns the subjects editable by admins
	function getSubjects(){
		$query = 'SELECT * FROM Subject';
		$result = doQuery($query);
		
		// save query results in an array
		$result_array = array();
		while($row = mysqli_fetch_assoc($result))
		{
    		$result_array[] = $row;
		}
		
		return $result_array;
	}
	
	// returns the user list
	function getUserList(){
		$query = 'SELECT * FROM User';
		$result = doQuery($query);
		
		// save query results in an array
		$result_array = array();
		while($row = mysqli_fetch_assoc($result))
		{
    		$result_array[] = $row;
		}
		
		return $result_array;
	}
	
	// returns the basic lesson list
	function getLessonList(){
		$query = 'SELECT L.lesson_id, U1.username AS tutor, U2.username AS student, L.startTime, L.duration, Subject.SubjectName, Subject.SubjectLevel, Subject.SubjectDescription, L.status, LS.statusDescription, L.lesson_comments
			FROM Lessons AS L 
			INNER JOIN Subject ON L.subject_id = Subject.SubjectId
			INNER JOIN User AS U1 ON L.tutor_id = U1.user_id
			INNER JOIN User AS U2 ON L.student_id = U2.user_id
			INNER JOIN LessonStatus AS LS ON L.status = LS.statusName
			ORDER BY L.startTime DESC';
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
