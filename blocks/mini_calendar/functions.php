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
 	<a href="?op=calendar&create=true&date=<?php echo $date; ?>"><img src="images/add.gif" /> Add New Event</a>
 	</td></tr></table>
<?php

	echo "<table width=\"100%\">";
 	
	$result = $db->Query("SELECT * FROM bayonet_events WHERE `date` = '$date' ORDER BY `time`");
	while(($row = $db->Fetch($result))!=false)
	{
		$tmp = true;
	 	
	 	$datetime = date_create($date.' '.$row['time']);
	 	$time = date_format($datetime, 'g:ia'); //gets time in hour:minutes am|pm
?>

<tr>
	<td><strong><?php echo $time." - ".$row['title']; ?></strong></td>
	<td><span style="border:1px solid black;background-color:#<?php echo $row['color'];?>;">&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
	<td>
		<a href="?op=calendar&month=<?php echo $_GET['month']; ?>&year=<?php echo $_GET['year']; ?>&edit=<?php echo $row['event_id'];?>">Edit</a>
		&nbsp;|&nbsp;
		<a href="?op=calendar&delete=<?php echo $row['event_id']; ?>">Delete</a>
	</td>
</tr>
<tr>
	<td><?php echo BBCode($row['text']); ?><br /><br /></td>
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
 
 
 /**
 * PrintCalendar() - prints the calendar with events 
 */
 function PrintCalendar(){
 	
		$date = time();
		date_default_timezone_set("America/New_York");  //EASTERN TIME ZONE
				
		//GET values for month and year
		$month = "";
		$year = "";
		//$month = $_GET['month'];
		//$year = $_GET['year'];
		
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
		    			<!-- <a href="?op=calendar&month=<?php echo $previous_month.'&year='.$previous_year; ?>"><<</a> -->
		    			<!-- Month Name and Year -->
		    			&nbsp;&nbsp;<span class="monthTitle"><?php echo strtoupper($title).' '.$year; ?></span>&nbsp;&nbsp;
						<!-- <a href="?op=calendar&month=<?php echo $next_month.'&year='.$next_year; ?>">>></a> -->
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
		
			//loop printing each day of the CURRENT month ONLY
			while($day_num <= $days_in_month){
		
			   if($day_count==1 || $day_count==7){
				echo '<td class="cal_weekend">';  //weekends
		           }else{
				echo '<td class="cal_weekday">';  //weekdays
			   }
			   			        
		       $sqlDate = $year.'-'.$monthNum.'-'.$day_num;  //old way NOT unix
		      
		  	 	//checks to see if the current day has events
		       $isEvent=false;

			 	global $db;
		  		$result = $db->Query("SELECT title,color FROM `bayonet_events` WHERE `date` = '$sqlDate' ORDER BY `date` DESC");
		  		while(($row = $db->Fetch($result))!=false)
		  		{
		    		$isEvent = true;
		    		if($day_num == $today){
		    			$todaysEvents[] = $row; 		    		
		    		}
		  		}  		  				
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
	//list events for today
	if(count($todaysEvents)>0){
		echo "<h3>Today's Events</h3>";
		foreach($todaysEvents as $event){
			echo "<span style=\"background-color: {$event['color']}\">&nbsp;&nbsp;</span>&nbsp;{$event['title']}<br />";
		}
	}
 }
  
 ?>