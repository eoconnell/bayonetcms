<?php
/**
 * Bayonet Content Management System
 * Copyright (C) 2008  Joseph Hunkeler
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

function ListModules(){

 	global $db;
 	$result = $db->Query("SELECT dir_name, weight, status FROM bayonet_modules ORDER BY status DESC, weight ASC");
 	$modules = $db->Fetch($result);
 	
 	OpenTable("50%");
 	echo "<tr><th>Directory Name</th><th>Weight</th><th>Status</th></tr>";
 	foreach($modules as $module){
 		echo "<tr><td>".$module['dir_name']."</td><td>".$module['weight']."</td><td>".$module['status']."</td></tr>"; 	
 	}
 	CloseTable();
}

function EditModule($module_id){
 
}

function DeleteModule($module_id){
 
}

?> 