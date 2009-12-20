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
 <div style="text-align:left;"><h2>- Edit Admins</h2></div>
<?php
if(!defined("ADMIN_FILE"))
{
  die("Access denied.");
}

include $basedir.'admins/functions.php';

if(isset($_GET['edit']))
{
  $user_id = $_GET['edit'];
  EditAdmin($user_id);
  return;
}

if(isset($_GET['delete']))
{
  $user_id = $_GET['delete'];
  DeleteAdmin($user_id);
  return;
}

if(isset($_GET['create']))
{
  NewAdmin();
  return;
}

echo "<table align=\"center\" width=\"200px\"><tr><th>".LinkInternal('<img src="images/add.png" />Add New Admin','?op=admins&create=true')."</th></tr></table>";

ListAdmins();

?>