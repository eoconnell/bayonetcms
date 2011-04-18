<?php

	global $db;
	
	// get all active members and members that attended the match
	// each member has a checkbox
	// -> Use AJAX oncheck to save the status of that member
	
	$battle = getBattleInfo($war_id);
	
	decho($battle);
	
	$members = getCombatSoldiers($war_id);
	
	decho($members);

?>
<h3>Engagement : <?php echo $battle['title']; ?></h3>