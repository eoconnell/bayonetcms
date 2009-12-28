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
 
 <div style="text-align:left;"><h2>- Manage Pages</h2></div>
<?php

if(!defined("ADMIN_FILE"))
{
  die("Access denied.");
}

include $basedir.'pages/functions.php';



?>

   <table class="panel" width="100%" cellspacing="0">
   		<tr>
	       <td class="panel-none">
	       		<?php ListPages(0); ?>
		   </td>
		   <td class="panel-box">
<?php
		if(isset($_GET['edit']))
		{
		  $page_id = $_GET['edit'];
		  EditPage($page_id);
		}
		else if(isset($_GET['delete']))
		{
		  $page_id = $_GET['delete'];
		  DeletePage($page_id);
		}
		else if(isset($_GET['create']))
		{
		  $create = $_GET['create'];
		  if($create)
		  {
		    	NewPage();
		  }
		}
?>
			</td>
  		</tr>
  </table>

