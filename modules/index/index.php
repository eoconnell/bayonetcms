<?php
/**
 * MODULE - INDEX >>
 * This page is a module that displays multiple modules
 * Database should store a list of module names in the order they are to be displayed
 * This should be fairly simple to produce -- Dont forget to set this as the default
 * in the config.php array
 * 
 */

$result = $db->Query("SELECT `dir_name` FROM `bayonet_modules` ORDER BY `weight` ASC");
$modules = $db->Fetch($result);
foreach($modules as $module)
{
	$indexModules[] = $module['dir_name'];
}

foreach($indexModules as $module)
{
	if(file_exists("modules/" . $module))
	{
		include 'modules/' . $module . '/index.php';
		decho("Index module loaded: '$module'");
	}
	else
	{
		OpenContent();
		ReportError("Cannot load module '{$module}' directory.<br>\n");
		CloseContent();    
	}
	echo "<br />";
}

?>
