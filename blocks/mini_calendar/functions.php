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
 * PrintCalendar() - prints the calendar with events 
 */
 ?>
<script type="text/javascript">
function openEvent(date)
{
     myWindow = window.open('http://testbed.3rd-infantry-division.org/cms/blocks/mini_calendar/event.php?date='+date+'','','width=300,height=300')
     myWindow.focus();
}
</script>
 <?php
 function PrintCalendar(){
 	
		$date = time();
		date_default_timezone_set("America/New_York");  //EASTERN TIME ZONE

		$day = date('d', $date);
	 	$today = date('j', $date);
		$month = date('m', $date);
		$monthNum = date('n', $date);
		$year = date('Y', $date);
		
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
				<tr style="background-color:#999999; height:20px;">
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
			
$sqlToday = date("Y-m-d", mktime(0, 0, 0, $monthNum, $today, $year));
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
		       			if($event['date'] == $sqlToday){
		       				$todaysEvents[] = $event;
		       			}
		       		}
		       		
		       }	  				
				if($day_num == $today && $isEvent==true){
					echo '<div class="eventtoday">'.$day_num.'</div>';				
				}else if($day_num == $today && $isEvent==false){
					echo '<div class="monthtoday">'.$day_num.'</div>'; 
				}else if($day_num != $today && $isEvent==true){
					echo "<div class=\"event\" onclick=\"openEvent('{$sqlDate}')\">";
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
			$time = date("g:i a", strtotime($event['date']." ".$event['time']));
			echo "<span style=\"background-color: {$event['color']}\">&nbsp;&nbsp;</span>&nbsp;{$event['title']} @ {$time}<br />";
		}
	}
 }
 
function GetEventsOnInterval($start,$end){
	global $db;
	$result = $db->Query("SELECT `event_id`, `title`, `color`, `date`, `time` FROM `bayonet_events` WHERE `date` BETWEEN '$start' AND '$end' ORDER BY `time` ASC");
	$events = $db->Fetch($result);
	return $events;
}
  
 ?>