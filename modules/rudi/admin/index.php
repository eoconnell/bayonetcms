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

//include '../includes/debug.php';
//include '../includes/sql.class.php';
//include '../includes/common.class.php';
include 'includes/admin.class.php';
//include '../header.php';

ob_start();
$common = new AdminCommon();
include 'views/view.admin.php';

if(isset($_GET['soldier']) && $_GET['soldier'] == 'modify')
{
  include 'views/view.modifysoldier.php';
  
}

//include '../footer.php';
ob_flush();
?>
