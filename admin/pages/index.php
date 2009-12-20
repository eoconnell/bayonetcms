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
 -Order articles needs to be completed.
<?php

if(!defined("ADMIN_FILE"))
{
  die("Access denied.");
}

include $basedir.'pages/functions.php';

if(isset($_GET['edit']))
{
  $page_id = $_GET['edit'];
  EditPage($page_id);
  return;
}

?>

   <table class="panel" width="100%" cellspacing="0">
   		<tr>
	       <td class="panel-none">
	       		<?php ListPages(0); ?>
		   </td>
<?php
		if(isset($_GET['delete']))
		{
		  $page_id = $_GET['delete'];
		  	echo "<td class=\"panel-box\">";
  				DeletePage($page_id);
		  	echo "</td>";
		 //return;
		}
		else if(isset($_GET['create']))
		{
		  $create = $_GET['create'];
		  if($create)
		  {
			echo "<td class=\"panel-box\">";
		    	NewPage();
	     	echo "</td>";
		    //return;
		  }
		}
		else
		{
			echo "<td class=\"panel-shadow\">
			</td>
			<td class=\"panel-box\">
   			</td>";	
		}

?>

  		</tr>
  </table>

