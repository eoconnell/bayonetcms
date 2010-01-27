<?php
		include $basedir.'rudi/includes/functions.members.php';
		if(isset($_GET['profile'])){
			$member_id = $_GET['profile'];
			include 'view.members.profile.php';	
		}else if(isset($_GET['service'])){
			$member_id = $_GET['service'];
			include 'view.members.service.php';
		}else if(isset($_GET['award'])){
			$member_id = $_GET['award'];
			include 'view.members.award.php';
		}else{
					
			 global $db;
			 
			 echo "<h3>Current Members</h3>";
			 echo "<table width=\"100%\" style=\"text-align:center;\">";
			 echo "<tr><th>Rank</th><th>Soldier</th><th>Main Info</th><th>Service Record</th><th>Medal Record</th></tr>";
			 $result = $db->Query("SELECT * FROM `rudi_unit_members` JOIN `rudi_ranks` ON rudi_unit_members.rank_id=rudi_ranks.rank_id WHERE rudi_unit_members.status_id != 4 AND rudi_unit_members.status_id != 5 ORDER BY rudi_ranks.weight DESC , rudi_unit_members.date_promotion ASC , rudi_unit_members.date_enlisted ASC");
			 $row = $db->Fetch($result);
			 
			 foreach($row as $member){
			 	echo "<tr>";
						echo "<td>{$member['shortname']}</td><td class=\"center\">{$member['first_name']} {$member['last_name']}</td>";
						echo "<td>".LinkInternal('Edit','?op=rudi&show=members&profile='.$member['member_id'])."</td>";
						echo "<td>".LinkInternal('Edit','?op=rudi&show=members&service='.$member['member_id'])."</td>";
						echo "<td>".LinkInternal('Edit','?op=rudi&show=members&award='.$member['member_id'])."</td>";
				echo "<tr>";	 
			 }
			 CloseTable();
			 
			 echo "<h3>Previous Members</h3>";
			 echo "<table width=\"100%\" style=\"text-align:center;\">";
			 echo "<tr><th>Rank</th><th>Soldier</th><th>Main Info</th><th>Service Record</th><th>Medal Record</th></tr>";
			 $result = $db->Query("SELECT * FROM `rudi_unit_members` JOIN `rudi_ranks` ON rudi_unit_members.rank_id=rudi_ranks.rank_id WHERE rudi_unit_members.status_id = 4 OR rudi_unit_members.status_id = 5 ORDER BY rudi_ranks.weight DESC, rudi_unit_members.date_promotion ASC, rudi_unit_members.date_enlisted ASC");
			 $row = $db->Fetch($result);
			 
			 foreach($row as $member){
			 	echo "<tr>";
						echo "<td>{$member['shortname']}</td><td class=\"center\">{$member['first_name']} {$member['last_name']}</td>";
						echo "<td>".LinkInternal('Edit','?op=rudi&show=members&profile='.$member['member_id'])."</td>";
						echo "<td>".LinkInternal('Edit','?op=rudi&show=members&service='.$member['member_id'])."</td>";
						echo "<td>".LinkInternal('Edit','?op=rudi&show=members&award='.$member['member_id'])."</td>";
				echo "<tr>";				 	
			 }
			 CloseTable();
	 	}

?>