<?php
	/*
		Message navigation bar
		
		*/
		
	// heredoc for page content
$sitePage = <<<EOT
	<div class='messageMenu'><ul class='message_Nav'>
	<li><a href='user_message_new.php'>Send New Message</a></li>
	<li><a href='user_messaging.php'>Inbox</a></li>
	<li><a href='user_messages_sent.php'>Sent Messages</a></li>
	</ul></div>
	
    
EOT;
	
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
