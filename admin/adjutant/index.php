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
 <link rel="stylesheet" type="text/css" href="adjutant/style.css" media="screen"/>
 <script type="text/javascript" src="scripts/jquery-ui-1.7.1.custom.min.js"></script>
 <div style="text-align:left;"><h2>- Adjutant Control Panel</h2></div>
 <a href="?op=adjutant&edit=points">Edit Points</a>&nbsp;&nbsp;
 <a href="?op=adjutant&edit=pointsnew">Edit Points *NEW*</a>&nbsp;&nbsp;
 <a href="?op=adjutant&edit=loas">Edit LOAs</a>
 <table class="panel" width="100%">
 	<tr><td style="text-align:center; vertical-align:top;">
 <?php
	if(!defined("ADMIN_FILE"))
	{
	  die("Access denied.");
	}
	
	include $basedir.'adjutant/functions.php';
	
 	//chek to see if the person is indeed an adjutant
 	
 	if(isset($_GET['edit'])){
 		if($_GET['edit'] == "points"){
 			echo "<h3>Edit Points</h3>";
 			EditPoints();
 		} 
    if($_GET['edit'] == "pointsnew"){
       echo "<h3>Edit Points *NEW*</h3>";
       EditPoints();
    }                    
 		if($_GET['edit'] == "loas"){
 			echo "<h3>Edit LOAs</h3>";
 			if(isset($_GET['member'])){
 				$member_id = $_GET['member'];
 				EditStatus($member_id);
 			}else{
 				if(isset($_GET['id']))
 					$status_id = $_GET['id'];
 				else
 					$status_id = 1;
 				EditLOAs($status_id);
 			}
 		} 	
 	}
 	else if(isset($_GET['drills'])){
 		if($_GET['drills'] == "new"){
 			
 		}
 	}
 ?>
 	</td></tr>
 	</table>
