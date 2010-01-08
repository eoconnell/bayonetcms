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

function getCategoryList()
{
	global $db;
	$query = sprintf("SELECT category_id, title FROM bayonet_downloads_categories");
	$result = $db->Query($query);
	$categories = $db->Fetch($result);
	
	return $categories;
}

function getCategoryName($category)
{
	global $db;
	if(!filter_var($category, FILTER_VALIDATE_INT)) 
		return array();
	
	$query = sprintf("SELECT category_id, title FROM bayonet_downloads_categories WHERE category_id = %d", (int)$category);
	$result = $db->Query($query);
	$data = $db->FetchRow($result);
	
	return $data['title'];
	//return is_array($data) ? $data : array(); 
}

function getCategoryFiles($category)
{
	global $db;
	$query = sprintf("SELECT ca.category_id, ca.title AS category, dl.name, dl.filename, dl.description FROM bayonet_downloads_categories AS ca LEFT OUTER JOIN bayonet_downloads AS dl ON dl.category_id = ca.category_id WHERE ca.category_id = %d", (int)$category);

	$result = $db->Query($query);
	$downloads = $db->FetchArray($result);
	decho('downloads data');
	decho($downloads);
	decho('downloads data done');
	
	return $downloads;
}

global $db;
$downloads = NULL;
$download_relative_path = "modules/" . basename(dirname(__FILE__)) . "/files/";
$download_absolute_path = dirname(__FILE__) . "/files/"; 

$category = $_GET['category'];
if(isset($category) && !filter_var($category, FILTER_VALIDATE_INT))
{
	ReportHack("Purposely invalid category entry.");
	return;
}

$downloads = getCategoryFiles($category);
decho($downloads);

OpenContent();
echo "<div class=\"contentHeading\">Categories</div>\n";
echo "<div class=\"content\">\n";

$categoryList = getCategoryList();

	foreach($categoryList as $categoryListItem)
	{
		echo "<p>";
		echo LinkModule("download", "&amp;category={$categoryListItem['category_id']}",$categoryListItem['title']);
		echo "</p>\n";
	}


echo "</div>\n</div>\n";
CloseContent();


OpenContent();
echo "<div class=\"contentHeading\">" . getCategoryName($category) . "</div>\n";
echo "<div class=\"content\">\n";

	OpenContent();
		echo "<div class=\"contentHeading\">Files</div>\n";
			echo "<div class=\"content\">\n";
			
			if(empty($downloads)) 
			{
				echo "No downloads available.\n";
				return;	
			}
			
			foreach($downloads as $file)
			{
				$download_full_path = $download_absolute_path . $file['filename'];	
				
				if(!file_exists($download_full_path)) $broken = "(Broken link detected)"; 
				echo "<p>";
				echo LinkInternal($file['name'], $file['filename'], $download_relative_path) . " $broken<br/>\n";
				echo "<b>Filename:</b> {$file['filename']}<br/>\n";
				printf("<b>Size:</b> %.2fKB<br/>\n", filesize($download_full_path) / 1024);
				echo "<b>MD5 Hash:</b> " . md5_file($download_full_path) . "<br/>\n";
				echo "<b>Description:</b> {$file['description']}<br/>\n";
				echo "</p>";
				
			}
			//logQueueFlush(FORCE);
			
			echo "</div>\n</div>";
		echo "</div>\n</div>";
		
	CloseContent();
CloseContent();
?>
