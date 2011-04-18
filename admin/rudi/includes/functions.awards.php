<?php

	function getAwardClasses(){
		global $db;
		$result = $db->Query("SELECT `name`, `class_id` FROM `rudi_award_classes`");
		return $db->Fetch($result);	
	}
	
	function getAwardsByClass($class_id){
		global $db;
		$result = $db->Query("SELECT `award_id`, `name`, `image`, `description` FROM `rudi_awards` WHERE `class_id` = '$class_id' ORDER BY `name`");
		return $db->Fetch($result);
	}
	
	function getAward($award_id){
		global $db;
		$result = $db->Query("SELECT `award_id`, `name`, `image`, `description`, `class_id` FROM `rudi_awards` WHERE `award_id` = '$award_id' LIMIT 1");
		return $db->FetchRow($result);
	}
?>