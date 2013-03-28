<?php
	/*
		Admin messaging view. Shows messages for all
		users on system.
		*/
		
	// import session and header
	include_once 'libraries/user_check.php';
	include_once 'libraries/messages.php';
	include_once 'classes/pageFactory.php';
	include_once 'templates/messages_nav.php';
	
	// check that user is logged in, else redirect
	if(getLoggedInType() != "admin"){
		header("Location: index.php");
	}
	
	// get message nav bar
	$sitePage = getMessageNavigation("Message Administration");
	
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
