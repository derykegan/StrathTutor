<?php
	
	include_once 'classes/pageFactory.php';
	include_once 'libraries/sql.php';
	include_once 'libraries/session.php';
	include_once 'libraries/user_check.php';
	include_once 'templates/messages_nav.php';
	
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
        <form method="POST" action="libraries/message_new.php">
 			       	
			<table class='create_message'>
                <tr>
                    <td><p class="label">To:</p></td>
                    <td><input type="text" name="toUser" size="30" required="required"></td>
                </tr>
                <tr>
                    <td><p class="label">Subject:</p></td>
                    <td><input type="text" name="subject" size="30" required="required"></td>
                </tr>
				<tr>
					<td class="styledText" colspan="2"><input type="textarea" name="message" required="required" class="maxText"></td>
				</tr>
                <tr>
                    <td><input type="Submit" value="Send Message" class="sendButton"></td>
                </tr>
            </table>

        </form>
EOT;

	// get navigation bar
	$createForm = getMessageNavigation("Create New Message") . $createForm;
	
	// print error message if appropriate
	if($error_noUser){
		$createForm = "<div class='errorNotice'><div class='errorText'>
		Oops! It doesn't look like that user name was right. Please try again.
		</div></div>" . $createForm;
	}
	
	// create page factory and generate new page
	$pageFactory = new pageFactory();
	$page = $pageFactory->makeHFCookiesPage($createForm);
	
	// print page to screen
	echo($page->getPage());

?>