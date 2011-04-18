<?php
	
	function DisplayUnits(){
		global $db;
		$result = $db->Query("SELECT `unit_id`, `name` FROM `rudi_combat_units` WHERE `detachment` = 0 ");
		$row = $db->Fetch($result);
		foreach($row as $unit){
			$unit_name = $unit['name'];
			$unit_id = $unit['unit_id'];
				echo '<img src="images/tree_branch.gif" />&nbsp;'.$unit_name.'<br />';
			selectUnits($unit_id, 0, $member['cunit_id']);
		}	
	}
	
		function selectUnits($previous_unit, $indent, $members_unit){
			global $db;
			
		  	$indent++;
		 	//$formatting = str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", $indent); 
		 	$formatting = str_repeat('<img src="images/tree_leaf.gif" />', $indent); 
		
		    $result = $db->Query("SELECT `unit_id`, `name` FROM `rudi_combat_units` WHERE `detachment` = '$previous_unit'");
	 		$row = $db->Fetch($result);
	 		foreach($row as $unit){
				$unit_id = $unit['unit_id'];
				$unit_name = $unit['name'];
	 				echo $formatting.'<img src="images/tree_branch.gif" />&nbsp;'.$unit_name.'<br />'; 
	 					
					selectUnits($unit_id, $indent, $members_unit);
			}
  	} 

?>