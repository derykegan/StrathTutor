<?php
	// import session and header
	include_once 'libraries/admin_sql.php';
	include_once 'libraries/user_check.php';
	include_once 'classes/pageFactory.php';
	
	// check is admin, direct to index if not
	if(!validateUserType("admin")){
		header("Location: index.php");
	}
	
	// heredoc for page content
$sitePage = <<<EOT
	
	<br />
	<div class = 'panelTitle'>Site Configuration</div>
	<div class = 'panelText'>The following values can be modified.</div>
	<br />
    
EOT;
	
	// now generate table
	$settings = getSiteSettings();
	$sitePage = $sitePage . ('<table class="2col">');
	
	$size = count($settings);
	for($i = 0; $i < $size; $i++){
		
		if($i % 2){
			$sitePage = $sitePage . ('<tr class = "odd">' . '<td class = "odd">' . $settings[$i]["key"] . 
			'<td class = "even">'. $settings[$i]["value"] . '</tr>');
		}
		else{
			$sitePage = $sitePage . ('<tr class = "even">' . '<td class = "odd">' . $settings[$i]["key"] . 
			'<td class = "even">'. $settings[$i]["value"] . '</tr>');
		}
	}
	$sitePage = $sitePage . ('</table>');
	
	// create page factory and generate new page
	$pageFactory = new pageFactory();
	$page = $pageFactory->makeHFCookiesPage($sitePage);
	
	// print page to screen
	echo($page->getPage());
	
?>
