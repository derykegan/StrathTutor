<?php
	
	include_once 'classes/pageFactory.php';
	include_once 'libraries/sql.php';
	include_once 'libraries/session.php';
	include_once 'libraries/user_check.php';
	
	$error_noUser = false;
	
	// check that user is logged in, else redirect
	if(getLoggedInType() == ""){
		header("Location: index.php");
	}
	
	// check session for errors
	if(isset($_SESSION['error_message_noUser'])){
		if($_SESSION['error_message_noUser']){
			$error_noUser = true;
		}
		unset($_SESSION['error_message_noUser']);
	}
	
$createForm = <<<EOT
	
	<h1>Messages</h1>
	<h2>Create New Message</h2>
        <form method="POST" action="libraries/message_new.php">
 			       	
			<table class='create_message'>
                <tr>
                    <td><p class="label">To:</p></td>
                    <td><input type="text" name="toUser" size="50" required="required"></td>
                </tr>
                <tr>
                    <td><p class="label">Subject:</p></td>
                    <td><input type="text" name="subject" size="30" required="required"></td>
                </tr>
				<tr>
					<td><input type="textarea" name="message" required="required"></td>
				</tr>
                <tr>
                    <td><input type="Submit" value="Send Message" class="sendButton"></td>
                </tr>
            </table>

        </form>
EOT;
	
	// print error message if appropriate
	if($error_noUser){
		$loginForm = "<div class='errorNotice'><div class='errorText'>
		Oops! It doesn't look like that user name was right. Please try again.
		</div></div>" . $loginForm;
	}
	
	// create page factory and generate new page
	$pageFactory = new pageFactory();
	$page = $pageFactory->makeHFCookiesPage($createForm);
	
	// print page to screen
	echo($page->getPage());

?>