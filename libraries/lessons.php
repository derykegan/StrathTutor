<?php
	// Class to deal with MySQL interaction for lessons
	
	include_once 'sql.php';
	
	// returns this student's messages
	function getStudentLessons($username){
		$username = escapeQuery($username);
		$query = "SELECT L.lesson_id, U1.username AS tutor, U2.username AS student, L.startTime, L.endTime, Subject.SubjectName, Subject.SubjectLevel, Subject.SubjectDescription
			FROM Lessons AS L 
			INNER JOIN Subject ON L.subject_id = Subject.SubjectId
			INNER JOIN User AS U1 ON L.tutor_id = U1.user_id
			INNER JOIN User AS U2 ON L.student_id = U2.user_id
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
	
	// creates the given message
	function sendMessage($fromUser, $toUser, $subject, $message){
		// escape all entered terms
		$fromUser = escapeQuery($fromUser);
		$toUser = escapeQuery($toUser);
		$subject = escapeQuery($subject);
		$message = escapeQuery($message);
		
		$continue = false;
		
		// check that both specified users exist, else don't do anything
		if(userExists($fromUser) && userExists($toUser)){
			$continue = true;
		}
		
		// convert usernames to id numbers for storage
		$fromUser = getIdFromUsername($fromUser);
		$toUser = getIdFromUsername($toUser);
		
		if($continue){
		
			 $query = "INSERT INTO Messages(
					fromUserId, 
					toUserId, 
					messageTitle, 
					messageText) 
				VALUES (
					$fromUser, 
					$toUser, 
					'$subject', 
					'$message');";
			
			$result = doQuery($query);
		
		}
		
	}
	
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
	

?>
