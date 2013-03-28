<?php

	/*
		Administrator view for editing site content pages.
		
		*/
		
	// import session and header
	include_once 'libraries/admin_sql.php';
	include_once 'libraries/user_check.php';
	include_once 'classes/pageFactory.php';
	
	// check is admin, direct to index if not
	if(!validateUserType("admin")){
		header("Location: index.php");
	}
	
	$actionURL = "libraries/admin_page_update.php";
	
	// heredoc for page content
$sitePage = <<<EOT
	
	<br />
	<h1>Page Editing</h1>
	<h2>Select a page in order to edit its content.</h2>
	<br />
    
EOT;
	
	// now generate table
	$pages = getSitePages();
	$sitePage = $sitePage . ('<div class="tableContainer"><table class="twoCol">');
	
	$size = count($pages);
	for($i = 0; $i < $size; $i++){
		
		if($i % 2){
			$sitePage = $sitePage . ('<tr class = "odd">' . '<td class = "odd">' . $pages[$i]["Page_title"] . 
			'<td class = "even">
			<form method="post" action="' . $actionURL . '"><textarea name="' . $pages[$i]["Page_title"]
			. '" class="edit_inline">' . $pages[$i]["Page_content"] 
			. '</textarea><input type="Submit" value="Save"></form></tr>');
		}
		else{
			$sitePage = $sitePage . ('<tr class = "even">' . '<td class = "odd">' . $pages[$i]["Page_title"] . 
			'<td class = "even">
			<form method="post" action="' . $actionURL . '"><textarea name="' . $pages[$i]["Page_title"]
			. '" class="edit_inline">' . $pages[$i]["Page_content"] 
			. '</textarea><input type="Submit" value="Save"></form></tr>');
		}
	}
	$sitePage = $sitePage . ('</table></div>');
	
	// create page factory and generate new page
	$pageFactory = new pageFactory();
	$page = $pageFactory->makeHFCookiesPage($sitePage);
	
	// print page to screen
	echo($page->getPage());
	
?>
