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
 
if(!defined("ADMIN_FILE"))
{
  die("Access denied.");
}

include $basedir.'newsreel/functions.php';
?>
 <div style="text-align:left;"><h2>- Manage News Reel</h2></div>
 -Add/Edit/Delete needs to be completed.
	<table class="panel" width="100%">
		<tr>
			<td class="panel"><?php EditOrder(); ?></td>
			<td class="panel-box" width="50%">
			<?php
				if(isset($_GET['enable'])){
					$slide_id = $_GET['enable'];
					EnableSlide($slide_id);
				}else if(isset($_GET['disable'])){
					$slide_id = $_GET['disable'];
					DisableSlide($slide_id);				
				}else{
					ListInactive();				
				}
			?>
			</td>
		</tr>
	</table>
