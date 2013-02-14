<?php
	/*
		Message navigation bar
		
		*/
		
	include_once 'libraries/user_check.php';
		
	// menu
	$sitePage = "<div class='messageMenu'><ul class='message_Nav'>";
	
	// show admin message menu if appropriate
	if(getLoggedInType() == 'admin'){
		$sitePage = $sitePage . "<li><a href='admin_messaging.php'>All Messages</a></li>";
	}
	$sitePage = $sitePage . "
	<li><a href='user_message_new.php'>Send New Message</a></li>
	<li><a href='user_messaging.php'>Inbox</a></li>
	<li><a href='user_messages_sent.php'>Sent Messages</a></li>
	</ul></div>";
	
	/* returns navigation bar for messages */
	function getMessageNavigation($pageTitle){
		global $sitePage;
		
		$sitePage = $sitePage . "<br />
			<h1>Messages</h1>
			<h2>$pageTitle</h2>
			<br />";
		
		return $sitePage;
	}
	
?>
