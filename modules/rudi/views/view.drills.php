<?php

function back()
{
	echo "<a href=\"?load=rudi&amp;show=drills\">Back</a>";
}

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

//$this->getMemberAttendance();

OpenContent();
?>
<div class="contentHeading">Drills</div>
<div class="content">

<?php if(isset($_GET['id'])): ?>
<table cellspacing="20" class="rudi" align="left" style="width: 100%;">
<tr>
  <th class="header">News</th>
</tr>

<tr>
	<td style="text-align:left;"><?php echo bbcode_format($drills->manifest->news); ?>&nbsp;</td>
</tr>

<tr>
	<th class="header">Notes</th>		
</tr>

<tr>
	<td style="text-align:left;"><?php echo bbcode_format($drills->manifest->notes); ?>&nbsp;</td>
</tr>
</table>

<br />

<table class="rudi" align="center" style="width: 100%;">
<tr>
	<th class="header">Soldier</th>
	<th class="header">Performance Rating</th>
	<th class="header">Initiative Rating</th>
	<th class="header">Excusal</th>
	<th class="header">Excusal Reason</th>
</tr>
<?php foreach($drills->manifest->members as $member): ?>
<?php
		$name = $member->last_name . ', ' . $member->first_name;
		$pRating = Rating($member->performance);
		$iRating = Rating($member->initiative);
?>
<tr>
	<td class="rudi"><?php echo $name; ?>&nbsp;</td>
	<td class="rudi"><?php echo $pRating; ?>&nbsp;</td>
	<td class="rudi"><?php echo $iRating; ?>&nbsp;</td>
	<td class="rudi"><?php echo ($member->excusal ? "Yes" : "No"); ?>&nbsp;</td>
  	<td class="rudi"><?php echo $this->evalData($member->excusal_reason); ?>&nbsp;</td>
</tr>
<?php endforeach; ?>  
</table>
  <?php echo "<br/>"; back();
  decho("DRILL DATA FOR ID({$_GET['id']}) QUERY");
  decho($drills->manifest);
  return;
  ?>

<?php endif; ?>

<table class="rudi" align="center" style="width: 100%;">
<tr>
<th class="header">&nbsp;</th>
<th class="header">Date</th>
</tr>

<?php foreach($drills->manifest as $drill): ?>
<tr>
  <td class="rudi"><a href="?load=rudi&amp;show=drills&amp;id=<?php echo $drill->drill_id; ?>">View</a></td>
  <td class="rudi"><?php echo $drill->date; ?> </td>
</tr>
<?php endforeach; ?>
</table>

</div>
<?php 
CloseContent();
OpenContent();
?>
<?php if(isset($_GET['stats']) && $_GET['stats'] == 'true'): ?>
<div class="contentHeading">Statistics</div>
<div class="content">
<?php
//decho($drills->getMemberAttendanceFull());
require_once 'view.drills.statistics.php';
?>
</div>
</div>

<?php endif; ?>

<?php
CloseContent();
decho('DATA FOR NO ID QUERY');
decho($drills->manifest);
?>
