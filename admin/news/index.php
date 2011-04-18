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
 
 <div style="text-align:left;"><h2>- Manage News</h2></div>
 -Add/Edit(-)/Delete news
 -Add/Edit/Delete categories
<?php

if(!defined("ADMIN_FILE"))
{
  die("Access denied.");
}

include $basedir.'news/functions.php';

echo "<table class=\"panel\" width=\"100%\">
		<tr><td class=\"panel\">";

if(isset($_GET['edit'])){
	$news_id = $_GET['edit'];
	EditNews($news_id);
}
else{
	ListNews();
	echo "</td><td class=\"panel-shadow\">";
	CreateNews();
}



?>
	</td></tr></table>