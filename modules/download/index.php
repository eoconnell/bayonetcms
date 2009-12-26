<?php
/**
 * Bayonet Content Management System
 * Copyright (C) 2008 Joseph Hunkeler & Evan O'Connell
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

if(!defined("MODULE_FILE"))
{
	die("Access denied...");
}
global $db;
$download = NULL;
$download_relative_path = "modules/" . basename(dirname(__FILE__)) . "/files/";
$download_absolute_path = dirname(__FILE__) . "/files/"; 

$result = $db->Query("SELECT `file_id`, `name`, `description`, `filename` FROM `bayonet_downloads`");
while(($row = $db->Fetch($result)) !== false)
{
	$download[] = $row;
}

OpenContent();
echo "<div class=\"contentHeading\">Downloads</div>";
echo "<div class=\"content\">";
foreach($download as $file)
{
	$download_full_path = $download_absolute_path . $file['filename'];
	
	if(file_exists($download_full_path))
	{
		echo "<p>";
		echo LinkInternal($file['name'], $file['filename'], $download_relative_path) . "<br/>\n";
		echo "<b>Filename:</b> {$file['filename']}<br/>\n";
		printf("<b>Size:</b> %.2fKB<br/>\n", filesize($download_full_path) / 1024);
		echo "<b>MD5 Hash:</b> " . md5_file($download_full_path) . "<br/>\n";
		echo "<b>Description:</b> {$file['description']}<br/>\n";
		echo "</p>";
	}
	else
	{
		decho("File $download_absolute_path{$file['filename']} does not exist!  Not listing for download.");
	}
}
decho($download);
//logQueueFlush(FORCE);

echo "</div>";

CloseContent();


?>