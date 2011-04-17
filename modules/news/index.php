<link rel="stylesheet" type="text/css" href="modules/news/style.css" media="screen"/>
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
 
if(!defined("MODULE_FILE"))
{
  die('Access Denied.');
}

include 'modules/news/functions.php';

$logged_id = 2;

if(!defined('INDEX_MODULE')){
	$page_num = 1;
	$page_num = $_GET['page']; //get variable for page number
	
	$page_num --; //so the $index can be calculated easier while keeping [1,n] page numbers
	
	$limit = 3; //number of items per page
	$index = $page_num * $limit;

}else{
	//only do the limit
	$limit = 3;
}

if(isset($_GET['id']))
{
  $news_id = $_GET['id'];
  displayNews(getNews($news_id));
  displayComments(getNewsComments($news_id));
  return;
}
else
{
	$news = getNews(null, $limit, $index);
	displayNews($news);
	OpenContent();
	if(defined('INDEX_MODULE')){
?>
		<div style="float:right;">
			<a href="?load=news">Read All</a>&nbsp;
		</div>

<?php
	}else{
		if($page_num > 0)
			echo "&nbsp;<a href=\"?load=news&page={$page_num}\">More Recent News</a>";
		
		decho("count: ".count($news));
		if(count($news) == $limit){
?>
		<div style="float:right;">
			<a href="?load=news&page=<?php echo ($page_num+2); ?>">Older News</a>&nbsp;
		</div>
<?php
		}
	}
	echo "<div class=\"clear\"></div>";
	CloseContent();
  return;
}




?>