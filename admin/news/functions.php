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
date_default_timezone_set("America/New_York"); 
function ListNews(){
	
	global $db;
	
	$result = $db->Query("SELECT n.news_id, n.title, n.date, n.category_id, u.username AS author, c.name AS catname, c.image AS catimage ".
                     "FROM `bayonet_news` AS n ".
                     "INNER JOIN `bayonet_news_categories` AS c ON c.category_id = n.category_id ".
                     "LEFT OUTER JOIN `bayonet_users` AS u ON u.user_id = n.author_id ORDER BY `date` DESC");
	
	$row = $db->Fetch($result);
	foreach($row as $news)
	{
?>		
		<a href="?op=news&edit=<?php echo $news['news_id']; ?>">
		<span class="bold"><?php echo $news['title']; ?></span>&nbsp;|&nbsp;<span class="blue"><?php echo $news['catname']; ?></span>&nbsp;&nbsp;<img src="images/page.png" /></a><br />		
		Posted By: <?php echo $news['author']; ?> on <?php echo date('n/j/Y @ g:ia T', strtotime($news['date'])); ?>
		<br /><br />
<?php
	}
	
}

function EditNews($news_id){
	
	global $db;
	
	if(isset($_POST['processed'])){
		
		$title = $_POST['title'];
		//$datetime = $_POST['year']."-".$_POST['month']."-".$_POST['day']." ".$_POST['time'];
		date_default_timezone_set('America/New_York');
		$datetime = date('Y-m-d H:i:s');
		$text = $_POST['text'];
		$author_id = $_POST['author'];
		$edited_id = ADMIN_ID;
		//$category_id = 1;
		$text = addslashes($text);
		
		$db->Query("UPDATE `bayonet_news` SET `title` = '$title', `message` = '$text', `author_id` = '$author_id', `edited` = '$datetime', `edited_id` = '$edited_id' WHERE `news_id` = '$news_id'");
		
		decho("UPDATE `bayonet_news` SET `title` = '$title', `message` = '$text', `author_id` = '$author_id', `edited` = '$datetime', `edited_id` = '$edited_id' WHERE `news_id` = '$news_id'");
		PageRedirect(1, "?op=news");
		return;
	}
	
	$result = $db->Query("SELECT `author_id`, `title`, `message`, `date`, `category_id`, `edited`, `edited_id` FROM `bayonet_news` WHERE `news_id` = '$news_id' LIMIT 1");
	$row = $db->FetchRow($result);
	
?>
<style type="text/css">
input {
 		height: 35px;
		width: 300px;
		font-size: 18px;	
 	}
</style>
	<h3>Edit News</h3>
  	<form action="" method="post">
  	Originally posted on <?php echo date('n/j/Y @ g:ia e', strtotime($row['date'])); ?>
<?php
	if($row['edited'] != NULL){
		echo "<br />Last edited on ".date('n/j/Y @ g:ia e', strtotime($row['edited']));	
	}
?>
  	<table>
  	<tr><th>Author</th><td><?php SelectAuthor($row['author_id']); ?></td></tr>
  	<tr><th>Title</th><td><input type="text" name="title" value="<?php echo $row['title']; ?>" /></td></tr>
  	<tr><th>Text</th><td><textarea id="markItUp" rows="30" cols="80" name="text"><?php echo $row['message']; ?></textarea></td>
  	<tr><th colspan="2"><input type="submit" name="processed" value="Submit" /></th></tr>
  	</table>
  	</form>
<?php
}

function CreateNews(){
	
	global $db;
	
	if(isset($_POST['processed'])){
		
		$title = $_POST['title'];
		//$datetime = $_POST['year']."-".$_POST['month']."-".$_POST['day']." ".$_POST['time'];
		date_default_timezone_set('America/New_York');
		$datetime = date('Y-m-d H:i:s');
		$text = $_POST['text'];
		$author_id = ADMIN_ID;
		$category_id = 1;
		$text = addslashes($text);
		
		$db->Query("INSERT INTO `bayonet_news` SET `title` = '$title', `message` = '$text', `author_id` = '$author_id', `date` = '$datetime', `category_id` = '$category_id'");
		
		decho("INSERT INTO `bayonet_news` SET `title` = '$title', `message` = '$text', `author_id` = '$author_id', `date` = '$datetime', `category_id` = '$category_id'");
		PageRedirect(1, "?op=news");
		return;
	}	
?>
<style type="text/css">
input {
 		height: 35px;
		width: 300px;
		font-size: 18px;	
 	}
</style>
	<h3>Post News</h3>
  	<form action="" method="post">
  	<table>
  	<tr><td>&nbsp;<input type="text" name="title" value="" /></td></tr>
  	<tr><td><textarea id="markItUp" rows="30" cols="80" name="text"></textarea></td>
  	<tr><th colspan="2"><input type="submit" name="processed" value="Post" /></th></tr>
  	</table>
  	</form>
<?php
}

 /**
  * SelectDate($date)
  * Function for outputing an html form for selecting a month day and year
  * @param date - formatted date string yyyy-mm-dd (optional)
  */  
  function SelectDate($date = NULL){

	$date_arr = date_parse($date); //returns an associative array $array['year']
				
		//List Months
		echo '<select name="month">';
		for($m = 1;$m <= 12; $m++){
		    $month =  date("F", mktime(0, 0, 0, $m));
		    if($date_arr['month'] == $m)
		    	echo "<option value='$m' selected=\"selected\">$month</option>";
	    	else
	    		echo "<option value='$m'>$month</option>";
		}
		echo "</select>";
		
		//List Days
		echo '<select name="day">';
		for($d = 1;$d <= 31; $d++){
		    if($date_arr['day'] == $d)
		    	echo "<option value='$d' selected=\"selected\">$d</option>";
	    	else
	    		echo "<option value='$d'>$d</option>";
		}
		echo "</select>";
		
		//List Years [CurYear, CurYear+5]
		echo '<select name="year">';
		$y = date('Y', time());
		$max = $y+5;
		for(;$y<$max; $y++){
			if($date_arr['year'] == $y)
		    	echo "<option value='$y' selected=\"selected\">$y</option>";
	    	else
	    		echo "<option value='$y'>$y</option>";		
		}
		echo "</select>";
  
  }
  
  function SelectAuthor($author_id){
  
  	  global $db;
  	  
  	  echo "<select name=\"author\">";
  	  $result = $db->Query("SELECT `user_id`, `lastname` FROM `bayonet_users` ORDER BY `username` ASC");
  	  $row = $db->Fetch($result);
  	  foreach($row as $author)
  	  {
  	  	  if($author_id == $author['user_id'])
  	  	  	echo "<option value=\"{$author['user_id']}\" selected>{$author['lastname']}</option>";
  	  	  else
  	  	  	echo "<option value=\"{$author['user_id']}\">{$author['lastname']}</option>";  	  	
  	  }
  	  echo "</select>";
  }
  
?>