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
 <link rel="stylesheet" type="text/css" href="settings/style.css" media="screen"/>
 <div style="text-align:left;"><h2>- Account Settings</h2>
 -<a href="?op=settings&change=password" >Change password</a>, email, name<br />
 </div>
 
 <?php

if(!defined("ADMIN_FILE"))
{
  die("Access denied.");
}

include $basedir.'settings/functions.php';

		if(isset($_GET['change']))
		{
		  $change = $_GET['change'];
		  if($change == "password"){
		  		changePassword();	  
		  }else if($change == "email"){
		  		changeEmail();		  
		  }
		 //return;		
	 	}


?>

  		</tr>
  </table>

 
 
 