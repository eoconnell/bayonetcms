<?php

	function getAllBattles(){
		global $db;
		
		$result = $db->Query("SELECT w.war_id, 
									 w.title, 
									 w.visit_unit_id, 
									 w.home_score, 
									 w.visit_score, 
									 w.date, 
									 w.status, 
									 v.name 
							  FROM rudi_war_stats AS w 
							  LEFT OUTER JOIN rudi_war_units AS v 
							  ON v.visitor_id = w.visit_unit_id 
							  ORDER BY w.date");
		$data = $db->Fetch($result);
		
		return $data;	
	}
	
	function getBattleInfo($war_id){
		global $db;
		
		$result = $db->Query("SELECT w.war_id, 
									 w.title, 
									 w.visit_unit_id, 
									 w.home_score, 
									 w.visit_score, 
									 w.date, 
									 w.status, 
									 v.name 
							  FROM rudi_war_stats AS w 
							  LEFT OUTER JOIN rudi_war_units AS v 
							  ON v.visitor_id = w.visit_unit_id 
							  WHERE w.war_id = {$war_id}");
		$data = $db->FetchRow($result);
		
		return $data;	
	}
	
	function getCombatSoldiers($war_id){
		global $db;
		
		$query = "SELECT m.member_id, 
									 m.first_name, 
									 m.last_name, 
									 r.shortname, 
									 r.longname, 
									 w.record_id,
									 								  
							  FROM rudi_combat_record AS w 
							  JOIN rudi_unit_members AS m 
							  ON m.member_id = w.member_id 
							  JOIN rudi_ranks AS r 
							  ON m.rank_id = r.rank_id 
							  WHERE m.status_id < 4, w.war_id = {$war_id} OR w.war_id IS NULL 
							  ORDER BY r.weight DESC , m.date_promotion ASC , m.date_enlisted ASC";
		
		decho($query);
		$result = $db->Query($query);
		$data = $db->Fetch($result);
		
		
		
		return $data;
	}

?>