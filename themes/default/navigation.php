<?php
/**
 * Bayonet Content Management System
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
<table border="0" cellspacing="0" class="navLinks">
	<tr>
 		<td>&nbsp;&nbsp;<a href="index.php">HOME</a>&nbsp;&nbsp;</td>
<?php
  
   	$result = $db->Query("SELECT * FROM `bayonet_navigation` ORDER BY `weight`");
   	$nav = $db->Fetch($result);

   	foreach ($nav as $link) {
   	  echo '<td>&nbsp;&nbsp;<a href="' . str_replace('&', '&amp;', $link['link']) . '">' . strtoupper($link['title']) . '</a>&nbsp;&nbsp;</td>'; 
   	}
   	?>
	</tr>
</table>
