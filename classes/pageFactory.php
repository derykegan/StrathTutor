<?php

	/* 	Interface and classes for creating pages.
		Uses factory design pattern.
		
		Interface: IPage
		
		Concrete class 1: HFCookiesPage ([Header, Footer, Cookies] page)
		Concrete class 2: TBD
		
		
		*/
		
	// interface for page classes
	interface IPage{
		
		// used to set main page content
		function setContent($content);
		
		// used to return the completed page
		function getPage();
		
	}
	
	// class to generate header, footer, cookies page
	class HFCookiesPage implements IPage{
		
		// constructor
		function __construct() {
				
			// import session and header
			include_once '../header.php';
			include_once '../footer.php';
			
			$page = "";
			$pageContent = "";
			
		}
		
		// sets desired page content
		function setContent($content){
			global $pageContent;
			$pageContent = $content;
		}
		
		// gets the current page object
		function getPage(){
			global $page, $pageContent;
			// reset current page content
			$page = "";
			
			// add header
			$page = $page . getHeader() . "\n";
			
			// add page content
			$page = $page . $pageContent;
			
			// add footer
			$page = $page . getFooter();
			
			return $page;
		}
		
		
	}
	
	
?>
