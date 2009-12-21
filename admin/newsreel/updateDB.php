<?php

include '../../includes/debug.php';
include '../../includes/config.php'; 
include '../../includes/sql.class.php';
include '../functions.php';

$action = $_POST['action'];
$updateRecordsArray = $_POST['recordsArray'];

$db = new Bayonet_SQL();
$db->Connect(
  $config['sql']['hostname'],
  $config['sql']['username'],
  $config['sql']['password']
  );
$db->Select_db($config['sql']['database']);

if ($action == "updateReelOrder"){

	$listingCounter = 1;
	foreach ($updateRecordsArray as $recordIDValue) {
	
		$db->Query("UPDATE `bayonet_newsreel` SET `weight` = '$listingCounter' WHERE `slide_id` = '$recordIDValue'");
		//mysql_query($query) or die('Error, insert query failed');
		$listingCounter = $listingCounter + 1;
	}
	echo "<img src=\"images/accepted.png\" />";
/*
	echo '<pre>';
	print_r($updateRecordsArray);
	echo '</pre>';
	echo 'If you refresh the page, you will see that records will stay just as you modified.';
*/
}
else{
	echo "<img src=\"images/rejected.png\" />";
}
date_default_timezone_set("America/New_York");
echo " Updated at ".date("g:i:s a", time());
?>