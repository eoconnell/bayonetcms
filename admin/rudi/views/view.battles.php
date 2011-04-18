<?php

	// list all battles
	// -> click one to view who was attending (lists everyone in the unit and those attending)
	// buttons to add/edit/delete battles
	
	// definitely gonna use ajax for this...
	
	include $basedir.'rudi/includes/functions.battles.php';
	
	if(isset($_GET['id'])){
		$war_id = $_GET['id'];
		include 'view.battles.list.php';	
	}else if(isset($_GET['service'])){
		$member_id = $_GET['service'];
		include 'view.members.service.php';
	}else{
		
		// list all battles
		$battles = getAllBattles();
		decho($battles);
		
?>			 
			 <h3>Unit Engagement:</h3>
			 <table width="100%" style="text-align:center;">
			 <tr><th>Title</th><th>Opponent</th><th>Result</th><th>Date</th></tr>
<?php
		foreach($battles as $battle){
			echo "<tr><td><a href=\"?op=rudi&show=battles&id={$battle['war_id']}\">{$battle['title']}</a></td><td>vs {$battle['name']}</td><td>{$battle['status']} {$battle['home_score']}-{$battle['visit_score']}</td><td>";
			echo date("M j Y", strtotime($battle['date']));
			echo "</td><tr>";
			
		}
		CloseTable();
	}
?>