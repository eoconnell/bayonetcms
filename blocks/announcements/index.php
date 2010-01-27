<?php

	global $db;
	$result = $db->Query("SELECT `text` FROM `bayonet_announcements` LIMIT 1");
	$row = $db->FetchRow($result);
	echo bbcode_format($row['text']);	

?>