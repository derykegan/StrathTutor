<?php

	/* 	Interface and classes for creating tables.
		Uses factory design pattern.
		
		Interface: ITable, ITableFactory
		
		Table factory:---
		Concrete class 1: tableFactory
		
		Table:---
		Concrete class 1: Table([Headings][Content])
		
		
		*/
			
	// interface for table factory
	interface ITableFactory{
		
		// $headings - Array of table headings
		// $content  - Array of content for table
		public function makeTable($headings, $content);
		
		// as above, but with:
		// $idFieldName - the name of the field containing the id of object
		// $viewURL - the URL to redirect to view the object.
		public function makeTableView($headings, $content, $idFieldName, $viewURL);
		
	}
		
	// interface for table classes
	interface ITable{
		
		// used to set table headings
		public function setHeadings($headings);
		
		// used to set main table contents
		public function setContent($content);
		
		// used to return the completed table
		public function getTable();
		
	}
	
	// concrete class for page factory
	class tableFactory implements ITableFactory{
		
		public function makeTable($headings, $content){
			return new Table($headings, $content);
		}
		
		public function makeTableView($headings, $content, $idFieldName, $viewURL){
			return new Table_View($headings, $content, $idFieldName, $viewURL);
		}
		
	}
	
	// class to generate table
	class Table implements ITable{
		
		// constructor
		function __construct($headings, $content) {
			global $page, $tableHeadings, $tableContent;
			
			$page = "";
			$tableHeadings = $headings;
			$tableContent = $content;
			
		}
		
		// sets desired table headings
		function setHeadings($headings){
			global $tableHeadings;
			
			$tableHeadings = $headings;
			
		}
		
		// sets desired table content
		function setContent($content){
			global $tableContent;
			
			$tableContent = $content;
		}
		
		// gets the current table object
		function getTable(){
			global $page, $tableContent, $tableHeadings;
			// reset current page content
			$page = "";
			
			$page = '<div class="tableContainer"><table class="twoCol">';
			
			// make sure we have a header row, else skip
			/*
			$headerSize = count($tableHeadings);
			if($headerSize > 0){
				
				$page = $page . '<tr class = "tableHeader">';
				
				foreach ($tableHeadings as $h){
					$page = $page . '<td class = "headerCell">' . $h . '</td>';
				}
				
				$page = $page . '</tr>';
			}
			*/
			
			
				
				$page = $page . '<tr class = "tableHeader">';
				
				foreach (array_keys($tableContent[0]) as $h){
					
					$page = $page . '<th class = "headerCell">' . $h . '</th>';
				}
				
				$page = $page . '</tr>';
			
			
			// make sure we have table content to print
			
			$contentSize = count($tableContent);
			
			for($i = 0; $i < $contentSize; $i++){
				$rowSize = count($tableContent[$i]);
				
				// vary row depending on odd/even
				if($i % 2){
					$page = $page . ('<tr class = "odd">');
				}
				else{
					$page = $page . ('<tr class = "even">');
				}
				
				// now build row content
				$oddevenCount = 0;
				foreach ($tableContent[$i] as $row){
					
					// vary cell tag depending on odd/even
					if($oddevenCount % 2){
						
						$page = $page . '<td class = "odd">';
						
					}
					else{
						$page = $page . '<td class = "even">';
					}
					
					// add content
					$page = $page . $row;
					
					// close cell tag
					$page = $page . '</td>';
					$oddevenCount += 1;
					
				}
				
				// close row tag
				$page = $page . '</tr>';
				
			}
			
			$page = $page . ('</table></div>');
			
			return $page;
		}
		
	}
	
	// class to generate table
	class Table_View implements ITable{
		
		// constructor
		function __construct($headings, $content, $idFieldName, $viewURL) {
			global $page, $tableHeadings, $tableContent, $idName, $URL;
			
			$page = "";
			$tableHeadings = $headings;
			$tableContent = $content;
			$idName = $idFieldName;
			$URL = $viewURL;
			
		}
		
		// sets desired table headings
		function setHeadings($headings){
			global $tableHeadings;
			
			$tableHeadings = $headings;
			
		}
		
		// sets desired table content
		function setContent($content){
			global $tableContent;
			
			$tableContent = $content;
		}
		
		// gets the current table object
		function getTable(){
			global $page, $tableContent, $tableHeadings, $idName, $URL;
			// reset current page content
			$page = "";
			
			$page = '<div class="tableContainer"><table class="twoCol">';
			
				
				$page = $page . '<tr class = "tableHeader">';
				$page = $page . '<td class = "headerCell"></td>';
				
				foreach (array_keys($tableContent[0]) as $h){
					
					$page = $page . '<td class = "headerCell">' . $h . '</td>';
				}
				
				$page = $page . '</tr>';
			
			
			// make sure we have table content to print
			
			$contentSize = count($tableContent);
			
			for($i = 0; $i < $contentSize; $i++){
				$rowSize = count($tableContent[$i]);
				
				// vary row depending on odd/even
				if($i % 2){
					$page = $page . ('<tr class = "odd">');
				}
				else{
					$page = $page . ('<tr class = "even">');
				}
				
				// now build row content
				$oddevenCount = 1;
				$view = '<td class = "even">
				<a href="' . $URL . '?id=' . $tableContent[$i][$idName] . '">
				VIEW</a></td>';
				$page = $page . $view;
				
				foreach ($tableContent[$i] as $row){
					
					// vary cell tag depending on odd/even
					if($oddevenCount % 2){
						
						$page = $page . '<td class = "even">';
						
					}
					else{
						$page = $page . '<td class = "odd">';
					}
					
					// add content
					$page = $page . $row;
					
					// close cell tag
					$page = $page . '</td>';
					$oddevenCount += 1;
					
				}
				
				// close row tag
				$page = $page . '</tr>';
				
			}
			
			$page = $page . ('</table></div>');
			
			return $page;
		}
		
	}
	
	
?>
