<?php
/**
 * MODULE - INDEX >>
 * This page is a module that displays multiple modules
 * Database should store a list of module names in the order they are to be displayed
 * This should be fairly simple to produce -- Dont forget to set this as the default
 * in the config.php array
 * 
 */
?>

<?php
  
   	$result = $db->Query("SELECT `index_modules` FROM `bayonet_settings` WHERE `title` = 'Default'");
 	while(($row = $db->Fetch($result))!==false)
	{
		$indexModules = $row['index_modules'];
	}
	
	$indexModules = explode(',',$indexModules);

	foreach($indexModules as $module)
	{ 
		  if(file_exists("modules/" . $module))
		  {
		    include 'modules/' . $module . '/index.php';
		  }
		  else
		  {
		    OpenTable();
		    ReportError("Cannot load module '{$module}' directory.<br>\n");
		    CloseTable();    
		  }
		  echo "<br />";
	}
?>