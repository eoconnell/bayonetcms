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
 
/**
 * Note to anyone feeling the need to edit this file...
 * You MUST declare $db as global inside your functions in order access MySQL from here.
 */
 
 /**
  * SelectDate($date)
  * Function for outputing an html form for selecting a month day and year
  * @param date - formatted date string yyyy-mm-dd (optional)
  */  
  function SelectDate($date = NULL){
  	
 	//function for adding to the db in sql 'datetime' format
 	//$date = date("Y-m-d h:i:s", mktime(8, 30, 0, 10, 26, 2009));
 	//$date = "2009-11-2";
	//echo $date."<br />";	
	//function for parsing our date format into an array
	//echo "<pre>";
	$date_arr = date_parse($date); //returns an associative array $array['year']
	//print_r($date_arr);
	//echo "</pre>";	
	//echo $date_arr['year']."   ".$date_arr['month']."   ".$date_arr['day']."<br />";; 
				
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
 
 function ListEvents($date){
 	
 	global $db;

?> 	
 	<table width="100%"><tr><td>
 	<h3>Events for: <?php echo date_format(date_create($date),'F jS, Y'); ?></h3>
 	</td><td align="right">
 	<a href="?op=calendar&create=true&date=<?php echo $date; ?>"><img src="images/add.png" /> Add New Event</a>
 	</td></tr></table>
<?php

	echo "<table width=\"100%\">";
 	
	$result = $db->Query("SELECT * FROM bayonet_events WHERE `date` = '$date' ORDER BY `time`");
	$row = $db->Fetch($result);
	foreach($row as $event)
	{
		$tmp = true;
	 	
	 	$datetime = date_create($date.' '.$event['time']);
	 	$time = date_format($datetime, 'g:ia'); //gets time in hour:minutes am|pm	
?>

<tr>
	<td><strong><?php echo $time." - ".$event['title']; ?></strong></td>
	<td><span style="border:1px solid black;background-color:<?php echo $event['color'];?>;">&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
	<td>
		<a href="?op=calendar&month=<?php echo $_GET['month']; ?>&year=<?php echo $_GET['year']; ?>&edit=<?php echo $event['event_id'];?>">Edit</a>
		&nbsp;|&nbsp;
		<a href="?op=calendar&delete=<?php echo $event['event_id']; ?>">Delete</a>
	</td>
</tr>
<tr>
	<td><?php echo bbcode_format($event['text']); ?><br /><br /></td>
</tr>
		
<tr>
	<td colspan="2" style="border-top:1px solid black;"><br /></td>
</tr>
<?php
	}
	if(!isset($tmp))
		echo "<tr><td>There are no events posted for this day.</td></tr>";
	
	echo "</table>";

 }
 
 function EditEvent($event_id){
 	
	//function for adding to the db in sql 'datetime' format
	//$date = date("Y-m-d h:i:s", mktime(8, 30, 0, 10, 26, 2009));
	/*
	echo $date."<br />";
	
	//function for parsing our date format into an array
	echo "<pre>";
	$date_arr = date_parse($date); //returns an associative array $array['year']
	print_r($date_arr);
	echo "</pre>";
	
	echo $date_arr['year']; */
	
	global $db;
	
	if(isset($_POST['processed'])){
		$title = addslashes($_POST['title']);
	    $text = addslashes($_POST['text']);
	    $year = addslashes($_POST['year']);
	    $month = addslashes($_POST['month']);
	    $day = addslashes($_POST['day']);
	    $time = addslashes($_POST['time']);
	    $color = addslashes($_POST['color']);
	    
	    $date = date("Y-m-d", mktime(0, 0, 0, $month, $day, $year));
	    
$db->Query("UPDATE `bayonet_events` SET `title` = '$title', `text` = '$text', `color` = '$color', `date` = '$date', `time` = '$time' WHERE `event_id` ='$event_id' LIMIT 1");

	}
	
	$result = $db->Query("SELECT * FROM `bayonet_events` WHERE `event_id` = $event_id LIMIT 1");
	$event = $db->FetchRow($result);
  ?>
  <h3>Edit Event</h3>
  <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
  <table>
  <tr><th>Title</th><td><input type="text" name="title" value="<?php echo $event['title']; ?>" /></td></tr>
  <tr><th>Color</th><td><input type="text" name="color" value="<?php echo $event['color']; ?>" /></td></tr>
  <tr><th>Date</th><td><?php SelectDate($event['date']); ?></td></tr>
  <tr><th>Time</th><td><input type="text" name="time" value="<?php echo substr($event['time'],0,-3); ?>" maxlength="5" size="5" /></td></tr>
  <tr><th>Text</th><td><textarea id="markItUp" rows="30" cols="80" name="text"><?php echo $event['text']; ?></textarea></td>
  <tr><th colspan="2"><input type="submit" name="processed" value="Submit" /></th></tr>
  </table>
  </form>
  <?php
 }
 
 function NewEvent(){
 	 	
  global $db;
  if(isset($_POST['processed']))
  {
    //Secure our data to prevent injection attacks.
    $title = addslashes($_POST['title']);
    $text = addslashes($_POST['text']);
    $year = addslashes($_POST['year']);
    $month = addslashes($_POST['month']);
    $day = addslashes($_POST['day']);
    $time = addslashes($_POST['time']);
    $color = addslashes($_POST['color']);
    
    $date = date("Y-m-d", mktime(0, 0, 0, $month, $day, $year));
    
    if(empty($title) || empty($text))
    {
      echo "You must fill everything out before proceeding.";
      return;
    }
    $sent = false;
  
    //Update the database with the new data.
    if(!$sent){
    	$sent = true;
   		$db->Query("INSERT INTO `bayonet_events` (`event_id` ,`date` ,`time` ,`title` ,`text` ,`color`)VALUES (NULL , '$date', '$time', '$title', '$text', '$color')");	
		   
		  //echo '<script>location.href="?op=calendar&list='.$date.'";</script>'; 	    
    }
    
   
    echo "New event, '$title', has been added.\n";
    PageRedirect(2,"?op=calendar");
    //die, because we have completed what we wanted to do.
    return;
  }
     
  ?>
  <h3>Add New Event</h3>
  <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
  <table>
  <tr><th>Title</th><td><input type="text" name="title" value="" /></td></tr>
  <tr><th>Color</th><td><input type="text" name="color" value="" /></td></tr>
  <tr><th>Date</th><td><?php SelectDate($_GET['date']); ?></td></tr>
  <tr><th>Time</th><td><input type="text" name="time" value="12:00" maxlength="5" size="5" /></td></tr>
  <tr><th>Text</th><td><textarea id="markItUp" rows="30" cols="80" name="text"></textarea></td>
  <tr><th colspan="2"><input type="submit" name="processed" value="Submit" /></th></tr>
  </table>
  </form>
  <?php
 }
 
 function DeleteEvent($event_id = 0){
 	
  global $db;
  
  $result = $db->Query("SELECT title FROM bayonet_events WHERE event_id = '$event_id'");
  $event = $db->Fetch($result);
  
  if(isset($_POST['proceed']))
  {
    echo "Event '{$event['title']}', was deleted.";
    $db->Query("DELETE FROM bayonet_events WHERE event_id = '$event_id' LIMIT 1");
    return;
  }
  if(isset($_POST['cancel']))
  {
    echo "User cancelled deletion of event: '{$event['title']}'";
    return;
  } 
  if($event_id <= 0 || !is_numeric($event_id)) {
  	echo "Invalid request to delete this event.";
	return;  
  }
  ?>

  <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
  <table>
  <th>Are you SURE you want to delete the event titled: '<?php echo $event['title']?>'?</th>
  <tr><th><button name="proceed">Yes</button>&nbsp;&nbsp;&nbsp;<button name="cancel">No</button></th></tr>
  </table>
  </form>
  <?php	 
 }
 
 /**
 * PrintCalendar() - prints the calendar with events 
 */
 function PrintCalendar(){
 	
		$date = time();
		date_default_timezone_set("America/New_York");  //EASTERN TIME ZONE
		
		//GET values for month and year
		$month = $_GET['month'];
		$year = $_GET['year'];
		
		$useCurDate = true;
		
		//check to makes sure month and year are in the desired ranges
		if(!empty($month) && !empty($year) && $month > 0 && $month < 13 && $year > 1990){
		    $useCurDate = false;
		}		
		//check to see if the get variables are for todays month
		if($month == date('n', $date) && $year == date('Y', $date)){
			$useCurDate = true;		
		}
									
		//use current date unless GET values are set	
		if($useCurDate)
		{
			$day = date('d', $date);
		 	$today = date('j', $date);
			$month = date('m', $date);
			$monthNum = date('n', $date);
			$year = date('Y', $date);
		}
		else
		{
			$monthNum = $month;
			//if GET values are equal to curdate, set $today
			if($year == date('Y', $date) && $monthNum == date('n', $date))
				$today = date('j', $date);
			else
				$today = 0;
		}   
		
		/* Accounts for the last couple days from the previous months */
			$first_day = mktime(0,0,0,$monthNum, 1, $year); 
		
			$title = date('F', $first_day);
		
			$day_of_week = date('D', $first_day);
		
			switch($day_of_week){
				case "Sun": $blank = 0; break;
				case "Mon": $blank = 1; break;
				case "Tue": $blank = 2; break;
				case "Wed": $blank = 3; break;
				case "Thu": $blank = 4; break;
				case "Fri": $blank = 5; break;
				case "Sat": $blank = 6; break;
			}
			
		/* calculates the days in the current month */
			$days_in_month = cal_days_in_month(0, $monthNum, $year);
		
				//makes sure that previous year is not year 0
		        if($monthNum == 1){
		            $previous_month = 12;
		            $previous_year = $year-1;
		        }else{
		            $previous_month = $monthNum-1;
		            $previous_year = $year;
		        }
		        //makes sure the next year is not year 13
		        if($monthNum == 12){
		            $next_month = 1;
		            $next_year = $year+1;
		        }else{
		            $next_month = $monthNum+1;
		            $next_year = $year;
		        }  
		?>		             
		<center>
			<table class="calendar" style="background-color:white;" cellspacing="1" cellpadding="0">	
				<tr style="background-color:#999999; height:27px;">
					<td colspan="50" style="vertical-align:middle; text-align:center;">
		    			<a href="?op=calendar&month=<?php echo $previous_month.'&year='.$previous_year; ?>"><<</a>
		    			<!-- Month Name and Year -->
		    			&nbsp;&nbsp;<span class="monthTitle"><?php echo strtoupper($title).' '.$year; ?></span>&nbsp;&nbsp;
						<a href="?op=calendar&month=<?php echo $next_month.'&year='.$next_year; ?>">>></a>
					</td>
				</tr>
					
				<tr>
					<th class="weekday">Sun</th><th class="weekday">Mon</th><th class="weekday">Tue</th><th class="weekday">Wed</th>
					<th class="weekday">Thu</th><th class="weekday">Fri</th><th class="weekday">Sat</th>
				</tr>
				
				<tr>
		<?php
		
			$day_count = 1; //holds the current day of the week 1-7
			$day_num = 1; //holds the current day of the month 1-31
		
			$days_monthbefore = cal_days_in_month(0, $previous_month, $year);
			//prints the numbers of days for the previous month
			while($blank > 0){
				$blank = $blank-1;
				$days_before = $days_monthbefore-$blank;
				echo '<td class="cal_notmonth">'.$days_before.'</td>'; //'.$days_before.'</td>';
				$day_count++;
			}
			
$events = GetEventsOnInterval("{$year}-{$monthNum}-01","{$year}-{$monthNum}-{$days_in_month}");
		
			//loop printing each day of the CURRENT month ONLY
			while($day_num <= $days_in_month){
		
			   if($day_count==1 || $day_count==7){
				echo '<td class="cal_weekend">';  //weekends
		           }else{
				echo '<td class="cal_weekday">';  //weekdays
			   }
			   			        
		       $sqlDate = date("Y-m-d", mktime(0, 0, 0, $monthNum, $day_num, $year));
		       
		  	 	//checks to see if the current day has events
		       $isEvent=false;
		       foreach($events as $event){
		       		if($event['date'] == $sqlDate){
		       			$isEvent = true;
		       		}
		       		
		       }
				
		  			if($useCurDate)
		  				echo "<a href=\"?op=calendar&list={$year}-{$monthNum}-{$day_num}\">";
	  				else
		  				echo "<a href=\"?op=calendar&month={$monthNum}&year={$year}&list={$year}-{$monthNum}-{$day_num}\">";
		  				
						if($day_num == $today && $isEvent==true){
						   echo '<div class="eventtoday">'.$day_num.'</div>'; 					
						}else if($day_num == $today && $isEvent==false){
		                   echo '<div class="monthtoday">'.$day_num.'</div>'; 
		               	}else if($day_num != $today && $isEvent==true){
		                   echo '<div class="event" id="event'.$day_num.'" onmouseover="highlightEvent(this.id)" onmouseout="normEvent(this.id)">';
						   		echo $day_num;
		   				   echo '</div>';                		               	
		               	}else{
		                   echo $day_num;
		               	}
           			echo "</a>";
		
			    echo '</td>';
		
				$day_num++;
				$day_count++;
		
				if($day_count > 7){
					echo '</tr><tr>';
					$day_count = 1;
				}
			}
		
			$days_after = 1;
			//loop for printing the days for the next month
			while($day_count > 1 && $day_count <=7){
				echo '<td class="cal_notmonth">'.$days_after.'</td>'; //'.$days_after.'</td>';
		                $days_after++;
				$day_count++;
			}
		
		    ?>
			 
		 	</tr>
		</table>
		</center>
<?php

 }
 
function GetEventsOnInterval($start,$end){
	global $db;
	$result = $db->Query("SELECT `event_id`, `title`, `color`, `date`, `time` FROM `bayonet_events` WHERE `date` BETWEEN '$start' AND '$end' ORDER BY `time` ASC");
	$events = $db->Fetch($result);
	return $events;
}
 ?>