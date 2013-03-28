<?php
	/*
		Admin page for editing site configuration.
		
		*/
		
	// import session and header
	include_once 'libraries/admin_sql.php';
	include_once 'libraries/user_check.php';
	include_once 'classes/pageFactory.php';
	
	// check is admin, direct to index if not
	if(!validateUserType("admin")){
		header("Location: index.php");
	}
	
	$actionURL = "libraries/admin_site_update.php";
	
	// heredoc for page content
$sitePage = <<<EOT
	
	<br />
	<h1>Site Configuration</h1>
	<h2>The following values can be modified.</h2>
	<br />
    
EOT;
	
	// now generate table
	$settings = getSiteSettings();
	$sitePage = $sitePage . ('<div class="tableContainer"><table class="twoCol">');
	
	$size = count($settings);
	for($i = 0; $i < $size; $i++){
		
		if($i % 2){
			$sitePage = $sitePage . ('<tr class = "odd">' . '<td class = "odd">' . $settings[$i]["key"] . 
			'<td class = "even">'.
			' <form method="post" action="' . $actionURL . '"><input type="text" name="' .  $settings[$i]["key"]
			. '" class="inline_singleText" value="' . $settings[$i]["value"]
			. '" title="' . $settings[$i]["friendly_key"] . '"><input type="Submit" value="Save"></form></tr>');
		}
		else{
			$sitePage = $sitePage . ('<tr class = "even">' . '<td class = "odd">' . $settings[$i]["key"] . 
			'<td class = "even">'.
			' <form method="post" action="' . $actionURL . '"><input type="text" name="' .  $settings[$i]["key"]
			. '" class="inline_singleText" value="' . $settings[$i]["value"]
			. '" title="' . $settings[$i]["friendly_key"] . '"><input type="Submit" value="Save"></form></tr>');
		}
	}
	$sitePage = $sitePage . ('</table></div>');
	
	// create page factory and generate new page
	$pageFactory = new pageFactory();
	$page = $pageFactory->makeHFCookiesPage($sitePage);
	
	// print page to screen
	echo($page->getPage());
	
?>
