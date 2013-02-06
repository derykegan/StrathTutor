<?php
	// import session and header
	include_once 'libraries/user_check.php';
	include_once 'libraries/messages.php';
	include_once 'classes/pageFactory.php';
	
	// check that user is logged in, else redirect
	if(getLoggedInType() != "admin"){
		header("Location: index.php");
	}
	
	// heredoc for page content
$sitePage = <<<EOT
	<div class='messageMenu'><ul class='message_Nav'>
	<li><a href='user_message_new.php'>Send New Message</a></li>
	<li><a href='user_messaging.php'>Inbox</a></li>
	<li><a href='user_messages_sent.php'>Sent Messages</a></li>
	</ul></div>
	<br />
	<h1>Administration - Messages</h1>
	<h2>View all system messages</h2>
	<br />
    
EOT;
	
	// get all messages
	$messages = getAllMessages();
	
	// build table
	$sitePage = $sitePage . ('<div class="tableContainer"><table class="twoCol">');
	
	$size = count($messages);
	
	// if no messages
	if($size == 0){
		$sitePage = $sitePage . '<tr class = "odd">' . '<td class = "bold">No messages.</td></tr>';
	}
	// else we are popular
	else{
		
		//print header row
		$sitePage = $sitePage . ('<tr class = "tableHeader">' . '<td class = "bold">' 
				. '</td>' .
				'<td class = "bold">' . 'From'. '</td>' . 
				'<td class = "bold">' . 'Title' . '</td>' .
				'<td class = "bold">' . 'Message' . '</td>' . '</tr>');
		
		for($i = 0; $i < $size; $i++){
			$messageid = $messages[$i]["message_id"];
			$text = $messages[$i]["messageText"];
			// if message > 100, cut size for display
			if(strlen($text) > 100){
				$text = substr($text, 0, 100) . '...';
			}
			if($i % 2){
				$sitePage = $sitePage . ('<tr class = "odd">' . '<td class = "bold">' 
				. '<a href="user_message_display.php?id=' . $messageid .'">VIEW</a> </td>' .
				'<td class = "even">' . $messages[$i]["fromUser"] . '</td>' . 
				'<td class = "even">' . $messages[$i]["messageTitle"] . '</td>' .
				'<td class = "even">' . $text . '</td>' . '</tr>');
			}
			else{
				$sitePage = $sitePage . ('<tr class = "even">' . '<td class = "bold">' 
				. '<a href="user_message_display.php?id=' . $messageid .'">VIEW</a> </td>' .
				'<td class = "even">' . $messages[$i]["fromUser"] . '</td>' .
				'<td class = "even">' . $messages[$i]["messageTitle"] . '</td>' .
				'<td class = "even">' . $text . '</td>' . '</tr>');
			}
		}
	}
	$sitePage = $sitePage . ('</table></div>');
	
	// create page factory and generate new page
	$pageFactory = new pageFactory();
	$page = $pageFactory->makeHFCookiesPage($sitePage);
	
	// print page to screen
	echo($page->getPage());
	
?>
