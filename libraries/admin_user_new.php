<?php
	// Class to deal with MySQL interaction for creating a new user.
	
	include_once 'sql.php';
	
	// returns user types as an associative array
	function getSystemUserTypes(){
		$query = 'SELECT * FROM UserType';
		$result = doQuery($query);
		
		return $result;
	}
	
	// generates drop down options depending on type
	function generateDropDown($type){
		
		$typeArray = array('userType');
		
		// if given option isn't predefined, return nothing
		if(!in_array($type, $typeArray)){
			return "";
		}
		
		// possible user types
		if($type == 'userType'){
			
			$result = getSystemUserTypes();
			$toReturn = "";
			
			if(count($result) > 0){
				while($row = $result->fetch_assoc()){
					$toReturn = $toReturn . "<option value=" . $row['userType'] . ">" . $row['typeDescription'] . "</option>";
				}
			}
			
			return $toReturn;
			
		}
		
		
		
	}
	

?>
