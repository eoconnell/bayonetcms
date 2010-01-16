<?php

function Rating($val)
{
  define('EXCELLENT',100);
  define('GOOD', 75);
  define('FAIR', 50);
  define('POOR', 25);
  define('TERRIBLE', 0);
  
  if($val == EXCELLENT)
    return "Excellent";
  elseif($val < EXCELLENT && $val >= GOOD)
    return "Good";
  elseif($val < GOOD && $val >= POOR)
    return "Poor";
  elseif($val < POOR && $val >= TERRIBLE)
    return "Terrible";
  else
    return "Bad Value";   
}

OpenTable("Drills");

if(isset($_GET['stats']))
{
	
	return;
}

if(isset($_GET['id']))
{
	echo "
	<tr>
  		<th class=\"header\">Soldier</th>
  		<th class=\"header\">Performance Rating</th>
  		<th class=\"header\">Initiative Rating</th>
  		<th class=\"header\">Early Excusal</th>
  		<th class=\"header\">Excusal Reason</th>
	</tr>";	
	foreach($drills->manifest['members'] as $drill)
	{
		$name = $drill->last_name . ', ' . $drill->first_name;
		$pRating = Rating($drill->performance);
		$iRating = Rating($drill->initiative);
    
    	echo "
		<tr>
      		<td class=\"rudi\">{$name}</td>
      		<td class=\"rudi\">{$pRating}</td>
      		<td class=\"rudi\">{$iRating}</td>
      		<td class=\"rudi\"> " . ($drill->excusal ? "Yes" : "No") . "</td>
    	  	<td class=\"rudi\">{$drill->excusal_reason}</td>
      
	    </tr>";
  }  
  CloseTable();
  echo "<a href=\"?load=rudi&amp;show=drills\">Back</a>";
  decho('DATA FOR QUERY');
  decho($drills->manifest);
  return;
}

echo "<tr>
<th class=\"header\">&nbsp;</th>
<th class=\"header\">Date</th>
<!-- <th class=\"header\">News</th> -->
<th class=\"header\">Notes</th>
</tr>";

foreach($drills->manifest as $drill)
{
  echo "<tr>
  <td class=\"rudi\"><a href=\"?load=rudi&amp;show=drills&amp;id={$drill->drill_id}\">View</a></td>
  <td class=\"rudi\">{$drill->date}</td>
  <!-- <td class=\"rudi\">{$drill->news}</td> -->
  <td class=\"rudi\">{$drill->notes}</td>
  </tr>";
}

/*
decho('manifest');
decho($drills->manifest);
decho('attendence of drill 2');
decho($drills->getAttendenceOf(2));
decho('member 1 attendence of drill 2');
decho($drills->getMemberAttendenceOf(2,1));
decho('member 1 attendence in general');
decho($drills->getMemberAttendence(1));
decho('statistics of member 1 in general');

$drill = $drills->getAttendenceOf(2);
$drill['stats'] = $drills->getMemberStatistics($drills->getAttendenceOf(2));

$member = $drills->getMemberAttendenceOf(2,1);
$member[] = $drills->getMemberStatistics($member);
*/


decho('DATA FOR QUERY');
decho($drills->manifest);
decho($drill);
decho($member);
CloseTable();
?>