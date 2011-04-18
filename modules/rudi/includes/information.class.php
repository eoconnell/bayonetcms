<?php
/**
 * Bayonet Content Management System - RUDI
 * Copyright (C) 2008-2011  Joseph Hunkeler & Evan O'Connell
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */


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
