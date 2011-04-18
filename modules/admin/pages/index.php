<?php
/**
 * Bayonet Content Management System
 * Copyright (C) 2008  Joseph Hunkeler
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
 
 <div class="maincontent">
 	<fieldset style="height:500px">
  	<legend>Manage Pages:</legend>
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

if(isset($_GET['delete']))
{
  $page_id = $_GET['delete'];
  DeletePage($page_id);
  return;
}

if(isset($_GET['create']))
{
  $create = $_GET['create'];
  if($create)
  {
    NewPage();
    return;
  }
}
?>

  	<table width="100%">
      <tr>
 		<td><?php ListPages(); ?></td>
 		<td class="right">
		 	<?php echo LinkInternal('<img src="images/add.gif" />&nbsp;Create a Page','?load=admin&op=pages&create=true'); ?>
	 	</td>

	<tr>
	</table>
	</fieldset>
</div>
