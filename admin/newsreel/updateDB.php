<?php

//basename(dirname('.'))
$dirname = "/home/thirdid/3rd-infantry-division.org";

define('BAYONET_ROOT', $dirname);
define('BAYONET_INCLUDE', BAYONET_ROOT . '/include');
define('BAYONET_CONFIG', BAYONET_ROOT . '/include/config.ini');

require BAYONET_INCLUDE . '/debug.php';
require BAYONET_INCLUDE . '/sql.class.php';
require BAYONET_INCLUDE . '/functions.php';

Bayonet_Config::init();
$config = Bayonet_Config::$ini;
$db = new Bayonet_SQL();


//Connect to the MySQL server
$db->Connect($config['sql']['hostname'], $config['sql']['username'], $config['sql']['password']);
$db->Select_db($config['sql']['database']);

/*----------------------------- */

$action = $_POST['action'];
$updateRecordsArray = $_POST['recordsArray'];

if ($action == "updateReelOrder"){

	$listingCounter = 1;
	foreach ($updateRecordsArray as $recordIDValue) {
	
		$db->Query("UPDATE `bayonet_newsreel` SET `weight` = '$listingCounter' WHERE `slide_id` = '$recordIDValue'");
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