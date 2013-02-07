<?php
	// Class to deal with MySQL interaction for user messages
	
	include_once 'sql.php';
	
	// returns this user's messages
	function getUserMessages($username){
		$username = escapeQuery($username);
		$query = "SELECT M.message_id, U1.username AS fromUser, U2.username AS toUser, M.messageTitle, M.messageText
			FROM Messages AS M
			INNER JOIN User AS U1 ON M.fromUserId = U1.user_id
			INNER JOIN User AS U2 ON M.toUserId = U2.user_id
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
