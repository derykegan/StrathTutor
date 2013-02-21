<?php
	// Class to deal with MySQL interaction for lessons
	
	include_once 'sql.php';
	
	// returns this student's messages
	function getStudentLessons($username){
		$username = escapeQuery($username);
		$query = "SELECT L.lesson_id, U1.username AS tutor, U2.username AS student, L.startTime, L.endTime, Subject.SubjectName, Subject.SubjectLevel, Subject.SubjectDescription, L.status, LS.statusDescription
			FROM Lessons AS L 
			INNER JOIN Subject ON L.subject_id = Subject.SubjectId
			INNER JOIN User AS U1 ON L.tutor_id = U1.user_id
			INNER JOIN User AS U2 ON L.student_id = U2.user_id
			INNER JOIN LessonStatus AS LS ON L.status = LS.statusName
			WHERE U2.username = '$username'";
		
		$result = doQuery($query);
		
		// save query results in an array
		$result_array = array();
		while($row = mysqli_fetch_assoc($result))
		{
    		$result_array[] = $row;
		}
		
		return $result_array;
	}
	
	// returns this tutor's messages
	function getTutorLessons($username){
		$username = escapeQuery($username);
		$query = "SELECT L.lesson_id, U1.username AS tutor, U2.username AS student, L.startTime, L.endTime, Subject.SubjectName, Subject.SubjectLevel, Subject.SubjectDescription, L.status, LS.statusDescription
			FROM Lessons AS L 
			INNER JOIN Subject ON L.subject_id = Subject.SubjectId
			INNER JOIN User AS U1 ON L.tutor_id = U1.user_id
			INNER JOIN User AS U2 ON L.student_id = U2.user_id
			INNER JOIN LessonStatus AS LS ON L.status = LS.statusName
			WHERE U1.username = '$username'";
		
		$result = doQuery($query);
		
		// save query results in an array
		$result_array = array();
		while($row = mysqli_fetch_assoc($result))
		{
    		$result_array[] = $row;
		}
		
		return $result_array;
	}
	
	// returns this parent's messages
	function getParentLessons($username){
		$username = escapeQuery($username);
		
		// first get the list of students for this parent
		$query1 = "SELECT  U1.username AS parent, U2.username AS student, UserStudent.IsOwnParent
			FROM UserStudent
			INNER JOIN User AS U1 ON UserStudent.parentID = U1.user_id
			INNER JOIN User AS U2 ON UserStudent.user_id = U2.user_id
			WHERE U1.username = '$username' AND UserStudent.IsOwnParent = '0'";
			
		$result1 = doQuery($query1);
		$student_array = array();
		while($row = mysqli_fetch_assoc($result1))
		{
    		$student_array[] = $row;
		}
		$studentCount = count($student_array);
		// if no students, don't continue
		if($studentCount <= 0){
			// return blank array
			return array();
		}
		
		// we have >=1 students
		
		// set up holding array
		$toReturn = array();
		
		for($i = 0; $i < $studentCount; $i++){
			
			$studentName = $student_array[$i]['student'];
			
			$studentLessons = getStudentLessons($studentName);
			
			// append to return array
			for($j = 0; $j < count($studentLessons); $j++){
				$toReturn[] = $studentLessons[$j];
			}
			
		}
		
		
		return $toReturn;
	}
	
	
	// creates a new lesson - if status is blank, the default waiting status will apply
	function createLesson($student, $tutor, $subject, $level, $startTime, $endTime, $comments, $status){
		// escape all entered terms
		$student = escapeQuery($student);
		$tutor = escapeQuery($tutor);
		$subject = escapeQuery($subject);
		$level = escapeQuery($level);
		$startTime = escapeQuery($startTime);
		$endTime = escapeQuery($endTime);
		$comments = escapeQuery($comments);
		
		// sanitise status string
		if($status == null | $status == ""){
			// set to default status - waiting for approval
			$status = "WAITING";
		}
		else{
			$status = escapeQuery($status);
		}
		
		
		$continue = false;
		
		// check that both specified users exist, else don't do anything
		if(userExists($student) && userExists($tutor)){
			$continue = true;
		}
		
		// convert usernames to id numbers for storage
		$student = getIdFromUsername($student);
		$tutor = getIdFromUsername($tutor);
		
		// convert subject info into a subject id
		$subjectId = getSubjectId($subjectName, $subjectLevel);
		
		if($continue){
		
			 $query = "INSERT INTO Lessons(
					student_id, 
					tutor_id, 
					startTime, 
					endTime,
					subject_id,
					status
					) 
				VALUES (
					$student, 
					$tutor, 
					'$startTime', 
					'$endTime',
					$subjectId,
					'$status');";
			
			$result = doQuery($query);
		
		}
		
	}
	/*
	// returns the message corresponding to this id
	function getSingleMessage($message_id){
		$message_id = escapeQuery($message_id);
		$query = "SELECT M.message_id, U1.username AS fromUser, U2.username AS toUser, M.messageTitle, M.messageText
			FROM Messages AS M
			INNER JOIN User AS U1 ON M.fromUserId = U1.user_id
			INNER JOIN User AS U2 ON M.toUserId = U2.user_id
			WHERE M.message_id = $message_id";
		$result = doQuery($query);
		
		// save query results in an array
		$result_array = array();
		while($row = mysqli_fetch_assoc($result))
		{
    		$result_array[] = $row;
		}
		
		return $result_array;
	}
	
	// returns this user's sent messages
	function getUserSentMessages($username){
		$username = escapeQuery($username);
		$query = "SELECT M.message_id, U1.username AS fromUser, U2.username AS toUser, M.messageTitle, M.messageText
			FROM Messages AS M
			INNER JOIN User AS U1 ON M.fromUserId = U1.user_id
			INNER JOIN User AS U2 ON M.toUserId = U2.user_id
			WHERE U1.username = '$username'";
		$result = doQuery($query);
		
		// save query results in an array
		$result_array = array();
		while($row = mysqli_fetch_assoc($result))
		{
    		$result_array[] = $row;
		}
		
		return $result_array;
	}
	
	// returns ALL the messages - for admin use
	function getAllMessages(){
		$query = "SELECT M.message_id, U1.username AS fromUser, U2.username AS toUser, M.messageTitle, M.messageText
			FROM Messages AS M
			INNER JOIN User AS U1 ON M.fromUserId = U1.user_id
			INNER JOIN User AS U2 ON M.toUserId = U2.user_id";
		$result = doQuery($query);
		
		// save query results in an array
		$result_array = array();
		while($row = mysqli_fetch_assoc($result))
		{
    		$result_array[] = $row;
		}
		
		return $result_array;
	}
	*/

?>