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
 
define("MODULE_FAIL", "You cannot access this module directly.<br/>\n",true);

if(!defined("MODULE_FILE"))
{
  die(MODULE_FAIL);
}

global $db;


if(!isset($_GET['id']))
{
  //ReportError("No page has been requested.<br>\n");
 // return 1;
 	$id = 1; //makes it so that the default page is the home page
}else{
	$id = $_GET['id'];
}

$result = $db->Query("SELECT u.username AS author, p.page_created, p.title, p.text FROM `bayonet_pages` AS p LEFT OUTER JOIN `bayonet_users` AS u ON u.user_id = p.author_id WHERE p.page_id = '$id'");
$proceed = mysql_num_rows($result);

if($proceed > 0)
{	
  while(($row = $db->Fetch($result))!==false)
  {
    $page = $row;
    OpenTable();
    echo "<div class=\"content\">";
   	$aresult = $db->Query("SELECT * FROM `bayonet_articles` WHERE `page_id` = $id ORDER BY `weight` ASC");
    while(($article = $db->Fetch($aresult))!==false)
	{
		$articleTitle = $article['title'];
		echo '<h2>'.$articleTitle.'</h2>';
		//echo "<h3>".$article['title']."</h3>";
		echo BBCode($article['text']);	 
	} 
	echo "</div>";
	CloseTable();
	  
  }
  ?>
  <?php // echo bbcode_format($page['text']) ?>
  <!-- <tr><th><?php echo $page['author'] ?></th></tr> -->
  <?php  
}
else
{
  ReportError("Page does not exist.<br>\n");
}

?> 