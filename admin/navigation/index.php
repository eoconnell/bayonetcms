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
 
 <div style="text-align:left;"><h2>- Navigation Links</h2></div>
 -Edit Order, Edit Page, Delete Pages, Add Pages<br />
 
<?php 
if(!defined("ADMIN_FILE"))
{
  die("Access denied.");
}


include $basedir.'navigation/functions.php';

if(isset($_GET['edit']))
{
  $block_id = $_GET['edit'];
  EditBlock($block_id);
  return;
}

if(isset($_GET['delete']))
{
  $block_id = $_GET['delete'];
  DeleteBlock($block_id);
  return;
}

if(isset($_GET['create']))
{
  NewBlock();
  return;
}

  ListNavigation();
?>