<?php

function Rating($val)
{
  define(EXCELLENT,100);
  define(GOOD, 75);
  define(FAIR, 50);
  define(POOR, 25);
  define(TERRIBLE, 0);
  
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

if(isset($_GET['id']))
{
  decho($this->drills);
  foreach($this->drills as $drill)
  {
    $name = $drill->last_name . ', ' . $drill->first_name;
    $pRating = Rating($drill->performance);
    $iRating = Rating($drill->initiative);
    
    echo "<tr>
      <th class=\"header\">Soldier</th>
      <th class=\"header\">Performance Rating</th>
      <th class=\"header\">Initiative Rating</th>
      <th class=\"header\">Early Excusal</th>
      <th class=\"header\">Excusal Reason</th>
      
    </tr>";
    
    echo "<tr>
      <td class=\"rudi\">{$name}</td>
      <td class=\"rudi\">{$pRating}</td>
      <td class=\"rudi\">{$iRating}</td>
      <td class=\"rudi\">{$drill->excusal}</td>
      <td class=\"rudi\">{$drill->excusal_reason}</td>
      
    </tr>";
  }  
  CloseTable();
  echo "<a href=\"?load=rudi&amp;show=drills\">Back</a>";
  return;
}

echo "<tr>
<th class=\"header\">&nbsp;</th>
<th class=\"header\">Date</th>
<!-- <th class=\"header\">News</th> -->
<th class=\"header\">Notes</th>
</tr>";

foreach($this->drills as $drill)
{
  echo "<tr>
  <td class=\"rudi\"><a href=\"?load=rudi&amp;show=drills&amp;id={$drill->drill_id}\">View</a></td>
  <td class=\"rudi\">{$drill->date}</td>
  <!-- <td class=\"rudi\">{$drill->news}</td> -->
  <td class=\"rudi\">{$drill->notes}</td>
  </tr>";
}

CloseTable();
?>