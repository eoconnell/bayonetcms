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
?>
<h3>Points Ticker:</h3>
<table width="100%" class="rudi" cellspacing="0">

	<tr>
      <!-- Table header -->
      <th class="header">Rank</th>
      <th class="header">Name</th>
      <th class="header">Points</th>
      <th class="header">Missed Count</th>
      <th class="header">Attended Count</th>
    </tr>
<?php
	$num = 0;
	foreach($this->data as $member){
		if($member->status_id < 4){
			if($num %2 == 0){
				echo '<tr style="background-color:#D4D4D4; height:30px;">';			
			}else{
				echo '<tr style="height:30px;">';			
			}
?>	
		<td><?php echo $member->rank_short; ?></td>
		<td><?php echo $member->first_name." ".$member->last_name; ?></td>
		<td><?php echo $member->points; ?></td>
		<td><?php echo $member->drillcount; ?></td>
		<td><?php echo $member->attendcount; ?></td>
	</tr>

<?php
			$num++;
		}	
	}

?>
</table>
