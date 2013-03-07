<?php
	// import session and header
	include_once 'libraries/sql.php';
	include_once 'libraries/user_check.php';
	include_once 'classes/pageFactory.php';
	include_once 'classes/tableFactory.php';
	
	// check that user is logged in, else redirect
	if(getLoggedInType() == ""){
		header("Location: index.php");
	}
	
	$actionURL = "libraries/user_password_update.php";
	
	// heredoc for page content
$sitePage = <<<EOT
	
	<br />
	<h1>User Options</h1>
	<h2></h2>
	<br />
    
EOT;
	
	// now generate table
	$sitePage = $sitePage . ('<div class="tableContainer"><form method="post" action="' . $actionURL . '"><table class="twoCol">');
	
	// change password option
	$sitePage = $sitePage . ('<tr class = "odd">' . '<td class = "odd">' . "New Password:" . 
			'<td class = "even">'.
			' <input type="password" name="new_password"
			class="inline_singleText" value="" title="Enter the new password here." required>
			<tr class = "odd">' . '<td class = "odd">' . "Confirm New Password:" . 
			'<td class = "even">'.
			'<input type="password" name="new_password_confirm"
			class="inline_singleText" value="" title="Re-enter the new password here to confirm." required>
			</tr>' .
			'<tr class = "odd">' . '<td class = "odd">' . "" . 
			'<td class = "even">'.'<input type="hidden" name="user_id" value="' . getIdFromUsername(getLoggedInUsername()) .
			'"><input type="Submit" value="Save New Password"></tr>');
			
	$sitePage = $sitePage . ('</table></form></div>');
	
	// create page factory and generate new page
	$pageFactory = new pageFactory();
	$page = $pageFactory->makeHFCookiesPage($sitePage);
	
	// print page to screen
	echo($page->getPage());
	
?>
