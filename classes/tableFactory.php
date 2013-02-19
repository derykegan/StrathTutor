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
		
	}
		
	// interface for table classes
	interface ITable{
		
		// constructor
		function __construct($headings, $content) ;
		
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
			return new Table;
		}
		
	}
	
	// class to generate table
	class Table implements ITable{
		
		// constructor
		function __construct($headings, $content) {
			global $page, $headings, $content;
			
			$page = "";
			$tableHeadings = setHeadings($headings);
			$tableContent = setContent($content);
			
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
			$headerSize = count($tableHeadings);
			if($headerSize > 0){
				
				$page = $page . '<tr class = "tableHeader">';
				
				foreach ($tableHeadings as $h){
					$page = $page . '<td class = "headerCell">$h</td>';
				}
				
				$page = $page . '</tr>';
			}
			
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
				
				for($j = 0; $j < $rowSize; $j++){
					
					// vary cell tag depending on odd/even
					if($j % 2){
						
						$page = $page . '<td class = "odd">';
						
					}
					else{
						$page = $page . '<td class = "even">';
					}
					
					// add content
					$page = $page . $tableContent[$i][$j];
					
					// close cell tag
					$page = $page . '</td>';
					
				}
				
				// close row tag
				$page = $page . '</tr>';
				
			}
			
			$page = $page . ('</table></div>');
			
			return $page;
		}
		
	}
	
	
?>
