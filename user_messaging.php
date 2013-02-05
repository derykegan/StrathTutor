<?php
	// import session and header
	include_once 'libraries/user_check.php';
	include_once 'libraries/messages.php';
	include_once 'classes/pageFactory.php';
	
	// check that user is logged in, else redirect
	if(getLoggedInType() == ""){
		header("Location: index.php");
	}
	
	// heredoc for page content
$sitePage = <<<EOT
	
	<br />
	<h1>Messages</h1>
	<h2>Send New Message | Inbox | Sent Messages</h2>
	<br />
    
EOT;
	
	// get username and query messages
	$username = getLoggedInUsername();
	$messages = getUserMessages($username);
	
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
			if($i % 2){
				$sitePage = $sitePage . ('<tr class = "odd">' . '<td class = "bold">' 
				. '<a href="display_message.php?=' . $messageid .'">VIEW</a> </td>' .
				'<td class = "even">' . $messages[$i]["fromUser"] . '</td>' . 
				'<td class = "even">' . $messages[$i]["messageTitle"] . '</td>' .
				'<td class = "even">' . $messages[$i]["messageText"] . '</td>' . '</tr>');
			}
			else{
				$sitePage = $sitePage . ('<tr class = "even">' . '<td class = "bold">' 
				. '<a href="display_message.php?=' . $messageid .'">VIEW</a> </td>' .
				'<td class = "even">' . $messages[$i]["fromUser"] . '</td>' .
				'<td class = "even">' . $messages[$i]["messageTitle"] . '</td>' .
				'<td class = "even">' . $messages[$i]["messageText"] . '</td>' . '</tr>');
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
