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

/**
 * MODULE - INDEX >>
 * This page is a module that displays multiple modules
 * Database should store a list of module names in the order they are to be displayed
 * This should be fairly simple to produce -- Dont forget to set this as the default
 * in the config.php array
 * 
 */

define('INDEX_MODULE', true);

$result = $db->Query("SELECT `dir_name` FROM `bayonet_modules` WHERE `status` = 'Active' ORDER BY `weight` ASC");
$modules = $db->Fetch($result);
foreach($modules as $module)
{
	$indexModules[] = $module['dir_name'];
}

foreach($indexModules as $module)
{
	if(file_exists("modules/" . $module))
	{
		include 'modules/' . $module . '/index.php';
		decho("Index module loaded: '$module'");
	}
	else
	{
		OpenContent();
		ReportError("Cannot load module '{$module}' directory.<br>\n");
		CloseContent();    
	}
	echo "<br />";
}

?>
