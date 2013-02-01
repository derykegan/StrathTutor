<?php

	/* 	Interface and classes for creating pages.
		Uses factory design pattern.
		
		Interface: IPage, IPageFactory
		
		Page factory:---
		Concrete class 1: pageFactory
		
		Pages:---
		Concrete class 1: HFCookiesPage ([Header, Footer, Cookies] page)
		Concrete class 2: HFNoCookiesPage ([Header, Footer, No cookies] page)
		
		
		*/
		
	// import header and footer
	include_once 'templates/header.php';
	include_once 'templates/footer.php';
			
	// interface for page factory
	interface IPageFactory{
		
		public function makeHFCookiesPage($content);
		public function makeHFNoCookiesPage($content);
		
	}
		
	// interface for page classes
	interface IPage{
		
		// constructor
		function __construct($content) ;
		
		// used to set main page content
		public function setContent($content);
		
		// used to return the completed page
		public function getPage();
		
	}
	
	// concrete class for page factory
	class pageFactory implements IPageFactory{
		
		public function makeHFCookiesPage($content){
			return new HFCookiesPage($content);
		}
		
		public function makeHFNoCookiesPage($content){
			return new HFNoCookiesPage($content);
		}
		
	}
	
	// class to generate header, footer, cookies page
	class HFCookiesPage implements IPage{
		
		// constructor
		function __construct($content) {
			global $page, $pageContent;
			
			$page = "";
			$pageContent = $content;
			
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
			
			// generate header
			$header = new Header();
			
			// add header
			$page = $page . $header->getHeader() . "\n";
			
			// add page content
			$page = $page . $pageContent;
			
			// add footer
			$page = $page . getFooter();
			
			return $page;
		}
		
	}
	
	// class to generate a header and footer page not using any cookies
	class HFNoCookiesPage implements IPage{
		
		// constructor
		function __construct($content) {
			global $page, $pageContent;
			
			$page = "";
			$pageContent = $content;
			
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
			
			// generate header
			$header = new Header();
			
			// add header
			$page = $page . $header->getHeaderNoCookies() . "\n";
			
			// add page content
			$page = $page . $pageContent;
			
			// add footer
			$page = $page . getFooter();
			
			return $page;
		}
		
	}
	
	
?>
