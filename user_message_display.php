<?php
	// import session and header
	include_once 'libraries/user_check.php';
	include_once 'libraries/messages.php';
	include_once 'classes/pageFactory.php';
	include_once 'templates/messages_nav.php';
	
	// check that user is logged in, else redirect
	if(getLoggedInType() == ""){
		header("Location: index.php");
	}
	
	// if there is no post variable, redirect
	if(!isset($_GET['id'])){
		header("Location: user_messaging.php");
	}
	// read message id from post
	$messageid = $_GET['id'];
	
	// get username and query the requested message
	$username = getLoggedInUsername();
	$messages = getSingleMessage($messageid);
	
	// now check that this user should be able to read this message at all.
	// ie - admin, or either the 'from' or 'to' user
	if(getLoggedInType() != "admin"){
		if($username != $messages[0]["fromUser"]
			&& $username != $messages[0]["toUser"]){
				// redirect as needed
				header("Location: user_messaging.php");
		}
	}
	
	// get message nav bar
	$sitePage = getMessageNavigation("View Message");
	
	// build table
	$sitePage = $sitePage . ('<div class="tableContainer"><table class="twoCol">');
	
	$size = count($messages);
	
	// if no messages
	if($size == 0){
		$sitePage = $sitePage . '<tr class = "odd">' . '<td class = "bold">Message does not exist.</td></tr>';
	}
	// else we are popular
	else{
		
		//print header row
		$sitePage = $sitePage . ('<tr class = "tableHeader">' . '<td class = "bold">' . 
				'<td class = "bold">' . 'From' . '</td>' .
				'<td class = "bold">' . 'To'. '</td>' . 
				'<td class = "bold">' . 'Title' . '</td>' .
				'<td class = "bold">' . 'Message' . '</td>' . '</tr>');
		
		for($i = 0; $i < $size; $i++){
			$messageid = $messages[$i]["message_id"];
			if($i % 2){
				$sitePage = $sitePage . ('<tr class = "odd">' . '<td class = "bold">' .
				'<td class = "even">' . $messages[$i]["fromUser"] . '</td>' . 
				'<td class = "even">' . $messages[$i]["toUser"] . '</td>' . 
				'<td class = "even">' . $messages[$i]["messageTitle"] . '</td>' .
				'<td class = "even">' . $messages[$i]["messageText"] . '</td>' . '</tr>');
			}
			else{
				$sitePage = $sitePage . ('<tr class = "even">' . '<td class = "bold">' .
				'<td class = "even">' . $messages[$i]["fromUser"] . '</td>' . 
				'<td class = "even">' . $messages[$i]["toUser"] . '</td>' .
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
