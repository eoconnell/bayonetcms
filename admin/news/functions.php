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
	
	$result = $db->Query("SELECT n.news_id, n.title, n.message, n.date, n.category_id, u.username AS author, c.name AS catname, c.image AS catimage ".
                     "FROM `bayonet_news` AS n ".
                     "INNER JOIN `bayonet_news_categories` AS c ON c.category_id = n.category_id ".
                     "LEFT OUTER JOIN `mybb_users` AS u ON u.uid = n.author_id ORDER BY `date` DESC");
	
	$row = $db->Fetch($result);
	foreach($row as $news)
	{
		$newsBody = $news['message'];
		echo "<a href=\"?op=news&edit={$news['news_id']}\">";
		echo "<span class=\"bold\">{$news['title']}</span>&nbsp;|&nbsp;<span class=\"blue\">{$news['catname']}</span>&nbsp;&nbsp;<img src=\"images/page.png\" /></a><br />";			
				if(($len = strlen($newsBody))>150)
					echo substr($newsBody, 0, 150)."...";			
				else
					echo $newsBody;
		echo '<br />';
		echo "Posted By: {$news['author']} on ".date('D M j, Y g:i a T', strtotime($news['date']));
		echo '<br /><br />';
	}
	
}

function EditNews($news_id){
	
	global $db;
	
	if(isset($_POST['processed'])){
		
		
		return;
	}
	
	$result = $db->Query("SELECT `author_id`, `title`, `message`, `date`, `category_id` FROM `bayonet_news` WHERE `news_id` = '$news_id' LIMIT 1");
	$row = $db->FetchRow($result);
	
	?>
	<h3>Edit News</h3>
  	<form action="<?php $_SERVER['PHP_SELF']?>" method="post">
  	<table>
  	<tr><th>Author</th><td><?php SelectAuthor($row['author_id']); ?></td></tr>
  	<tr><th>Title</th><td><input type="text" name="title" value="<?php echo $row['title']; ?>" /></td></tr>
  	<tr><th>Date</th><td><?php SelectDate($row['date']); ?></td></tr>
  	<tr><th>Time</th><td><input type="text" name="time" value="<?php echo date('G:i', strtotime($row['date'])); ?>" maxlength="5" size="5" /></td></tr>
  	<tr><th>Text</th><td><textarea id="markItUp" rows="30" cols="80" name="text"><?php echo $row['message']; ?></textarea></td>
  	<tr><th colspan="2"><input type="submit" name="processed" value="Submit" /></th></tr>
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