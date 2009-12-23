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
 
 <div style="text-align:left;"><h2>- Manage Calendar & Events</h2></div>
<?php

if(!defined("ADMIN_FILE"))
{
  die("Access denied.");
}

include $basedir.'calendar/functions.php';


?>

<!--
<hr />
 <table width="100%" style="text-align:center;">
 	<tr>
 		<td>
 			<?php echo LinkInternal('Add Events','?op=calendar&create=true'); ?>
 		</td>
 		<td>
 			<?php echo LinkInternal('Edit Events','?op=calendar&edit='); ?>
 		</td>
 		<td>
 			<?php echo LinkInternal('Delete Events','?op=calendar&delete='); ?>
 		</td>
 	</tr>
 </table> -->
 
 <table class="panel" width="100%">
 	<tr>
 		<td style="width:325px; vertical-align:top; text-align:center;">
		 	<a href="?op=calendar&create=true"><img src="images/add.png" /> Add New Event</a><br /><br />
			 <?php PrintCalendar(); ?>
			 Click on a day to add/edit/delete events
	 	</td>
 		<td class="panel-box">
	 	<?php
	 		if(isset($_GET['list']))
	 		{
	 			$eventDate = $_GET['list'];
			 	ListEvents($eventDate);
				//return;		
	 		}
			else if(isset($_GET['edit']))
			{
			  $event_id = $_GET['edit'];
			  EditEvent($event_id);
			  //return;
			}			
			else if(isset($_GET['delete']))
			{
			  $event_id = $_GET['delete'];
			  DeleteEvent($event_id);
			  //return;
			}
			else if(isset($_GET['create']))
			{
			  $create = $_GET['create'];
			  if($create)
			  {
			    NewEvent();
			    //return;
			  }
			}
	 	?>
		</td>
 	</tr>
 </table>

