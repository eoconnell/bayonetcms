<?php
	global $db;
	$result = $db->Query("SELECT `first_name`, `last_name` FROM `rudi_unit_members` WHERE `member_id` = '$member_id' LIMIT 1");
	$member = $db->FetchRow($result);
	echo "<h3>Service Record of {$member['first_name']} {$member['last_name']}</h3>";
		
	if(isset($_GET['edit'])){
		$record_id = $_GET['edit'];
		EditServiceRecord($record_id);
	}else if(isset($_GET['add'])){
		if($_GET['add']){
			AddServiceRecord($_GET['service']);
		}
	}else{
	
		echo "<div style=\"text-align:left;\">".LinkInternal('Back to Roster', '?op=rudi&show=members')."</div>";
		ListServiceRecord($_GET['service']);
	}
?>