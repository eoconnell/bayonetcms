<?php
/**
 * Bayonet Content Management System
 * Copyright (C) 2008  Joseph Hunkeler & Evan O'Connell
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
 
/**
 * Note to anyone feeling the need to edit this file...
 * You MUST declare $db as global inside your functions in order access MySQL from here.
 */

function ListNavigation(){
  
  global $db;
  $result = $db->Query("SELECT `nav_id`, `title`, `weight` FROM `bayonet_navigation` ORDER BY `weight`");
  $data = $db->Fetch($result);
  
  echo "|0|Home|0|<br />";
  
  foreach($data as $nav){
  	
	  	echo "|{$nav['nav_id']}|{$nav['title']}|{$nav['weight']}|<br />";  
  }
  
}
?>