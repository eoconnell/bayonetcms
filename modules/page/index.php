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

/**
 * List available pages.
 * Only right now I don't know if the _pages table has been deprecated.
 * I'm confused.  -jhunk
 */
if(isset($_GET['list']))
{
	if($_GET['list'] == "true")
	{
		$result = $db->Query("SELECT title, page_id FROM bayonet_articles");
		while(($row = $db->Fetch($result)) !== false)
		{
			$pages[] = $row;
		}
		mysql_free_result($result);
		
		OpenContent();
		echo "<div class=\"contentHeading\">Page Map</div>";
		echo "<div class=\"content\">";
		echo "<ul>";
		foreach($pages as $page)
		{
			echo "<li>" . LinkPage($page['page_id'], $page['title']) . "</li>";	
		}
		echo "</ul>";
		echo "</div>";
		CloseContent();
		
		/* Kill module execution to prevent odd page results */
		return;
	}
}

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
    OpenContent();
    echo "<div class=\"content\">";
   	$aresult = $db->Query("SELECT * FROM `bayonet_articles` WHERE `page_id` = $id ORDER BY `weight` ASC");
    while(($article = $db->Fetch($aresult))!==false)
	{
		$articleTitle = $article['title'];
		echo '<h2>'.$articleTitle.'</h2>';
		//echo "<h3>".$article['title']."</h3>";
		echo bbcode_format($article['text']);	 
	} 
	echo "</div>";
	CloseContent();
	  
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