<?php

class RUDI_Information extends RUDI_Common
{
	public function __construct()
	{
		global $db;
		$this->db = $db;
	}
	
	public function Unit($unit_id)
	{
		$query = sprintf("SELECT leader_id, name, logo, url, creed, bio 
		FROM rudi_units 
		WHERE unit_id = %d", (int)$unit_id);
		$result = $this->db->Query($query);
		$unit = $this->db->FetchObject($result, 'UnitInfo', true);
		return $unit;
	}
	
	public function Platoon($unit_id, $platoon_id)
	{
		$query = sprintf("SELECT leader_id, name, logo, creed, bio  
		FROM rudi_platoons 
		WHERE unit_id = %d AND platoon_id = %d", (int)$unit_id, (int)$platoon_id);
		$result = $this->db->Query($query);
		$platoon = $this->db->FetchObject($result, 'UnitInfo', true);
		decho($platoon);
		
		return $platoon;		
	}
}

?>