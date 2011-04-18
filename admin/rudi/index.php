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
 
 ?>
 <link rel="stylesheet" type="text/css" href="rudi/style.css" media="screen"/>
 <div style="text-align:left;"><h2>- RUDI/Quartermaster Control Panel</h2></div>
 <?php
	if(!defined("ADMIN_FILE"))
	{
	  die("Access denied.");
	}

	if(isset($_GET['show'])){
		
		switch($_GET['show']){
			case 'members':
				include $basedir.'rudi/views/view.members.php';
				break;
			case 'units':
				include $basedir.'rudi/views/view.units.php';
				break;
			case 'awards':
				include $basedir.'rudi/views/view.awards.php';
				break;
			case 'ranks':
				include $basedir.'rudi/views/view.ranks.php';
				break;
			case 'drills':
				include $basedir.'rudi/views/view.drills.php';
				break;
			case 'battles':
				include $basedir.'rudi/views/view.battles.php';
				break;       
		}	
	}else{
		$th = array('Rudi Options','');
        $td = array(
			LinkInternal('Roster','?op=rudi&show=members'),
			LinkInternal('Units','?op=rudi&show=units'),
			LinkInternal('Awards', '?op=rudi&show=awards'),
			LinkInternal('Battles', '?op=rudi&show=battles')  
        );
        
        //render administration table
        CompileAdmin($th,$td);	
	}
 ?>