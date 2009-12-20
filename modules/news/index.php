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

if(isset($_GET['id']))
{
  $news_id = $_GET['id'];
  displayNews(getNews($news_id));
  displayComments(getNewsComments($news_id));
  return;
}
else
{
  displayNews(getNews());
  return;
}


?>