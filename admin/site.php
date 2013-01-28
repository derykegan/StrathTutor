<?php
	// import session and header
	include_once '../header.php';
	include_once 'admin_sql.php';
	include_once '../libraries/user_check.php';
	
	// check is admin, direct to index if not
	if(!validateUserType("admin")){
		header("Location: ../index.php");
	}
	
	// print header
	echo(getHeader() . "\n");
	
	// heredoc for page content
$sitePage = <<<EOT
	
	<br />
	<div class = 'panelTitle'>Site Configuration</div>
	<div class = 'panelText'>Please select an option below to begin configuration.</div>
	<br />
    
EOT;
	
	// print site admin page
	echo($sitePage);
	
	// now generate table
	$settings = getSiteSettings();
	echo('<table>');
	$size = count($settings);
	for($i = 0; $i < $size; $i++){
		
		if($i % 2){
			echo('<tr class = "odd">' . '<td class = "odd">'. $settings[$i]["key"] . 
			'<td class = "even">'. $settings[$i]["value"] . '</tr>');
		}
		else{
			echo('<tr class = "even">' . '<td class = "odd">'. $settings[$i]["key"] . 
			'<td class = "even">'. $settings[$i]["value"] . '</tr>');
		}
	}
	echo('</table>');
	
?>
