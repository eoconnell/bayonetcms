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

function EditNews($news_id){
	
	global $db;
	
	if(isset($_POST['processed'])){
		
		
		return;
	}
	
	$result = $db->Query("SELECT `author_id`, `title`, `message`, `date`, `category_id` FROM `bayonet_news` WHERE `news_id` = '$news_id' LIMIT 1");
	$row = $db->Fetch($result);
	
	?>
	<h3>Edit Event</h3>
  	<form action="<?php $_SERVER['PHP_SELF']?>" method="post">
  	<table>
  	<tr><th>Author</th><td><?php SelectAuthor($row['author_id']); ?></td></tr>
  	<tr><th>Title</th><td><input type="text" name="title" value="<?php echo $row['title']; ?>" /></td></tr>
  	<tr><th>Date</th><td><?php SelectDate($row['date']); ?></td></tr>
  	<tr><th>Time</th><td><input type="text" name="time" value="<?php echo substr($row['time'],0,-3); ?>" maxlength="5" size="5" /></td></tr>
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
  	  $result = $db->Query("SELECT `user_id`, `lastname` FROM `bayonet_users` WHERE `active` = 1 ORDER BY `username` ASC");
  	  while(($row = $db->Fetch($result))!= false){
  	  	  if($author_id == $row['user_id'])
  	  	  	echo "<option value=\"{$row['user_id']}\" selected>{$row['lastname']}</option>";
  	  	  else
  	  	  	echo "<option value=\"{$row['user_id']}\">{$row['lastname']}</option>";
  	  }
  	  echo "</select>";
  }
  
?>