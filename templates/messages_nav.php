<?php
	
	// heredoc for page content
$sitePage = <<<EOT
	<div class='messageMenu'><ul class='message_Nav'>
	<li><a href='user_message_new.php'>Send New Message</a></li>
	<li><a href='user_messaging.php'>Inbox</a></li>
	<li><a href='user_messages_sent.php'>Sent Messages</a></li>
	</ul></div>
	<br />
	<h1>Messages</h1>
	<h2>Sent Messages</h2>
	<br />
    
EOT;
	
	/* returns navigation bar for messages */
	function getMessageNavigation(){
		return $sitePage;
	}
	
?>
